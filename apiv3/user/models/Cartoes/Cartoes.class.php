<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Usuarios/Enderecos.class.php';
require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';


class Cartoes extends Conexao
{


    public function __construct()
    {
        $this->Conecta();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->tabela = "app_pedidos";
        $this->tabela_users = "app_users";
        $this->tabela_status = "app_pedidos_status";
    }

    public function selecionarFavorito($id_user,$id_cartao)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_cartoes` SET status_favorito='2'
        WHERE app_users_id='$id_user'"
        );

        $sql_cadastro->execute();

        $sql_cadastro1 = $this->mysqli->prepare("
        UPDATE `app_cartoes` SET status_favorito='1'
        WHERE app_users_id='$id_user' AND id='$id_cartao'"
        );

        $sql_cadastro1->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cartão favorito atualizado"
        ];

        return $Param;
    }

    public function listCartoes($id_user)
    {
        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,a.final,a.bandeira,a.token,b.nome,a.status_favorito
            FROM `app_cartoes` AS a
            INNER JOIN `app_users` AS b ON a.app_users_id=b.id
            WHERE a.app_users_id='$id_user'
            "
        );

        $sql->execute();
        $sql->bind_result($id,$final,$bandeira,$token,$nome_user,$favorito);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {
                $Param['id'] = $id;
                $Param['final'] = $final;
                $Param['bandeira'] = $bandeira;
                $Param['status_favorito'] = $favorito;
                $Param['nome_user'] = decryptitem($nome_user);
                // $Param['token'] = $token;
                $Param['rows'] = $rows;

                array_push($lista, $Param);
            }
        }
        return $lista;
    }


    public function deleteCartao($id_user,$item)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_cartoes` WHERE id='$item' AND app_users_id='$id_user'"
        );

        $sql_limpa->execute();


        $Param = [
            "status" => "01",
            "msg" => "Cartão removido"
        ];

        return $Param;

    }
    public function saveCartao($id_user,$card_number,$expiration_month,$expiration_year,$security_code,$nome, $cpf, $cep, $numero)
    {
        $usuarios = new Usuarios();
        $dados_user = $usuarios->Perfil($id_user);

        $celular = $dados_user['celular'];
        $email = $dados_user['email'];

        $cliente_id=$this->criar_cliente($nome,$cpf);
        if(!$cliente_id){
            $Param = [
                "status" => "02",
                "msg" => "Erro ao salvar o cartão.",
            ];
            return $Param;
        }


        $url = ASAAS_URL_PRODUCTION."v3/creditCard/tokenize";
        // Dados da requisição
        $data = array(
            "creditCard" => array(
                "holderName" => "$nome",
                "number" => "$card_number",
                "expiryMonth" => "$expiration_month",
                "expiryYear" => "$expiration_year",
                "ccv" => "$security_code"
            ),
            "creditCardHolderInfo" => array(
                "name" => "$nome",
                "email" => "$email",
                "cpfCnpj" => "$cpf",
                "postalCode" => "$cep",
                "addressNumber" => "$numero",
                "phone" => "$celular"
            ),
            "customer" => "$cliente_id"
        );

        // Token de acesso
        $access_token = ASAAS_KEY; // Substitua pelo seu token real

        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'access_token: ' . $access_token,
            'content-type: application/json',
            'User-Agent: PostmanRuntime/7.28.0'
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        $json_data = json_decode($response, true);

        //print_r($json_data);exit;

        if($json_data['creditCardNumber']){
            $final =$json_data['creditCardNumber'];
            $bandeira =$json_data['creditCardBrand'];
            $token=$json_data['creditCardToken'];
            $card_number="";
            $expiration_month="";
            $expiration_year="";
            $security_code="";
        }else{
            $final =obterUltimos4Numeros($card_number);
            $bandeira =identificarBandeiraCartao($card_number);
            $token="";
            $card_number=cryptitem($card_number);
            $expiration_month=cryptitem($expiration_month);
            $expiration_year=cryptitem($expiration_year);
            $security_code=cryptitem($security_code);
        }

        $nome=cryptitem($nome);
        $cpf=cryptitem($cpf);
        $cep=cryptitem($cep);
        $numero=cryptitem($numero);

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_cartoes`(`app_users_id`,`customer`,`final`,`bandeira`,`token`,`card_number`,`month`,`year`,`cvv`,`nome`,`cpf`,`cep`,`numero`,`status_favorito`)
            VALUES ('$id_user','$cliente_id','$final','$bandeira','$token','$card_number','$expiration_month','$expiration_year','$security_code','$nome','$cpf','$cep','$numero','2')"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cartão salvo com sucesso.",
        ];

        // Fecha a sessão cURL
        curl_close($ch);

        return $Param;



    }

    public function saveCartaoSandbox($id_user,$card_number,$expiration_month,$expiration_year,$security_code,$nome, $cpf, $cep, $numero)
    {
        $usuarios = new Usuarios();
        $dados_user = $usuarios->Perfil($id_user);

        $celular = $dados_user['celular'];
        $email = $dados_user['email'];

        $cliente_id=$this->criar_cliente_sandbox($nome,$cpf);
        if(!$cliente_id){
            $Param = [
                "status" => "02",
                "msg" => "Erro ao salvar o cartão.",
            ];
            return $Param;
        }


        $url = ASAAS_URL ."v3/creditCard/tokenize";
        // Dados da requisição
        $data = array(
            "creditCard" => array(
                "holderName" => "$nome",
                "number" => "$card_number",
                "expiryMonth" => "$expiration_month",
                "expiryYear" => "$expiration_year",
                "ccv" => "$security_code"
            ),
            "creditCardHolderInfo" => array(
                "name" => "$nome",
                "email" => "$email",
                "cpfCnpj" => "$cpf",
                "postalCode" => "$cep",
                "addressNumber" => "$numero",
                "phone" => "$celular"
            ),
            "customer" => "$cliente_id"
        );

        // Token de acesso
        $access_token = ASAAS_KEY_SANDBOX; // Substitua pelo seu token real

        // Inicializa a sessão cURL
        $ch = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'access_token: ' . $access_token,
            'content-type: application/json',
            'User-Agent: PostmanRuntime/7.28.0'
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        $json_data = json_decode($response, true);

        //print_r($json_data);exit;

        if($json_data['creditCardNumber']){
            $final =$json_data['creditCardNumber'];
            $bandeira =$json_data['creditCardBrand'];
            $token=$json_data['creditCardToken'];
            $card_number="";
            $expiration_month="";
            $expiration_year="";
            $security_code="";
        }else{
            $final =obterUltimos4Numeros($card_number);
            $bandeira =identificarBandeiraCartao($card_number);
            $token="";
            $card_number=cryptitem($card_number);
            $expiration_month=cryptitem($expiration_month);
            $expiration_year=cryptitem($expiration_year);
            $security_code=cryptitem($security_code);
        }

        $nome=cryptitem($nome);
        $cpf=cryptitem($cpf);
        $cep=cryptitem($cep);
        $numero=cryptitem($numero);

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_cartoes`(`app_users_id`,`customer`,`final`,`bandeira`,`token`,`card_number`,`month`,`year`,`cvv`,`nome`,`cpf`,`cep`,`numero`,`status_favorito`)
            VALUES ('$id_user','$cliente_id','$final','$bandeira','$token','$card_number','$expiration_month','$expiration_year','$security_code','$nome','$cpf','$cep','$numero','2')"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cartão salvo com sucesso.",
        ];

        // Fecha a sessão cURL
        curl_close($ch);

        return $Param;



    }

    // public function saveCartao($id_user,$card_number,$expiration_month,$expiration_year,$security_code,$nome, $cpf, $cep, $numero)
    // {
    //     $usuarios = new Usuarios();
    //     $dados_user = $usuarios->Perfil($id_user);
    //     $celular= $dados_user['celular'];
    //     $email =$dados_user['email'];

    //     $final =obterUltimos4Numeros($card_number);
    //     $bandeira =identificarBandeiraCartao($card_number);
    //     $token="";


    //     $card_number=cryptitem($card_number);
    //     $expiration_month=cryptitem($expiration_month);
    //     $expiration_year=cryptitem($expiration_year);
    //     $security_code=cryptitem($security_code);
    //     $nome=cryptitem($nome);
    //     $cpf=cryptitem($cpf);
    //     $cep=cryptitem($cep);
    //     $numero=cryptitem($numero);

    //     $sql_cadastro = $this->mysqli->prepare(
    //         "INSERT INTO `app_cartoes`(`app_users_id`,`customer`,`final`,`bandeira`,`token`,`card_number`,`month`,`year`,`cvv`,`nome`,`cpf`,`cep`,`numero`,`status_favorito`)
    //         VALUES ('$id_user','','$final','$bandeira','$token','$card_number','$expiration_month','$expiration_year','$security_code','$nome','$cpf','$cep','$numero','2')"
    //     );

    //     $sql_cadastro->execute();

    //     $Param = [
    //         "status" => "01",
    //         "msg" => "Cartão salvo com sucesso.",
    //     ];

    //     // Fecha a sessão cURL
    //     curl_close($ch);

    //     return $Param;



    // }
    public function criar_cliente($nome,$cpf)
    {
        $url = ASAAS_URL_PRODUCTION."v3/customers";

        $headers = array(
            'accept: application/json',
            'access_token:'. ASAAS_KEY,
            'content-type: application/json',
            'User-Agent: PostmanRuntime/7.28.0'
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

    public function criar_cliente_sandbox($nome,$cpf)
    {
        $url = ASAAS_URL ."v3/customers";

        $headers = array(
            'accept: application/json',
            'access_token:'. ASAAS_KEY_SANDBOX,
            'content-type: application/json',
            'User-Agent: PostmanRuntime/7.28.0'
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
}
