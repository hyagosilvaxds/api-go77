<?php

use MercadoPago\Config\Json;

require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Pagamentos/Pagamentos.class.php';
require_once MODELS . '/phpMailer/Enviar.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Notificacoes/Notificacoes.class.php';

require 'autoload.php';


class MpPayment extends Conexao
{

  public function __construct()
  {

    $this->Conecta();

    $request = file_get_contents('php://input');

    $this->input = json_decode($request);
    $this->secure = new Secure();
    $this->req = $_REQUEST;
    $this->data = date('Y-m-d H:i:s');
  }


  public function createTokenCard() {

      $request = file_get_contents('php://input');
      $input = json_decode($request);

      $data = array(
      "card_number" => $input->card_number,
      "expiration_month" => $input->expiration_month,
      "expiration_year" => $input->expiration_year,
      "security_code" => $input->security_code,
      "cardholder" => array("name" => $input->nome, "identification" => array("number" => $input->cpf, "type" => "CPF"))
      );

      $myJSON = json_encode($data);

      $ch_person = curl_init("https://api.mercadopago.com/v1/card_tokens");

      curl_setopt($ch_person, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch_person, CURLOPT_POSTFIELDS, $myJSON);
      curl_setopt($ch_person, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch_person, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . TOKEN_MP_SANDBOX,
      'Content-Length: ' . strlen($myJSON))
    );
    
    
    $result = curl_exec($ch_person);
    
    echo $result;
  
  }

  public function listCartoes($id_cliente) {

    
    $url = 'https://api.mercadopago.com/v1/customers/' . $id_cliente . '/cards';
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . TOKEN_MP_SANDBOX,
    ]);
    
    $result = curl_exec($ch);
    
    echo $result;

    
  }

  public function criarCliente($nome, $email,$celular) {

    $primeiro_nome = explode(" ", $nome)[0];
    $segundo_nome =explode(" ", $nome)[1] ;
    if(!$segundo_nome){$segundo_nome=$primeiro_nome;}

    $url = 'https://api.mercadopago.com/v1/customers';
    
    $data = array(
        "email" => $email,
        "first_name" => $primeiro_nome,
        "last_name" => $segundo_nome,
        "phone" => array(
            "area_code" => "55",
            "number" => $celular
        ),
    );
    
    $headers = array(
        'Authorization: Bearer ' . TOKEN_MP_SANDBOX,
        'Content-Type: application/json'
    );
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    // echo $response;
    if(!empty($data['id'])){
      return $data;
    }else{
      $Param = [
        "status" => "02",
        "msg" => $data['cause'][0]['description'],
    ];

    return $Param;
    }
    
    curl_close($ch);  
    
  }

  
  public function saveCartao($customerId,$token) {

    $url = 'https://api.mercadopago.com/v1/customers/' . $customerId . '/cards';
    
    $data = array(
        'token' => $token
    );
    
    $headers = array(
        'Authorization: Bearer ' . TOKEN_MP_SANDBOX,
        'Content-Type: application/json'
    );
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    echo $response;
    
    curl_close($ch);
    
    
  }

  public function deleteCartao($customerId,$cardId) {

    
    $url = 'https://api.mercadopago.com/v1/customers/' . $customerId . '/cards/' . $cardId;
    
    $headers = array(
        'Authorization: Bearer ' . TOKEN_MP_SANDBOX
    );
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    echo $response;
    
    curl_close($ch);
  }

  public function criarTokenCartaoAssinatura() {

      $request = file_get_contents('php://input');
      $input = json_decode($request);

      $data = array(
      "card_number" => $input->card_number,
      "expiration_month" => $input->expiration_month,
      "expiration_year" => $input->expiration_year,
      "security_code" => $input->security_code,
      "cardholder" => array("name" => $input->nome, "identification" => array("number" => $input->cpf, "type" => "CPF"))
      );

      $myJSON = json_encode($data);

      $ch_person = curl_init("https://api.mercadopago.com/v1/card_tokens");

      curl_setopt($ch_person, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch_person, CURLOPT_POSTFIELDS, $myJSON);
      curl_setopt($ch_person, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch_person, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . TOKEN_MP_SANDBOX_PROD,
      // 'Authorization: Bearer ' . TOKEN_MP_PRODUCTION,
      'Content-Length: ' . strlen($myJSON))
    );
    
    
    $result = curl_exec($ch_person);
    
    echo $result;

  }
  public function orderCartaoAssinatura($id_usuario,$email_usuario, $tipo_pagamento,$id_plano,$valor, $card,$tipo,$dias)
  {  
    //remove anteriores para nao haver risco de pagamento duplicado
    $remover_planos_anteriores = $this->removerPlano($id_usuario);

    MercadoPago\SDK::setAccessToken(TOKEN_MP_SANDBOX_PROD);
    // MercadoPago\SDK::setAccessToken(TOKEN_MP_PRODUCTION);

    $preapproval_data = new MercadoPago\Preapproval();
    
    // $valor=0.5;
    // $preapproval_data->payer_email = $email_usuario;
    $preapproval_data->payer_email = EMAIL_MP_SANDBOX_PROD;
    $preapproval_data->card_token_id = $card;
    $preapproval_data->back_url = "https://mobile.repasse.app/";
    $preapproval_data->reason = "Assinatura Repasse";
    $preapproval_data->external_reference = "REPASSE-1";
    $preapproval_data->status = "authorized";
    $preapproval_data->notification_url = "https://mobile.repasse.app/apiv3/user/mp/notificacao";
    $preapproval_data->auto_recurring = array( 
      "frequency" => $dias,
      "frequency_type" => "days",
      "transaction_amount" => $valor,
      "currency_id" => "BRL"
    );
  
    $preapproval_data->save();
    // print_r($preapproval_data);

    $id_payer = $preapproval_data->payer_id;
    $status_order = $preapproval_data->status;
    // print_r($id_order);exit;


    if ($id_payer != "") {

      $pagamentos = new Pagamentos();

      $pagamentos->save($id_usuario,$id_plano,$tipo_pagamento,$this->data,null,null,$valor,1,$id_payer,$status_order,$tipo);
      $this->trocaPlano($id_plano,$id_usuario);

      $Param['status'] = '01';
      $Param['msg'] = "Assinatura gerada com sucesso.";
      $lista[] = $Param;

      return $lista;
    }
    else {

      $Param['status'] = '02';
      $Param['msg'] = "Pagamento não efetuado, tente novamente.";
      $lista[] = $Param;

      return $lista;
    }
  }
  public function removerPlano($id_usuario)
  {  

    $payer_id = $this->dadosAssinatura($id_usuario);
    if(!$payer_id){
      $Param['status'] = '02';
      $Param['msg'] = "Ocorreu um erro ao cancelar, tente novamente.";
      $lista[] = $Param;
      return $lista;
    }

    MercadoPago\SDK::setAccessToken(TOKEN_MP_SANDBOX_PROD);
    // MercadoPago\SDK::setAccessToken(TOKEN_MP_PRODUCTION);

        // Busca as assinaturas relacionadas ao pagador
        $subscriptions = \MercadoPago\Preapproval::search([
          'payer_id' => $payerId,
      ]);
      //para cada assinatura encontrada desse payer_id
      foreach ($subscriptions as $subscription) {
        $preapproval_data = new MercadoPago\Preapproval();
          try {
            // Busque o preapproval pelo ID
            $preapproval = \MercadoPago\Preapproval::find_by_id($subscription->id);
        
            // Cancela
            $preapproval->status = 'cancelled';
            $preapproval->update();
        } catch (\Exception $e) {
            // echo 'Erro: ' . $e->getMessage();
            $Param['status'] = '02';
            $Param['msg'] = "Ocorreu um erro ao cancelar, tente novamente.";
            $lista[] = $Param;
      
            return $lista;
        }
      }
      //se nao ouve erros
      $pagamentos = new Pagamentos();

      $pagamentos->cancelaPlanos($id_usuario,$preapproval->status);

      $Param['status'] = '01';
      $Param['msg'] = "Assinatura cancelada com sucesso.";
      $lista[] = $Param;
      return $lista;
  }

  public function orderCartao($id_usuario,$nome_usuario, $email_usuario, $documento_usuario, $tipo_pagamento,$id_plano,$valor, $payment_id, $card, $parcelas,$tipo)
  {

    // MercadoPago\SDK::setAccessToken(TOKEN_MP_PRODUCTION);
    MercadoPago\SDK::setAccessToken(TOKEN_MP_SANDBOX);
    $payment = new MercadoPago\Payment();

    $payment->transaction_amount = $valor;
    //token tem que ser sempre gerado 1x
    $payment->token = $card;
    $payment->description = "Compra no app Re.passe";
    $payment->installments = $parcelas;
    $payment->payment_method_id = $payment_id;
    $payment->notification_url = "https://mobile.repasse.app/apiv3/user/mp/notificacao";
    $payment->payer = array(
      "email" => $email_usuario,
      "first_name" => $nome_usuario,
      "last_name" => '',
      "identification" => array(
        "type" => 'CPF',
        "number" => $documento_usuario
      )
    );
    
    $payment->capture = true;
    $payment->binary_mode = true;
    
    $payment->save();
    // print_r($payment);exit;


    $id_order = $payment->id;
    $status_order = $payment->status;


    if ($id_order != "") {

      $pagamentos = new Pagamentos();

      $pagamentos->save(
        $id_usuario,
        $id_plano,
        $tipo_pagamento,
        $this->data,
        null,
        null,
        $valor,
        $parcelas,
        $id_order,
        $status_order,
        $tipo
      );

      $Param['status'] = '01';
      $Param['msg'] = "Pagamento gerado com sucesso, aguarde aprovação.";
      $lista[] = $Param;

      return $lista;
    }
    else {

      $Param['status'] = '02';
      $Param['msg'] = "Pagamento não efetuado, tente novamente.";
      $lista[] = $Param;

      return $lista;
    }
  }

  public function orderBoleto($id_usuario,$id_plano,$nome_usuario, $email_usuario, $documento_usuario, $cep, $endereco, $estado, $cidade, $bairro, $numero, $tipo_pagamento, $payment_id, $valor, $parcelas)
  {
    // MercadoPago\SDK::setAccessToken(TOKEN_MP_PRODUCTION);
    MercadoPago\SDK::setAccessToken(TOKEN_MP_SANDBOX);
    $primeiro_nome = explode(" ", $nome_usuario)[0];
    $segundo_nome =explode(" ", $nome_usuario)[1] ;
    if(!$segundo_nome){$segundo_nome=$primeiro_nome;}

    $payment = new MercadoPago\Payment();
    $payment->transaction_amount = $valor;
    $payment->description = "Compra no app Re.passe";
    $payment->payment_method_id = $payment_id;
    $payment->notification_url = "https://mobile.repasse.app/apiv3/user/mp/notificacao";
    $payment->payer = array(
      "email" => $email_usuario,
      "first_name" => $primeiro_nome,
      "last_name" => $segundo_nome,
      "identification" => array(
        "type" => 'CPF',
        "number" => $documento_usuario
      ),
      "address" =>  array(
        "zip_code" => tiraCarac($cep),
        "street_name" => $endereco,
        "street_number" => $numero,
        "neighborhood" => $bairro,
        "city" => $cidade,
        "federal_unit" => $estado
        )
      );
      $payment->save();
      // print_r ($payment);exit;

    $id_order = $payment->id;
    $status_order = $payment->status;
    $link_boleto = $payment->transaction_details->external_resource_url;
    $cod_barras = $payment->barcode->content;

    if ($id_order != "") {

      $pagamentos = new Pagamentos();

      $pagamentos->save(
        $id_usuario,
        $id_plano,
        $tipo_pagamento,
        $this->data,
        $link_boleto,
        null,
        $valor,
        $parcelas,
        $id_order,
        $status_order,
        2
      );

      $Param['status'] = '01';
      $Param['msg'] = "Pagamento gerado com sucesso, aguardando pagamento.";
      $Param['cod_barras'] = $cod_barras;
      $lista[] = $Param;

      return $lista;
    }
    else {

      $Param['status'] = '02';
      $Param['msg'] = "Pagamento não efetuado, tente novamente.";
      $lista[] = $Param;

      return $lista;
    }
  }

  public function orderPix($id_usuario,$id_plano, $nome_usuario, $email_usuario, $documento_usuario, $tipo_pagamento, $payment_id, $valor, $parcelas)
  {

    MercadoPago\SDK::setAccessToken(TOKEN_MP_SANDBOX);
    // MercadoPago\SDK::setAccessToken(TOKEN_MP_PRODUCTION);

    $payment = new MercadoPago\Payment();


    $payment->transaction_amount = $valor;
    $payment->description = "Compra no app Re.passe";
    $payment->payment_method_id = $payment_id;
    $payment->notification_url = "https://mobile.repasse.app/apiv3/user/mp/notificacao";
    $payment->payer = array(
      "email" => $email_usuario,
      "first_name" => explode(" ", $nome_usuario)[0],
      "last_name" => explode(" ", $nome_usuario)[1],
      "identification" => array(
        "type" => "CPF",
        // "number" => $documento_usuario
      )
    );

    $payment->save();


    $id_order = $payment->id;
    $status_order = $payment->status;
    $qrcode = $payment->point_of_interaction->transaction_data->qr_code;
    $qrcode_64 = $payment->point_of_interaction->transaction_data->qr_code_base64;

    if ($id_order != "") {

      $pagamentos = new Pagamentos();

      $pagamentos->save(
        $id_usuario,
        $id_plano,
        $tipo_pagamento,
        $this->data,
        null,
        $qrcode,
        $valor,
        $parcelas,
        $id_order,
        $status_order,
        2
      );

      $Param['status'] = '01';
      $Param['msg'] = "Pagamento gerado com sucesso, aguardando pagamento.";
      $Param['qrcode'] = $qrcode;
      $Param['qrcode_64'] = $qrcode_64;
      $lista[] = $Param;

      return $lista;
    }
    else {

      $Param['status'] = '02';
      $Param['msg'] = "Pagamento não efetuado, tente novamente.";
      $lista[] = $Param;

      return $lista;
    }
  }

  public function notificacao()
  {
    
    $request = file_get_contents('php://input');
    $input = json_decode($request);

    // o caminho e nome do arquivo de log
    $logFile = 'log/webhook_log.txt';

    // Adicione a data e hora à mensagem
    $logMessage = date('Y-m-d H:i:s') . " - Notificação Recebida:\n$request\n";

    // Escreva a mensagem no arquivo de log (anexando ao conteúdo existente)
    file_put_contents($logFile, $logMessage, FILE_APPEND);

    $this->token = $input->data->id;
    // $this->token = "1317696883";

    // MercadoPago\SDK::setAccessToken(TOKEN_MP_PRODUCTION);
    MercadoPago\SDK::setAccessToken(TOKEN_MP_SANDBOX);

    $payment = MercadoPago\Payment::find_by_id($this->token);
    $status = $payment->status;
    // $status = "rejected";

    $sql = $this->mysqli->prepare("UPDATE `app_pagamentos` SET status = ? WHERE token = ?");
    $sql->bind_param('ss', $status, $this->token);
    $sql->execute();
    $sql->close();

    //SALVANDO NOTIFICAÇÂO
    $notificacao = new Notificacoes();
    $dadosPagamento = $this->dadosPagamento($this->token);
    $status_f = $this->statusPayment($status);

    if($dadosPagamento['tipo'] == 1){
      if($status == "authorized"){
          $plano = $this->infoPlano($this->token);
          $this->trocaPlano($dadosPagamento['id_anuncio_plano'],$dadosPagamento['id_usuario']);
      }else if($status == "cancelled"){
        $this->cancelaPlano($dadosPagamento['id_usuario']);
      }
    }else{
      if($status == "approved"){
        $diasTurbinado = $this->findTurbinado();
        $anuncio = $this->infoAnuncio($this->token);
        $this->atualizaAnuncio($dadosPagamento['id_anuncio_plano'],$diasTurbinado);
      }
    }

    if (($dadosPagamento['tipo'] == 2) && $status == "approved") {
      $type = "turbinar-aprovado";
    }
    if (($dadosPagamento['tipo'] == 2) && (($status == "rejected")||($status == "cancelled")) ){
      $type = "turbinar-reprovado";
    }
    if(($dadosPagamento['tipo'] == 1) && $status == "cancelled"){
      $type = "pagamento-reprovado";
    }
    if( ($dadosPagamento['tipo'] == 1) && $status == "authorized"){
      $type = "pagamento-aprovado";
    }

    $notificacao->save($type, $dadosPagamento['id_usuario'], $anuncio['nome'],$plano);
    
    echo "HTTP STATUS 200 (OK)";
  }
  public function atualizaAnuncio($id,$duracao)
  {
    $validade_turbinado  = date('Y-m-d H:i:s', strtotime("+{$duracao} days")); 
    $status_turbinado=1;
    $sql_status = $this->mysqli->prepare("UPDATE `app_anuncios` SET turbinado = ?,validade_turbinado=? WHERE id = ?");
    $sql_status->bind_param('isi', $status_turbinado,$validade_turbinado, $id);
    $sql_status->execute();
    $sql_status->close();
  }
  public function findTurbinado()
  {

    $sql = $this->mysqli->prepare("
    SELECT dias_turbinado
    FROM `app_config`");
    $sql->execute();
    $sql->bind_result($resultado);
    $sql->fetch();
    return $resultado;
  }
  public function dadosAssinatura($id_user)
  {

    $sql = $this->mysqli->prepare("
    SELECT token
    FROM `app_pagamentos`
    WHERE id_usuario='$id_user' AND tipo='1'
    ORDER BY id DESC");
    $sql->execute();
    $sql->bind_result($token);
    $sql->store_result();
    $rows = $sql->num_rows;
    $lista = [];
    if ($rows == 0) {
        $lista['rows'] = $rows;
    } else {
        while ($row = $sql->fetch()) {
            $item['token'] =$token;
            array_push($lista,$item);
        }
    }
    return $lista[0];
  }
  public function dadosPagamento($token)
  {

    $sql = $this->mysqli->prepare("
    SELECT id_usuario,id_anuncio_plano,tipo
    FROM `app_pagamentos`
    WHERE token='$token'
    ORDER BY id DESC");
    $sql->execute();
    $sql->bind_result($id_usuario,$id_anuncio_plano,$tipo);
    $sql->store_result();
    $rows = $sql->num_rows;
    $lista = [];
    if ($rows == 0) {
        $lista['rows'] = $rows;
    } else {
        while ($row = $sql->fetch()) {
            $item['id_usuario'] =$id_usuario;
            $item['id_anuncio_plano'] =$id_anuncio_plano;
            $item['tipo'] =$tipo;
            array_push($lista,$item);
        }
    }
    return $lista[0];
  }
  public function infoPlano($token)
  {
      $sql = $this->mysqli->prepare(
          "
          SELECT a.nome,a.validade_dias
          FROM `app_planos` AS a
          INNER JOIN `app_pagamentos` AS b ON a.id = b.id_anuncio_plano
          WHERE b.token = '$token'
      "
      );
      $sql->execute();
      $sql->bind_result($this->nome_plano,$this->dias);
      $sql->store_result();
      $rows = $sql->num_rows;
      $usuarios = [];
      if ($rows == 0) {
          $usuarios['rows'] = $rows;
      } else {
          while ($row = $sql->fetch()) {
            $data_validade  = date('Y-m-d H:i:s', strtotime("+{$this->dias} days"));
              $item['nome'] =$this->nome_plano;
              $item['validade'] =dataHoraBR($data_validade);
              array_push($usuarios,$item);
          }
      }
      // print_r($usuarios[0]);exit;
      return $usuarios[0];
  }
  public function infoAnuncio($token)
  {
      $sql = $this->mysqli->prepare(
          "
          SELECT a.nome
          FROM `app_anuncios` AS a
          INNER JOIN `app_pagamentos` AS b ON a.id = b.id_anuncio_plano
          WHERE b.token = '$token'
      "
      );
      $sql->execute();
      $sql->bind_result($nome);
      $sql->store_result();
      $rows = $sql->num_rows;
      $usuarios = [];
      if ($rows == 0) {
          $usuarios['rows'] = $rows;
      } else {
          while ($row = $sql->fetch()) {
              $item['nome'] =$nome;
              array_push($usuarios,$item);
          }
      }
      // print_r($usuarios[0]);exit;
      return $usuarios[0];
  }
  public function trocaPlano($id_plano,$id_usuario)
  {
    //pego o id do plano ,descubro a duração e descubro a nova data de validade
    $sql = $this->mysqli->prepare("SELECT validade_dias FROM `app_planos` WHERE id!=1 AND id='$id_plano' ORDER BY id ASC");
    $sql->execute();
    $sql->bind_result($this->dias);
    $sql->fetch();
    $sql->close();
    $data_validade  = date('Y-m-d H:i:s', strtotime("+{$this->dias} days"));

    //Mudando plano do user
    $sql_status = $this->mysqli->prepare("UPDATE `app_users_planos` SET app_planos_id = ?,data_cadastro = ?,data_validade=? WHERE app_users_id = ?");
    $sql_status->bind_param('issi', $id_plano,$this->data,$data_validade, $id_usuario);
    $sql_status->execute();
    $sql_status->close();
  }
  public function cancelaPlano($id_usuario)
  {
    $id_plano=1;
    //Mudando plano do user
    $sql_status = $this->mysqli->prepare("UPDATE `app_users_planos` SET app_planos_id = ?,data_cadastro = ? WHERE app_users_id = ?");
    $sql_status->bind_param('isi', $id_plano,$this->data, $id_usuario);
    $sql_status->execute();
    $sql_status->close();
  }

  public function statusPayment($status)
  {

    switch ($status) {
      case 'pending':
        $v = "Pendente";
        break;
      case 'approved':
        $v = "Aprovado";
        break;
      case 'rejected':
        $v = "Rejeitado";
        break;
      case 'Cancelled':
        $v = "Cancelado";
        break;
      case 'Refunded':
        $v = "Devolvido";
        break;
    }

    return $v;
  }

  public function buscaMpIdCliente($id_user)
  {
      $sql = $this->mysqli->prepare(
          "
          SELECT id_mp
          FROM `app_users` 
          WHERE id = '$id_user'
      "
      );
      $sql->execute();
      $sql->bind_result($id_mp);
      $sql->store_result();
      $rows = $sql->num_rows;
        while ($row = $sql->fetch()) {
        }

      // print_r($usuarios[0]);exit;
      return $id_mp;
  }
}
