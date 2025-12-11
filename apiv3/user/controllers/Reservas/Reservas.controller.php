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
require_once MODELS . '/Carrinho/Carrinho.class.php';
require_once MODELS . '/Configuracoes/Configuracoes.class.php';
require_once MODELS . '/Notificacoes/Notificacoes.class.php';
require_once MODELS . '/Anuncios/Anuncios.class.php';
require_once MODELS . '/Cupons/Cupons.class.php';

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
        $model_carrinho = new Carrinho();
        $model_cupons = new Cupons();

        // Processa cupom de desconto se informado
        $cupom_aplicado = null;
        $valor_original = $this->input->valor;
        $valor_desconto_cupom = 0;
        $valor_com_desconto = $this->input->valor;

        if (!empty($this->input->codigo_cupom)) {
            $validacao_cupom = $model_cupons->validarCupom(
                $this->input->codigo_cupom,
                $this->input->id_user,
                $this->input->id_anuncio,
                $this->input->id_categoria,
                $this->input->valor
            );

            if ($validacao_cupom['valido']) {
                $cupom_aplicado = $validacao_cupom['cupom'];
                $valor_desconto_cupom = floatval($validacao_cupom['valores']['valor_desconto']);
                $valor_com_desconto = floatval($validacao_cupom['valores']['valor_final']);
                
                // Atualiza o valor para usar o valor com desconto
                $this->input->valor = $valor_com_desconto;
                
                // Se o valor final for zero, trata como cortesia
                if ($valor_com_desconto == 0) {
                    $this->input->tipo_pagamento = 4;
                    $this->input->cortesia = 1;
                }
            } else {
                // Cupom inválido - retorna erro
                jsonReturn(array($validacao_cupom));
                return;
            }
        }


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

            // Número de parcelas (padrão: 1 = à vista)
            $parcelas = isset($this->input->parcelas) ? (int)$this->input->parcelas : 1;
            // Valida limite de parcelas (máximo 12 para maioria das bandeiras, 21 para Visa/Master)
            if ($parcelas < 1) $parcelas = 1;
            if ($parcelas > 12) $parcelas = 12;

            if(empty($dadosCartao['token'])){


                $AprovarCartao = $model_pagamentos->cobrarCartao($this->input->valor,$dadosCartao['customer'],$dadosCartao['token'],decryptitem($dadosCartao['card_number']),
                decryptitem($dadosCartao['month']),decryptitem($dadosCartao['year']),decryptitem($dadosCartao['cvv']),decryptitem($dadosCartao['nome']),decryptitem($dadosCartao['cpf']),
                decryptitem($dadosCartao['cep']),decryptitem($dadosCartao['numero']),$email,$celular,$parcelas);

            }else{


                $AprovarCartao = $model_pagamentos->cobrarCartaoComToken($this->input->valor,$dadosCartao['customer'],$dadosCartao['token'],decryptitem($dadosCartao['nome']),
                decryptitem($dadosCartao['cpf']),decryptitem($dadosCartao['cep']),decryptitem($dadosCartao['numero']),$email,$celular,$parcelas);
            }


            if($AprovarCartao['status'] != 1){

                jsonReturn(array($AprovarCartao));
            }else{


              $token = $AprovarCartao['payment_id'];
              $status_pagamento = $AprovarCartao['status_pagamento'];
              $installment_id = $AprovarCartao['installment'] ?? null;
              $valor_parcela = $AprovarCartao['installmentValue'] ?? null;
              $qtd_parcelas = $AprovarCartao['installmentCount'] ?? 1;


              if($status_pagamento == "CONFIRMED"){
                $status_final = 1;
              }else{
                $status_final = 2;
              }

              //cria pagamento com dados de parcelamento
              $id_pagamento = $model_pagamentos->save(
              $this->input->id_user, $this->input->id_anuncio, $this->input->tipo_pagamento, moneySQL($this->input->valor),
              moneySQL($valor_anunciante), moneySQL($valor_admin), $this->input->cartao_id, $qrcode = "", $token, $status_pagamento,
              $qtd_parcelas, $valor_parcela, $installment_id
              );

              //cria reserva
              $id_reserva = $model->save(
              $id_pagamento['id'], $this->input->id_user, $this->input->id_anuncio, $this->input->id_anuncio_type, $this->input->id_carrinho, $this->input->adultos, $this->input->criancas,
              dataUS($this->input->data_de), dataUS($this->input->data_ate), moneySQL($this->input->valor), $this->input->obs, $status_final);

              //update saldo

              if($status_pagamento == "CONFIRMED"){

                //se for ingresso gera os qrcodes
                if($this->input->id_categoria == 3){

                  $count_ing = $model_carrinho->CountIngressos($this->input->id_carrinho);

                  foreach($count_ing as $key => $value){

                    $qrcode = generateRandomString(32);
                    $qrcodeF = cryptitem($qrcode);

                    $update_qrcode = $model_carrinho->updateIngressos($value['id'], $qrcodeF);
                    $fecha_carrinho = $model_carrinho->fecharCarrinho($this->input->id_carrinho);

                  }

                }

                $dadosReserva = $model->listReservaToken($token);
                $saldo_atual = $usuarios->findSaldo($dadosReserva['id_anunciante']);

                $saldo_update = $saldo_atual + $dadosReserva['valor_anunciante'];

                $atualizar_saldo = $usuarios->updateSaldo($dadosReserva['id_anunciante'], $saldo_update);
                $save_comissao = $model_pagamentos->saveComissao($dadosReserva['id_anunciante'], $dadosReserva['valor_anunciante'], $status = 2);
              }

              //RESGATA DADOS do anuncio e anunciante
              $dadosAnuncio = $model_anuncios->listID($this->input->id_anuncio);

              //RESERVA INICIADA (disparar anfitriao)
              $notificacao->save("reserva-iniciada-anfitriao", $dadosAnuncio[0]['id_user'], $dadosAnuncio[0]['nome']);


              // Registra uso do cupom se aplicado (cartao credito - iniciar)
              if ($cupom_aplicado) {
                  $model_cupons->aplicarCupom(
                      $cupom_aplicado['id'],
                      $this->input->id_user,
                      $id_reserva['id'],
                      $valor_original,
                      $valor_desconto_cupom,
                      $valor_com_desconto
                  );
              }

              $result = [
                  "status" => "01",
                  "tipo_pagamento" => "1",
                  "id_pagamento" => $id_pagamento['id'],
                  "id_reserva" => $id_reserva['id'],
                  "payment_id" => $token,
                  "status" => $status_pagamento ,
                  "msg" => "Pagamento efetuado!",
                                "cupom_aplicado" => $cupom_aplicado ? true : false,
                  "valor_original" => $valor_original,
                  "valor_desconto" => $valor_desconto_cupom,
                  "valor_final" => $valor_com_desconto,
              ];

            }

        }


        //pix
        if($this->input->tipo_pagamento == 3){

            $usuarios = new Usuarios();
            $dados_user = $usuarios->Perfil($this->input->id_user);
            $dados_config = $model_config->listConfig();
            $perc_imoveis = $dados_config['perc_imoveis'];
            $perc_eventos = $dados_config['perc_eventos'];

            $celular= $dados_user['celular'];
            $email = $dados_user['email'];
            $nome = $dados_user['nome'];

            //calculo de percentual para split
            if($this->input->id_categoria == 1){
              $perc_final = $perc_imoveis;
            }else{
              $perc_final = $perc_eventos;
            }

            $valor_anunciante = $this->input->valor / 100 * $perc_final;
            $valor_admin = $this->input->valor - $valor_anunciante;

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
            $id_pagamento['id'], $this->input->id_user, $this->input->id_anuncio, $this->input->id_anuncio_type, $this->input->id_carrinho, $this->input->adultos, $this->input->criancas,
            dataUS($this->input->data_de), dataUS($this->input->data_ate), moneySQL($this->input->valor), $this->input->obs, $status = 2);

            // Registra uso do cupom se aplicado (PIX)
            if ($cupom_aplicado) {
                $model_cupons->aplicarCupom(
                    $cupom_aplicado['id'],
                    $this->input->id_user,
                    $id_reserva['id'],
                    $valor_original,
                    $valor_desconto_cupom,
                    $valor_com_desconto
                );
            }

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
                "cupom_aplicado" => $cupom_aplicado ? true : false,
                "valor_original" => $valor_original,
                "valor_desconto" => $valor_desconto_cupom,
                "valor_final" => $valor_com_desconto,
            ];

      }

      //cortesia (gratuito) - tipo_pagamento = 4
      if($this->input->tipo_pagamento == 4 || $this->input->valor == 0 || $this->input->cortesia == 1){

            $usuarios = new Usuarios();
            $dados_user = $usuarios->Perfil($this->input->id_user);

            $token = "CORTESIA_" . generateRandomString(16);
            $status_pagamento = "CONFIRMED";
            $valor_anunciante = 0;
            $valor_admin = 0;

            //cria pagamento (registro para histórico, valor zero)
            $id_pagamento = $model_pagamentos->save(
            $this->input->id_user, $this->input->id_anuncio, 4, 0,
            0, 0, "", "", $token, $status_pagamento
            );

            // Tratar campos opcionais para cortesia
            $id_anuncio_type = isset($this->input->id_anuncio_type) ? $this->input->id_anuncio_type : null;
            $adultos = isset($this->input->adultos) ? $this->input->adultos : 0;
            $criancas = isset($this->input->criancas) ? $this->input->criancas : 0;
            $data_de = isset($this->input->data_de) && !empty($this->input->data_de) ? dataUS($this->input->data_de) : null;
            $data_ate = isset($this->input->data_ate) && !empty($this->input->data_ate) ? dataUS($this->input->data_ate) : null;
            $obs = isset($this->input->obs) ? $this->input->obs : '';

            //cria reserva com status confirmado (1)
            $id_reserva = $model->save(
            $id_pagamento['id'], $this->input->id_user, $this->input->id_anuncio, $id_anuncio_type, $this->input->id_carrinho, $adultos, $criancas,
            $data_de, $data_ate, 0, $obs, $status = 1);

            //se for ingresso gera os qrcodes
            if($this->input->id_categoria == 3){

              $count_ing = $model_carrinho->CountIngressos($this->input->id_carrinho);

              foreach($count_ing as $key => $value){

                $qrcode = generateRandomString(32);
                $qrcodeF = cryptitem($qrcode);

                $update_qrcode = $model_carrinho->updateIngressos($value['id'], $qrcodeF);
                $fecha_carrinho = $model_carrinho->fecharCarrinho($this->input->id_carrinho);

              }

            }

            //RESGATA DADOS do anuncio e anunciante
            $dadosAnuncio = $model_anuncios->listID($this->input->id_anuncio);

            //RESERVA INICIADA (disparar anfitriao)
            $notificacao->save("reserva-cortesia-anfitriao", $dadosAnuncio[0]['id_user'], $dadosAnuncio[0]['nome']);

            // Registra uso do cupom se aplicado (cortesia)
            if ($cupom_aplicado) {
                $model_cupons->aplicarCupom(
                    $cupom_aplicado['id'],
                    $this->input->id_user,
                    $id_reserva['id'],
                    $valor_original,
                    $valor_desconto_cupom,
                    $valor_com_desconto
                );
            }

            $result = [
                "status" => "01",
                "tipo_pagamento" => "4",
                "id_pagamento" => $id_pagamento['id'],
                "id_reserva" => $id_reserva['id'],
                "payment_id" => $token,
                "status" => $status_pagamento,
                "cortesia" => true,
                "msg" => "Reserva cortesia confirmada!",
                "cupom_aplicado" => $cupom_aplicado ? true : false,
                "valor_original" => $valor_original,
                "valor_desconto" => $valor_desconto_cupom,
                "valor_final" => $valor_com_desconto,
            ];

      }

      jsonReturn(array($result));

    }



    public function iniciarSandBox()
    {

        $this->secure->tokens_secure($this->input->token);


        $model = new Reservas();
        $model_pagamentos = new Pagamentos();
        $model_config = new Configuracoes();
        $notificacao = new Notificacoes();
        $model_anuncios = new Anuncios();
        $model_carrinho = new Carrinho();


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


                $AprovarCartao = $model_pagamentos->cobrarCartaoComTokenSandbox($this->input->valor,$dadosCartao['customer'],$dadosCartao['token'],decryptitem($dadosCartao['nome']),
                decryptitem($dadosCartao['cpf']),decryptitem($dadosCartao['cep']),decryptitem($dadosCartao['numero']),$email,$celular);
            }


            if($AprovarCartao['status'] != 1){

                jsonReturn(array($AprovarCartao));
            }else{


              $token = $AprovarCartao['payment_id'];
              $status_pagamento = $AprovarCartao['status_pagamento'];


              if($status_pagamento == "CONFIRMED"){
                $status_final = 1;
              }else{
                $status_final = 2;
              }

              //cria pagamento
              $id_pagamento = $model_pagamentos->save(
              $this->input->id_user, $this->input->id_anuncio, $this->input->tipo_pagamento, moneySQL($this->input->valor),
              moneySQL($valor_anunciante), moneySQL($valor_admin), $this->input->cartao_id, $qrcode = "", $token, $status_pagamento
              );

              //cria reserva
              $id_reserva = $model->save(
              $id_pagamento['id'], $this->input->id_user, $this->input->id_anuncio, $this->input->id_anuncio_type, $this->input->id_carrinho, $this->input->adultos, $this->input->criancas,
              dataUS($this->input->data_de), dataUS($this->input->data_ate), moneySQL($this->input->valor), $this->input->obs, $status_final);

              //update saldo

              if($status_pagamento == "CONFIRMED"){

                //se for ingresso gera os qrcodes
                if($this->input->id_categoria == 3){

                  $count_ing = $model_carrinho->CountIngressos($this->input->id_carrinho);

                  foreach($count_ing as $key => $value){

                    $qrcode = generateRandomString(32);
                    $qrcodeF = cryptitem($qrcode);

                    $update_qrcode = $model_carrinho->updateIngressos($value['id'], $qrcodeF);
                    $fecha_carrinho = $model_carrinho->fecharCarrinho($this->input->id_carrinho);

                  }

                }

                $dadosReserva = $model->listReservaToken($token);
                $saldo_atual = $usuarios->findSaldo($dadosReserva['id_anunciante']);

                $saldo_update = $saldo_atual + $dadosReserva['valor_anunciante'];

                $atualizar_saldo = $usuarios->updateSaldo($dadosReserva['id_anunciante'], $saldo_update);
                $save_comissao = $model_pagamentos->saveComissao($dadosReserva['id_anunciante'], $dadosReserva['valor_anunciante'], $status = 2);
              }

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
            $id_pagamento['id'], $this->input->id_user, $this->input->id_anuncio, $this->input->id_anuncio_type, $this->input->id_carrinho, $this->input->adultos, $this->input->criancas,
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

      //cortesia (gratuito) - tipo_pagamento = 4 (SandBox)
      if($this->input->tipo_pagamento == 4 || $this->input->valor == 0 || $this->input->cortesia == 1){

            $usuarios = new Usuarios();
            $dados_user = $usuarios->Perfil($this->input->id_user);

            $token = "CORTESIA_SANDBOX_" . generateRandomString(16);
            $status_pagamento = "CONFIRMED";
            $valor_anunciante = 0;
            $valor_admin = 0;

            //cria pagamento (registro para histórico, valor zero)
            $id_pagamento = $model_pagamentos->save(
            $this->input->id_user, $this->input->id_anuncio, 4, 0,
            0, 0, "", "", $token, $status_pagamento
            );

            //cria reserva com status confirmado (1)
            $id_reserva = $model->save(
            $id_pagamento['id'], $this->input->id_user, $this->input->id_anuncio, $this->input->id_anuncio_type, $this->input->id_carrinho, $this->input->adultos, $this->input->criancas,
            dataUS($this->input->data_de), dataUS($this->input->data_ate), 0, $this->input->obs, $status = 1);

            //se for ingresso gera os qrcodes
            if($this->input->id_categoria == 3){

              $count_ing = $model_carrinho->CountIngressos($this->input->id_carrinho);

              foreach($count_ing as $key => $value){

                $qrcode = generateRandomString(32);
                $qrcodeF = cryptitem($qrcode);

                $update_qrcode = $model_carrinho->updateIngressos($value['id'], $qrcodeF);
                $fecha_carrinho = $model_carrinho->fecharCarrinho($this->input->id_carrinho);

              }

            }

            //RESGATA DADOS do anuncio e anunciante
            $dadosAnuncio = $model_anuncios->listID($this->input->id_anuncio);

            //RESERVA INICIADA (disparar anfitriao)
            $notificacao->save("reserva-cortesia-anfitriao", $dadosAnuncio[0]['id_user'], $dadosAnuncio[0]['nome']);

            $result = [
                "status" => "01",
                "tipo_pagamento" => "4",
                "id_pagamento" => $id_pagamento['id'],
                "id_reserva" => $id_reserva['id'],
                "payment_id" => $token,
                "status" => $status_pagamento,
                "cortesia" => true,
                "msg" => "Reserva cortesia confirmada!",
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

          $estorno = $model_pagamentos->estornarTaxandoToken($dadosReserva['token']);
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
          $notificacao->save("reserva-cancelada-hospede", $dadosReserva['id_hospede'], $dadosReserva['nome_anuncio']);

          //RESERVA CANCELADA (disparar ANFITRAO)
          $notificacao->save("reserva-cancelada-anfitriao", $dadosReserva['id_anunciante'], $dadosReserva['nome_anuncio']);

          jsonReturn($updateSaldo);

        }else{
          jsonReturn($estorno);
        }

    }

    public function lista()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Reservas();

        if($this->input->tipo == 1){
          $result = $model->Mylista1($this->input->id_user, dataUS($this->input->data_de), dataUS($this->input->data_ate));
        }else{
          $result = $model->Mylista2($this->input->id_user, dataUS($this->input->data_de), dataUS($this->input->data_ate));
        }


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

        //VERIFICA PERC user (bseado na id_categoria) - desconto personalizado do parceiro
        $percUser = $model_usuarios->findUserPerc($this->input->id_anunciante, $this->input->id_categoria);
        $percUser = $percUser ? floatval($percUser) : 0; // Se NULL, considera 0

        // Taxa total = taxa da categoria + taxa do pagamento - desconto do parceiro
        $taxa_total = $percCategoriaConfig + $percPagamentoConfig - $percUser;
        if ($taxa_total < 0) $taxa_total = 0; // Não pode ser negativa
        
        $taxa_total_final = ($this->input->valor / 100 * $taxa_total);
        $valor_total = $this->input->valor + $taxa_total_final;


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

    public function qrcode()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Reservas();
        $model_carrinho = new Carrinho();

        $verifica = $model_carrinho->validaQrcode(cryptitem($this->input->qrcode));

        jsonReturn($verifica);

    }

    //PAGAMENTOS

    public function criarTokenCartao()
    {

        $this->secure->tokens_secure($this->input->token);

        $order = new MpPayment();

        $result = $order->createTokenCard(
            $this->input->card_number,
            $this->input->expiration_month,
            $this->input->expiration_year,
            $this->input->security_code,
            $this->input->nome,
            $this->input->cpf
        );

        //jsonReturn($result);
    }
    public function criarTokenCartaoAssinatura()
    {

        $this->secure->tokens_secure($this->input->token);

        $order = new MpPayment();

        $result = $order->criarTokenCartaoAssinatura(
            $this->input->card_number,
            $this->input->expiration_month,
            $this->input->expiration_year,
            $this->input->security_code,
            $this->input->nome,
            $this->input->cpf
        );

        //jsonReturn($result);
    }
    public function removerPlano()
    {

        $this->secure->tokens_secure($this->input->token);

        $order = new MpPayment();

        $result = $order->removerPlano(
            $this->input->id_usuario
        );

        jsonReturn($result);
    }

    public function adicionar()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Usuarios();
        $order = new MpPayment();
        $user = $usuarios->listId($this->input->id_usuario);
        // print_r(decryptitem($user[0]['nome']));exit;

        if($this->input->tipo == 1){
            $plano = $usuarios->listPlanosId($this->input->id_plano_anuncio);
            $valor= $plano[0]['valor'];
            $valor=moneySQL($valor);
            $dias=$plano[0]['dias'];
            // print_r($plano[0]);exit;
            $result = $order->orderCartaoAssinatura(
                $this->input->id_usuario,
                $user[0]['email'],
                $this->input->tipo_pagamento,
                $this->input->id_plano_anuncio,
                $valor,
                $this->input->card,
                $this->input->tipo,
                $dias
            );
        }else{
            $valor= $usuarios->valorTurbinar();
            // print_r($valor);exit;
            $valor=moneySQL($valor[0]['valor']);


            if ($this->input->tipo_pagamento == 1) {
                $result = $order->orderCartao(
                    $this->input->id_usuario,
                    $user[0]['nome'],
                    $user[0]['email'],
                    $this->input->cpf,
                    $this->input->tipo_pagamento,
                    $this->input->id_plano_anuncio,
                    $valor,
                    $this->input->payment_id,
                    $this->input->card,
                    1,
                    $this->input->tipo
                );
            } else if ($this->input->tipo_pagamento == 2) {

                $result = $order->orderBoleto(
                    $this->input->id_usuario,
                    $this->input->id_plano_anuncio,
                    $user[0]['nome'],
                    $user[0]['email'],
                    $this->input->cpf,
                    $this->input->cep,
                    $this->input->endereco,
                    $this->input->estado,
                    $this->input->cidade,
                    $this->input->bairro,
                    $this->input->numero,
                    $this->input->tipo_pagamento,
                    $payment_id = "bolbradesco",
                    $valor,
                    1
                );
            } else if ($this->input->tipo_pagamento == 3) {
                $result = $order->orderPix(
                    $this->input->id_usuario,
                    $this->input->id_plano_anuncio,
                    $user[0]['nome'],
                    $user[0]['email'],
                    $this->input->cpf,
                    $this->input->tipo_pagamento,
                    $payment_id = "pix",
                    $valor,
                    1
                );
            }
            else{
              $result = $order->orderApple(
                  $this->input->id_usuario,
                  $this->input->id_plano_anuncio,
                  $user[0]['nome'],
                  $user[0]['email'],
                  $this->input->cpf,
                  $this->input->tipo_pagamento,
                  $this->input->id_order,
                  $this->input->status_order,
                  1
              );

            }
        }
        jsonReturn($result);
    }

    public function listaPagamentos()
    {

        $this->secure->tokens_secure($this->input->token);

        $pagamentos = new Pagamentos();

        $lista_pagamentos = $pagamentos->listaPagamentos($this->input->id_user, dataUS($this->input->data_de), dataUS($this->input->data_ate));

        jsonReturn($lista_pagamentos);
    }

    public function verificaPixPago()
    {

        $this->secure->tokens_secure($this->input->token);

        $pagamentos = new Pagamentos();

        $result = $pagamentos->verificaPixPago($this->input->payment_id);

        // gerarLogUserSaida($result,$this->input->id_user,"corridaEmAberto");

        jsonReturn($result);
    }



    public function cronTransfer()
    {
        $request = file_get_contents('php://input');
        $input = json_decode($request);

        // o caminho e nome do arquivo de log
        //$logFile = 'log/webhook_log.txt';

        // Adicione a data e hora à mensagem
        //$logMessage = date('Y-m-d H:i:s') . " - Cron Transferencias disparado\n";

        //file_put_contents($logFile, $logMessage, FILE_APPEND);

        $pagamentos = new Pagamentos();
        $lista_pagamentos = $pagamentos->cronTransfer();

        http_response_code(200);
        echo "HTTP STATUS 200 (OK)";

        // $pagamentos->cronRefounds();

        //jsonReturn($lista_pagamentos);
    }

    public function webhook()
    {

        $request = file_get_contents('php://input');
        $this->input = json_decode($request, true);

        try {
            // Tente executar o código do webhook
            $pagamentos = new Pagamentos();
            $lista_pagamentos = $pagamentos->webhook($this->input);

            http_response_code(200);
            echo "HTTP STATUS 200 (OK)";
            // jsonReturn($lista_pagamentos);
        } catch (Exception $e) {
            // Se ocorrer uma exceção, adicione detalhes ao log de erro

            // Retorne um status de erro ao cliente, por exemplo, 500 (Internal Server Error)
            http_response_code(500);
            echo "HTTP STATUS 500 (Internal Server Error)";
        }
    }


}
