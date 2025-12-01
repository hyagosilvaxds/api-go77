<?php
require_once MODELS . '/Mp/order.php';
require_once MODELS . '/Pagamentos/Pagamentos.class.php';
require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Secure/Secure.class.php';

class PagamentosController extends Pagamentos
{

    public function __construct()
    {
        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->dia_atual = date('Y-m-d');

    }

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

    public function lista()
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
        $logFile = 'log/webhook_log.txt';

        // Adicione a data e hora à mensagem
        $logMessage = date('Y-m-d H:i:s') . " - Cron Transferencias disparado\n";

        file_put_contents($logFile, $logMessage, FILE_APPEND);

        $pagamentos = new Pagamentos();
        $lista_pagamentos = $pagamentos->cronTransfer();

        // $pagamentos->cronRefounds();

        jsonReturn($lista_pagamentos);
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
