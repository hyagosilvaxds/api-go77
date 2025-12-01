<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Usuarios/Enderecos.class.php';
require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Cadastros/Cadastros.class.php';
require_once MODELS . '/Anuncios/Anuncios.class.php';
require_once MODELS . '/Configuracoes/Configuracoes.class.php';
require_once MODELS . '/Notificacoes/Notificacoes.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';


class Reservas extends Conexao
{


    public function __construct()
    {
        $this->Conecta();
        // $this->ConectaWordPress();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->data = date('Y-m-d');
        $this->data_atual_soma1d = date('Y-m-d', strtotime($this->data. ' + 1 days'));

    }


    public function save($id_pagamento,$id_user,$id_anuncio,$id_anuncio_type,$adultos,$criancas,$date_de,$data_ate,$valor_final,$obs, $status){

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_reservas`(`app_pagamentos_id`,`app_users_id`,`app_anuncios_id`,`id_anuncio_type`,`adultos`,`criancas`,`data_de`,`data_ate`,`valor_final`,`taxa_limpeza`,`data_cadastro`,`obs`,`status`)
             VALUES ('$id_pagamento','$id_user','$id_anuncio','$id_anuncio_type','$adultos','$criancas','$date_de','$data_ate','$valor_final','0.00','$this->data_atual','$obs','$status')"
        );
        $sql_cadastro->execute();

        $id_reserva = $sql_cadastro->insert_id;

        $Param = [
            "status" => "01",
            "id" => $id_reserva,
            "msg" => "Reserva efetuada com sucesso."
        ];

        return $Param;
    }

    public function saveCancelamento($id_reserva,$id_user,$id_motivo,$obs,$status){

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_reservas_cancelamentos`(`app_reservas_id`,`app_users_id`,`app_cancelamentos_id`,`obs`,`status`)
             VALUES ('$id_reserva','$id_user','$id_motivo','$obs','$status')"
        );
        $sql_cadastro->execute();

        return $Param;
    }

    public function verificaCartao($id_cartao,$id_user)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id,customer,token,card_number,month,year,cvv,nome,cpf,cep,numero,bandeira
            FROM `app_cartoes`
            WHERE id = '$id_cartao' AND app_users_id='$id_user'
            "
        );

        $sql->execute();
        $sql->bind_result($id,$customer,$token,$card_number,$month,$year,$cvv,$nome,$cpf,$cep,$numero,$bandeira);
        $sql->store_result();
        $rows = $sql->num_rows;


        $lista = [];

        while ($row = $sql->fetch()) {
            $Param['id'] = $id;
            $Param['customer'] = $customer;
            $Param['token'] = $token;
            $Param['bandeira'] = $bandeira;
            $Param['card_number'] = $card_number;
            $Param['month'] = $month;
            $Param['year'] = $year;
            $Param['cvv'] = $cvv;
            $Param['nome'] = $nome;
            $Param['cpf'] = $cpf;
            $Param['cep'] = $cep;
            $Param['numero'] = $numero;

            array_push($lista, $Param);
        }
        return $lista[0];
    }

    public function listReservasAnuncioAll($id_anuncio)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id, a.adultos, a.criancas, a.data_de, a.data_ate, a.valor_final, b.id, b.nome
            FROM `app_reservas` as a
            INNER JOIN `app_users` as b ON a.app_users_id = b.id
            WHERE a.app_anuncios_id ='$id_anuncio' AND a.status='1'
            "
        );

        $sql->execute();
        $sql->bind_result($id,$adultos,$criancas,$data_de,$data_ate,$valor_final,$id_user,$nome_user);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        }else{

            while ($row = $sql->fetch()){

                $Param['id'] = $id;
                $Param['adultos'] = $adultos;
                $Param['criancas'] = $criancas;
                $Param['data_de'] = dataBR($data_de);
                $Param['data_ate'] = dataBR($data_ate);
                $Param['valor_final'] = moneyView($valor_final);
                $Param['id_user'] = $id_user;
                $Param['nome_user'] = decryptitem($nome_user);


                array_push($lista, $Param);
            }

        }

        return $lista;
    }

    public function listReservasAnuncio($id_anuncio, $id_anuncio_type)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT a.id, a.adultos, a.criancas, a.data_de, a.data_ate, a.valor_final, b.id, b.nome
            FROM `app_reservas` as a
            INNER JOIN `app_users` as b ON a.app_users_id = b.id
            WHERE a.app_anuncios_id ='$id_anuncio' AND a.id_anuncio_type='$id_anuncio_type' AND a.status='1'
            "
        );

        $sql->execute();
        $sql->bind_result($id,$adultos,$criancas,$data_de,$data_ate,$valor_final,$id_user,$nome_user);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        }else{

            while ($row = $sql->fetch()){

                $Param['id'] = $id;
                $Param['adultos'] = $adultos;
                $Param['criancas'] = $criancas;
                $Param['data_de'] = dataBR($data_de);
                $Param['data_ate'] = dataBR($data_ate);
                $Param['valor_final'] = moneyView($valor_final);
                $Param['id_user'] = $id_user;
                $Param['nome_user'] = decryptitem($nome_user);


                array_push($lista, $Param);
            }

        }

        return $lista;
    }

    public function listReservasAnuncioTipo($id)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT id, adultos, criancas, data_de, data_ate, valor_final
            FROM `app_reservas`
            WHERE id_anuncio_type='$id' AND status='1'
            "
        );

        $sql->execute();
        $sql->bind_result($id,$adultos,$criancas,$data_de,$data_ate,$valor_final);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if ($rows == 0) {
            $Param['rows'] = 0;
            array_push($lista, $Param);
        }else{

            while ($row = $sql->fetch()){

                $Param['id'] = $id;
                $Param['adultos'] = $adultos;
                $Param['criancas'] = $criancas;
                $Param['data_de'] = dataBR($data_de);
                $Param['data_ate'] = dataBR($data_ate);
                $Param['valor_final'] = moneyView($valor_final);


                array_push($lista, $Param);
            }

        }

        return $lista;
    }

    public function lista($id, $tipo_pagamento, $data_de, $data_ate, $status){

      $filter .= "WHERE a.id>0";

      if(!empty($id)){
          $filter .= " AND a.id='$id'";
      }
      if(!empty($tipo_pagamento)){
          $filter .= " AND b.tipo_pagamento='$tipo_pagamento'";
      }

      if(!empty($data_de) AND !empty($data_ate)){
          $filter .= " AND a.data_de <='$data_de' AND a.data_ate >='$data_ate'";
      }

      if(!empty($status)){
          $filter .= " AND a.status='$status'";
      }

      $sql = $this->mysqli->prepare(
          "
          SELECT a.id, a.app_users_id, a.app_anuncios_id, a.adultos, a.criancas, a.data_de, a.data_ate, a.taxa_limpeza, a.obs, a.status,
          b.tipo_pagamento, b.valor_final, b.valor_anunciante, b.valor_admin, b.data, b.token,
          c.app_users_id
          FROM `app_reservas` as a
          INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
          INNER JOIN `app_anuncios` as c ON a.app_anuncios_id = c.id
          $filter
          GROUP BY a.id
          ORDER BY a.id ASC
          ");

      $sql->execute();
      $sql->bind_result(
      $id, $id_user, $id_anuncio, $adultos, $criancas, $data_de, $data_ate, $taxa_limpeza, $obs, $status_reserva, $tipo_pagamento, $valor_final,
      $valor_anunciante, $valor_admin, $data, $token, $id_anfitrao
      );
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {

        while ($row = $sql->fetch()) {

              $model_usuarios = New Usuarios();
              $model_cadastros = New Cadastros();
              $model_anuncios = New Anuncios();
              $model_config = New Configuracoes();

              $dadosAnuncio = $model_anuncios->listID($id_anuncio);


              $Param['rows'] = $rows;
              $Param['id'] = $id;
              $Param['adultos'] = $adultos;
              $Param['criancas'] = $criancas;
              $Param['data_de'] = dataBR($data_de);
              $Param['data_ate'] = dataBR($data_ate);
              $Param['taxa_limpeza'] = moneyView($taxa_limpeza);
              $Param['obs'] = $obs;
              $Param['status'] = statusReserva($status_reserva);
              $Param['tipo_pagamento'] = tipoPagamento($tipo_pagamento);
              $Param['valor_final'] = moneyView($valor_final);
              $Param['valor_anunciante'] = moneyView($valor_anunciante);
              $Param['valor_admin'] = moneyView($valor_admin);
              $Param['id_pagamento'] = $token;
              $Param['data_pagamento'] = dataBR($data);
              $Param['horario_pagamento'] = horarioBR($data);
              $Param['cancelar'] = $cancelar;
              $Param['tempo_cancelamento'] = $tempo_cancelamento_s;
              //$Param['perfil'] = $model_usuarios->Perfil($id_user);
              $Param['perfil'] = $model_cadastros->Perfil($id_user);
              $Param['anfitriao'] = $model_cadastros->Perfil($id_anfitrao);
              $Param['anuncio'] = $model_anuncios->listID($id_anuncio);




              array_push($lista, $Param);

        }


      }

      return $lista;

    }

    public function Mylista2($id_user, $data_de, $data_ate){

      $filter = " WHERE a.app_users_id ='$id_user' AND a.status IN(1,3)";

      if(!empty($data_de) AND !empty($data_ate)){
          $filter .= " AND a.data_de <='$data_de' AND a.data_ate >='$data_ate'";
      }

      $sql = $this->mysqli->prepare(
          "
          SELECT a.id, a.app_users_id, a.app_anuncios_id, a.adultos, a.criancas, a.data_de, a.data_ate, a.taxa_limpeza, a.obs, a.status,
          b.tipo_pagamento, b.valor_final, b.valor_anunciante, b.valor_admin, b.data, b.token
          FROM `app_reservas` as a
          INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
          $filter
          GROUP BY a.id
          ORDER BY a.id ASC
          ");

      $sql->execute();
      $sql->bind_result(
      $id, $id_user, $id_anuncio, $adultos, $criancas, $data_de, $data_ate, $taxa_limpeza, $obs, $status_reserva, $tipo_pagamento, $valor_final,
      $valor_anunciante, $valor_admin, $data, $token
      );
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = [];

      if ($rows == 0) {
          $Param['rows'] = 0;
          array_push($lista, $Param);
      } else {

        while ($row = $sql->fetch()) {

              $model_usuarios = New Usuarios();
              $model_anuncios = New Anuncios();
              $model_config = New Configuracoes();

              //verifica se pode cancelar baseado na configuracao de minutos que antecedem o checkin
              $dadosConfig = $model_config->listConfig();
              $dadosAnuncio = $model_anuncios->listID($id_anuncio);

              $checkinAnuncio = $dadosAnuncio[0]['checkin'];
              $tempoCancelarAdmin = $dadosConfig['tempo_cancelamento'];

              $dataDe = $data_de . " " . $checkinAnuncio;

              $tempoCancelar = calculaDifDatas($this->data_atual, $dataDe);

              if($tempoCancelar['dias'] > 0){
                $cancelar = 1;
                $tempo_cancelamento_s = "Você ainda tem " . $tempoCancelar['dias'] . " dia(s) para cancelar a reserva.";
              }
              elseif(($tempoCancelar['dias'] == 0) && ($tempoCancelar['minutos'] <= $tempoCancelarAdmin)){
                $cancelar = 1;
                $tempo_cancelamento_s = "Você ainda tem " . $tempoCancelar['minutos'] . " minutos(s) para cancelar a reserva.";
              }
              elseif(($tempoCancelar['dias'] == 0) && ($tempoCancelar['minutos'] < $tempoCancelarAdmin)){
                $cancelar = 2;
                $tempo_cancelamento_s = "Você não pode mais cancelar essa reserva.";
              }


              $Param['id'] = $id;
              $Param['adultos'] = $adultos;
              $Param['criancas'] = $criancas;
              $Param['data_de'] = dataBR($data_de);
              $Param['data_ate'] = dataBR($data_ate);
              $Param['taxa_limpeza'] = moneyView($taxa_limpeza);
              $Param['obs'] = $obs;
              $Param['status'] = statusReserva($status_reserva);
              $Param['tipo_pagamento'] = tipoPagamento($tipo_pagamento);
              $Param['valor_final'] = moneyView($valor_final);
              $Param['id_pagamento'] = $token;
              $Param['data_pagamento'] = dataBR($data);
              $Param['horario_pagamento'] = horarioBR($data);
              $Param['cancelar'] = $cancelar;
              $Param['tempo_cancelamento'] = $tempo_cancelamento_s;
              $Param['perfil'] = $model_usuarios->Perfil($dadosAnuncio[0]['id_user']);
              $Param['anuncio'] = $model_anuncios->listID($id_anuncio);


              if($status_reserva == 3){
                $Param['cancelamento'] = $this->verificaCancelamento($id, $valor_final);
              }

              array_push($lista, $Param);

        }


      }

      return $lista;

    }



    public function listMotivos($id, $tipo)
    {

        $filter = " WHERE status='1'";

        if(!empty($id)){ $filter .= " AND id='$id'";}

        if(!empty($tipo)){ $filter .= " AND tipo='$tipo'";}

        $sql = $this->mysqli->prepare("SELECT * FROM `app_cancelamentos` $filter");
        $sql->execute();
        $sql->bind_result($id,$tipo,$nome,$taxado,$taxa_perc,$status);
        $sql->store_result();
        $rows = $sql->num_rows;


        $lista = [];

        if($rows == 0){
          $Param['rows'] = $rows;

          array_push($lista, $Param);
        }else{

          while ($row = $sql->fetch()) {

              $Param['id'] = $id;
              $Param['tipo'] = $tipo;
              $Param['nome'] = $nome;
              $Param['taxado'] = $taxado;
              $Param['taxa_perc'] = $taxa_perc;
              $Param['status'] = $status;

              array_push($lista, $Param);
          }

        }
        return $lista;
    }

    public function updateReserva($id_pagamento, $status){

      $sql = $this->mysqli->prepare("UPDATE `app_reservas` SET status='$status' WHERE app_pagamentos_id='$id_pagamento'");
      $sql->execute();


    }

    public function listReserva($id)
    {

        $sql = $this->mysqli->prepare("
        SELECT a.id, a.app_users_id, a.valor_final, b.token, b.valor_anunciante, c.app_users_id, c.nome
        FROM `app_reservas` as a
        INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
        INNER JOIN `app_anuncios` as c ON b.app_anuncios_id = c.id
        WHERE a.id='$id'
        ");


        $sql->execute();
        $sql->bind_result($id,$id_hospede,$valor_final,$token,$valor_anunciante,$id_anunciante,$nome_anuncio);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;


        $Param = [
            "id" => $id,
            "valor_final" => $valor_final,
            "valor_anunciante" => $valor_anunciante,
            "id_hospede" => $id_hospede,
            "id_anunciante" => $id_anunciante,
            "nome_anuncio" => $nome_anuncio,
            "token" => $token
        ];

        return $Param;
    }

    public function listReservaToken($token)
    {

        $sql = $this->mysqli->prepare("
        SELECT a.id, a.app_users_id, a.valor_final, b.token, b.valor_anunciante, c.app_users_id, c.nome
        FROM `app_reservas` as a
        INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
        INNER JOIN `app_anuncios` as c ON b.app_anuncios_id = c.id
        WHERE b.token='$token'
        ");


        $sql->execute();
        $sql->bind_result($id,$id_hospede,$valor_final,$token,$valor_anunciante,$id_anunciante,$nome_anuncio);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;


        $Param = [
            "id" => $id,
            "valor_final" => $valor_final,
            "valor_anunciante" => $valor_anunciante,
            "id_hospede" => $id_hospede,
            "id_anunciante" => $id_anunciante,
            "nome_anuncio" => $nome_anuncio,
            "token" => $token
        ];

        return $Param;
    }

    public function findLastUser($id_user)
    {

        $sql = $this->mysqli->prepare("
        SELECT a.id, b.id, b.checkout, a.data_ate
        FROM `app_reservas` as a
        INNER JOIN `app_anuncios` as b ON a.app_anuncios_id = b.id
        WHERE a.app_users_id='$id_user'
        ORDER BY a.id DESC
        LIMIT 1
        ");

        $sql->execute();
        $sql->bind_result($id_reserva, $id_anuncio, $checkout, $data_ate);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        if($rows > 0){
          $Param = [
            "status" => 01,
            "id_reserva" => $id_reserva,
            "id_anuncio" => $id_anuncio,
            "checkout" => $checkout,
            "data_ate" => $data_ate
          ];

        }else{

          $Param = [
            "status" => 01,
            "msg" => "Não possui reservas no momento."
          ];
        }


        return $Param;
    }


    public function cronLembrete()
    {

        $sql = $this->mysqli->prepare("
        SELECT a.id, a.app_users_id, a.data_de, b.checkin, b.nome
        FROM `app_reservas` as a
        INNER JOIN `app_anuncios` as b ON a.app_anuncios_id = b.id
        WHERE a.status='1' AND a.data_de='$this->data_atual_soma1d'
        ");


        $sql->execute();
        $sql->bind_result($id,$id_hospede,$data_de,$checkin,$nome);
        $sql->store_result();
        $rows = $sql->num_rows;


        while ($row = $sql->fetch()) {

          $notificacao = new Notificacoes();

          //LEMBRETE DE RESERVA (disparar anfitriao)
          $param = "Sua estadia está chegando... imóvel: " . $nome . " com checkin: " . dataBR($data_de) . " - " . $checkin;
          $notificacao->save("lembrete-reserva-anfitriao", $id_hospede, $param);


        }
    }

    public function listIngressosComprados($id_type_ing)
    {


        $sql = $this->mysqli->prepare("
        SELECT COUNT(c.id) as count FROM `app_reservas` as a
        INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
        INNER JOIN `app_carrinho_conteudo` as c ON a.id_carrinho = c.app_carrinho_id
        WHERE b.status IN ('RECEIVED', 'CONFIRMED') AND c.app_anuncios_ing_types_id='$id_type_ing'
        GROUP BY c.app_anuncios_ing_types_id
        ");
        $sql->execute();
        $sql->bind_result($count);
        $sql->store_result();
        $sql->fetch();

        return $count;
    }

    public function listIngressosReserva($id)
    {

        $sql = $this->mysqli->prepare("
        SELECT c.tipo, c.nome, b.id, b.valor, b.qrcode, b.nome, b.email, b.celular, b.lido
        FROM `app_reservas` as a
        INNER JOIN `app_carrinho_conteudo` as b ON a.id_carrinho = b.app_carrinho_id
        INNER JOIN `app_anuncios_ing_types` as c ON b.app_anuncios_ing_types_id = c.id
        WHERE a.id='$id'
        ORDER BY b.id ASC
        ");
        $sql->execute();
        $sql->bind_result($tipo, $nome_ingresso, $id, $valor, $qrcode, $nome, $email, $celular, $lido);
        $sql->store_result();
        $rows = $sql->num_rows;

        $lista = [];

        if($rows == 0){
          $Param['rows'] = $rows;

          array_push($lista, $Param);
        }else{

          while ($row = $sql->fetch()) {

              $Param['nome_ingresso'] = $nome_ingresso;
              $Param['tipo'] = tipoIngressos($tipo);
              $Param['id'] = $id;
              $Param['valor'] = moneyView($valor);
              $Param['qrcode'] = decryptitem($qrcode);
              $Param['nome'] = decryptitem($nome);
              $Param['email'] = decryptitem($email);
              $Param['celular'] = decryptitem($celular);
              $Param['lido'] = $lido;

              array_push($lista, $Param);
          }

        }
        return $lista;
    }


}
