<?php
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Notificacoes/Notificacoes.class.php';

class Chat extends Conexao
{


    public function __construct()
    {
        $this->Conecta();
        $this->data_atual = date('Y-m-d H:i:s');
    }

    public function listChat($id)
    {

        $sql = $this->mysqli->prepare("
        SELECT app_chat.id, app_chat.id_de, app_chat.id_para, app_chat.tipo, app_chat.url, app_chat.mensagem, app_chat.data, app_chat.lida
        FROM app_chat JOIN (
          SELECT
            (case when id_para='$id' then id_de
              when id_de='$id' then id_para
             end) user
            , MAX(id) m
          FROM app_chat
          WHERE (id_para='$id' or id_de='$id') AND deleteby='2'
          GROUP BY user
      ) t1 ON id = m
      ORDER BY id DESC
        ");

        $sql->execute();
        $sql->bind_result($this->id_chat, $this->id_de, $this->id_para, $this->tipo, $this->url, $this->mensagem, $this->data, $this->lida);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                if(trim($this->id_de) != trim($id)){

                  $info_user = $this->listChatUser($this->id_de);
                  $this->dif = calculaDias($this->data_atual, $this->data);
                  $n_lidas = $this->listMsgNLidas($this->id_para, $this->id_de);

                  $Param['id'] = $this->id_chat;
                  $Param['id_de'] = $this->id_de;
                  $Param['id_para'] = $this->id_para;
                  $Param['tipo'] = $this->tipo;
                  $Param['url'] = $this->url;
                  $Param['mensagem'] = $this->typeMessageChat($this->tipo, $this->mensagem);
                  $Param['data'] = $this->dif;
                  $Param['lida'] = $this->lida;
                  $Param['n_lidas'] = $n_lidas;
                  $Param['nome'] = $info_user[0]['nome']?? "";
                  $Param['url_avatar'] = $info_user[0]['url_avatar'] ?? "";
                  
                  $Param['rows'] = $rows;

                  array_push($usuarios, $Param);

                }

                elseif(trim($this->id_para) != trim($id)){

                  $info_user = $this->listChatUser($this->id_para);
                  $this->dif = calculaDias($this->data_atual, $this->data);
                  $n_lidas = $this->listMsgNLidas($this->id_de, $this->id_para);

                  $Param['id'] = $this->id_chat;
                  $Param['id_de'] = $this->id_de;
                  $Param['id_para'] = $this->id_para;
                  $Param['tipo'] = $this->tipo;
                  $Param['url'] = $this->url;
                  $Param['mensagem'] = $this->typeMessageChat($this->tipo, $this->mensagem);
                  $Param['data'] = $this->dif;
                  $Param['lida'] = $this->lida;
                  $Param['n_lidas'] = $n_lidas;
                  $Param['nome'] = $info_user[0]['nome']?? "";
                  $Param['url_avatar'] = $info_user[0]['url_avatar']?? "";
                  $Param['rows'] = $rows;

                  array_push($usuarios, $Param);

                }


            }
        }

        $arr_final = unique_multidimensional_array($usuarios, $key = 'nome');
        return $arr_final;
    }

    public function listChatUser($id){

      $sql = $this->mysqli->prepare("SELECT nome , avatar  FROM app_users WHERE id='$id'");
      $sql->execute();
      $sql->bind_result($nome,$avatar);
      $sql->store_result();
      $sql->fetch();

      $usuarios = [];

      $Param['nome'] = decryptitem($nome);
      $Param['url_avatar'] = $avatar;

      array_push($usuarios, $Param);

      return $usuarios;

    }

      public function listMsgNLidas($id, $id_user){


        $sql = $this->mysqli->prepare("SELECT id_de, id_para FROM app_chat WHERE (id_de='$id' AND id_para='$id_user') OR (id_de='$id_user' AND id_para='$id') AND lida='2'");
        $sql->execute();
        $sql->bind_result($id_de, $id_para);
        $sql->store_result();
  
        $usuarios = [];
  
          while ($row = $sql->fetch()) {
  
            $i=0;
  
            if($id_de != $id){
  
              $i++;
  
              $Param['lida'] = $i;
  
              array_push($usuarios, $Param);
  
            }
  
          }
  
         $total = array_sum (array_column($usuarios, 'lida') );
  
         if($total == 0){
            return 0;
          }else{
            return $total;
          }
  
      }
      public function typeMessageChat($tipo, $mensagem){


        switch ($tipo) {
          case 1:
            $m = $mensagem;
            break;
          case 2:
            $m = "Imagem";
            break;
          case 3:
            $m = "Áudio";
          break;
          case 4:
            $m = "Documento";
          break;

        }
  
        return $m;
  
      }

      public function listInteressadoId($id_anuncio,$user_id)
      {

          $sql = $this->mysqli->prepare(
            "
            SELECT id_usuario
            FROM `app_anuncios` 
            WHERE id = '$id_anuncio'
        "
          );
          $sql->execute();
          $sql->bind_result($id_dono);
          $sql->store_result();
          $sql->fetch();
  
          $sql = $this->mysqli->prepare(
              "
              SELECT COUNT(*)
              FROM `app_anuncios_entregas`
              WHERE app_anuncios_id = '$id_anuncio' AND id_usuario='$user_id'
          "
          );
  
          $sql->execute();
          $sql->bind_result($contagem);
          $sql->store_result();
          $sql->fetch();
          $rows = $sql->num_rows;
          if($id_dono == $user_id){
            return 1;
          }else{
            return $contagem;
          }
      }
      public function updateChat($id_de,$id_para)
      {
  
          $sql_cadastro = $this->mysqli->prepare("UPDATE `app_chat` SET lida='1' WHERE id_de='$id_para' AND id_para='$id_de'");
          $sql_cadastro->execute();
  
          $Param = [
              "status" => "01",
              "msg" => "lida com sucesso"
          ];
  
          return $Param;
      }
      public function listChatID($id_de, $id_para)
      {
  
  
          $sql = $this->mysqli->prepare("
          SELECT a.id, a.id_de, a.id_para, a.tipo, a.url, a.mensagem, a.deleteby, a.data, a.lida, b.id, b.nome
          FROM app_chat as a
          INNER JOIN app_users as b ON a.id_de = b.id
          WHERE (a.id_para = '$id_para' and a.id_de = '$id_de') OR (a.id_para = '$id_de' and a.id_de = '$id_para')
          ORDER BY a.data DESC
  
          ");
          $sql->execute();
          $sql->bind_result($this->id, $this->id_de, $this->id_para, $this->tipo, $this->url, $this->mensagem, $this->deleteby, $this->data, $this->lida, $this->id_user, $this->nome);
          $sql->store_result();
          $rows = $sql->num_rows;
  
          $usuarios = [];
  
          if ($rows == 0) {
              $Param['rows'] = $rows;
              array_push($usuarios, $Param);
          } else {
              while ($row = $sql->fetch()) {
  
                  if($this->deleteby == 2):
  
                    $this->dif = calculaDias($this->data_atual, $this->data);
  
                    $Param['id'] = $this->id;
                    $Param['id_de'] = $this->id_de;
                    $Param['id_para'] = $this->id_para;
                    $Param['tipo'] = $this->tipo;
                    $Param['url'] = $this->url;
                    $Param['mensagem'] = $this->mensagem;
                    $Param['data_t'] = dataBR($this->data);
                    $Param['data'] = $this->dif;
                    $Param['horario'] = horarioBR($this->data);
                    $Param['lida'] = $this->lida;
                    $Param['nome'] = decryptitem($this->nome);
                    // $Param['url_avatar'] = $this->listAlbumCapa($this->id_user);
                    $Param['rows'] = $rows;
  
                    array_push($usuarios, $Param);
  
                  endif;
              }
          }
          return $usuarios;
      }
      public function updateMensagem($id, $mensagem)
      {
  
          $sql_cadastro = $this->mysqli->prepare("UPDATE `app_chat` SET mensagem='$mensagem' WHERE id='$id'");
          $sql_cadastro->execute();
  
          $Param = [
              "status" => "01",
              "msg" => "Mensagem atualizada com sucesso"
          ];
  
          return $Param;
      }
      public function deleteChat($id)
      {
  
          $sql_cadastro = $this->mysqli->prepare("UPDATE `app_chat` SET deleteby='1' WHERE id='$id'");
          $sql_cadastro->execute();
  
          $Param = [
              "status" => "01",
              "msg" => "Mensagem removida com sucesso."
          ];
  
          return $Param;
      }
 
      public function findLatLong($id_user){

        $sql = $this->mysqli->prepare("SELECT latitude , longitude  FROM app_users_location WHERE app_users_id='$id_user'");
        $sql->execute();
        $sql->bind_result($lat,$long);
        $sql->store_result();
        $sql->fetch();
  
        $usuarios = [];
  
        $Param['lat'] = $lat;
        $Param['long'] = $long;
  
        array_push($usuarios, $Param);
  
        return $usuarios[0];
  
      }
      public function saveChat($id_de, $id_para, $type, $url, $mensagem)
      {
  
          $sql = $this->mysqli->prepare(
              "
          INSERT INTO `app_chat`(`id_de`, `id_para`, `tipo`, `url`, `mensagem`, `deleteby`, `data`, `lida`)
              VALUES ('$id_de', '$id_para', '$type', '$url', '$mensagem', '2', '$this->data_atual', '2')"
  
          );
  
          $sql->execute();
          $this->id = $sql->insert_id;
  
          $Param = [
              "status" => "01",
              "msg" => "Mensagem enviada com sucesso.",
              "id" => $this->id
          ];
  
          return $Param;
      }

      public function mensagemNLida($id)
      {  
          $sql = $this->mysqli->prepare("
          SELECT id
          FROM app_chat 
          WHERE id_para = '$id' AND lida='2'
          ");
          $sql->execute();
          $sql->bind_result($id);
          $sql->store_result();
          $rows = $sql->num_rows;
          $usuarios = [];
  
          if ($rows == 0) {
              $Param['status'] = 2;
              array_push($usuarios, $Param);
          } else {
              while ($row = $sql->fetch()) {
                $Param['status'] = 1;
                    array_push($usuarios, $Param);
  
              }
          }
          return $usuarios;
      }
      public function verificaMsgPalavras($mensagem)
      {  
          $palavrasProibidas = array("compra","custo", "venda", "valor", "$", "preço");
      
          // Função de verificação que procura correspondências exatas
          function contemPalavraProibida($mensagem, $palavraProibida) {
              $palavras = explode(" ", $mensagem); // Divida a mensagem em palavras
              foreach ($palavras as $palavra) {
                  if (strcasecmp($palavra, $palavraProibida) === 0) {
                      return true; // Correspondência exata encontrada
                  }
              }
              return false;
          }
      
          $contemPalavraProibida = false;
      
          foreach ($palavrasProibidas as $palavra) {
            if (preg_match('/\d{6,}/', $mensagem)) {
              $contemPalavraProibida = true;
                break; // Se encontrar uma palavra proibida, pode parar a verificação.
              }
              if (contemPalavraProibida($mensagem, $palavra)) {
                  $contemPalavraProibida = true;
                  break; // Se encontrar uma palavra proibida, pode parar a verificação.
              }

          }
      
          $Param = array();
          
          if ($contemPalavraProibida) {
              // A mensagem contém uma palavra proibida.
              $Param['status'] = 2;
              $Param['mensagem'] = 'Esta mensagem viola as políticas do aplicativo';
          } else {
              // A mensagem é válida.
              $Param['status'] = 1;
              $Param['mensagem'] = 'Mensagem válida';
          }
          // print_r($Param);exit;
          return $Param;
      }
      public function verificaMsgContatos($mensagem)
      {  
          // Expressões regulares para verificar números de telefone e endereços de e-mail
          $regexTelefone = '/\b(?:\+\d{1,3}\s?)?\(?\d{2,3}\)?[-.\s]?\d{4,5}[-.\s]?\d{4}\b/';
          $regexTelefone2 = '/\b\d{4,5}[-]\d{4}\b/';
          $regexEmail = '/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}\b/';

          $Param = array();
          
          if (preg_match($regexTelefone, $mensagem) || preg_match($regexEmail, $mensagem) ||preg_match($regexTelefone2, $mensagem)) {
              // A mensagem contém um número de telefone ou endereço de e-mail.
              $Param['status'] = 2;
              $Param['mensagem'] = 'Esta mensagem viola as políticas do aplicativo';
          } else {
              // A mensagem é válida.
              $Param['status'] = 1;
              $Param['mensagem'] = 'Mensagem válida';
          }
          // print_r($Param);exit;
          return $Param;
      }

      
  
}
