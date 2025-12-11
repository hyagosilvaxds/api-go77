<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Usuarios/Enderecos.class.php';
require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Reservas/Reservas.class.php';
require_once MODELS . '/Carrinho/Carrinho.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';


class Pagamentos extends Conexao
{


    public function __construct()
    {
        $this->Conecta();
        // $this->ConectaWordPress();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->data_atual_s = date('Y-m-d');
        $this->tabela = "app_pedidos";
        $this->tabela_users = "app_users";
        $this->tabela_status = "app_pedidos_status";
    }


    public function save($id_user,$id_anuncio,$tipo_pagamento,$valor_final,$valor_anunciante,$valor_admin,$cartao_id, $qrcode, $token,$status,$parcelas = 1,$valor_parcela = null,$installment_id = null){

        // Se valor_parcela não foi informado, calcula baseado nas parcelas
        if ($valor_parcela === null && $parcelas > 0) {
            $valor_parcela = $valor_final / $parcelas;
        }

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_pagamentos`(`app_users_id`, `app_anuncios_id`,`tipo_pagamento`,`valor_final`,`valor_anunciante`,`valor_admin`,`parcelas`,`valor_parcela`,`installment_id`,`cartao_id`,`qrcode`,`data`,`token`,`status`)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)"
        );
        // Tipos: i=int, d=double, s=string
        // 14 parâmetros: int, int, int, double, double, double, int, double, string, string, string, string, string, string
        $sql_cadastro->bind_param("iiidddidssssss", 
            $id_user, 
            $id_anuncio, 
            $tipo_pagamento, 
            $valor_final, 
            $valor_anunciante, 
            $valor_admin, 
            $parcelas, 
            $valor_parcela, 
            $installment_id, 
            $cartao_id, 
            $qrcode, 
            $this->data_atual, 
            $token, 
            $status
        );
        $sql_cadastro->execute();

        $id_pagamento = $sql_cadastro->insert_id;

        $Param = [
            "status" => "01",
            "id" => $id_pagamento,
            "msg" => "Reserva efetuada com sucesso.",
            "parcelas" => $parcelas,
            "valor_parcela" => $valor_parcela
        ];

        return $Param;
    }

    public function saveComissao($id_user,$valor,$status){

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_saldo_pagamentos`(`app_users_id`,`valor`,`data`,`status`)
             VALUES ('$id_user','$valor','$this->data_atual','$status')"
        );
        $sql_cadastro->execute();

    }


    public function estornarTudoToken($token) {


        $url = ASAAS_URL_PRODUCTION . "v3/payments/".$token."/refund";

        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: application/json',
        'User-Agent: PostmanRuntime/7.28.0',
        'access_token:' . ASAAS_KEY));
        curl_setopt($ch, CURLOPT_HTTPGET, true);


        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        $json_data = json_decode($response, true);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Verifica se houve algum erro na requisição
        if (curl_errno($ch) OR ($httpCode != 200) ) {
            $lista = [
                "status" => '02',
                "msg" => $json_data['errors'][0]['description']
            ];

            return $lista;
        }


        // Fecha a sessão cURL
        curl_close($ch);

        $lista = [
            "status" => '01',
            "msg" => "Reserva cancelada com sucesso.",
            "payment_id" => $json_data['id']
        ];

        return $lista;
    }
    public function estornarTaxandoToken($valor,$token) {


        $url = ASAAS_URL_PRODUCTION."v3/payments/".$token."/refund";

        // Dados da requisição
        $data = array(
            'value' => $valor
        );
        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'User-Agent: PostmanRuntime/7.28.0',
            'access_token:'. ASAAS_KEY,
            'content-type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        $json_data = json_decode($response, true);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Verifica se houve algum erro na requisição
        if (curl_errno($ch) OR ($httpCode != 200) ) {
            $lista = [
                "status" => '02',
                "msg" => $json_data['errors'][0]['description']
            ];

            return $lista;
        }


        // Fecha a sessão cURL
        curl_close($ch);

        $lista = [
            "status" => '01',
            "msg" => "Reserva cancelada com sucesso.",
            "payment_id" => $json_data['id']
        ];

        return $lista;

    }
    public function estornarTudo($id_corrida,$id_passageiro) {

        $sql= $this->mysqli->prepare("SELECT `token` FROM `app_corridas_pagamentos` WHERE app_corridas_id ='$id_corrida' AND app_users_id='$id_passageiro' ORDER BY id DESC LIMIT 1");
        $sql->execute();
        $sql->bind_result($token);
        $sql->store_result();
        $sql->fetch();
        $sql->close();


        $url = ASAAS_URL_PRODUCTION."v3/payments/".$token."/refund";

        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: application/json',
        'User-Agent: PostmanRuntime/7.28.0',
        'access_token:' . ASAAS_KEY));
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        $json_data = json_decode($response, true);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $sql = $this->mysqli->prepare("
        UPDATE `app_corridas_pagamentos` SET status='REFOUNDED'
        WHERE app_corridas_id='$id_corrida' AND app_users_id='$id_passageiro'"
        );
        $sql->execute();


        if ($httpCode != 200) {
            return $json_data['errors'][0]['description'];
        }

        // Fecha a sessão cURL
        curl_close($ch);
    }
    public function estornarTaxando($id_corrida,$id_user,$valor,$tipo_pagamento) {

        $sql = $this->mysqli->prepare("SELECT token FROM `app_corridas_pagamentos` WHERE app_corridas_id = $id_corrida AND app_users_id='$id_user'");
        $sql->execute();
        $sql->bind_result($token);
        $sql->store_result();
        $sql->fetch();
        $sql->close();

        // $token="pay_v6xdjimuct47ig57";
        if($tipo_pagamento == 1){
            $this->confirmaPagamentoAsaas($token);
        }

        $url = ASAAS_URL_PRODUCTION."v3/payments/".$token."/refund";

        // Dados da requisição
        $data = array(
            'value' => $valor
        );
        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'User-Agent: PostmanRuntime/7.28.0',
            'access_token:'. ASAAS_KEY,
            'content-type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $json_data = json_decode($response,true);

        // print_r($json_data);
        // Verifica se houve algum erro na requisição

        $sql = $this->mysqli->prepare("
        UPDATE `app_corridas_pagamentos` SET status='REFOUNDED'
        WHERE app_corridas_id='$id_corrida' AND app_users_id='$id_user'"
        );
        $sql->execute();


        // Fecha a sessão cURL
        curl_close($ch);
    }
    public function cobrarCartao($valor,$customer,$token,$card_number,$month,$year,$cvv,$nome,$cpf,$cep,$numero,$email,$celular,$parcelas = 1)
    {

        // URL da API
        $url = ASAAS_URL_PRODUCTION.'v3/payments';

        if(!empty($token)){
            // Dados da requisição com token existente
            $data = array(
                'billingType' => 'CREDIT_CARD',
                'customer' => $customer,
                'dueDate' => $this->data_atual,
                'creditCardToken' => $token,
                'authorizeOnly' => true
            );
            
            // Parcelamento com token
            if ($parcelas >= 2) {
                $data['installmentCount'] = (int)$parcelas;
                $data['totalValue'] = $valor;
            } else {
                $data['value'] = $valor;
            }
        }else{
            // Dados da requisição com dados do cartão
            $data = array(
                'billingType' => 'CREDIT_CARD',
                'customer' => $customer,
                'dueDate' => $this->data_atual,
                //'authorizeOnly' => true,
                'creditCardHolderInfo' => array(
                    'name' => $nome,
                    'email' => $email,
                    'cpfCnpj' => $cpf,
                    'postalCode' => $cep,
                    'addressNumber' => $numero,
                    'phone' => $celular
                ),
                'creditCard' => array(
                    'holderName' => $nome,
                    'number' => $card_number,
                    'expiryMonth' => $month,
                    'expiryYear' => $year,
                    'ccv' => $cvv
                )
            );
            
            // Parcelamento sem token
            if ($parcelas >= 2) {
                $data['installmentCount'] = (int)$parcelas;
                $data['totalValue'] = $valor;
            } else {
                $data['value'] = $valor;
            }
        }



        // print_r($data);exit;
        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'User-Agent: PostmanRuntime/7.28.0',
            'access_token:'. ASAAS_KEY,
            'content-type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $json_data = json_decode($response,true);

        // echo $response;
        // Verifica se houve algum erro na requisição
        if (curl_errno($ch) OR ($httpCode != 200) ) {
            $lista = [
                "status" => '02',
                "msg" => $json_data['errors'][0]['description']
            ];

            return $lista;
        }


        // Fecha a sessão cURL
        curl_close($ch);

        $lista = [
            "status" => '01',
            "status_pagamento" => $json_data['status'],
            "payment_id" => $json_data['id'],
            "installment" => $json_data['installment'] ?? null,
            "installmentCount" => $json_data['installmentCount'] ?? 1,
            "installmentValue" => $json_data['installmentValue'] ?? $valor
        ];

        return $lista;
    }
    public function cobrarCartaoComToken($valor, $customer, $token, $nome, $cpf, $cep, $numero, $email, $celular, $parcelas = 1)
    {

    // URL da API
    $url = ASAAS_URL_PRODUCTION . 'v3/payments';

    // Dados base da requisição usando o token do cartão
    $data = array(
        'billingType' => 'CREDIT_CARD',
        'customer' => $customer,
        'dueDate' => $this->data_atual,
        'creditCardToken' => $token,
        //'authorizeOnly' => true,
        'creditCardHolderInfo' => array(
            'name' => $nome,
            'email' => $email,
            'cpfCnpj' => $cpf,
            'postalCode' => $cep,
            'addressNumber' => $numero,
            'phone' => $celular
        )
    );

    // Se for parcelado (2 ou mais parcelas), usa installmentCount e totalValue
    // Se for à vista (1 parcela), usa apenas value
    if ($parcelas >= 2) {
        $data['installmentCount'] = (int)$parcelas;
        $data['totalValue'] = $valor;
    } else {
        $data['value'] = $valor;
    }

    // Inicializa a sessão cURL
    $ch = curl_init($url);

    // Configura as opções da requisição
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: application/json',
        'User-Agent: PostmanRuntime/7.28.0',
        'access_token:' . ASAAS_KEY,
        'content-type: application/json'
    ));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Executa a requisição e obtém a resposta
    $response = curl_exec($ch);

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $json_data = json_decode($response, true);

    // Verifica se houve algum erro na requisição
    if (curl_errno($ch) || ($httpCode != 200)) {
        $lista = [
            "status" => '02',
            "msg" => $json_data['errors'][0]['description'] ?? 'Erro desconhecido.'
        ];

        curl_close($ch);
        return $lista;
    }

    // Fecha a sessão cURL
    curl_close($ch);

    $lista = [
        "status" => '01',
        "status_pagamento" => $json_data['status'],
        "payment_id" => $json_data['id'],
        "installment" => $json_data['installment'] ?? null,
        "installmentCount" => $json_data['installmentCount'] ?? 1,
        "installmentValue" => $json_data['installmentValue'] ?? $valor
    ];

    return $lista;
}


public function cobrarCartaoComTokenSandbox($valor, $customer, $token, $nome, $cpf, $cep, $numero, $email, $celular)
{




// URL da API
$url = ASAAS_URL . 'v3/payments';

// Dados da requisição usando o token do cartão
$data = array(
    'billingType' => 'CREDIT_CARD',
    'customer' => $customer,
    'value' => $valor,
    'dueDate' => $this->data_atual,
    'creditCardToken' => $token,
    //'authorizeOnly' => true,
    'creditCardHolderInfo' => array(
        'name' => $nome,
        'email' => $email,
        'cpfCnpj' => $cpf,
        'postalCode' => $cep,
        'addressNumber' => $numero,
        'phone' => $celular
    )
);

// Inicializa a sessão cURL
$ch = curl_init($url);

// Configura as opções da requisição
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: application/json',
    'User-Agent: PostmanRuntime/7.28.0',
    'access_token:' . ASAAS_KEY_SANDBOX,
    'content-type: application/json'
));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Executa a requisição e obtém a resposta
$response = curl_exec($ch);

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$json_data = json_decode($response, true);

// Verifica se houve algum erro na requisição
if (curl_errno($ch) || ($httpCode != 200)) {
    $lista = [
        "status" => '02',
        "msg" => $json_data['errors'][0]['description'] ?? 'Erro desconhecido.'
    ];

    curl_close($ch);
    return $lista;
}

// Fecha a sessão cURL
curl_close($ch);

$lista = [
    "status" => '01',
    "status_pagamento" => $json_data['status'],
    "payment_id" => $json_data['id']
];

return $lista;
}


    public function gerarCobrancaPix($valor, $id_customer)
    {

        // URL da API
        $url = ASAAS_URL_PRODUCTION.'v3/payments';

        // Dados da requisição
        $data = array(
            'billingType' => 'PIX',
            'customer' => $id_customer,
            'value' => $valor,
            'dueDate' => $this->data_atual
        );

        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'access_token:'. ASAAS_KEY,
            'content-type: application/json',
            'User-Agent: PostmanRuntime/7.28.0' // Exemplo com Postman
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);


        // Verifica se houve algum erro na requisição
        if (curl_errno($ch)) {
            echo 'Erro na requisição cURL: ' . curl_error($ch);
        }

        // Fecha a sessão cURL
        curl_close($ch);

        // Exibe a resposta da requisição
        $json_data = json_decode($response,true);

        //print_r($json_data);exit;

        return $json_data;
    }

    public function verificarClientePorEmail($email)
    {
        // URL da API para listar clientes
        $url = ASAAS_URL_PRODUCTION . 'v3/customers?email=' . urlencode($email);

        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'User-Agent: PostmanRuntime/7.28.0',
            'access_token:' . ASAAS_KEY,
            'content-type: application/json',

        ));

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $json_data = json_decode($response, true);

        // Fecha a sessão cURL
        curl_close($ch);

        // Verifica se houve algum erro na requisição
        if (curl_errno($ch) || ($httpCode != 200)) {
            return [
                "status" => '02',
                "msg" => $json_data['errors'][0]['description'] ?? 'Erro desconhecido.'
            ];
        }

        // Verifica se o cliente foi encontrado
        if (!empty($json_data['data'])) {
            // Retorna o customer_id do primeiro cliente encontrado
            return [
                "status" => '01',
                "customer_id" => $json_data['data'][0]['id']
            ];
        } else {
            return [
                "status" => '00',
                "msg" => "Cliente não encontrado."
            ];
        }
    }

    public function criar_cliente($nome,$cpf)
    {
        $url = ASAAS_URL_PRODUCTION . "v3/customers";

        $headers = array(
            'accept: application/json',
            'access_token:'. ASAAS_KEY,
            'content-type: application/json',
            'User-Agent: PostmanRuntime/7.28.0' // Exemplo com Postman
        );

        $data = array(
            "name" => $nome,
            "cpfCnpj" => "$cpf"
        );

        // print_r($data);exit;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $json_data = json_decode($response, true);

        //print_r($json_data);exit;

        if ($response === false) {
            $Param = [
                "status" => "02",
                "msg" => "Erro ao criar o cliente.",
            ];

            return $Param;
        } else {
            // Verifique o código de resposta
            if ($httpCode === 200) {
                return $json_data['id'];
                // echo 'Solicitação bem-sucedida: ' . $response;
            } else {
                return null;
            }
        }

        curl_close($ch);

    }
    public function gerarQrCode($valor, $id_customer)
    {
        $dados_cobranca = $this->gerarCobrancaPix($valor, $id_customer);
        // print_r($dados_cobranca['id']);exit;
        $payment_id =$dados_cobranca['id'];
        // URL da API
        $url = ASAAS_URL_PRODUCTION.'v3/payments/'.$payment_id.'/pixQrCode';

        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'access_token:'.ASAAS_KEY,
            'User-Agent: PostmanRuntime/7.28.0' // Exemplo com Postman
        ));
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);

        //print_r($response);exit;

        // Verifica se houve algum erro na requisição
        if (curl_errno($ch)) {
            echo 'Erro na requisição cURL: ' . curl_error($ch);
        }

        // Fecha a sessão cURL
        curl_close($ch);

        // Exibe a resposta da requisição
        $json_data = json_decode($response,true);




        $lista = [
            "payment_id" => $payment_id,
            "payload" => $json_data['payload'],
            "qrCode64" => $json_data['encodedImage']
        ];

        return $lista;

    }

    public function webhook($payload)
    {


        if ($payload["event"] == "PAYMENT_RECEIVED") {

            $token = $payload["payment"]["id"];
            $status = $payload["payment"]["status"];


            $model_reservas = New Reservas();
            $model_usuarios = New Usuarios();
            $model_carrinho = New Carrinho();
            $notificacao = new Notificacoes();
            $dadosReserva = $model_reservas->listReservaToken($token);


            $id_pagamento = $this->listIDPagamento($token);
            $id_categoria = $this->listIDCategoria($token);

            $saldo_atual = $model_usuarios->findSaldo($dadosReserva['id_anunciante']);
            $update_pagamento = $this->updatePagamento($token, $status);

            if (($status == 'RECEIVED') || ($status == 'CONFIRMED')) {


                $update_reserva = $model_reservas->updateReserva($id_pagamento, $status = 1);

                //atualizar saldo e salvar comissão
                $saldo_update = $saldo_atual + $dadosReserva['valor_anunciante'];

                $atualizar_saldo = $model_usuarios->updateSaldo($dadosReserva['id_anunciante'], $saldo_update);
                $save_comissao = $this->saveComissao($dadosReserva['id_anunciante'], $dadosReserva['valor_anunciante'], $status = 2);

                if($id_categoria == 3){

                  $id_carrinho = $model_reservas->listIDCarrinho($id_pagamento);

                  $count_ing = $model_carrinho->CountIngressos($id_carrinho);

                  foreach($count_ing as $key => $value){

                    $qrcode = generateRandomString(32);
                    $qrcodeF = cryptitem($qrcode);

                    $update_qrcode = $model_carrinho->updateIngressos($value['id'], $qrcodeF);
                    $fecha_carrinho = $model_carrinho->fecharCarrinho($id_carrinho);

                  }

                }

                //PAGAMENTO CONFIRMADO (disparar HOSPEDE)
                $notificacao->save("pagamento-confirmado-hospede", $dadosReserva['id_hospede'], $dadosReserva['nome_anuncio']);

                //PAGAMENTO CONFIRMADO (disparar ANFITRAO)
                $notificacao->save("pagamento-confirmado-anfitriao", $dadosReserva['id_anunciante'], $dadosReserva['nome_anuncio']);

            }else{
                $update_reserva = $model_reservas->updateReserva($id_pagamento, $status = 3);
            }

        }

        elseif($payload["event"] == "PAYMENT_REFUNDED") {

          $token = $payload["payment"]["id"];
          $status = $payload["payment"]["status"];

          $model_reservas = New Reservas();
          $notificacao = new Notificacoes();

          $id_pagamento = $this->listIDPagamento($token);
          $update_pagamento = $this->updatePagamento($token, $status);

          $update_reserva = $model_reservas->updateReserva($id_pagamento, $status = 3);

          //PAGAMENTO CANCELADO (disparar HOSPEDE)
          $notificacao->save("pagamento-cancelado-hospede", $dadosReserva['id_hospede'], $dadosReserva['nome_anuncio']);

          //PAGAMENTO CANCELADO (disparar ANFITRAO)
          $notificacao->save("pagamento-cancelado-anfitriao", $dadosReserva['id_anunciante'], $dadosReserva['nome_anuncio']);

        }

    }

    public function asaasTransferIndividual($id_user,$chave,$tipo_chave,$valor,$valor_comissao)
    {

        $url = ASAAS_URL_PRODUCTION . "v3/transfers";

        $headers = array(
            'accept: application/json',
            'access_token:'. ASAAS_KEY,
            'content-type: application/json',
            'User-Agent: PostmanRuntime/7.28.0'
        );

        $data = array(
            "value" => $valor_comissao,
            "operationType" => "PIX",
            "pixAddressKey" => trim($chave),
            "pixAddressKeyType" => trim($tipo_chave),
            "description" => "user:".$id_user
        );

        // print_r($data);exit;

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $json_data = json_decode($response, true);

        echo $response;

        if ($response === false) {
            $resposta = [
                "status" => 2,
                "descricao" => "Erro ao fazer a solicitação"
            ];
            return $resposta;
        } else {
            // Verifique o código de resposta
            if ($httpCode === 200) {
                $resposta = [
                    "status" => 1,
                    "descricao" => $response
                ];
                return $resposta;
                // echo 'Solicitação bem-sucedida: ' . $response;
            } else {
                $resposta = [
                    "status" => 2,
                    "descricao" => $json_data['errors'][0]['description']
                ];
                return $resposta;
                // echo 'Erro na solicitação. Código de resposta: ' . $httpCode . ', Mensagem: ' . $response;
            }
        }

        curl_close($ch);

    }


    public function listIDPagamento($token)
    {


        $sql = $this->mysqli->prepare("SELECT id FROM `app_pagamentos` WHERE token='$token'");
        $sql->execute();
        $sql->bind_result($id);
        $sql->fetch();

        return $id;

    }

    public function listIDCategoria($token)
    {


        $sql = $this->mysqli->prepare("
        SELECT b.app_categorias_id FROM `app_pagamentos` as a
        INNER JOIN `app_anuncios` as b ON a.app_anuncios_id = b.id
        WHERE a.token='$token'
        ");
        $sql->execute();
        $sql->bind_result($id_categoria);
        $sql->fetch();

        return $id_categoria;

    }

    public function updatePagamento($id, $status){

      $sql = $this->mysqli->prepare("UPDATE `app_pagamentos` SET status='$status' WHERE token='$id'");
      $sql->execute();


    }

    public function listaPagamentos($id_user, $data_de, $data_ate)
    {

        $filter = " WHERE app_users_id ='$id_user'";

        if(!empty($data_de) AND !empty($data_ate)){
            $filter .= " AND data between '$data_de' and '$data_ate' ";
        }

        $sql = $this->mysqli->prepare("
        SELECT id, app_anuncios_id, tipo_pagamento, valor_final, data, token, status
        FROM `app_pagamentos`
        $filter
        ORDER BY id DESC
        ");
        $sql->execute();
        $sql->bind_result($this->id, $this->id_anuncio, $this->tipo_pagamento, $this->valor_final, $this->data,$this->token, $this->status);
        $sql->store_result();
        $rows = $sql->num_rows();

        if ($rows == 0) {
            $param['rows'] = $rows;
            $lista[] = $param;
        } else {
            while ($row = $sql->fetch()) {

                $model_anuncios = New Anuncios();

                $param['id'] = $this->id;
                $param['tipo_pagamento'] = tipoPagamento($this->tipo_pagamento);
                $param['valor'] = moneyView($this->valor_final);
                $param['data'] = data($this->data);
                $param['token'] = $this->token;
                $param['status_pagamento'] = statusPayment($this->status);
                $param['anuncio'] = $model_anuncios->listID($this->id_anuncio);
                $param['rows'] = $rows;
                $lista[] = $param;
            }
        }
        return $lista;
    }

    public function verificaPixPago($paymentid)
    {

        $sql = $this->mysqli->prepare("SELECT status FROM `app_pagamentos` WHERE token='$paymentid'");
        $sql->execute();
        $sql->bind_result($status);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;
        $lista = [];
        if (($status == 'RECEIVED') || ($status == 'CONFIRMED')) {
            $Param['status'] = '01';
            $Param['msg'] = 'O pagamento foi identificado!';
            array_push($lista, $Param);
        }else{
            $Param['status'] = '02';
            $Param['msg'] = 'O pagamento  não foi identificado!';
            array_push($lista, $Param);

        }

        // print_r($usuarios);exit;
        return $lista;
    }

    public function motoristasSaldo($novaData)
    {

        $sql = $this->mysqli->prepare("
        SELECT SUM(c.valor) as soma_comissao,a.app_users_id,a.saldo,b.tipo_chave,b.chave
        FROM `app_users_saldo` AS a
        INNER JOIN `app_users_pix` AS b ON b.app_users_id = a.app_users_id
        INNER JOIN `app_saldo_pagamentos` AS c ON b.app_users_id = c.app_users_id
        WHERE c.data='$novaData' AND c.status='2'
        GROUP BY a.app_users_id
        ");


        $sql->execute();
        $sql->bind_result($soma_comissao,$id_motorista, $saldo, $tipo_chave, $chave);
        $sql->store_result();
        $rows = $sql->num_rows();

        if ($rows == 0) {
            $lista=[];
        } else {
            while ($row = $sql->fetch()) {

                $param['soma_comissao'] = $soma_comissao;
                $param['id_motorista'] = $id_motorista;
                $param['saldo'] = $saldo;
                $param['tipo_chave'] = $tipo_chave;
                $param['chave'] = $chave;

                $lista[] = $param;
            }
        }
        return $lista;
    }

    public function efetuarPagamento($id_user,$valor)
    {
        $sql_saldo = $this->mysqli->prepare("SELECT saldo FROM `app_users_saldo` WHERE app_users_id=?");
        $sql_saldo->bind_param("i", $id_user);
        $sql_saldo->execute();
        $saldo = $sql_saldo->get_result()->fetch_assoc()['saldo'];
        if ($saldo < $valor) {
            $valor = $saldo; // caso o valor inserido seja maior que o saldo, subtraia apenas o saldo.
        }

        $sql = $this->mysqli->prepare("UPDATE `app_users_saldo`
        SET saldo= saldo - $valor , data='$this->data_atual_h'
        WHERE app_users_id='$id_user'");
        $sql->execute();

    }

    public function updateComissoes($data, $status)
    {

        $sql = $this->mysqli->prepare("UPDATE `app_saldo_pagamentos` SET status='$status' WHERE data='$data'");
        $sql->execute();

    }

    public function cronTransfer(){

        $this->novaData = date('Y-m-d', strtotime($this->data_atual_s . " -1 days"));

        $motorista_com_saldo = $this->motoristasSaldo($this->novaData);


        foreach ($motorista_com_saldo as $motorista) {

            $id_motorista =  $motorista['id_motorista'];
            $saldo = $motorista['saldo'];
            $soma_comissao = $motorista['soma_comissao'];
            $chave =  $motorista['chave'];

            if($motorista['tipo_chave'] == 1){
                $tipo_chave = "CPF/CNPJ";

            }elseif($motorista['tipo_chave'] == 2){
                $tipo_chave = "PHONE";
            }elseif($motorista['tipo_chave'] == 3){
                $tipo_chave = "EMAIL";
            }elseif($motorista['tipo_chave'] == 4){
                $tipo_chave = "EVP";
            }
            $asaas = $this->asaasTransferIndividual($id_motorista,$chave,$tipo_chave,$saldo,$soma_comissao);

            if($asaas['status'] == 1){

                //atualizado saldo e coloca todas comissoes como pagas data de ontem
                $valor_comissao = $this->efetuarPagamento($id_motorista, $soma_comissao);
                $update_comissoes = $this->updateComissoes($this->novaData, $status = 1);

                $notificacao->save("pagamento-comissao", $id_motorista, moneyView($soma_comissao));
            }
        }

    }






}
