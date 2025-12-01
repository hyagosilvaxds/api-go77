<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once MODELS . '/Anuncios/Anuncios.class.php';
require_once MODELS . '/Reservas/Reservas.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/phpMailer/Enviar.class.php';


class Usuarios extends Conexao
{


    public function __construct()
    {
        $this->Conecta();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->data = date('Y-m-d');
        // $this->helper = new UsuariosHelper();
        $this->tabela = "app_users";
    }


    public function tiposCarros()
    {



        $sql = $this->mysqli->prepare(
            "
            SELECT id,nome,url
            FROM `app_tipos_carros`
            WHERE status='1'
            "
        );

        $sql->execute();
        $sql->bind_result($id,$nome,$icone);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        } else {
            while ($row = $sql->fetch()) {
                $Param['id'] = $id;
                $Param['nome'] = $nome;
                $Param['icone'] = $icone;
                    array_push($lista, $Param);
            }
        }

        // print_r($lista);
        return $lista;
    }
    public function updateSplit($id_usuario,$cpf,$nome_conta,$codigo_banco,$numero_agencia,$digito_agencia,$numero_conta,$digito_conta,$tipo_conta,$email,$recipient_id){
        // Verificando e atribuindo o tipo de conta com base no valor recebido
        if ($tipo_conta == '1') {
            $tipo_conta = 'checking';
        } else {
            $tipo_conta = 'savings';
        }

        // Montando o corpo da requisição em formato de array
        $body = array(
            "bank_account" => array(
                "holder_name" => $nome_conta,
                "holder_type" => "individual",
                "holder_document" => $cpf,
                "bank" => $codigo_banco,
                "branch_number" => $numero_agencia,
                "branch_check_digit" => $digito_agencia,
                "account_number" => $numero_conta,
                "account_check_digit" => $digito_conta,
                "type" => $tipo_conta
            )
        );

        // URL da API e chave de API
        $url = 'https://api.pagar.me/core/v5/recipients/' . $recipient_id . '/default-bank-account';
        $apiKey = PAGARME_KEY;

        // Configurando a requisição cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH'); // Usando PATCH method
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode($apiKey . ':'),
            'Content-Type: application/json',
            'Accept: application/json'
        ));

        // Executando a requisição e capturando a resposta
        $response = curl_exec($ch);
        // Verificando por erros
        if(curl_errno($ch)) {
            echo 'Erro ao fazer a requisição: ' . curl_error($ch);
        }

        // Fechando a conexão
        curl_close($ch);

        // Decodificando a resposta JSON
        $jsonData = json_decode($response, true);

        // print_r($jsonData);exit;
        // Exibindo a resposta
        if(isset($jsonData['id'])){
            $split_id = $jsonData['id'];
            $Param = array(
                "status" => "01",
                "msg" => "Split atualizado com sucesso!"
            );

            // Atualizando os dados no banco de dados
            $documento = cryptItem($cpf);
            $sql_cadastro = $this->mysqli->prepare("
                UPDATE `app_users` SET split='$split_id', documento='$documento' WHERE id='$id_usuario'"
            );
            $sql_cadastro->execute();
        } else {
            $Param = array(
                "status" => "02",
                "msg" => "Para editar os dados bancários entre em contato com o suporte.",
                "msg2" => $jsonData['message']
            );
        }

        return $Param;


    }
    public function save($tipo, $cod, $nome_fantasia, $nome, $email, $celular, $hash, $avatar, $status){


        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_users`(`tipo`, `cod`, `nome_empresa`, `nome`, `email`, `password`, `celular`, `avatar`, `data_cadastro`, `u_login`, `status`, `status_aprovado`)
            VALUES ('$tipo', '$cod', '$nome_fantasia', '$nome', '$email', '$hash', '$celular', '$avatar', '$this->data_atual', '$this->data_atual', '$status', '$status')"
        );

        $sql_cadastro->execute();
        $this->id_cadastro = $sql_cadastro->insert_id;

        $Param = [
            "status" => "01",
            "msg" => "Cadastro efetuado com sucesso.",
            "cod_cliente" => $cod,
            "id" => $this->id_cadastro,
            "nome" => $nome,
            "email" => $email
        ];

        return $Param;
    }

    public function saveInteresse($id_user, $interesses){

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_users_interesses` WHERE app_users_id='$id_user'"
        );

        $sql_limpa->execute();

        foreach ($interesses as $categoria) {

            $sql_cadastro = $this->mysqli->prepare(
                "INSERT INTO `app_users_interesses`(`app_users_id`, `app_categorias_id`)
                VALUES ('$id_user', '$categoria')"
            );

            $sql_cadastro->execute();
        }

        $Param = [
            "status" => "01",
            "msg" => "Interesses atualizados com sucesso."
        ];

        return $Param;

    }

    public function saveSplit($id_usuario,$cpf,$nome_conta,$codigo_banco,$numero_agencia,$digito_agencia,$numero_conta,$digito_conta,$tipo_conta,$email){

        if($tipo_conta == 1){$tipo_conta="checking";}else{$tipo_conta="savings";}

        $body = array(

            "default_bank_account" => array(
                "holder_name" => "$nome_conta",
                "bank" => "$codigo_banco",
                "branch_number" => "$numero_agencia",
                "branch_check_digit" => "$digito_agencia",
                "account_number" => "$numero_conta",
                "account_check_digit" => "$digito_conta",
                "holder_type" => "individual",
                "holder_document" => "$cpf",
                "type" => "$tipo_conta"
            ),
            "transfer_settings" => array(
                "transfer_enabled" => true,
                "transfer_interval" => "Weekly",
                "transfer_day" => 1
            ),
            "name" => "$nome_conta",
            "email" => "$email",
            "description" => "id: $id_usuario",
            "document" => "$cpf",
            "type" => "individual",
            "code" => "id: $id_usuario"
        );


        // URL da API e chave de API
        $url = PAGARME_URL.'/recipients';
        $apiKey = PAGARME_KEY;

        // Configurar a requisição
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode($apiKey . ':'),
            'Content-Type: application/json'
        ));

        // Executar a requisição e capturar a resposta
        $response = curl_exec($ch);

        // Verificar por erros
        if(curl_errno($ch)) {
            echo 'Erro ao fazer a requisição: ' . curl_error($ch);
        }

        // Fechar a conexão
        curl_close($ch);
        $jsonData = json_decode($response,true);
        // Exibir a resposta

        if($jsonData['id']){
            $split_id= $jsonData['id'];
            $Param = [
                "status" => "01",
                "msg" => "Split cadastrado com sucesso!"
            ];

            $documento = cryptItem($cpf);
            $sql_cadastro = $this->mysqli->prepare("
            UPDATE `app_users` SET split='$split_id', documento='$documento' WHERE id='$id_usuario'"
            );
            $sql_cadastro->execute();

        }else{
            $Param = [
                "status" => "02",
                "msg" => $jsonData['message']
            ];
        }


        return $Param;

    }


    public function updateDoc($app_users_id, $avatar_final,$lado,$tipo){


        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_veiculos_doc` WHERE app_users_id='$app_users_id' AND doc_lado='$lado' AND tipo='$tipo'"
        );

        $sql_limpa->execute();

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_veiculos_doc`(`app_users_id`, `tipo`,`doc_lado`,`documento`, `status`)
            VALUES ('$app_users_id', '$tipo', '$lado', '$avatar_final','2')"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Documento enviado com sucesso."
        ];

        return $Param;

    }

    public function saveLocation($id, $latitude, $longitude){


        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_users_location`(`app_users_id`, `latitude`, `longitude`, `data`)
            VALUES ('$id', '$latitude', '$longitude', '$this->data_atual')"
        );

        $sql_cadastro->execute();

    }
    public function cadastroApp($nome, $email, $hash, $celular)
    {

        $this->token = geraToken(rand(5, 15), rand(100, 500), rand(6000, 10000));

        $status_aprovado = 1;
        $status = 1;
        $avatar = "avatar.png";
        if($tipo == 2){
            $status_aprovado = 1;
        }

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_users`(`nome`, `email`,`password`, `data_cadastro`, `token_cadastro`, `perc_imoveis`, `perc_eventos`, `status_aprovado`, `status`,`avatar`,`celular`,`id_grupo`,`tipo_pessoa`)
            VALUES ('$nome','$email', '$hash', '$this->data_atual', '$this->token', '0.00', '0.00', '$status_aprovado', '$status','$avatar','$celular','4','1')"
        );

        $sql_cadastro->execute();
        $this->id_cadastro = $sql_cadastro->insert_id;

        $Param = [
            "status" => "01",
            "msg" => "Cadastro efetuado com sucesso.",
            "id" => $this->id_cadastro,
            "nome" => decryptitem($nome),
            "email" => decryptitem($email),
            "token_cadastro" => $this->token
        ];

        return $Param;
    }
    public function savePlanoGratis($id_user)
    {
        $plano_gratuito = 2;

        $sql = $this->mysqli->prepare("SELECT validade_dias FROM app_planos WHERE id='$plano_gratuito'");
        $sql->execute();
        $sql->bind_result($this->dias);
        $sql->store_result();
        $sql->fetch();

        $data_validade  = date('Y-m-d H:i:s', strtotime("+{$this->dias} days"));
        // echo "data de validade= ". $data_validade . " E dias = " . $this->dias;exit;

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_users_planos`(`app_users_id`,`app_planos_id`,`data_cadastro`,`data_validade`)
            VALUES ('$id_user','$plano_gratuito','$this->data_atual','$data_validade')"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cadastro efetuado com sucesso.",
        ];

        return $Param;
    }






    public function updateLocation($id_user, $latitude, $longitude)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_users_location` SET latitude='$latitude', longitude='$longitude', data='$this->data_atual'
        WHERE app_users_id='$id_user'"
        );

        $sql_cadastro->execute();


        $Param = [
            "status" => "01",
            "msg" => "Localização atualizada"
        ];

        return $Param;
    }

    public function listCorrida($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.app_corridas_id, a.prioridade_delay
            FROM `app_corridas_disparos` AS a
            INNER JOIN `app_corridas` AS b ON a.app_corridas_id = b.id
            WHERE a.id_motorista = '$id_usuario' AND a.status = '3' AND b.status='3'
            AND (a.data + INTERVAL a.prioridade_delay SECOND) <= NOW()
            ORDER BY a.prioridade_delay ASC, a.data DESC
            LIMIT 1;
        "
        );
        $sql->execute();
        $sql->bind_result($id_corrida,$prioridade_delay);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        $usuarios = [];
        $corridaInfo = $this->corridaInfo($id_corrida);


        // print_r($usuarios);exit;
        return $corridaInfo;
    }
    public function corridaInfo($id_corrida)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id, a.id_usuario,a.id_motorista,a.valor_total,a.duracao_min,a.distancia_km,a.bagagem_status,a.obs,a.data,a.status,
            b.origem,b.origem_lat,b.origem_long,b.parada1,b.parada1_lat,b.parada1_long,b.parada2,b.parada2_lat,b.parada2_long,b.destino,b.destino_lat,b.destino_long,b.polyline,
            c.valor_motorista,b.polyline_motorista,a.cupom,a.paradas_feitas
            FROM `app_corridas` AS a
            INNER JOIN `app_corridas_end` AS b ON a.id=b.app_corridas_id
            INNER JOIN `app_corridas_pagamentos` AS c ON a.id=c.app_corridas_id
            WHERE a.id = '$id_corrida'
            LIMIT 1;
        "
        );
        $sql->execute();
        $sql->bind_result($id_corrida,$id_usuario,$id_motorista,$valor_total,$duracao_min,$distancia_km,$bagagem_status,$obs,$data,$status,
        $origem,$origem_lat,$origem_long,$parada_end_1,$parada1_lat,$parada1_long,$parada_end_2,$parada2_lat,$parada2_long,$destino,$destino_lat,$destino_long,
        $polyline,$valor_motorista,$polyline_motorista,$cupom,$paradas_feitas);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        while ($row = $sql->fetch()) {
            $item['id_corrida'] =$id_corrida;
            if ($status == 1 || $status == 5) {
                //se corrida completa ou iniciou nao preciso verificar se chegou , pois ele ja chegou anteriormente.
                $item['status_chegou'] = 2;
            }else{
                $item['status_chegou'] =$this->verificaChegou($id_motorista,$origem_lat,$origem_long);
            }
            if(!empty($parada1_lat)){
                //verifica se o motorista esta a X metros da parada 1 ou 2.
                $parada1=$this->verificaChegou($id_motorista,$parada1_lat,$parada1_long);
                $parada2 = 2;
                if(!empty($parada2_lat)){
                    $parada2=$this->verificaChegou($id_motorista,$parada2_lat,$parada2_long);
                }
                if(($parada1 == 1) || ($parada2 == 1)){
                    //se ja estou parado, status 3 para indicar q estou aguardando
                    if($parada2 == 1){
                        if($paradas_feitas == 1){
                            $this->atualizaParadas($id_corrida,2);
                        }
                    }else{
                        if($paradas_feitas == 0){
                            $this->atualizaParadas($id_corrida,1);
                        }
                    }

                    if($status == 6){
                        $status_parada = 3;
                    }else{
                        $status_parada = 1;
                    }
                }else{
                    $status_parada = 2;
                }


                $item['status_parada'] =$status == 6 ? 3 : $parada1;
            }else{
                $item['status_parada'] =2;
            }
            if(!empty($cupom)){
                $percCupom = $this->percCupom($cupom);
                $valor_original = $valor_total / (1 - ($percCupom / 100));
                $item['desconto'] =number_format($valor_original - $valor_total,2);
            }else{
                $item['desconto'] ="0";
            }
            $item['passageiro'] =$this->userInfo($id_usuario);
            $item['motorista'] =$this->userInfo($id_motorista);
            $veiculo = $this->veiculoInfo($id_motorista);
            $item['placa_moto'] =$veiculo['placa'];
            $item['modelo_moto'] =$veiculo['modelo'];
            $item['cor_moto'] =$veiculo['cor'];
            $item['valor_total'] =$valor_total;
            $item['valor_motorista'] =$valor_motorista;
            $item['duracao_min'] =$duracao_min;
            $item['distancia_km'] =$distancia_km;
            $item['bagagem_status'] =$bagagem_status;
            $item['obs'] =$obs;
            $item['data'] =$data;
            $item['status'] =$status;
            switch ($status) {
                case '1':
                    $item['status_text'] ='Completa';
                    $item['status_text_passageiro'] ='Completa';
                  break;
                case '2':
                    $item['status_text'] ='Trajeto';
                    $item['status_text_passageiro'] ='Trajeto';
                  break;
                case '3':
                    $item['status_text'] ='Solicitando';
                    $item['status_text_passageiro'] ='Solicitando';
                  break;
                case '4':
                    $item['status_text'] ='Cancelada';
                    $item['status_text_passageiro'] ='Cancelada';
                  break;
                  case '5':
                    $item['status_text'] ='Iniciada';
                    $item['status_text_passageiro'] ='Iniciada';
                  break;
                  case '6':
                    $item['status_text'] ='Aguardando o passageiro';
                    $item['status_text_passageiro'] ='Motorista chegou';
                  break;
              }

            $item['origem'] =$origem;
            $item['origem_lat'] =$origem_lat;
            $item['origem_long'] =$origem_long;

            $item['parada1'] =$parada_end_1;
            $item['parada1_lat'] =$parada1_lat;
            $item['parada1_long'] =$parada1_long;

            $item['parada2'] =$parada_end_2;
            $item['parada2_lat'] =$parada2_lat;
            $item['parada2_long'] =$parada2_long;

            $item['destino'] =$destino;
            $item['destino_lat'] =$destino_lat;
            $item['destino_long'] =$destino_long;

            $item['polyline'] =$polyline;
            $item['polyline_motorista'] =$polyline_motorista;
            $item['notification_sound'] =HOME_URI."/uploads/notification.mp3";
            $item['button_sound'] =HOME_URI."/uploads/button.mp3";

            $location = $this->listLocation($id_motorista);
            if($paradas_feitas == 0){
                $maps = criaStringMapas($location['lat'],$location['long'],$destino_lat,$destino_long,$parada1_lat,$parada1_long,$parada2_lat,$parada2_long);
            }
            if($paradas_feitas == 1){
                $maps = criaStringMapas($location['lat'],$location['long'],$destino_lat,$destino_long,$parada2_lat,$parada2_long,"","");
            }
            if($paradas_feitas == 2){
                $maps = criaStringMapas($location['lat'],$location['long'],$destino_lat,$destino_long,"","","","");
            }

            $maps_motorista = criaStringMapas($location['lat'],$location['long'],$origem_lat,$origem_long,"","","","");

            $item['google_maps_motorista'] = $maps_motorista['google_maps'];
            $item['apple_maps_motorista'] = $maps_motorista['apple_maps'];
            $item['waze_motorista'] = $maps_motorista['waze'];

            $item['google_maps'] = $maps['google_maps'];
            $item['apple_maps'] = $maps['apple_maps'];
            $item['waze'] = $maps['waze'];

            $item['rows'] = $rows;
            // gerarLogUserEntrada($maps['google_maps'],$id_motorista,"while do corridaInfo");
            array_push($usuarios,$item);
        }

        // print_r($usuarios);exit;
        return $usuarios[0];
    }
    public function percCupom($cupom)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT perc_desconto
            FROM `app_cupons`
            WHERE codigo='$cupom'
            "
        );

        $sql->execute();
        $sql->bind_result($perc_desconto);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        $lista = [];

        // print_r($perc_desconto);
        return $perc_desconto;
    }
    public function getSaldoPagarme($id_split)
    {
        $body = array();


        // URL da API e chave de API
        $url = PAGARME_URL."/recipients/$id_split/balance";
        $apiKey = PAGARME_KEY;

        // Configurar a requisição
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode($apiKey . ':'),
            'Content-Type: application/json'
        ));

        // Executar a requisição e capturar a resposta
        $response = curl_exec($ch);

        // Verificar por erros
        if(curl_errno($ch)) {
            echo 'Erro ao fazer a requisição: ' . curl_error($ch);
        }

        // Fechar a conexão
        curl_close($ch);
        $response = json_decode($response,true);
        // Exibir a resposta

        return $response['waiting_funds_amount'];


    }
    public function verificaSplit($id_split)
    {
        $body = array();


        // URL da API e chave de API
        $url = PAGARME_URL."/recipients/$id_split";
        $apiKey = PAGARME_KEY;

        // Configurar a requisição
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode($apiKey . ':'),
            'Content-Type: application/json'
        ));

        // Executar a requisição e capturar a resposta
        $response = curl_exec($ch);

        // Verificar por erros
        if(curl_errno($ch)) {
            echo 'Erro ao fazer a requisição: ' . curl_error($ch);
        }

        // Fechar a conexão
        curl_close($ch);
        $response = json_decode($response,true);
        // print_r($response);exit;
        // Exibier a resposta

        if($response['id']){
            $Param = [
                "status" => "01",
                "msg" => "Split cadastrado com sucesso!"
            ];
        }else{
            $Param = [
                "status" => "02",
                "msg" => "Não foi encontrado os registros para esse usuário"
            ];
        }


        return $Param;


    }
    public function getDadosBancarios($id_split)
    {
        $body = array();


        // URL da API e chave de API
        $url = PAGARME_URL."/recipients/$id_split";
        $apiKey = PAGARME_KEY;

        // Configurar a requisição
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode($apiKey . ':'),
            'Content-Type: application/json'
        ));

        // Executar a requisição e capturar a resposta
        $response = curl_exec($ch);

        // Verificar por erros
        if(curl_errno($ch)) {
            echo 'Erro ao fazer a requisição: ' . curl_error($ch);
        }

        // Fechar a conexão
        curl_close($ch);
        $response = json_decode($response,true);
        // Exibir a resposta


        return $response['default_bank_account'];


    }
    public function verificaChegou($id_motorista,$origem_lat,$origem_long)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT latitude,longitude
            FROM `app_users_location`
            WHERE app_users_id='$id_motorista'
        "
        );
        $sql->execute();
        $sql->bind_result($motorista_lat,$motorista_long);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        $motorista = [];

        if ($rows == 0) {
            return "2";
        } else {
            $distancia = distancia($motorista_lat,$motorista_long,$origem_lat,$origem_long);
            $distancia_metros = $distancia*1000;

            // echo $distancia_metros;
            if($distancia_metros <= RAIO_PARADA){
                return 1 ;
            }else{
                return 2 ;
            }
        }
        // print_r($usuarios);exit;

    }
    public function userInfo($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,nome,descricao,avatar,tipo
            FROM `app_users`
            WHERE id='$id_usuario'
        "
        );
        $sql->execute();
        $sql->bind_result($id,$nome,$descricao,$avatar,$tipo);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);

        } else {
                while ($row = $sql->fetch()) {
                    $item['id'] =$id;
                    $item['nome'] =decryptitem($nome);
                    $item['descricao'] =$descricao;
                    $item['avatar'] =$avatar;
                    $item['avaliacao'] =$this->avaliacaoUser($id_usuario);
                    if($tipo == 2){
                        $latLong = $this->listLocation($id_usuario);
                        $item['lat'] =$latLong['lat'];
                        $item['long'] =$latLong['long'];
                    }
                    $item['rows'] = $rows;
                    array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function listLocation($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT latitude,longitude
            FROM `app_users_location`
            WHERE app_users_id='$id_usuario'
        "
        );
        $sql->execute();
        $sql->bind_result($lat,$long);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);

        } else {
                while ($row = $sql->fetch()) {
                    $item['lat'] =$lat;
                    $item['long'] = $long;
                    array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios[0];
    }
    public function verificaOnline($id)
    {
        $sql = $this->mysqli->prepare("SELECT * FROM app_users WHERE online='1'");
        $sql->execute();
        $sql->store_result();
        $rows = $sql->num_rows;

        return $rows;
    }

    public function VerificaTecnico($cod)
    {
        $sql = $this->mysqli->prepare("SELECT * FROM app_users WHERE cod='$cod' AND tipo='2'");
        $sql->execute();
        $sql->store_result();
        $rows = $sql->num_rows;

        return $rows;
    }

    public function findFotoFrota($id_frota){

        $sql = $this->mysqli->prepare("SELECT url FROM app_frotas WHERE id='$id_frota'");
        $sql->execute();
        $sql->bind_result($this->url_frota);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        return $this->url_frota;
    }

    public function findSaldo($id){

        $sql = $this->mysqli->prepare("SELECT saldo FROM app_users_saldo WHERE app_users_id='$id'");
        $sql->execute();
        $sql->bind_result($this->saldo);
        $sql->store_result();
        $sql->fetch();


        return $this->saldo;
    }

    public function updateSaldo($id, $saldo)
    {

        $sql_cadastro = $this->mysqli->prepare("UPDATE app_users_saldo SET saldo='$saldo' WHERE app_users_id='$id'");
        $sql_cadastro->execute();

    }

    public function verificaFcmUser($id){

        $sql = $this->mysqli->prepare("SELECT id FROM app_fcm WHERE app_users_id='$id'");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        return $rows;
    }

    public function verificaIDUser($cod){

        $sql = $this->mysqli->prepare("SELECT id FROM app_users WHERE cod='$cod'");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->store_result();
        $sql->fetch();


        return $this->id;
    }

    // public function buscaEndereco($end_busca,$id_user)
    // {
    //     $latLong=$this->listLocation($id_user);
    //     $data=autoCompleteEndereco($end_busca,$latLong['lat'],$latLong['long']);

    //     $usuarios=[];

    //     if ($data['status'] == 'OK') {
    //         $predictions = $data['predictions'];
    //         foreach ($predictions as $end) {
    //             // Processa a descrição para remover "State of" e manter apenas a sigla do estado
    //             $descricao = str_replace("State of ", "", $end['description']);
    //             $latLong = geocodeAddress($descricao);

    //             $item = [
    //                 'end_completo' => $descricao,
    //                 'latitude' => $latLong['lat'],
    //                 'longitude' => $latLong['long'],
    //                 'rows' => count($predictions)
    //             ];
    //             array_push($usuarios, $item);
    //         }
    //     } else {
    //         $item = ['rows' => 0];
    //         array_push($usuarios, $item);
    //     }

    //     return $usuarios;
    // }
    public function buscaEndereco($end_busca, $id_user, $latitude, $longitude)
    {
        $latLong = $this->listLocation($id_user);
        $data = autoCompleteEndereco($end_busca, $latitude, $longitude);


        $usuarios = [];

        if ($data['status'] == 'OK') {
            $predictions = $data['predictions'];
            foreach ($predictions as $end) {
                // Processa a descrição para remover "State of" e manter apenas a sigla do estado
                $descricao = str_replace("State of ", "", $end['description']);
                $latLongResult = geocodeAddress($descricao);

                // Calcula a distância entre as coordenadas do usuário e as coordenadas do resultado
                $distance = distancia($latitude, $longitude, $latLongResult['lat'], $latLongResult['long']);

                $item = [
                    'end_completo' => $descricao,
                    'latitude' => $latLongResult['lat'],
                    'longitude' => $latLongResult['long'],
                    'distance_meters' => floatval($distance),
                    'rows' => count($predictions)
                ];
                array_push($usuarios, $item);
            }

            // Ordena os resultados por distância
            usort($usuarios, function($a, $b) {
                if (floatval($a['distance_meters']) == floatval($b['distance_meters'])) {
                    return 0;
                }
                return (floatval($a['distance_meters']) < floatval($b['distance_meters'])) ? -1 : 1;
            });


        } else {
            $item = ['rows' => 0];
            array_push($usuarios, $item);
        }

        return $usuarios;
    }



    public function meusEnderecos($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,nome,end_completo,latitude,longitude
            FROM `app_users_endereco`
            WHERE app_users_id='$id_usuario'
        "
        );
        $sql->execute();
        $sql->bind_result($id,$nome,$end_completo,$latitude,$longitude);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);

        } else {
                while ($row = $sql->fetch()) {
                    $item['id'] =$id;
                    $item['nome'] =decryptitem($nome);
                    $item['end_completo'] =decryptitem($end_completo);
                    $item['latitude'] =decryptitem($latitude);
                    $item['longitude'] =decryptitem($longitude);
                    $item['rows'] = $rows;
                    array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }

    public function meusEnderecosSave($id_user,$nome,$end_completo,$lat,$long){
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_users_endereco`(`app_users_id`, `nome`, `end_completo`, `latitude`, `longitude`)
             VALUES ('$id_user','$nome','$end_completo','$lat','$long')"
        );
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cadastro efetuado com sucesso.",
        ];

        return $Param;
    }

    public function meusEnderecosDelete($item)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_users_endereco` WHERE id='$item'"
        );

        $sql_limpa->execute();


        $Param = [
            "status" => "01",
            "msg" => "Endereço removido"
        ];

        return $Param;

    }
    public function saveFcmUser($id, $type, $registration_id)
    {

        $sql = $this->mysqli->prepare("INSERT INTO app_fcm (app_users_id, type, registration_id) VALUES ('$id', '$type', '$registration_id')");
        $sql->execute();

        $Param['status'] = '01';
        $Param['msg'] = 'OK';

        return $Param;
    }

    public function updateFcmUser($id, $type, $registration_id)
    {

        $sql_cadastro = $this->mysqli->prepare("UPDATE app_fcm SET type='$type', registration_id='$registration_id' WHERE app_users_id='$id'");
        $sql_cadastro->execute();

        $Param['status'] = '01';
        $Param['msg'] = 'OK';

        return $Param;
    }

    public function atualizaParadas($id_corrida, $paradas)
    {

        $sql_cadastro = $this->mysqli->prepare("UPDATE app_corridas SET paradas_feitas='$paradas' WHERE id='$id_corrida'");
        $sql_cadastro->execute();
    }
    public function savePix($id_usuario,$tipo_chave,$chave){


        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_users_pix` WHERE app_users_id='$id_usuario'"
        );

        $sql_limpa->execute();

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_users_pix`(`app_users_id`, `tipo_chave`,`chave`)
            VALUES ('$id_usuario', '$tipo_chave', '$chave')"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Chave cadastrada com sucesso."
        ];

        return $Param;

    }

    public function Perfil($id)
    {

        $sql = $this->mysqli->prepare("SELECT a.id,a.tipo_pessoa,a.nome,a.email,a.password,a.celular,a.avatar,a.data_nascimento,
        a.data_cadastro,a.u_login,a.token_senha,a.status,a.status_aprovado,a.documento,a.cnpj,a.razao_social,a.nome_fantasia,a.ie,a.perc_imoveis,a.perc_eventos,
        b.tipo_chave,b.chave,
        c.saldo
        FROM `app_users` AS a
        LEFT JOIN `app_users_pix` AS b ON a.id=b.app_users_id
        LEFT JOIN `app_users_saldo` AS c ON a.id=c.app_users_id
        WHERE a.id = '$id'");
        $sql->execute();
        $sql->bind_result($this->id,$this->tipo_pessoa,$this->nome, $this->email, $this->password ,
        $this->celular, $this->avatar, $this->data_nascimento, $this->data_cadastro, $this->u_login, $this->token_senha, $this->status, $this->status_aprovado,
        $this->cpf,$this->cnpj,$this->razao_social,$this->nome_fantasia,$this->ie,$this->perc_imoveis,$this->perc_eventos,$this->tipo_chave,$this->chave,$this->saldo);
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();
        $sql->close();


        if ($rows == 0) {
            $error['status'] = '01';
            $error['msg'] = 'Nenhum registro encontrado.';
            return $error;
        } else {

            $model_anuncios = New Anuncios();
            $model_reservas = New Reservas();

            $dadosReserva = $model_reservas->findLastUser($this->id);

            $success['id'] = $this->id;
            $success['tipo_pessoa'] = $this->tipo_pessoa;
            $success['nome'] = decryptitem($this->nome);
            $success['email'] = decryptitem($this->email);
            $success['celular'] = decryptitem($this->celular);
            $success['data_nascimento'] = decryptitem($this->data_nascimento);
            $success['cpf'] = decryptitem($this->cpf);
            $success['cnpj'] = decryptitem($this->cnpj);
            $success['razao_social'] = decryptitem($this->razao_social);
            $success['nome_fantasia'] = decryptitem($this->nome_fantasia);
            $success['ie'] = decryptitem($this->ie);
            $success['tipo_chave'] = $this->tipo_chave;
            $success['chave'] = $this->chave;
            if($this->avatar){
                $success['avatar'] = $this->avatar;
            }
            else{
                $success['avatar'] = "avatar.png";
            }
            $success['saldo'] = moneyView($this->saldo);
            $success['status'] = $this->status ;
            $success['status_aprovado'] = $this->status_aprovado;
            $success['perc_imoveis'] = $this->perc_imoveis;
            $success['perc_eventos'] = $this->perc_eventos;
            $success['data_cadastro'] = data($this->data_cadastro);
            $success['u_login'] = data($this->u_login);
            $success['favoritos'] = $model_anuncios->listaFavoritos($this->id);
            $success['qtd_anuncios'] = $model_anuncios->countAnunciosUser($this->id);
            $success['ultimo_pagamento'] = $this->ultimo_pagamento($id);
            $success['id_ultima_reserva'] = $dadosReserva['id_reserva'];
            $success['verifica_avaliou'] = $model_anuncios->verificaAvaliou(
              $dadosReserva['id_reserva'],
              $dadosReserva['id_anuncio'],
              $dadosReserva['data_ate'],
              $dadosReserva['checkout'],
              $id
            );

            return $success;
        }
    }
    public function ultimo_pagamento($id)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT DISTINCT a.tipo_pagamento,a.cartao_id
            FROM `app_pagamentos` AS a
            WHERE a.app_users_id='$id'
            ORDER BY a.id DESC
            LIMIT 1
        "
        );
        $sql->execute();
        $sql->bind_result($tipo_pagamento,$cartao_id);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];


        while ($row = $sql->fetch()) {

            $param['tipo_pagamento'] =$tipo_pagamento;
            $param['cartao_id'] =$cartao_id;

            array_push($usuarios,$param);
        }
        if(COUNT($usuarios) == 0){
            $param['tipo_pagamento'] =2;
            $param['cartao_id'] ="";

            array_push($usuarios,$param);
        }

        return $usuarios;
    }
    public function veiculoInfo($id_motorista)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.cor,a.modelo,a.placa,a.tipo,b.url
            FROM `app_veiculos` AS a
            INNER JOIN `app_tipos_carros` AS b ON a.tipo=b.nome
            WHERE a.app_users_id='$id_motorista'
        "
        );
        $sql->execute();
        $sql->bind_result($cor,$modelo,$placa,$tipo,$url);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        $model = new Usuarios();
        $cores = $model->listCores();


        while ($row = $sql->fetch()) {

            foreach ($cores as $item) {
                if ($item['hex'] === $cor) {
                    $nomeCor = $item['nome']; // Armazena o nome da cor correspondente
                    break; // Para o loop após encontrar o valor
                }
            }
            $param['cor'] =$nomeCor;
            $param['cor_hex'] =$cor;
            $param['modelo'] = $modelo;
            $param['placa'] = $placa;
            $param['url'] = $url;
            $param['tipo'] = $tipo;
            array_push($usuarios,$param);
        }



        // print_r($usuarios);exit;
        return $usuarios[0];
    }
    public function qtdCaronas($id_usuario)
    {
        $sql = $this->mysqli->prepare(
            "
            SELECT COUNT(*)
            FROM `app_corridas`
            WHERE id_motorista = ? AND status = '2'
            "
        );

        // Substitui o valor do id_motorista de forma segura
        $sql->bind_param('i', $id_usuario);

        // Executa a query
        $sql->execute();

        // Atribui o resultado à variável $contagem
        $sql->bind_result($contagem);
        $sql->fetch();  // Extrai a linha do resultado

        // Fecha o statement
        $sql->close();

        // Retorna o valor da contagem ou 0 se não houver registros
        return $contagem ? $contagem : 0;
    }

    public function pegaValorReceber($id_usuario,$split)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT saldo
            FROM `app_users_saldo`
            WHERE app_users_id='$id_usuario'
        "
        );
        $sql->execute();
        $sql->bind_result($saldo);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        $saldoPagarMe = $this->getSaldoPagarme($split);
        $saldoPagarMe = $saldoPagarMe / 100;

        // print_r($usuarios);exit;
        return moneyView($saldo + $saldoPagarMe);
    }
    public function pegaChavePix($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT tipo_chave,chave
            FROM `app_users_pix`
            WHERE app_users_id='$id_usuario'
        "
        );
        $sql->execute();
        $sql->bind_result($tipo_chave,$chave);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];
            while ($row = $sql->fetch()) {
                $item['tipo_chave'] =$tipo_chave;
                $item['chave'] =$chave;
                array_push($usuarios,$item);
        }
        // print_r($usuarios);exit;
        return $usuarios[0];
    }

    public function listInterresesUser($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT b.id,b.nome,b.url
            FROM `app_users_interesses` AS a
            INNER JOIN `app_categorias` AS b ON a.app_categorias_id=b.id
            WHERE a.app_users_id='$id_usuario'
        "
        );
        $sql->execute();
        $sql->bind_result($id,$nome,$url);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];
            while ($row = $sql->fetch()) {
                $item['id'] =$id;
                $item['nome'] =$nome;
                $item['url'] =$url;
                array_push($usuarios,$item);
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function avaliacoes($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,a.id_de,b.nome,b.avatar,a.estrelas,a.descricao,a.data_cadastro
            FROM `app_relatorio` AS a
            INNER JOIN `app_users` AS b ON a.id_de=b.id
            WHERE a.tipo='1' AND a.id_para='$id_usuario'
            ORDER BY data_cadastro DESC
        "
        );
        $sql->execute();
        $sql->bind_result($id,$id_de,$nome,$avatar,$estrelas,$descricao,$data_cadastro);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];
            while ($row = $sql->fetch()) {
                $item['id_avaliacao'] =$id;
                $item['id_de'] =$id_de;
                $item['nome'] =decryptitem($nome);
                $item['avatar'] =$avatar;
                $item['estrelas'] =$estrelas;
                $item['descricao'] =$descricao;
                $item['data_cadastro'] =dataBR($data_cadastro);
                array_push($usuarios,$item);
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function avaliacaoUser($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT AVG(estrelas)
            FROM `app_relatorio`
            WHERE id_para='$id_usuario' AND (tipo='1' OR tipo='4')
        "
        );
        $sql->execute();
        $sql->bind_result($media);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];
            while ($row = $sql->fetch()) {
        }
        !$media ? $media = 5 : $media;
        // print_r($usuarios);exit;
        return number_format($media,2);
    }
    public function veiculoRetornaPendente($id)
    {

        // $sql_cadastro = $this->mysqli->prepare("
        // UPDATE `$this->tabela`
        //   SET status_aprovado='2',status='1'
        // WHERE id='$id'
        // ");

        // $sql_cadastro->execute();

        // $linhas_afetadas = $sql_cadastro->affected_rows;

            $param = [
                "status" => "01",
                "msg" => "Cadastro atualizado"
            ];

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_veiculos_doc`
            SET status='2'
        WHERE app_users_id='$id' AND tipo='2'
        ");
        $sql_cadastro->execute();


        return $param;

    }
    public function ativarUsuarioDev($id)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela`
          SET status_aprovado='1',status='1'
        WHERE id='$id'
        ");

        $sql_cadastro->execute();

        $linhas_afetadas = $sql_cadastro->affected_rows;

            $param = [
                "status" => "01",
                "msg" => "Cadastro atualizado"
            ];

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_veiculos_doc`
            SET status='1'
        WHERE app_users_id='$id'
        ");
        $sql_cadastro->execute();


        return $param;

    }

    public function update($id,$tipo_pessoa,$nome,$celular,$data_nascimento,$cpf,$cnpj,$razao_social,$nome_fantasia,$ie)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela`
          SET tipo_pessoa='$tipo_pessoa',nome='$nome',celular='$celular',celular='$celular',data_nascimento='$data_nascimento',
          documento='$cpf',cnpj='$cnpj',razao_social='$razao_social',nome_fantasia='$nome_fantasia',ie='$ie'
        WHERE id='$id'
        ");

        $sql_cadastro->execute();
        $linhas_afetadas = $sql_cadastro->affected_rows;

            $param = [
                "status" => "01",
                "msg" => "Cadastro atualizado"
            ];


        return $param;

    }

    public function updateAvatar($app_users_id, $avatar)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela`
        SET avatar='$avatar'
        WHERE id='$app_users_id'
        ");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Imagem de perfil atualizada"
        ];

        return $Param;
    }
    public function verificaplano($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT data_validade
            FROM `app_users_planos`
            WHERE app_users_id='$id_usuario'
            ORDER BY data_cadastro DESC LIMIT 1

        "
        );
        $sql->execute();
        $sql->bind_result($this->data_validade);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $usuarios['rows'] = $rows;
        } else {
            while ($row = $sql->fetch()) {

                if($this->data_validade > $this->data_atual){
                    $usuarios['status'] ="01";
                    $usuarios['mensagem'] = "Plano valido!";

                }
                else{
                    $usuarios['status'] = "02";
                    $usuarios['mensagem'] = "Plano expirado!";
                }

            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function planoUser($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT b.id,a.data_cadastro,a.data_validade,b.nome
            FROM `app_users_planos` AS a
            INNER JOIN `app_planos` AS b ON a.app_planos_id = b.id
            WHERE a.app_users_id='$id_usuario'
            ORDER BY a.data_cadastro DESC LIMIT 1
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->data_cadastro,$this->data_validade,$this->nome);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $usuarios['rows'] = $rows;
        } else {
            while ($row = $sql->fetch()) {

                $cadastro = DateTime::createFromFormat('Y-m-d H:i:s', $this->data_cadastro);
                $validade = DateTime::createFromFormat('Y-m-d', $this->data_validade);
                $atual = DateTime::createFromFormat('Y-m-d H:i:s', $this->data_atual);

                $total = $validade->diff($cadastro);
                $restante = $validade->diff($atual);

                // echo "Diferença: " . $restante->format('%a dias, %h horas e %i minutos');

                if($this->data_validade > $this->data_atual){
                    $usuarios['plano_id'] =$this->id;
                    $usuarios['expiracao_validade'] =dataBR($this->data_validade);
                    $usuarios['plano_nome'] =$this->nome;
                    $usuarios['tempo_restante_dias'] =$restante->days;
                    $usuarios['tempo_total_dias'] =$total->days;
                    // $usuarios['tempo_restante_horas'] =$restante->h;
                    // $usuarios['tempo_restante_minutos'] =$restante->i;
                    $usuarios['status'] ="01";
                }else{
                    $usuarios['plano_id'] =1;
                    $usuarios['plano_nome'] ="Free";
                    // $usuarios['tempo_restante_dias'] =0;
                    // $usuarios['tempo_restante_horas'] =0;
                    // $usuarios['tempo_restante_minutos'] =0;
                    $usuarios['status'] ="02";
                }

            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function listCategorias()
    {

        $sql = $this->mysqli->prepare("SELECT DISTINCT a.id,a.nome,a.descricao,a.url
            FROM `app_categorias` AS a
            INNER JOIN `app_leiloes` AS b ON a.id=b.app_categorias_id
            WHERE a.status='1'
            ORDER BY a.id ASC");
        $sql->execute();
        $sql->bind_result($this->id,$this->nome,$this->descricao,$this->url);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $usuarios['rows'] = $rows;
        } else {
            while ($row = $sql->fetch()) {

                $item['id'] =$this->id;
                $item['nome'] =$this->nome;
                $item['descricao'] =$this->descricao;
                $item['url'] =$this->url;
                array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function cancelamentos($tipo,$corrida)
    {
        $sql = $this->mysqli->prepare(
            " SELECT id,tipo,nome,taxado,taxa_perc,`status` FROM `app_cancelamentos` WHERE tipo='$tipo' AND cancelar_corrida='$corrida' AND `status`='1'"
        );
        $sql->execute();
        $sql->bind_result($id,$tipo,$nome,$taxado,$taxa_perc,$status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {

                $item['id'] =$id;
                $item['tipo'] =$tipo;
                $item['nome'] =$nome;
                $item['taxado'] =$taxado;
                $item['taxa_perc'] =$taxa_perc;
                $item['status'] =$status;

                array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function suporte()
    {

        $sql = $this->mysqli->prepare(
            " SELECT whatsapp,facebook,instagram,manutencao,credito,pix,dinheiro FROM `app_config` WHERE id='1'"
        );
        $sql->execute();
        $sql->bind_result($whatsapp,$facebook,$instagram,$manutencao,$credito,$pix,$dinheiro);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $usuarios['rows'] = $rows;
        } else {
            while ($row = $sql->fetch()) {
                $item['whatsapp'] =$whatsapp;
                $item['facebook'] =$facebook;
                $item['instagram'] =$instagram;
                $item['manutencao'] =$manutencao;
                $item['credito'] =$credito;
                $item['dinheiro'] =$dinheiro;
                $item['pix'] =$pix;

                array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios[0];
    }
    public function listComissoes($id_user,$data_de,$data_ate)
    {
        $filter = " WHERE a.app_users_id='$id_user' ";
        if(!empty($data_de)){$filter .=  " AND 'a.data' >= '$data_de' ";}
        if(!empty($data_ate)){$filter .=  " AND 'a.data' <= '$data_ate' ";}

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id, a.valor, a.data, a.status, b.chave
            FROM `app_saldo_pagamentos` as a
            INNER JOIN `app_users_pix` as b ON a.app_users_id = b.app_users_id
            $filter
            ORDER BY a.id DESC
            ");

        $sql->execute();
        $sql->bind_result($id,$valor,$data,$status,$pix);
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
                $item['data'] =dataHoraBR($data);
                $item['status'] =statusComissao($status);
                array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }


    public function listComissoesSUM($id_user,$data_de,$data_ate)
    {
        $filter = " WHERE app_users_id='$id_user' ";
        if(!empty($data_de)){$filter .=  " AND 'data' >= '$data_de' ";}
        if(!empty($data_ate)){$filter .=  " AND 'data' <= '$data_ate' ";}

        $sql = $this->mysqli->prepare("SELECT SUM(valor) as total FROM `app_saldo_pagamentos` $filter");
        $sql->execute();
        $sql->bind_result($total);
        $sql->store_result();
        $sql->fetch();

        $Param = [
            "valor_total" => moneyView($total)
        ];

        return $Param;
    }

    public function listConfig()
    {

        $sql = $this->mysqli->prepare(
            " SELECT id,live,whatsapp FROM `app_config`"
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->live,$this->whatsapp);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $usuarios['rows'] = $rows;
        } else {
            while ($row = $sql->fetch()) {

                $item['id'] =$this->id;
                $item['live'] =$this->live;
                $item['whatsapp'] =$this->whatsapp;
                array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function listBanners()
    {

        $sql = $this->mysqli->prepare(
            " SELECT id,nome,link,url,ordem,status FROM `app_banners` WHERE status = '1'
            ORDER BY ordem ASC"
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->nome_banner,$this->link_banner,$this->url_banner,$this->ordem,$this->status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($sql->num_rows == 0) {
            $usuarios['rows'] = $rows;
        } else {
            while ($row = $sql->fetch()) {

                $item['id'] =$this->id;
                $item['nome'] =$this->nome_banner;
                $item['link'] =$this->link_banner;
                $item['url'] =$this->url_banner;
                $item['status'] =$this->status;
                $item['ordem'] =$this->ordem;
                $item['rows'] =$rows;
                array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function listPlanos()
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,nome,descricao,id_store,valor,validade_dias
            FROM `app_planos` WHERE status='1' AND id!=1
            ORDER BY id ASC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->nome,$this->descricao,$this->id_store,$this->valor,$this->dias);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $usuarios['rows'] = $rows;
        } else {
            while ($row = $sql->fetch()) {

                $item['plano_id'] =$this->id;
                $item['plano_nome'] =$this->nome;
                $item['descricao'] =$this->descricao;
                $item['id_store'] =$this->id_store;
                $item['valor'] =moneyView($this->valor);
                $item['dias'] =$this->dias;
                array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function listPlanosId($id_plano)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,nome,valor,validade_dias
            FROM `app_planos` WHERE id='$id_plano'
            ORDER BY id ASC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->nome,$this->valor,$this->dias);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $usuarios['rows'] = $rows;
        } else {
            while ($row = $sql->fetch()) {

                $item['plano_id'] =$this->id;
                $item['plano_nome'] =$this->nome;
                $item['valor'] =moneyView($this->valor);
                $item['dias'] =$this->dias;
                array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function planosHistorico($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,a.tipo_pagamento,a.data,a.valor_total,a.status
            FROM `app_pagamentos` AS a
            INNER JOIN `app_planos` AS b ON a.app_planos_id = b.id
            WHERE a.app_users_id = $id_usuario
            ORDER BY a.data DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->tipo_pagamento,$this->data,$this->valor_total,$this->status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);

        } else {
            while ($row = $sql->fetch()) {
                $item['id'] = $this->id;
                $item['data'] =dataBR($this->data);
                $item['hora'] =horaBR($this->data);
                if( $this->tipo_pagamento == 1){
                    $item['tipo_pagamento'] = "Cartão de crédito";
                }elseif($this->tipo_pagamento == 2){
                    $item['tipo_pagamento'] = "Boleto";
                }else{
                    $item['tipo_pagamento'] = "Pix";
                }
                $item['valor'] =moneyView($this->valor_total);
                $item['status'] = statusPayment($this->status);
                array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function valorTurbinar()
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT valor_turbinar
            FROM `app_config`

        "
        );
        $sql->execute();
        $sql->bind_result($valor);
        $sql->store_result();
        $rows = $sql->num_rows;
        $usuarios = [];
        while ($row = $sql->fetch()) {
            $Param['valor'] = moneyView($valor);
            array_push($usuarios,$Param);
        }

        // print_r($usuarios);exit;
        return $usuarios;
    }

    public function listId($id_usuario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id, avatar, nome, email, celular
            FROM `$this->tabela`
            WHERE id='$id_usuario'

        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->avatar, $this->nome, $this->email, $this->celular);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['avatar'] = $this->avatar;
                $Param['nome'] = decryptitem($this->nome);
                $Param['email'] = decryptitem($this->email);
                $Param['celular'] = decryptitem($this->celular);
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function listUsuarios($type, $search, $id){


        $filter = "WHERE a.tipo='$type'";
        if(isset($search)){$filter .=  " AND (a.nome LIKE '%$search%' OR a.nome_empresa LIKE '%$search%' OR a.email='$search') ";}
        if(isset($id)){$filter .=  " AND a.id='$id'";}

        $sql = $this->mysqli->prepare("
        SELECT a.id, a.tipo, a.cod, a.nome_empresa, a.nome, a.email, a.celular, a.avatar, a.data_cadastro, a.status,
        b.latitude, b.longitude
        FROM app_users as a
        LEFT JOIN app_users_location as b
        ON a.id = b.app_users_id
        $filter
        ");

        $sql->execute();
        $sql->bind_result(
          $this->id,
          $this->tipo,
          $this->cod,
          $this->nome_empresa,
          $this->nome,
          $this->email,
          $this->celular,
          $this->avatar,
          $this->data_cadastro,
          $this->status,
          $this->latitude,
          $this->longitude
        );
        $sql->store_result();
        $rows = $sql->num_rows();

        if($rows == 0) {
            $param['rows'] = $rows;
            $lista[] = $param;
        }else{

        while($row = $sql->fetch()){

          $param['id'] = $this->id;
          $param['tipo'] = $this->tipo;
          $param['cod'] = $this->cod;
          $param['nome_empresa'] = $this->nome_empresa;
          $param['nome'] = $this->nome;
          $param['email'] = $this->email;
          $param['celular'] = $this->celular;
          $param['avatar'] = $this->avatar;
          $param['data_cadastro'] = $this->data_cadastro;
          $param['status'] = $this->status;
          $param['latitude'] = $this->latitude;
          $param['longitude'] = $this->longitude;

          $lista[] = $param;

        }
      }

      return $lista;
    }
    public function recuperarsenha($email)
    {

        //VERIFICA SE JÁ EXISTE E-MAIL
        $sql = $this->mysqli->prepare("SELECT nome FROM `$this->tabela` WHERE email='$email' ");
        $sql->execute();
        $sql->bind_result($this->nome);
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();


        if ($rows > 0) {

            $this->token = geraToken(rand(5, 15), rand(100, 500), rand(6000, 10000));

            $sql_cadastro = $this->mysqli->prepare("UPDATE `$this->tabela`SET token_senha='$this->token'WHERE email = '$email'");
            $sql_cadastro->execute();

            //ENVIA E-MAIL RECUPERACAO DE SENHA
            $mail = new EnviarEmail();
            $mail->recuperarsenha(decryptitem($this->nome), decryptitem($email), $this->token, $tipo);

            $Param['status'] = '01';
            $Param['msg'] = 'As instruções para alteração de senha foram enviadas para o seu e-mail.';
            $lista[] = $Param;
            return $lista;
        }
        if ($rows == 0) {
            $Param['status'] = '02';
            $Param['msg'] = 'Não encontramos o seu e-mail em nosso cadastro, por favor, tente outros dados';
            $lista[] = $Param;
            return $lista;
        }
    }
    public function verificatokenCadastro($token)
    {

        // echo "SELECT * FROM `$this->tabela` WHERE token_senha='$token'"; exit;

        //VERIFICA SE JÁ EXISTE E-MAIL
        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tabela` WHERE token_cadastro='$token'");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        if ($rows > 0) {

            $Param['status'] = '01';
            $Param['msg'] = 'Token OK';
            $Param['id'] = $this->id;

            $lista[] = $Param;

            $json = json_encode($lista);
            echo $json;
        }
        if ($rows == 0) {
            $Param['status'] = '02';
            $Param['msg'] = 'Token Inexistente';
            $lista[] = $Param;
            $json = json_encode($lista);
            echo $json;
        }
    }
    public function verificatoken($token)
    {

        // echo "SELECT * FROM `$this->tabela` WHERE token_senha='$token'"; exit;

        //VERIFICA SE JÁ EXISTE E-MAIL
        $sql = $this->mysqli->prepare("SELECT * FROM `$this->tabela` WHERE token_senha='$token'");
        $sql->execute();
        $sql->store_result();
        $rows = $sql->num_rows;

        if ($rows > 0) {

            $Param['status'] = '01';
            $Param['msg'] = 'Token OK';
            $lista[] = $Param;

            $json = json_encode($lista);
            echo $json;
        }
        if ($rows == 0) {
            $Param['status'] = '02';
            $Param['msg'] = 'Token Inexistente';
            $lista[] = $Param;
            $json = json_encode($lista);
            echo $json;
        }
    }
    public function updatepasswordtoken($password, $token)
    {

        $this->custo = '08';
        $this->salt = geraSalt(22);

        // Gera um hash baseado em bcrypt
        $this->hash = crypt($password, '$2a$' . $this->custo . '$' . $this->salt . '$');

        $sql = $this->mysqli->prepare("UPDATE `$this->tabela` SET password = ? WHERE token_senha = ? ");
        $sql->bind_param('ss', $this->hash, $token);
        $sql->execute();

        $lista = array();

        if ($sql->affected_rows) {

            $Param['status'] = '01';
            // $Param['token'] = $this->token;
            $Param['msg'] = 'Senha alterada com sucesso!';
            $lista[] = $Param;
            $json = json_encode($lista);
            echo $json;
        } else {
            $Param['status'] = '02';
            $Param['msg'] = 'Erro ao alterar senha, tente novamente!';
            $lista[] = $Param;
            $json = json_encode($lista);
            echo $json;
        }
    }
    public function updatePassword($id, $password)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela`
        SET password='$password'
        WHERE id='$id'
        ");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Senha atualizada"
        ];

        return $Param;
    }
    public function ficarOnline($id_user,$status) {

        $sql_cadastro = $this->mysqli->prepare("UPDATE $this->tabela SET online='$status' WHERE id='$id_user' AND status='1'");
        $sql_cadastro->execute();

        if($status == 1){
            return array(
            "status"=>"01",
            "msg"=>"Você esta online!",
            "url"=>HOME_URI."/uploads/online.mp3");
        }else{
            return array(
            "status"=>"01",
            "msg"=>"Você se desconectou!",
            "url"=>HOME_URI."/uploads/offline.mp3");
        }

    }
    public function desativarConta($id_user) {

        $sql_cadastro = $this->mysqli->prepare("UPDATE $this->tabela SET status='2' WHERE id='$id_user'");
        $sql_cadastro->execute();

        return array("status"=>"01", "msg"=>"Conta desativada com sucesso.");
    }
    public function listObras($id_user)
    {
        $data_atual = date("Y-m-d", strtotime($this->data_atual));

        $filter = " WHERE a.app_users_id='$id_user' AND b.tipo = '2' AND b.status = '1' AND '$data_atual' BETWEEN b.data_in AND b.data_out";

        $sql = $this->mysqli->prepare(
            "
            SELECT b.id,b.nome, b.validade_proposta, b.total_proposta, b.obs, b.data_emissao, b.data_cadastro , b.data_in,b.data_out
            FROM `app_users_equipe` AS a
            INNER JOIN `app_lancamentos` AS b ON b.id = a.app_lancamentos_id
            $filter
            ORDER BY b.id DESC
        "
        );
        // print_r($filter);exit;
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->validade_proposta, $this->total_proposta, $this->obs, $this->data_emissao , $this->data_cadastro, $this->data_in, $this->data_out);
        $sql->store_result();
        $rows = $sql->num_rows;
        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {
                    $Param['id'] = $this->id;
                    $Param['nome'] = ucwords($this->nome);
                    $Param['data_in'] = dataBR($this->data_in);
                    $Param['data_out'] = dataBR($this->data_out);
                    $Param['fotos'] = $this->fotosObra($this->id);
                    $Param['rows'] = $rows;
                    array_push($usuarios, $Param);

            }
        }
        return $usuarios;
    }
    public function fotosObra($id_obra)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,url
            FROM `app_lancamentos_fotos`
            WHERE app_lancamentos_id='$id_obra'
            ORDER BY id DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id_foto, $this->url);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id_foto'] = $this->id_foto;
                $Param['url'] = $this->url;
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function listServicos($id_obra)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT b.id,b.nome, b.un, b.descricao, b.qtd_ultrapassar, b.url
            FROM `app_lancamentos_itens` AS a
            INNER JOIN `app_servicos` AS b ON b.id = a.app_servicos_id
            WHERE a.app_lancamentos_id='$id_obra'
            ORDER BY b.nome ASC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->un, $this->descricao, $this->qtd_ultrapassar, $this->url);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $ultrapassar = $this->ultrapassarRestante($this->id,$id_obra);

                $Param['id'] = $this->id;
                $Param['nome'] = ucwords($this->nome);
                // $Param['un'] = $this->un;
                $Param['descricao'] = $this->descricao;
                $Param['status_ultrapassar'] = $ultrapassar['ultrapassar_status'];
                $Param['valor_consumido'] = $ultrapassar['valor_consumido'];
                $Param['maximo_ultrapassar'] = $ultrapassar['maximo_ultrapassar'];
                $Param['porcentagem_consumida'] = $ultrapassar['porcentagem_consumida'];
                $Param['url'] = $this->url;
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function VerificaTarefa($id,$id_obra)
    {
        $sql = $this->mysqli->prepare("SELECT id FROM app_tarefas_campos WHERE app_tarefas_id='$id'");
        $sql->execute();
        $sql->bind_result($this->id_tarefa);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if($rows > 0){
            while ($row = $sql->fetch()) {
                $Param = $this->id_tarefa;
                array_push($usuarios, $Param);
            }
        }

        $result = 2;

        foreach ($usuarios as $tarefas){
            $sql1 = $this->mysqli->prepare("SELECT id FROM app_lancamentos_tarefas WHERE app_tarefas_campos_id='$tarefas' AND app_lancamentos_id='$id_obra'");
            $sql1->execute();
            $sql1->bind_result($this->id_campo);
            $sql1->store_result();
            $rows1 = $sql1->num_rows;
            if($rows1 > 0){
                $result = 1;
            }else{
                $result = 2;
            }
        }
        return $result;
    }
    public function listBriefing($id_tarefa,$id_obra)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,nome
            FROM `app_tarefas_campos`
            WHERE app_tarefas_id='$id_tarefa'
            ORDER BY nome ASC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->nome);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['nome'] = ucwords($this->nome);
                $Param['qtd_respondida'] = $this->verificaLancamento($this->id,$id_obra);
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function verificaLancamento($id,$id_obra){

        $sql = $this->mysqli->prepare("SELECT qtd FROM app_lancamentos_tarefas
         WHERE app_lancamentos_id='$id_obra' AND app_tarefas_campos_id='$id' AND (data >= '$this->data 00:00:00' AND data <= '$this->data 23:59:59')");
        $sql->execute();
        $sql->bind_result($this->qtd_respondida);
        $sql->store_result();
        $rows = $sql->num_rows;
        if($rows > 0){
            while ($row = $sql->fetch()) {
                return $this->qtd_respondida;
            }
        }
        return null;
    }
    public function deleteFotos($id_foto)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_lancamentos_fotos` WHERE id='$id_foto'"
        );

        $sql_limpa->execute();


        $Param = [
            "status" => "01",
            "msg" => "Foto deletada"
        ];

        return $Param;

    }
    public function excluirFrotas($id)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_frotas` WHERE id='$id'"
        );

        $sql_limpa->execute();


        $Param = [
            "status" => "01",
            "msg" => "Frota deletada"
        ];

        return $Param;

    }

    public function listMarcas()
    {
        // Iniciando a sessão cURL
        $ch = curl_init();

        // Configurando a URL da API FIPE
        curl_setopt($ch, CURLOPT_URL, "https://parallelum.com.br/fipe/api/v1/carros/marcas");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Executando a request e armazenando o resultado
        $response = curl_exec($ch);

        // Verificando erros
        if(curl_errno($ch)) {
            return json_encode(['error' => curl_error($ch)]);
        }

        // Fechando a sessão cURL
        curl_close($ch);

        // Decodificando a resposta JSON
        $marcas = json_decode($response, true);

        // Criando um array apenas com 'nome' e 'id' de cada marca
        $resultado = [];
        foreach ($marcas as $marca) {
            $resultado[] = [
                'nome' => $marca['nome'],
                'id'   => $marca['codigo']
            ];
        }

        // Retornando o array em formato JSON
        return $resultado;
    }

    public function criaSaldo($id_user)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_users_saldo`(`app_users_id`,`saldo`,`data`)
            VALUES ('$id_user','0','$this->data_atual')"
        );

        $sql_cadastro->execute();
    }
    public function criaAvaliacao($id_user)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_relatorio`(`tipo`,`id_para`,`estrelas`,`descricao`,`data_cadastro`)
            VALUES ('1','$id_user','5','Cadastro','$this->data_atual')"
        );

        $sql_cadastro->execute();
    }
    public function saveMarcas($id_user,$nome,$status)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_equipamentos_marcas`(`app_users_id`,`nome`,`status`)
            VALUES ('$id_user','$nome','$status')"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Marca cadastrada com sucesso.",
        ];

        return $Param;
    }
    public function excluirMarcas($id)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_equipamentos_marcas` WHERE id='$id'"
        );

        $sql_limpa->execute();


        $Param = [
            "status" => "01",
            "msg" => "Marca deletada"
        ];

        return $Param;

    }

    public function listCores()
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,a.nome,a.cor,a.status
            FROM `app_cores` AS a
            WHERE a.status='1'
        "
        );
        $sql->execute();
        $sql->bind_result($id,$nome,$hex,$status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        while ($row = $sql->fetch()) {

            $param['id'] =$id;
            $param['nome'] =$nome;
            $param['hex'] =$hex;
            $param['status'] = $status;

            array_push($usuarios,$param);
        }



        // print_r($usuarios);exit;
        return $usuarios;
    }
    // public function listCores()
    // {
    //     // Array contendo as cores mais comuns de carros e seus códigos hexadecimais
    //     $cores = [
    //         ['nome' => 'Preto', 'hex' => '#000000'],
    //         ['nome' => 'Branco', 'hex' => '#FFFFFF'],
    //         ['nome' => 'Prata', 'hex' => '#C0C0C0'],
    //         ['nome' => 'Cinza', 'hex' => '#808080'],
    //         ['nome' => 'Vermelho', 'hex' => '#FF0000'],
    //         ['nome' => 'Azul', 'hex' => '#0000FF'],
    //         ['nome' => 'Verde', 'hex' => '#008000'],
    //         ['nome' => 'Amarelo', 'hex' => '#FFFF00'],
    //         ['nome' => 'Marrom', 'hex' => '#A52A2A'],
    //         ['nome' => 'Laranja', 'hex' => '#FFA500'],
    //         ['nome' => 'Rosa', 'hex' => '#FFC0CB'],
    //         ['nome' => 'Violeta', 'hex' => '#EE82EE'],
    //         ['nome' => 'Bege', 'hex' => '#F5F5DC'],
    //         ['nome' => 'Dourado', 'hex' => '#FFD700'],
    //         ['nome' => 'Bordô', 'hex' => '#800000']
    //     ];

    //     // Retornando o array em formato JSON
    //     return $cores;
    // }

    public function listModelos($id_marca)
    {
        // Iniciando a sessão cURL
        $ch = curl_init();

        // Configurando a URL da API FIPE com o ID da marca
        $url = "https://parallelum.com.br/fipe/api/v1/carros/marcas/{$id_marca}/modelos";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Executando a request e armazenando o resultado
        $response = curl_exec($ch);

        // Verificando erros
        if(curl_errno($ch)) {
            return json_encode(['error' => curl_error($ch)]);
        }

        // Fechando a sessão cURL
        curl_close($ch);

        // Decodificando a resposta JSON
        $data = json_decode($response, true);

        // Verificando se a resposta contém a chave 'modelos'
        if (isset($data['modelos'])) {
            $modelos = $data['modelos'];

            // Criando um array apenas com 'nome' e 'id' de cada modelo
            $resultado = [];
            foreach ($modelos as $modelo) {
                $resultado[] = [
                    'nome' => $modelo['nome'],
                    'id'   => $modelo['codigo']
                ];
            }

            // Retornando o array em formato JSON
            return $resultado;
        }

    }

    public function updateModelos($id_modelo,$nome,$status)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_equipamentos_modelos` SET nome='$nome', status='$status'
        WHERE id='$id_modelo'"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Modelo atualizado"
        ];

        return $Param;
    }
    public function saveModelos($marca_id,$nome,$status)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_equipamentos_modelos`(`app_equipamentos_marcas_id`,`nome`,`status`)
            VALUES ('$marca_id','$nome','$status')"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Modelo cadastrado com sucesso.",
        ];

        return $Param;
    }
    public function excluirModelos($id)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_equipamentos_modelos` WHERE id='$id'"
        );

        $sql_limpa->execute();


        $Param = [
            "status" => "01",
            "msg" => "Modelo deletado"
        ];

        return $Param;

    }
    public function findModelo($id_modelo)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT DISTINCT nome
            FROM `app_equipamentos_modelos`
            WHERE id= $id_modelo
        "
        );
        $sql->execute();
        $sql->bind_result($this->nome_modelo);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {
            }
        }
        // print_r($usuarios);exit;
        return $this->nome_modelo;
    }
    public function criaDescricao($equipamento)
    {
        $texto = sprintf(
            "<strong>%s</strong> | %s<br><br><strong>Equipamento:</strong> %s<br><strong>Marca:</strong> %s<br><strong>Modelo:</strong> %s<br><strong>Série:</strong> %s<br><strong>Ano:</strong> %s<br><strong>Placa:</strong> %s<br><strong>Horímetro:</strong> %s<br><strong>Proprietário:</strong> %s",
            $equipamento['placa'],
            $equipamento['modelo_nome'],
            $equipamento['nome'],
            $equipamento['marca_nome'],
            $equipamento['modelo_nome'],
            $equipamento['serie'],
            $equipamento['ano'],
            $equipamento['placa'],
            $equipamento['horimetro'],
            $equipamento['proprietario']
        );

        return $texto;
    }
    public function listEquipamentosId($id)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT DISTINCT a.id,a.app_equipamentos_marcas_id,a.app_equipamentos_modelos_id,a.nome,a.ano,a.serie,a.horimetro,a.proprietario,a.placa,a.data_cadastro,a.status,b.nome
            FROM `app_equipamentos` AS a
            INNER JOIN `app_equipamentos_marcas` AS b ON a.app_equipamentos_marcas_id = b.id
            WHERE a.id= '$id'
            GROUP BY a.id
            ORDER BY a.id ASC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->marca,$this->modelo,$this->nome,$this->ano,$this->serie,$this->horimetro,$this->proprietario,$this->placa,$this->data_cadastro,$this->status,$this->marca_nome);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {

                $item['id'] =$this->id;
                $item['marca'] =$this->marca;
                $item['marca_nome'] =$this->marca_nome;
                $item['modelo'] =$this->modelo;
                $item['modelo_nome'] =$this->findModelo($this->modelo);
                $item['nome'] =$this->nome;
                $item['ano'] =$this->ano;
                $item['serie'] =$this->serie;
                $item['horimetro'] =$this->horimetro;
                $item['proprietario'] =$this->proprietario;
                $item['placa'] =$this->placa;
                $item['data_cadastro'] =dataBR($this->data_cadastro);
                $item['status'] =$this->status;
                array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios[0];
    }
    public function listEquipamentos($id)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT DISTINCT a.id,a.app_equipamentos_marcas_id,a.app_equipamentos_modelos_id,a.nome,a.ano,a.serie,a.horimetro,a.proprietario,a.placa,a.data_cadastro,a.status,b.nome
            FROM `app_equipamentos` AS a
            INNER JOIN `app_equipamentos_marcas` AS b ON a.app_equipamentos_marcas_id = b.id
            WHERE b.app_users_id= $id
            GROUP BY a.id
            ORDER BY a.id ASC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->marca,$this->modelo,$this->nome,$this->ano,$this->serie,$this->horimetro,$this->proprietario,$this->placa,$this->data_cadastro,$this->status,$this->marca_nome);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {

                $item['id'] =$this->id;
                $item['marca'] =$this->marca;
                $item['marca_nome'] =$this->marca_nome;
                $item['modelo'] =$this->modelo;
                $item['modelo_nome'] =$this->findModelo($this->modelo);
                $item['nome'] =$this->nome;
                $item['ano'] =$this->ano;
                $item['serie'] =$this->serie;
                $item['horimetro'] =$this->horimetro;
                $item['proprietario'] =$this->proprietario;
                $item['placa'] =$this->placa;
                $item['data_cadastro'] =dataBR($this->data_cadastro);
                $item['status'] =$this->status;
                array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function updateEquipamentos($id_equipamento,$id_marca,$id_modelo,$nome,$ano,$serie,$horimetro,$proprietario,$placa,$status)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_equipamentos` SET app_equipamentos_marcas_id='$id_marca', app_equipamentos_modelos_id='$id_modelo',nome='$nome',ano='$ano',serie='$serie',
        horimetro='$horimetro',proprietario='$proprietario',placa='$placa',status='$status'
        WHERE id='$id_equipamento'"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Equipamento atualizado"
        ];

        return $Param;
    }
    public function saveEquipamentos($id_marca,$id_modelo,$nome,$ano,$serie,$horimetro,$proprietario,$placa,$status)
    {
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_equipamentos`(`app_equipamentos_marcas_id`,`app_equipamentos_modelos_id`,`nome`,`ano`,`serie`,`horimetro`,`proprietario`,`placa`,`data_cadastro`,`status`)
            VALUES ('$id_marca','$id_modelo','$nome','$ano','$serie','$horimetro','$proprietario','$placa','$this->data_atual','$status')"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Equipamento cadastrado com sucesso.",
        ];

        return $Param;
    }
    public function excluirEquipamentos($id)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_equipamentos` WHERE id='$id'"
        );

        $sql_limpa->execute();


        $Param = [
            "status" => "01",
            "msg" => "Equipamento deletado"
        ];

        return $Param;

    }


    public function listTarefas($frota_id)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,a.app_frotas_id,a.nome,a.descricao,a.obs_checklist,a.app_tarefas_status_id,b.nome,c.nome,a.data_in,a.data_out
            FROM `app_tarefas` AS a
            INNER JOIN `app_tarefas_status` AS b ON a.app_tarefas_status_id = b.id
            INNER JOIN `app_equipamentos` AS c ON a.app_equipamentos_id = c.id
            WHERE a.app_frotas_id= $frota_id
            ORDER BY a.ordem DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->frota,$this->nome,$this->descricao,$this->obs_checklist,$this->id_status,$this->nome_status,$this->nome_equipamento,$this->data_in,$this->data_out);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {
                if ($this->data_out !== null) {
                    $dataOut =  $this->data_out;
                    // Adiciona 24 horas à data atual
                    $limite24horas = date('Y-m-d H:i:s', strtotime('+24 hours', strtotime($this->data_atual)));
                    if ($dataOut > $limite24horas) {
                        // A data de conclusão está a mais de 24 horas de distância
                        $cor = '#0ed145'; // Verde
                    } elseif ($dataOut > $this->data_atual) {
                        // Está a menos de 24 horas da data de conclusão
                        $cor = '#ffca18'; // Amarelo
                    } else {
                        // A data de conclusão já passou
                        $cor = '#ec1c24'; // Vermelho
                    }
                } else {
                    // A tarefa não possui uma data de conclusão definida
                    $cor = '#0ed145'; // Verde
                }


                $item['id'] =$this->id;
                $item['frota'] =$this->frota;
                $item['nome'] =$this->nome;
                $item['descricao'] =$this->descricao;
                $item['obs_checklist'] =$this->obs_checklist;
                $item['id_status'] =$this->id_status;
                $item['nome_status'] =$this->nome_status;
                $item['nome_equipamento'] =$this->nome_equipamento;
                $item['data_in'] =$this->data_in == null ? null : dataHoraBR($this->data_in);
                $item['data_out'] =$this->data_out == null ? null : dataHoraBR($this->data_out);
                $item['cor_entrega'] =$cor;
                $item['rows'] = $rows;
                array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function listTarefasId($tarefa_id)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,a.app_frotas_id,a.nome,a.descricao,a.obs_checklist,a.app_tarefas_status_id,b.nome,c.nome,c.id,a.data_in,a.data_out,c.horimetro
            FROM `app_tarefas` AS a
            INNER JOIN `app_tarefas_status` AS b ON a.app_tarefas_status_id = b.id
            INNER JOIN `app_equipamentos` AS c ON a.app_equipamentos_id = c.id
            WHERE a.id= $tarefa_id
            ORDER BY a.id DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->frota,$this->nome,$this->descricao,$this->obs_checklist,$this->id_status,$this->nome_status,$this->nome_equipamento,
        $this->id_equipamento,$this->data_in,$this->data_out,$this->horimetro);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {
                if ($this->data_out !== null) {
                    $dataOut =  $this->data_out;
                    // Adiciona 24 horas à data atual
                    $limite24horas = date('Y-m-d H:i:s', strtotime('+24 hours', strtotime($this->data_atual)));
                    if ($dataOut > $limite24horas) {
                        // A data de conclusão está a mais de 24 horas de distância
                        $cor = '#0ed145'; // Verde
                    } elseif ($dataOut > $this->data_atual) {
                        // Está a menos de 24 horas da data de conclusão
                        $cor = '#ffca18'; // Amarelo
                    } else {
                        // A data de conclusão já passou
                        $cor = '#ec1c24'; // Vermelho
                    }
                } else {
                    // A tarefa não possui uma data de conclusão definida
                    $cor = '#0ed145'; // Verde
                }

                $item['id'] =$this->id;
                $item['frota'] =$this->frota;
                $item['nome'] =$this->nome;
                $item['descricao'] =$this->descricao;
                $item['obs_checklist'] =$this->obs_checklist;
                $item['id_status'] =$this->id_status;
                $item['nome_status'] =$this->nome_status;
                $item['id_equipamento'] =$this->id_equipamento;
                $item['nome_equipamento'] =$this->nome_equipamento;
                $item['data_in'] =$this->data_in == null ? null : dataHoraBR($this->data_in);
                $item['data_out'] =$this->data_out == null ? null : dataHoraBR($this->data_out);
                $item['cor_entrega'] =$cor;
                $item['horimetro'] =$this->horimetro;
                $item['rows'] = $rows;
                array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function updateTarefas($id_tarefa,$id_frota,$id_equipamento,$nome,$descricao,$checklist,$status,$data_in,$data_out)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_tarefas` SET app_frotas_id='$id_frota', app_equipamentos_id='$id_equipamento',nome='$nome',
        descricao='$descricao',obs_checklist='$checklist',app_tarefas_status_id='$status',data_in='$data_in',data_out='$data_out'
        WHERE id='$id_tarefa'"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Tarefa atualizada"
        ];

        return $Param;
    }
    public function saveTarefas($id_frota,$id_equipamento,$nome,$descricao)
    {
        $sql = $this->mysqli->prepare("SELECT ordem FROM app_tarefas WHERE app_frotas_id='$id_frota' ORDER BY ordem DESC LIMIT 1");
        $sql->execute();
        $sql->bind_result($this->ordem);
        $sql->store_result();
        $sql->fetch();

        $ordem = $this->ordem + 1;
        $status = 1;

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_tarefas`(`app_frotas_id`,`app_equipamentos_id`,`nome`,`descricao`,`app_tarefas_status_id`,`ordem`,`data_in`)
            VALUES ('$id_frota','$id_equipamento','$nome','$descricao','$status','$ordem','$this->data_atual')"
        );

        $sql_cadastro->execute();
        $this->id_cadastro = $sql_cadastro->insert_id;
        $Param = [
            "status" => "01",
            "msg" => "Tarefa cadastrada com sucesso.",
            "id_tarefa"=>$this->id_cadastro ,
            "id_frota"=>$id_frota ,
        ];

        return $Param;
    }
    public function excluirTarefas($id)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_tarefas` WHERE id='$id'"
        );

        $sql_limpa->execute();


        $Param = [
            "status" => "01",
            "msg" => "Tarefa deletada"
        ];

        return $Param;

    }


    public function listTarefasFuncionarios($id_tarefa)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,a.nome,a.avatar
            FROM `app_users` AS a
            INNER JOIN `app_tarefas_users` AS b ON a.id = b.app_users_id
            WHERE b.app_tarefas_id = '$id_tarefa'
            ORDER BY b.id DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->nome,$this->avatar);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {
                    $item['id'] =$this->id;
                    $item['avatar'] =$this->avatar;
                    $item['nome'] =$this->nome;
                    $item['rows'] = $rows;
                    array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function listTarefasFuncionariosAll($id_tarefa,$id_empresa)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,a.nome,a.avatar
            FROM `app_users` AS a
            WHERE a.id_empresa = '$id_empresa'
            ORDER BY a.id DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->nome,$this->avatar);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {

                $verifica = $this->verificaFuncionarioTarefa($this->id,$id_tarefa);
                //evita q funcionarios q ja estao na tarefa sejam reelistados
                if($verifica)
                {
                    $item['id'] =$this->id;
                    $item['avatar'] =$this->avatar;
                    $item['nome'] =$this->nome;
                    $item['rows'] = $rows;
                    array_push($usuarios,$item);
                }

            }
        }
        if(count($usuarios) < 1){
            $item['rows'] = 0;
            array_push($usuarios,$item);
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function verificaFuncionarioTarefa($id_funcionario,$id_tarefa)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id
            FROM `app_tarefas_users`
            WHERE app_tarefas_id = '$id_tarefa' AND app_users_id = '$id_funcionario'
        "
        );
        $sql->execute();
        $sql->bind_result($this->id_funcionario);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;
        if ($rows == 0) {
            return true;
        } else {
            return false;
        }
        // print_r($usuarios);exit;

    }

    public function saveTarefasFuncionarios($id_tarefa,$id_funcionario)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_tarefas_users`(`app_tarefas_id`,`app_users_id`)
            VALUES ('$id_tarefa','$id_funcionario')"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Funcionário adicionado com sucesso.",
        ];

        return $Param;
    }
    public function excluirTarefasFuncionarios($id_tarefa,$id_funcionario)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_tarefas_users` WHERE app_tarefas_id='$id_tarefa' AND app_users_id ='$id_funcionario'"
        );

        $sql_limpa->execute();


        $Param = [
            "status" => "01",
            "msg" => "Funcionário removido"
        ];

        return $Param;

    }


    public function listTarefasChecklists($id_tarefa)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,a.nome
            FROM `app_checklist` AS a
            WHERE a.app_tarefas_id = '$id_tarefa'
            ORDER BY a.id DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->nome);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {
                    $itensArray=$this->listTarefasChecklistsItens($this->id);
                    $itensChecked=0;

                    foreach ($itensArray as $value) {
                        if(($value['rows'] >0 )&&($value['check'] == 1)){
                            $itensChecked =$itensChecked+1;
                        }
                    }
                    // print_r($value);exit;

                    $item['id'] =$this->id;
                    $item['nome'] =$this->nome;
                    $item['perc_progresso'] =number_format(($itensChecked / count($itensArray)) * 100,2);
                    $item['rows'] = $rows;
                    array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function listTarefasChecklistsItens($id_checklist)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,a.nome,a.check,a.data_cadastro,a.app_checklist_id,a.previsao
            FROM `app_checklist_itens` AS a
            WHERE a.app_checklist_id = '$id_checklist'
            ORDER BY a.previsao ASC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id_filho,$this->nome_check,$this->check,$this->data_cadastro,$this->checklist_id,$this->previsao);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {
                $item['id_checklist'] =$this->checklist_id;
                $item['id'] =$this->id_filho;
                $item['check'] =$this->check;
                $item['nome'] =$this->nome_check;
                $item['data_cadastro'] =dataBR($this->data_cadastro);
                $item['previsao'] =dataHoraBR($this->previsao);
                $item['rows'] = $rows;
                array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }

    public function saveTarefasChecklists($id_tarefa,$nome)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_checklist`(`app_tarefas_id`,`nome`)
            VALUES ('$id_tarefa','$nome')"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Checklist adicionado com sucesso.",
        ];

        return $Param;
    }
    public function saveTarefasChecklistsItens($id_checklist,$nome,$previsao)
    {
        $status_check = 2;
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_checklist_itens`(`app_checklist_id`,`nome`,`check`,`data_cadastro`,`previsao`)
            VALUES ('$id_checklist','$nome','$status_check','$this->data_atual','$previsao')"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Etapa adicionada com sucesso.",
        ];

        return $Param;
    }
    public function excluirTarefasChecklists($id_checklist)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_checklist` WHERE id='$id_checklist'"
        );

        $sql_limpa->execute();


        $Param = [
            "status" => "01",
            "msg" => "Checklist removido"
        ];

        return $Param;

    }
    public function excluirTarefasChecklistsItens($item)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_checklist_itens` WHERE id='$item'"
        );

        $sql_limpa->execute();


        $Param = [
            "status" => "01",
            "msg" => "Etapa removida"
        ];

        return $Param;

    }
    public function updateTarefasCheckItens($id_checklist,$nome,$previsao)
    {
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_checklist_itens`
        SET nome ='$nome' , previsao='$previsao'
        WHERE id='$id_checklist'"
        );
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Checklist atualizado"
        ];

        return $Param;
    }
    public function updateTarefasChecklists($id_checklist,$nome)
    {
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_checklist`
        SET nome ='$nome'
        WHERE id='$id_checklist'"
        );
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Checklist atualizado"
        ];

        return $Param;
    }
    public function checkItem($item)
    {
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_checklist_itens`
        SET `check` =
            CASE WHEN `check` = 1 THEN 2
            WHEN `check` = 2 THEN 1
            ELSE `check` END
        WHERE id='$item'"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Status atualizado"
        ];

        return $Param;
    }

    public function listFotos($id_obra)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,url
            FROM `app_lancamentos_fotos`
            WHERE app_lancamentos_id='$id_obra'
            ORDER BY id DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->url);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['url'] = $this->url;
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function listEquipe($id_obra)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.app_users_id,b.nome,b.tipo_equipe
            FROM `app_users_equipe` AS a
            INNER JOIN `app_users`  AS b ON a.app_users_id = b.id
            WHERE a.app_lancamentos_id='$id_obra'
            ORDER BY b.tipo_equipe ASC
        "
        );
        $sql->execute();
        $sql->bind_result($this->user_id,$this->nome,$this->tipo_equipe);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $horario = $this->verificaHorario($this->user_id,$id_obra);

                $Param['user_id'] = $this->user_id;
                $Param['nome'] = $this->nome;
                $Param['nome'] = $this->nome;
                $Param['tipo_equipe_id'] = $this->tipo_equipe;
                $Param['date_in'] = $horario[0]['data_in'] != null ? hora($horario[0]['data_in']) : null;
                $Param['date_out'] = $horario[0]['data_out'] != null ? hora($horario[0]['data_out']) : null;
                $Param['tipo_equipe'] = ($this->tipo_equipe == 1)? "Líder" : "Funcionário";
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function updateEquipe($id_obra ,$id_funcionario, $tipo_equipe, $date_in, $date_out)
    {
        $data_de = date('Y-m-d H:i:s',strtotime($date_in));
        $data_ate = date('Y-m-d H:i:s',strtotime($date_out));
        $date_hoje=  date("Y-m-d 00:00:01");
        $insertHoje = $this->verificaHorario($id_funcionario,$id_obra);
        $equipeAll = $this->listEquipe($id_obra);

        //status 01 significa que o usuario ja teve um insert feito hoje
        if($insertHoje[0]['status'] == 01){
            if($tipo_equipe == 1){

                foreach($equipeAll as $pessoa){
                    $item = $pessoa['user_id'];

                    $sql_limpa = $this->mysqli->prepare(
                        "DELETE FROM `app_lancamentos_equipe` WHERE app_users_id ='$item' AND app_lancamentos_id='$id_obra' AND data_in > '$date_hoje'"
                    );

                    $sql_limpa->execute();

                    $sql_cadastro = $this->mysqli->prepare(
                        "INSERT INTO `app_lancamentos_equipe`(`app_lancamentos_id`, `app_users_id`, `data_in`, `data_out`)
                        VALUES ('$id_obra', '$item','$data_de','$data_ate')"
                        );

                    $sql_cadastro->execute();

                    $Param = [
                        "status" => "01",
                        "msg" => "Horário Atualizado"
                    ];
                }
            }
            else{

                $sql_limpa = $this->mysqli->prepare(
                    "DELETE FROM `app_lancamentos_equipe` WHERE app_users_id ='$id_funcionario' AND app_lancamentos_id='$id_obra' AND data_in > '$date_hoje'"
                );

                $sql_limpa->execute();

                $sql_cadastro = $this->mysqli->prepare(
                    "INSERT INTO `app_lancamentos_equipe`(`app_lancamentos_id`, `app_users_id`, `data_in`, `data_out`)
                    VALUES ('$id_obra', '$id_funcionario','$data_de','$data_ate')"
                     );

                $sql_cadastro->execute();

                $Param = [
                    "status" => "01",
                    "msg" => "Horário Atualizado"
                ];
            }

        }
        else{
            if($tipo_equipe == 1){

                foreach($equipeAll as $pessoa){
                    // print_r($pessoa['nome']);
                    $item = $pessoa['user_id'];

                    $sql_cadastro = $this->mysqli->prepare(
                        "INSERT INTO `app_lancamentos_equipe`(`app_lancamentos_id`, `app_users_id`, `data_in`, `data_out`)
                        VALUES ('$id_obra', '$item','$data_de','$data_ate')"
                        );

                    $sql_cadastro->execute();

                    $Param = [
                        "status" => "01",
                        "msg" => "Horário inserido"
                    ];
                }
            }
            else{
                $sql_cadastro = $this->mysqli->prepare(
                    "INSERT INTO `app_lancamentos_equipe`(`app_lancamentos_id`, `app_users_id`, `data_in`, `data_out`)
                    VALUES ('$id_obra', '$id_funcionario','$data_de','$data_ate')"
                     );

                $sql_cadastro->execute();

                $Param = [
                    "status" => "01",
                    "msg" => "Horário inserido"
                ];
            }
        }

        return $Param;


    }

    public function listFrotas($id_user)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,nome,url,obs,data_cadastro,ordem,status
            FROM `app_frotas`
            WHERE app_users_id='$id_user'
            ORDER BY ordem ASC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->nome,$this->url,$this->obs,$this->data_cadastro,$this->ordem,$this->status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {
                $Param['id'] = $this->id;
                $Param['nome'] = $this->nome;
                $Param['url'] = $this->url;
                $Param['obs'] = $this->obs;
                $Param['data_cadastro'] = dataBR($this->data_cadastro);
                $Param['ordem'] = $this->ordem;
                $Param['status'] = $this->status;
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function saveFrotas($id_user, $url,$nome,$obs)
    {
        $sql = $this->mysqli->prepare("SELECT ordem FROM app_frotas WHERE app_users_id='$id_user' ORDER BY ordem DESC LIMIT 1");
        $sql->execute();
        $sql->bind_result($this->ordem);
        $sql->store_result();
        $sql->fetch();

        $ordem = $this->ordem + 1;
        $status = 1;

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_frotas`(`app_users_id`, `url`,`nome`,`obs`,`data_cadastro`,`ordem`,`status`)
            VALUES ('$id_user', '$url','$nome','$obs','$this->data_atual','$ordem','$status')"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Frota cadastrada com sucesso"
        ];

        return $Param;
    }











    public function listDocs($id){


        $sql = $this->mysqli->prepare("
        SELECT id, tipo, doc_lado, documento,status
        FROM app_veiculos_doc
        WHERE app_users_id='$id'
        ORDER BY tipo DESC
        ");
        $sql->execute();
        $sql->bind_result($id, $tipo, $doc_lado, $documento, $status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        $usuarios['status'] = 1;
        $usuarios['documentos'] = [];
        if ($rows == 0) {
            $Param['rows'] = $rows;
            if(count($usuarios['documentos']) != 2 ){
                $usuarios['status'] = 2;
            }
            array_push($usuarios['documentos'], $Param);
        } else {
            while ($row = $sql->fetch()) {

                // $Param['id'] = $id;
                $Param['tipo'] = $tipo;
                if($tipo == 1){
                    $Param['tipo_nome'] = "CNH";
                }elseif($tipo == 2){
                    $Param['tipo_nome'] = "Veículo";
                }

                $Param['doc_lado'] = $doc_lado;
                $Param['documento'] = $documento;
                $Param['status'] = $status;
                $Param['rows'] = $rows;

                if($status != 1){
                    $usuarios['status'] = 2;
                }
                array_push($usuarios['documentos'], $Param);
            }
            //verifica se foi mandado todos os doc frente e verso pela quantidade
            if(count($usuarios['documentos']) != 2 ){
                $usuarios['status'] = 2;
            }
        }
        return $usuarios;
    }

    public function listVeiculo($id){


        $sql = $this->mysqli->prepare("
        SELECT a.id, a.cor,a.modelo,a.marca,a.ano, a.status,a.placa,a.tipo,a.pais
        FROM app_veiculos AS a
        WHERE a.app_users_id='$id'
        ");
        $sql->execute();
        $sql->bind_result($id, $cor,$modelo, $marca,$ano,$status,$placa,$tipo,$pais);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];
        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                // $Param['id_veiculo'] = $id;

                $Param['placa'] = $placa;
                $Param['cor'] = $cor;
                $Param['modelo'] = $modelo;
                $Param['pais'] = $pais;
                $Param['marca'] = $marca;
                $Param['ano'] = $ano;
                $Param['status'] = $status;
                $Param['tipo'] = $tipo;
                $Param['rows'] = $rows;
                array_push($usuarios, $Param);
            }

        }
        return $usuarios;
    }


    public function Notificacoes($id){
        $sql = $this->mysqli->prepare("
        SELECT data_cadastro FROM app_users
        WHERE id='$id'
        ");
        $sql->execute();
        $sql->bind_result($tipo_user,$data_cadastro);
        $sql->store_result();
        $sql->fetch();
        $sql->close();

        $sql = $this->mysqli->prepare("
        SELECT id, titulo, descricao, data FROM app_notificacoes
        WHERE data >='$data_cadastro' AND
        ((app_users_id='0') OR app_users_id='$id') OR
        app_users_id='0'
        ORDER BY id DESC
        LIMIT 5
        ");
        $sql->execute();
        $sql->bind_result($this->id, $this->titulo, $this->descricao, $this->data);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['titulo'] = $this->titulo;
                $Param['descricao'] = $this->descricao;
                $Param['data'] = dataBR($this->data) . " - " . horarioBR($this->data);
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }
    public function listaFuncionarios($id_empresa)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,a.nome,a.avatar,a.email,a.celular,a.status,a.cpf,a.data_nascimento
            FROM `app_users` AS a
            WHERE a.id_empresa = '$id_empresa'
            ORDER BY a.nome DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->nome,$this->avatar,$this->email,$this->celular,$this->status,$this->cpf,$this->data_nascimento);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {
                    $item['id'] =$this->id;
                    $item['avatar'] =$this->avatar;
                    $item['nome'] =$this->nome;
                    $item['email'] =$this->email;
                    $item['celular'] =$this->celular;
                    $item['status'] =$this->status;
                    $item['data_nascimento'] =dataBR($this->data_nascimento);
                    $item['cpf'] =formataCpf($this->cpf);
                    $item['rows'] = $rows;
                    array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function listaFuncionariosId($id_empresa,$id_funcionario)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,a.nome,a.avatar,a.email,a.celular,a.data_nascimento,a.status,a.cpf
            FROM `app_users` AS a
            WHERE a.id_empresa = '$id_empresa' AND a.id='$id_funcionario'
            ORDER BY a.nome DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->nome,$this->avatar,$this->email,$this->celular,$this->data_nascimento,$this->status,$this->cpf);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {
                    $item['id'] =$this->id;
                    $item['avatar'] =$this->avatar;
                    $item['nome'] =$this->nome;
                    $item['email'] =$this->email;
                    $item['celular'] =$this->celular;
                    $item['data_nascimento'] =$this->data_nascimento;
                    $item['status'] =$this->status;
                    $item['cpf'] =formataCpf($this->cpf);
                    $item['rows'] = $rows;
                    array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function updateStatusFuncionario($id_empresa,$id_funcionario)
    {
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_users`
        SET `status` =
            CASE WHEN `status` = 1 THEN 2
            WHEN `status` = 2 THEN 1
            ELSE `status` END
        WHERE id='$id_funcionario' AND id_empresa='$id_empresa'"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Status atualizado"
        ];

        return $Param;
    }
    public function excluirFuncionario($id_empresa,$id_funcionario)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_users` WHERE id='$id_funcionario' AND id_empresa='$id_empresa'"
        );

        $sql_limpa->execute();


        $Param = [
            "status" => "01",
            "msg" => "funcionário excluído"
        ];

        return $Param;

    }
    public function updateVeiculo($id_user,$modelo,$marca,$ano,$cor,$placa,$pais,$tipo)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_veiculos` WHERE app_users_id='$id_user'"
        );

        $sql_limpa->execute();

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_veiculos`(`app_users_id`, `modelo`, `marca`, `ano`,`cor`, `placa`, `status`, `pais`, `tipo`)
            VALUES ('$id_user', '$modelo',  '$marca', '$ano','$cor', '$placa','1', '$pais', '$tipo')"
        );

        $sql_cadastro->execute();

        $this->veiculoRetornaPendente($id_user);

        $Param = [
            "status" => "01",
            "msg" => "Cadastro atualizado."
        ];

        return $Param;

    }

    public function editarFuncionario($id_empresa,$id_funcionario,$nome,$email,$celular,$cpf,$data_nascimento,$status)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela`
          SET nome='$nome',email='$email', cpf='$cpf',celular='$celular',data_nascimento='$data_nascimento',status='$status'
        WHERE id='$id_funcionario' AND id_empresa='$id_empresa'
        ");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cadastro atualizado"
        ];

        return $Param;
    }
    public function saveFuncionario($id_empresa,$nome,$email,$celular,$cpf,$data_nascimento){

        $tipo=2;
        $avatar="avatar.png";
        $status=1;
        $aprovado=2;
        $this->token = geraToken(rand(5, 15), rand(100, 500), rand(6000, 10000));
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_users`(`tipo`, `id_empresa`, `nome`, `email`, `celular`,`cpf`,`data_nascimento`,`avatar`, `data_cadastro`, `u_login`, `status`, `status_aprovado`, `token_cadastro`)
            VALUES ('$tipo', '$id_empresa', '$nome', '$email', '$celular', '$cpf','$data_nascimento','$avatar', '$this->data_atual', '$this->data_atual', '$status', '$aprovado', '$this->token')"
        );

        $sql_cadastro->execute();
        $this->id_cadastro = $sql_cadastro->insert_id;

        if($this->id_cadastro>0){
            //ENVIA E-MAIL
            $mail = new EnviarEmail();
            $mail->confirmarcadastro($email,$nome, $this->token);

            $Param['status'] = '01';
            $Param['msg'] = 'As instruções para alteração de senha foram enviadas para o e-mail do funcionário.';
            $lista[] = $Param;
        }

        return $lista;
    }

    public function listaFuncionariosToken($token)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,a.nome,a.avatar,a.email,a.celular,a.data_nascimento,a.status,a.cpf
            FROM `app_users` AS a
            WHERE a.token_cadastro = '$token'
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->nome,$this->avatar,$this->email,$this->celular,$this->data_nascimento,$this->status,$this->cpf);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {
                    $item['id'] =$this->id;
                    $item['avatar'] =$this->avatar;
                    $item['nome'] =$this->nome;
                    $item['email'] =$this->email;
                    $item['celular'] =$this->celular;
                    $item['data_nascimento'] =$this->data_nascimento;
                    $item['status'] =$this->status;
                    $item['cpf'] =formataCpf($this->cpf);
                    $item['rows'] = $rows;
                    array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function cadastroFuncionario($token,$password,$id)
    {
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela`
          SET password='$password', status_aprovado='1',token_cadastro=null WHERE token_cadastro='$token'
        ");

        $sql_cadastro->execute();
        $this->id_cadastro = $sql_cadastro->insert_id;
        $Param = [
            "status" => "01",
            "msg" => "Cadastro efetuado com sucesso.",
            "id" => $id
        ];

        return $Param;
    }
    public function findUserIdByToken($token){

        $sql = $this->mysqli->prepare("SELECT id FROM app_users WHERE token_cadastro='$token'");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->store_result();
        $sql->fetch();


        return $this->id;
    }
    public function findUserPerc($id_user, $id_categoria){

      if($id_categoria == 1){$campo = "perc_imoveis";}else{$campo = "perc_eventos";}

        $sql = $this->mysqli->prepare("SELECT $campo FROM app_users WHERE id='$id_user'");
        $sql->execute();
        $sql->bind_result($this->perc);
        $sql->store_result();
        $sql->fetch();

        return $this->perc;
    }
    public function saveAnexo($tarefa_id,$id_user,$tipo, $url)
    {
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_tarefas_anexos`(`app_tarefas_id`,`app_users_id`,`tipo`, `url`,`data_cadastro`)
            VALUES ('$tarefa_id', '$id_user','$tipo','$url','$this->data_atual')"
        );

        $sql_cadastro->execute();
        $this->verifica_resultado = $sql_cadastro->insert_id;
        if($this->verifica_resultado>0){
            $Param = [
                "status" => "01",
                "msg" => "Anexo adicionado com sucesso."
            ];
        }else{
            $Param = [
                "status" => "02",
                "msg" => "Ocorreu um erro ao anexar."
            ];
        }


        return $Param;
    }
    public function listAnexos($tarefa_id)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,b.nome,a.tipo,a.url,a.data_cadastro
            FROM `app_tarefas_anexos` AS a
            INNER JOIN `app_users` AS b ON a.app_users_id=b.id
            WHERE a.app_tarefas_id = '$tarefa_id'
            ORDER BY a.data_cadastro DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->nome,$this->tipo,$this->url,$this->data_cadastro);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {
                    $item['id'] =$this->id;
                    $item['tipo'] =$this->tipo;
                    $item['nome'] =$this->nome;
                    $item['url'] =$this->url;
                    $item['data_cadastro'] =dataHoraBR($this->data_cadastro);
                    $item['rows'] = $rows;
                    array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function excluirAnexo($id_anexo)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_tarefas_anexos` WHERE id='$id_anexo'"
        );

        $sql_limpa->execute();

        $linhas_afetadas = $sql_limpa->affected_rows;

        if ($linhas_afetadas > 0) {
            $param = [
                "status" => "01",
                "msg" => "Anexo deletado"
            ];
        } else {
            $param = [
                "status" => "02",
                "msg" => "Falha ao deletar o anexo"
            ];
        }

        return $param;

    }
    public function listTarefasComentarios($tarefa_id)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id,b.id,b.nome,a.descricao,a.data
            FROM `app_comentarios` AS a
            INNER JOIN `app_users` AS b ON a.app_users_id=b.id
            WHERE a.app_tarefas_id = '$tarefa_id'
            ORDER BY a.data DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->nome_id,$this->nome,$this->descricao,$this->data_cadastro);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $item['rows'] = $rows;
            array_push($usuarios,$item);
        } else {
            while ($row = $sql->fetch()) {
                    $item['id'] =$this->id;
                    $item['descricao'] =$this->descricao;
                    $item['nome_id'] =$this->nome_id;
                    $item['nome'] =$this->nome;
                    $item['data_cadastro'] =dataHoraBR($this->data_cadastro);
                    $item['rows'] = $rows;
                    array_push($usuarios,$item);
            }
        }
        // print_r($usuarios);exit;
        return $usuarios;
    }
    public function excluirTarefasComentarios($id_comentario)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_comentarios` WHERE id='$id_comentario'"
        );

        $sql_limpa->execute();

        $linhas_afetadas = $sql_limpa->affected_rows;

        if ($linhas_afetadas > 0) {
            $param = [
                "status" => "01",
                "msg" => "Comentário deletado"
            ];
        } else {
            $param = [
                "status" => "02",
                "msg" => "Falha ao deletar o comentário"
            ];
        }

        return $param;

    }
    public function saveTarefasComentarios($tarefa_id,$id_user,$descricao)
    {
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_comentarios`(`app_tarefas_id`,`app_users_id`,`descricao`,`data`)
            VALUES ('$tarefa_id', '$id_user','$descricao','$this->data_atual')"
        );

        $sql_cadastro->execute();
        $this->verifica_resultado = $sql_cadastro->insert_id;
        if($this->verifica_resultado>0){
            $Param = [
                "status" => "01",
                "msg" => "Comentário adicionado com sucesso."
            ];
        }else{
            $Param = [
                "status" => "02",
                "msg" => "Ocorreu um erro."
            ];
        }


        return $Param;
    }
    public function updateTarefasComentarios($comentario_id,$id_user,$descricao)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_comentarios`
          SET descricao='$descricao',data='$this->data_atual'
        WHERE id='$comentario_id' AND app_users_id='$id_user'
        ");

        $sql_cadastro->execute();
        $linhas_afetadas = $sql_cadastro->affected_rows;

        if ($linhas_afetadas > 0) {
            $Param = [
                "status" => "01",
                "msg" => "Comentário atualizado"
            ];
        } else {
            $Param = [
                "status" => "02",
                "msg" => "Falha ao editar o comentário"
            ];
        }
        return $Param;
    }


    public function importarCsv($arquivo)
    {

        $delimitador = ',';
        $cerca='"';

        $arquivo_aberto= fopen($arquivo,'r');

        if($arquivo_aberto){
            $cabecalho= fgetcsv($arquivo_aberto,0,$delimitador,$cerca);
            if(count($cabecalho)<= 1){
                fclose($arquivo_aberto);
                $arquivo_aberto= fopen($arquivo,'r');
                $delimitador = ';';

                $cabecalho = fgetcsv($arquivo_aberto, 0, $delimitador, $cerca);
            }

            while(!feof($arquivo_aberto)){
                $linha = fgetcsv($arquivo_aberto,0,$delimitador,$cerca);

                if(!$linha){
                    continue;
                }

                //montando os registro para mandar pro banco
                $registros = array_combine($cabecalho,$linha);
                $marca= trim($registros['Marca']);
                $modelo= trim($registros['Modelo']);
                $nome= utf8_encode(trim($registros['Nome']));
                $serie= trim($registros['Série']);
                $ano= intval($registros['Ano']);
                $horimetro= intval($registros['Horímetro']);
                $proprietario= utf8_encode(trim($registros['Proprietário']));
                $placa= trim($registros['Placa']);

                $verifica=$this->verificaRepetidos($nome,$marca);
                // print_r($verifica);exit;
                if(!empty($marca) AND !empty($modelo) AND ($verifica < 1)){
                    $enviar = $this->saveEquipamentos($marca,$modelo,$nome,$ano,$serie,$horimetro,$proprietario,tiraCarac($placa),1);
                }

            }
            fclose($arquivo_aberto);
        }
        $Param = [
            "status" => "01",
            "msg" => "Arquivo importado com sucesso."
        ];
        return $Param;
    }

    public function listCnpj($cnpj)
    {
        $dados = listCnpj($cnpj);
        $param = [
            "situacao_cadastral" => $dados->estabelecimento->situacao_cadastral,
            "nome_responsavel" => $dados->qualificacao_do_responsavel->descricao,
            "nome_fantasia" => $dados->estabelecimento->nome_fantasia,
            "razao_social" => $dados->razao_social,
            "inscricao_estadual" => $dados->estabelecimento->inscricoes_estaduais[0]->inscricao_estadual
        ];

        return $param;
    }




}
