<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Usuarios/Enderecos.class.php';
require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Reservas/Reservas.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';


class Pagamentos extends Conexao
{


    public function __construct()
    {
        $this->Conecta();
        // $this->ConectaWordPress();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->tabela = "app_pedidos";
        $this->tabela_users = "app_users";
        $this->tabela_status = "app_pedidos_status";
    }


    public function save($id_user,$id_anuncio,$tipo_pagamento,$valor_final,$valor_anunciante,$valor_admin,$cartao_id, $qrcode, $token,$status){

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_pagamentos`(`app_users_id`, `app_anuncios_id`,`tipo_pagamento`,`valor_final`,`valor_anunciante`,`valor_admin`,`cartao_id`,`qrcode`,`data`,`token`,`status`)
             VALUES ('$id_user','$id_anuncio','$tipo_pagamento','$valor_final','$valor_anunciante','$valor_admin','$cartao_id','$qrcode', '$this->data_atual','$token','$status')"
        );
        $sql_cadastro->execute();

        $id_pagamento = $sql_cadastro->insert_id;

        $Param = [
            "status" => "01",
            "id" => $id_pagamento,
            "msg" => "Reserva efetuada com sucesso."
        ];

        return $Param;
    }


    public function estornarTudoToken($token) {


        $url = ASAAS_URL."v3/payments/".$token."/refund";

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

        if ($httpCode != 200) {
            return $json_data['errors'][0]['description'];
        }else{
            return $json_data;
        }

        // Fecha a sessão cURL
        curl_close($ch);
    }
    public function estornarTaxandoToken($valor,$token) {

        $url = ASAAS_URL."v3/payments/".$token."/refund";

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

        if ($httpCode != 200) {
            return $json_data['errors'][0];
        }else{
            return $json_data;
        }
        // Verifica se houve algum erro na requisição

        // Fecha a sessão cURL
        curl_close($ch);
    }

    public function cobrarCartao($valor,$customer,$token,$card_number,$month,$year,$cvv,$nome,$cpf,$cep,$numero,$email,$celular)
    {

        // URL da API
        $url = ASAAS_URL.'v3/payments';

        if(!empty($token)){
            // Dados da requisição
            $data = array(
                'billingType' => 'CREDIT_CARD',
                'customer' => $customer,
                'value' => $valor,
                'dueDate' => $this->data_atual,
                'creditCardToken' => $token,
                'authorizeOnly' => true
            );
        }else{
            // Dados da requisição
            $data = array(
                'billingType' => 'CREDIT_CARD',
                'customer' => $customer,
                'value' => $valor,
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
            "payment_id" => $json_data['id']
        ];

        return $lista;
    }
    public function cobrarCartaoComToken($valor, $customer, $token, $nome, $cpf, $cep, $numero, $email, $celular)
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
        "payment_id" => $json_data['id']
    ];

    return $lista;
}


    public function gerarCobrancaPix($valor, $id_customer)
    {

        // URL da API
        $url = ASAAS_URL.'v3/payments';

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

        return $json_data;
    }

    public function verificarClientePorEmail($email)
    {
        // URL da API para listar clientes
        $url = ASAAS_URL . 'v3/customers?email=' . urlencode($email);

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
        $url = ASAAS_URL."v3/customers";

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
        $url = ASAAS_URL.'v3/payments/'.$payment_id.'/pixQrCode';

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


    public function listIDPagamento($token)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `app_pagamentos` WHERE token='$token'");
        $sql->execute();
        $sql->bind_result($id);
        $sql->fetch();
        $sql->store_result();
        $rows = $sql->num_rows;

        return $id_pagamento;

    }

    public function listComissoes($data_de,$data_ate)
    {
        $filter = " WHERE a.id > 0 ";
        if(!empty($data_de) AND !empty($data_ate)){
            $filter .= " AND a.data BETWEEN '$data_de' AND '$data_ate'";
        }

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id, a.valor, a.data, a.status, b.chave, c.id, c.nome
            FROM `app_saldo_pagamentos` as a
            INNER JOIN `app_users_pix` as b ON a.app_users_id = b.app_users_id
            INNER JOIN `app_users` as c ON b.app_users_id = c.id
            $filter
            ORDER BY a.data DESC
            ");




        $sql->execute();
        $sql->bind_result($id,$valor,$data,$status,$pix,$id_cliente,$nome);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];



        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {

                $item['id'] =$id;
                $item['valor'] = moneyView($valor);
                $item['pix'] =$pix;
                $item['data'] =dataBR($data);
                $item['status'] =statusComissao($status);
                $item['id_cliente'] = $id_cliente;
                $item['nome'] = decryptitem($nome);
                array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }


}
