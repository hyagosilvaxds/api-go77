<?php

require_once MODELS . '/Conexao/Conexao.class.php';

class Gcm extends Conexao
{


  public function __construct()
  {

    $this->Conecta();
    $this->tabela = "app_servicos";
    $this->tabela_gcm = "app_fcm";
    $this->id_projeto = "82054626274";
  }



public function notificacao_android_user($titulo, $descricao, $id_user = null, $id_de = null, $isIOS = false )
{
    // Verifica se o id_user foi passado
    if (!empty($id_user)) {
        // Query para selecionar o registration_id de um usuário específico
        $query_push = "
            SELECT registration_id
            FROM `$this->tabela_gcm`
            WHERE app_users_id = '$id_user' AND type = 1
        ";
    } else {
        // Monta o filtro dinâmico se o id_user não for passado
        $filter = "WHERE fcm.type = 1";

        // Query para selecionar os registration_ids com base no filtro
        $query_push = "
            SELECT fcm.registration_id
            FROM `$this->tabela_gcm` AS fcm
            JOIN `app_users` AS u ON fcm.app_users_id = u.id
            $filter
        ";
    }

    $sql_push = $this->mysqli->query($query_push);

    $data = array();
    while ($res = $sql_push->fetch_object()) {
        $data[] = $res->registration_id;
    }
    $registrationIDs = array_values($data);


    // Novo endpoint para a API HTTP v1
    $url = 'https://fcm.googleapis.com/v1/projects/'.$this->id_projeto.'/messages:send';

    // Gerar token de acesso OAuth 2.0
    $accessToken = $this->getAccessToken();

    // Verifica se há registration IDs
    if (sizeof($registrationIDs) > 0) {
        // Monta o payload da mensagem
        $fields = array(
            'registration_ids' => $registrationIDs,
            'data' => array(
                "titulo" => $titulo,
                "descricao" => $descricao,
                'type'  =>  'notification',
                'id_de' => $id_de, // Incluindo o id_de aqui
            ),
        );

        if (sizeof($registrationIDs) > 1000) {
            $newId = array_chunk($registrationIDs, 1000);
            foreach ($newId as $inner_id) {
                $this->sendNotification($url, $inner_id,$titulo, $descricao, $accessToken, $isIOS, $id_de);
            }
        } else {
            $this->sendNotification($url, $registrationIDs, $titulo, $descricao, $accessToken, $isIOS, $id_de);
        }
    } else {
        // Tratar caso não haja registration IDs
        // Por exemplo: você pode logar um aviso ou lançar uma exceção
        error_log('Nenhum registration ID encontrado para os parâmetros fornecidos.');
    }
}


public function notificacao_ios_user($titulo, $descricao, $id_user = null, $id_de = null, $isIOS = true)
{
    // Verifica se o id_user foi passado
    if (!empty($id_user)) {
        // Query para selecionar o registration_id de um usuário específico
        $query_push = "
            SELECT registration_id
            FROM `$this->tabela_gcm`
            WHERE app_users_id = '$id_user' AND type = 2
        ";
    } else {
        // Query para selecionar todos os registration_ids do tipo iOS
        $query_push = "
            SELECT registration_id
            FROM `$this->tabela_gcm`
            WHERE type = 2
        ";
    }

    $sql_push = $this->mysqli->query($query_push);

    $data = array();
    while ($res = $sql_push->fetch_object()) {
        $data[] = $res->registration_id;
    }
    $registrationIDs = array_values($data);

    // Novo endpoint para a API HTTP v1
    $url = 'https://fcm.googleapis.com/v1/projects/'.$this->id_projeto.'/messages:send';

    // Gerar token de acesso OAuth 2.0
    $accessToken = $this->getAccessToken();

    // Verifica se há registration IDs
    if (sizeof($registrationIDs) > 0) {
        // Monta o payload da mensagem
        $fields = array(
            'registration_ids' => $registrationIDs,
            'data' => array(
                "titulo" => $titulo,
                "descricao" => $descricao,
                'type'  =>  'notification',
                'id_de' => $id_de, // Incluindo o id_de aqui
            ),
        );

        if (sizeof($registrationIDs) > 1000) {
            $newId = array_chunk($registrationIDs, 1000);
            foreach ($newId as $inner_id) {
                $this->sendNotification($url, $inner_id, $titulo, $descricao, $accessToken, $isIOS, $id_de);
            }
        } else {
            $this->sendNotification($url, $registrationIDs, $titulo, $descricao, $accessToken, $isIOS, $id_de);
        }
    } else {
        // Tratar caso não haja registration IDs
        error_log('Nenhum registration ID encontrado para os parâmetros fornecidos.');
    }
}









public function notificacao_android($titulo, $descricao, $isIOS = false)
{
  // SELECIONA GCM de quem tenha consulta com data_de igual a data de hoje
  $query_push = "SELECT registration_id FROM `$this->tabela_gcm` WHERE type=1";
  $sql_push = $this->mysqli->query($query_push);

  $data = array();
  while ($res = $sql_push->fetch_object()) {
      $data[] = $res->registration_id;
  }

  $registrationIDs = array_values($data);

  // Novo endpoint para a API HTTP v1
  $url = 'https://fcm.googleapis.com/v1/projects/'.$this->id_projeto.'/messages:send';

  // Gerar token de acesso OAuth 2.0
  $accessToken = $this->getAccessToken();

  if (sizeof($registrationIDs) > 1000) {
      $newId = array_chunk($registrationIDs, 1000);
      foreach ($newId as $inner_id) {
          $this->sendNotification($url, $inner_id, $titulo, $descricao, $accessToken, $isIOS, $id_de);
      }
  } else {
      $this->sendNotification($url, $registrationIDs, $titulo, $descricao, $accessToken, $isIOS, $id_de);
  }
}
public function notificacao_ios($titulo, $descricao, $isIOS = true)
{
  // SELECIONA GCM de quem tenha consulta com data_de igual a data de hoje
  $query_push = "SELECT registration_id FROM `$this->tabela_gcm` WHERE type=2";
  $sql_push = $this->mysqli->query($query_push);

  $data = array();
  while ($res = $sql_push->fetch_object()) {
      $data[] = $res->registration_id;
  }

  $registrationIDs = array_values($data);

  // Novo endpoint para a API HTTP v1
  $url = 'https://fcm.googleapis.com/v1/projects/'.$this->id_projeto.'/messages:send';

  // Gerar token de acesso OAuth 2.0
  $accessToken = $this->getAccessToken();

  if (sizeof($registrationIDs) > 1000) {
      $newId = array_chunk($registrationIDs, 1000);
      foreach ($newId as $inner_id) {
          $this->sendNotification($url, $inner_id, $titulo, $descricao, $accessToken, $isIOS, $id_de);
      }
  } else {

      $this->sendNotification($url, $registrationIDs, $titulo, $descricao, $accessToken, $isIOS, $id_de);
  }
}
private function getAccessToken()
{
  // Caminho para o arquivo JSON de credenciais
  $serviceAccountFile = 'firebase_key.json';

  // Carregar e decodificar o arquivo JSON de credenciais
  $jsonKey = json_decode(file_get_contents($serviceAccountFile), true);

  // Verificar se o JSON foi carregado corretamente
  if (!$jsonKey) {
      die('Erro ao carregar o arquivo JSON de credenciais.');
  }

  // Extrair as informações necessárias do JSON
  $privateKey = $jsonKey['private_key'];
  $clientEmail = $jsonKey['client_email'];
  $tokenUri = $jsonKey['token_uri'];

  // Definir o escopo necessário
  $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];

  // Criar a carga JWT (claims)
  $now = time();
  $jwtHeader = base64_encode(json_encode([
      'alg' => 'RS256',
      'typ' => 'JWT'
  ]));
  $jwtClaim = base64_encode(json_encode([
      'iss' => $clientEmail,
      'scope' => implode(' ', $scopes),
      'aud' => $tokenUri,
      'exp' => $now + 3600,
      'iat' => $now
  ]));

  // Criar a string de assinatura
  $data = $jwtHeader . '.' . $jwtClaim;
  $signature = '';
  openssl_sign($data, $signature, $privateKey, 'sha256');
  $jwtSignature = base64_encode($signature);

  // Montar o token JWT completo
  $jwt = $jwtHeader . '.' . $jwtClaim . '.' . $jwtSignature;

  // Solicitação de token de acesso usando cURL
  $postFields = [
      'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
      'assertion' => $jwt
  ];

  $ch = curl_init($tokenUri);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));

  $response = curl_exec($ch);

  // Verifica se a solicitação foi bem-sucedida
  if ($response === false) {
      die('Erro na solicitação cURL: ' . curl_error($ch));
  }

  $data = json_decode($response, true);


  // Verifica se o token de acesso está presente na resposta
  if (isset($data['access_token'])) {
      $accessToken = $data['access_token'];

      // Armazenar o token em cache para futuras solicitações
      $cacheFile = 'access_token_cache.json';
      file_put_contents($cacheFile, json_encode(['access_token' => $accessToken]));

      return $accessToken;
  } else {
      die('Erro ao obter o token de acesso: ' . $response);
  }

  // Fechar a conexão cURL
  curl_close($ch);
}
private function sendNotification($url, $registrationIDs, $titulo, $descricao, $accessToken, $isIOS, $id_de)
{
    foreach ($registrationIDs as $registrationID) {
        $message = array(
            'message' => array(
                'token' => $registrationID,
                'notification' => array(
                    'title' => $titulo,
                    'body' => $descricao
                    // Removido 'id_de' da seção notification
                ),
                'data' => array(
                    'id_de' => $id_de // Mantido apenas na seção data
                ),
            )
        );

        if ($isIOS) {
            $message['message']['apns'] = array(
                'headers' => array(
                    'apns-priority' => '10',
                ),
                'payload' => array(
                    'aps' => array(
                        'alert' => array(
                            'title' => $titulo,
                            'body' => $descricao
                        ),
                        'badge' => 1,
                        'sound' => 'default'
                    ),
                    // Enviando id_de aqui também para iOS
                    'id_de' => $id_de // Esse 'id_de' está na seção de payload do apns e não deve causar erro
                )
            );
        } else {
            $message['message']['android'] = array(
                'priority' => 'high'
                // Removido 'id_de' da seção android
            );
        }

        $headers = array(
            "Authorization: Bearer $accessToken",
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));

        // Execute post
        $result = curl_exec($ch);

        //print_r($result);exit;

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Log de resposta (pode ser removido em produção)
        // print_r($result);

        // Close connection
        curl_close($ch);
    }
}








}
