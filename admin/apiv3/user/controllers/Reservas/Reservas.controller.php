<?php

require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once HELPERS . '/UsuariosHelper.class.php';
//require_once MODELS . '/Gcm/Gcm.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';
//require_once MODELS . '/Mp/order.php';
require_once MODELS . '/Reservas/Reservas.class.php';
require_once MODELS . '/Reservas/Pagamentos.class.php';
require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Configuracoes/Configuracoes.class.php';
require_once MODELS . '/Notificacoes/Notificacoes.class.php';
require_once MODELS . '/Anuncios/Anuncios.class.php';

class ReservasController
{

    public function __construct()
    {

        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();
        $this->req = $_REQUEST;
        $this->data_atual = date('Y-m-d H:i:s');
        $this->dia_atual = date('Y-m-d');
        // gerarLog($this->input);


    }

    public function iniciar()
    {

        $this->secure->tokens_secure($this->input->token);


        $model = new Reservas();
        $model_pagamentos = new Pagamentos();
        $model_config = new Configuracoes();
        $notificacao = new Notificacoes();
        $model_anuncios = new Anuncios();


        //inicio correto dos fluxos
        //cartao de credito
        if($this->input->tipo_pagamento == 1){
            $dadosCartao = $model->verificaCartao($this->input->cartao_id,$this->input->id_user);

            if(empty($dadosCartao['id'])){
                $result = [
                    "status" => "02",
                    "msg" => "Cartão não encontrado."
                ];

                jsonReturn(array($result));
            }

            $usuarios = new Usuarios();
            $dados_user = $usuarios->Perfil($this->input->id_user);
            $dados_config = $model_config->listConfig();
            $perc_imoveis = $dados_config['perc_imoveis'];
            $perc_eventos = $dados_config['perc_eventos'];

            $celular= $dados_user['celular'];
            $email =$dados_user['email'];

            //calculo de percentual
            if($this->input->id_categoria == 1){
              $perc_final = $perc_imoveis;
            }else{
              $perc_final = $perc_eventos;
            }

            $valor_anunciante = $this->input->valor / 100 * $perc_final;
            $valor_admin = $this->input->valor - $valor_anunciante;


            if(empty($dadosCartao['token'])){

                $AprovarCartao = $model_pagamentos->cobrarCartao($this->input->valor,$dadosCartao['customer'],$dadosCartao['token'],decryptitem($dadosCartao['card_number']),
                decryptitem($dadosCartao['month']),decryptitem($dadosCartao['year']),decryptitem($dadosCartao['cvv']),decryptitem($dadosCartao['nome']),decryptitem($dadosCartao['cpf']),
                decryptitem($dadosCartao['cep']),decryptitem($dadosCartao['numero']),$email,$celular);

            }else{

                $AprovarCartao = $model_pagamentos->cobrarCartaoComToken($this->input->valor,$dadosCartao['customer'],$dadosCartao['token'],decryptitem($dadosCartao['nome']),
                decryptitem($dadosCartao['cpf']),decryptitem($dadosCartao['cep']),decryptitem($dadosCartao['numero']),$email,$celular);
            }


            if($AprovarCartao['status'] != 1){

                jsonReturn(array($AprovarCartao));
            }else{

              $token = $AprovarCartao['payment_id'];
              $status_pagamento = $AprovarCartao['status_pagamento'];

              if($status_pagamento == "CONFIRMED"){$status_final = 1;}else{$status_final = 2;}

              //cria pagamento
              $id_pagamento = $model_pagamentos->save(
              $this->input->id_user, $this->input->id_anuncio, $this->input->tipo_pagamento, moneySQL($this->input->valor),
              moneySQL($valor_anunciante), moneySQL($valor_admin), $this->input->cartao_id, $qrcode = "", $token, $status_pagamento
              );

              //cria reserva
              $id_reserva = $model->save(
              $id_pagamento['id'], $this->input->id_user, $this->input->id_anuncio, $this->input->id_anuncio_type, $this->input->adultos, $this->input->criancas,
              dataUS($this->input->data_de), dataUS($this->input->data_ate), moneySQL($this->input->valor), $this->input->obs, $status_final);

              //RESGATA DADOS do anuncio e anunciante
              $dadosAnuncio = $model_anuncios->listID($this->input->id_anuncio);

              //RESERVA INICIADA (disparar anfitriao)
              $notificacao->save("reserva-iniciada-anfitriao", $dadosAnuncio[0]['id_user'], $dadosAnuncio[0]['nome']);


              $result = [
                  "status" => "01",
                  "tipo_pagamento" => "1",
                  "id_pagamento" => $id_pagamento['id'],
                  "id_reserva" => $id_reserva['id'],
                  "payment_id" => $token,
                  "status" => $status_pagamento ,
                  "msg" => "Pagamento efetuado!",
              ];

            }

        }


        //pix
        if($this->input->tipo_pagamento == 3){

            $usuarios = new Usuarios();
            $dados_user = $usuarios->Perfil($this->input->id_user);

            $celular= $dados_user['celular'];
            $email = $dados_user['email'];
            $nome = $dados_user['nome'];

            $criar_cliente = $model_pagamentos->criar_cliente($nome, $this->input->cpf);
            $cobrançaQrCode = $model_pagamentos->gerarQrCode($this->input->valor,$criar_cliente);

            $qr_code = $cobrançaQrCode['payload'];
            $token = $cobrançaQrCode['payment_id'];
            $status_pagamento = "PENDING";
            $base64QrCode = $cobrançaQrCode['qrCode64'];

            //cria pagamento
            $id_pagamento = $model_pagamentos->save(
            $this->input->id_user, $this->input->id_anuncio, $this->input->tipo_pagamento, moneySQL($this->input->valor),
            moneySQL($valor_anunciante), moneySQL($valor_admin), $this->input->cartao_id = "", $qr_code, $token, $status_pagamento
            );

            //cria reserva
            $id_reserva = $model->save(
            $id_pagamento['id'], $this->input->id_user, $this->input->id_anuncio, $this->input->id_anuncio_type, $this->input->adultos, $this->input->criancas,
            dataUS($this->input->data_de), dataUS($this->input->data_ate), moneySQL($this->input->valor), $this->input->obs, $status = 2);

            $result = [
                "status" => "01",
                "tipo_pagamento" => "3",
                "id_pagamento" => $id_pagamento['id'],
                "id_reserva" => $id_reserva['id'],
                "payment_id" => $token,
                "status" => $status_pagamento ,
                "msg" => "Aguardando pagamento do QrCode.",
                "qrCode" => $qr_code,
                "qrCode64" => $base64QrCode,
            ];

      }

      jsonReturn(array($result));

    }

    public function cancelar()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Reservas();
        $model_pagamentos = new Pagamentos();
        $model_config = new Configuracoes();
        $model_usuarios = new Usuarios();
        $notificacao = new Notificacoes();

        $dadosReserva = $model->listReserva($this->input->id);

        //print_r($dadosReserva);exit;

        $motivoDados = $model->listMotivos($id = $this->input->id_motivo, $tipo = null);

        $saldoAnunciante = $model_usuarios->findSaldo($dadosReserva['id_anunciante']);

        $valor_estornado = $dadosReserva['valor_final'] - ($dadosReserva['valor_final'] * $motivoDados[0]['taxa_perc'] / 100);

        //verifica se o motivo tem taxa para estorno
        if($motivoDados[0]['taxado'] == 1){

          $estorno = $model_pagamentos->estornarTaxandoToken(number_format($valor_estornado, 2, '.', ''), $dadosReserva['token']);
          //$estornocomTaxa = $model_pagamentos->estornarTaxandoToken("10.00", $dadosReserva['token']);
          $retorno_ok = $estorno['id'];

        }else{

          $estorno = $model_pagamentos->estornarTudoToken($dadosReserva['token']);
          $retorno_ok = $estorno['id'];
        }

        if(isset($retorno_ok)){

          //UPDATE SALDO E SALVA CANCELAMENTO(subtraindo a comissão do cancelamento)
          $saveCancelamento = $model->saveCancelamento($dadosReserva['id'], $this->input->id_user, $this->input->id_motivo, $this->input->obs, $status = 1);
          $saldoNovo = $saldoAnunciante - $dadosReserva['valor_anunciante'];
          $updateSaldo = $model_usuarios->updateSaldo($dadosReserva['id_anunciante'], $saldoNovo);

          //RESERVA CANCELADA (disparar HOSPEDE)
          //$notificacao->save("reserva-cancelada-hospede", $dadosReserva['id_hospede'], $dadosReserva['nome_anuncio']);

          //RESERVA CANCELADA (disparar ANFITRAO)
          //$notificacao->save("reserva-cancelada-anfitriao", $dadosReserva['id_anunciante'], $dadosReserva['nome_anuncio']);

          jsonReturn($updateSaldo);

        }else{
          jsonReturn($estorno);
        }

    }

    public function lista()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Reservas();

        $result = $model->lista($this->input->id, $this->input->tipo_pagamento, dataUS($this->input->data_de), dataUS($this->input->data_ate), $this->input->status);

        jsonReturn($result);

    }

    public function listaMotivos()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Reservas();
        $result = $model->listMotivos($id = null, $tipo = $this->input->tipo);

        jsonReturn($result);

    }

    public function simulaTaxa()
    {

        $this->secure->tokens_secure($this->input->token);

        $model_config = new Configuracoes();
        $model_usuarios = new Usuarios();

        //VERIFICA PERC CONFIG GERAL (bseado na id_categoria)
        $percCategoriaConfig = $model_config->listConfigPerc($this->input->id_categoria);

        //VERIFICA TIPO PAGAMENTO CONFIG GERAL (bseado na id_categoria)
        $percPagamentoConfig = $model_config->listConfigPagamento($this->input->tipo_pagamento);

        //VERIFICA PERC user (bseado na id_categoria)
        $percUser = $model_usuarios->findUserPerc($this->input->id_anunciante, $this->input->id_categoria);

        $perc_100 = "100.00";
        $taxa_admin = $perc_100 - ($percCategoriaConfig + $percUser);
        $taxa_total = $taxa_admin + $percPagamentoConfig;
        $taxa_total_final = ($this->input->valor / 100 * $taxa_total);
        $valor_total = $this->input->valor + ($this->input->valor / 100 * $taxa_total);


        $Param['perc_tipo_categoria'] = $percCategoriaConfig;
        $Param['perc_tipo_pagamento'] = $percPagamentoConfig;
        $Param['taxa_total'] = moneyView($taxa_total_final);
        $Param['valor_total'] = $valor_total;
        $Param['valor_total_string'] = moneyView($valor_total);

        jsonReturn($Param);

    }

    public function cronLembrete()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Reservas();

        $result = $model->cronLembrete();

        jsonReturn($result);

    }

    public function listComissoes()
    {

        //request usada para propositos de desenvolvimento
        $this->secure->tokens_secure($this->input->token);

        $model = new Pagamentos();
        $perfil = $model->listComissoes($this->input->data_de,$this->input->data_ate);

        jsonReturn($perfil);
    }


}
