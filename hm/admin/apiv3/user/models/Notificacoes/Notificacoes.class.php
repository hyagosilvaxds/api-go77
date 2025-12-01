<?php

require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Notificacoes/Modelos.class.php';
require_once MODELS . '/Gcm/Gcm.class.php';

class Notificacoes extends Conexao
{


  public function __construct()
  {

    $this->Conecta();
    $this->tabela = "app_notificacoes";
    $this->data = date('Y-m-d H:i:s');
  }

  public function save($type, $id, $param){

      $this->modelos = New Modelos();
      $result = $this->modelos->montaModelos($type, $param);

      $titulo = $result['titulo'];
      $descricao = $result['descricao'];


      $sql = $this->mysqli->prepare("INSERT INTO app_notificacoes
      (id_user, titulo, descricao, data)
      VALUES ('$id', '$titulo', '$descricao', '$this->data')");
      $sql->execute();

      //DISPARANDO NOTIFICAÇÂO
      $gcm =  new Gcm();
      switch ($type) {

        case 'create-product':
          $gcm->produtoAdd_Android($id, $titulo, $descricao);
          $gcm->produtoAdd_IOS($id, $titulo, $descricao);
        break;


      }
  }

  public function notificacaoUser($titulo, $descricao,$id){


    $sql = $this->mysqli->prepare("INSERT INTO app_notificacoes
    (app_users_id, titulo, descricao, data)
    VALUES ('$id', '$titulo', '$descricao', '$this->data')");
    $sql->execute();

    //DISPARANDO NOTIFICAÇÂO
    $gcm =  new Gcm();

    $gcm->notificacao_android_user($titulo, $descricao,$id);
    $gcm->notificacao_ios_user($titulo, $descricao,$id);
    }


    public function aprovouCadastro($type, $id){
      // print_r("chegou aqui");exit;
      $this->modelos = New Modelos();
      $result = $this->modelos->montaModelos($type);

      $titulo = $result['titulo'];
      $descricao = $result['descricao'];

      // print_r($descricao);exit;
      $sql = $this->mysqli->prepare("INSERT INTO app_notificacoes
      (app_users_id, titulo, descricao, data)
      VALUES ('$id', '$titulo', '$descricao', '$this->data_atual')");
      $sql->execute();
      // print_r($type);exit;
      //DISPARANDO NOTIFICAÇÂO
      $gcm =  new Gcm();
      switch ($type) {

      case 'aprovou-cadastro':
        $gcm->aprovouAdd_Android($id, $titulo, $descricao);
        $gcm->aprovouAdd_IOS($id, $titulo, $descricao);
      break;


    }
}

    public function aprovouCompraRecibo($type, $id){
      // print_r("chegou aqui");exit;
      $this->modelos = New Modelos();
      $result = $this->modelos->aprovouCompra($type);

      $titulo = $result['titulo'];
      $descricao = $result['descricao'];

      // print_r($descricao);exit;
      $sql = $this->mysqli->prepare("INSERT INTO app_notificacoes
      (app_users_id, titulo, descricao, data)
      VALUES ('$id', '$titulo', '$descricao', '$this->data_atual')");
      $sql->execute();
      // print_r($type);exit;
      //DISPARANDO NOTIFICAÇÂO
      $gcm =  new Gcm();
      switch ($type) {

      case 'aprovou-compra':
        $gcm->aprovouCompra_Android($id, $titulo, $descricao);
        $gcm->aprovouCompra_IOS($id, $titulo, $descricao);
      break;


    }
}

    public function remove($param)
    {

        $sql = $this->mysqli->prepare("DELETE FROM `app_notificacoes` WHERE id = ?");
        $sql->bind_param('i', $param);
        $sql->execute();

        $linhas_afetadas = $sql->affected_rows;

        if ($linhas_afetadas > 0) {
            $param = [
                "status" => "01",
                "msg" => "Notificação deletada"
            ];
        } else {
            $param = [
                "status" => "02",
                "msg" => "Falha ao deletar"
            ];
        }

        return $param;
    }

    public function saveNotificacoes($titulo,$descricao)
    {

        $sql = $this->mysqli->prepare("INSERT INTO app_notificacoes (app_users_id,titulo,descricao,data) VALUES
        ('0','$titulo','$descricao', '$this->data')");

        $sql->execute();

        $Param = [
          "status" => "01",
          "msg" => "Notificação salva!"
      ];

      return $Param;
    }

    public function gerarCSV() {
      // Abrir o arquivo de log (criar se não existir)
      $arquivo = fopen("uploads/planilhas/exportarNotifica.csv", "w");

      $sql = $this->mysqli->prepare("
      SELECT id, titulo, descricao, data FROM app_notificacoes WHERE app_users_id='0'");

      $sql->execute();
      $sql->bind_result($id, $titulo, $descricao, $data);
      $sql->store_result();
      $rows = $sql->num_rows;

      $usuarios = [];

      if ($rows == 0) {
          $Param['rows'] = $rows;
          array_push($usuarios, $Param);
      } else {
          while ($row = $sql->fetch()) {


              $Param['id'] = $id;
              $Param['titulo'] = $titulo;
              $Param['descricao'] = $descricao;
              $Param['data'] = dataBR($data);

              array_push($usuarios, $Param);
          }
      }

      $cabecalho = ['id', 'titulo', 'descricao', 'data'];

      fputcsv($arquivo, $cabecalho, ';');

      // Escrever o conteúdo no arquivo
      foreach($usuarios as $row_usuario){
          fputcsv($arquivo, $row_usuario, ';');
      }
      // Fechar arquivo
      fclose($arquivo);

  }

    public function listAll()
    {

        $sql = $this->mysqli->prepare("SELECT id, titulo, descricao, data FROM app_notificacoes WHERE app_users_id='0' ORDER BY data DESC");

        $sql->execute();
        $sql->bind_result($id, $titulo, $descricao, $data);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['titulo'] = $titulo;
                $Param['descricao'] = $descricao;
                $Param['data'] = dataBR($data);

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

  public function aprovouDoc($type, $id){

      $this->modelos = New Modelos();
      $result = $this->modelos->aprovouDoc($type);

      $titulo = $result['titulo'];
      $descricao = $result['descricao'];

    // print_r($descricao);exit;
      $sql = $this->mysqli->prepare("INSERT INTO app_notificacoes
      (id_user, titulo, descricao, data)
      VALUES ('$id', '$titulo', '$descricao', '$this->data')");
      $sql->execute();

      //DISPARANDO NOTIFICAÇÂO
      $gcm =  new Gcm();
      switch ($type) {

        case 'aprovou-doc':
          $gcm->aprovouDoc_Android($id, $titulo, $descricao);
          $gcm->aprovouDoc_IOS($id, $titulo, $descricao);
        break;


      }
  }
  public function reprovouDoc($type, $id){

      $this->modelos = New Modelos();
      $result = $this->modelos->reprovouDoc($type);

      $titulo = $result['titulo'];
      $descricao = $result['descricao'];

    // print_r($descricao);exit;
      $sql = $this->mysqli->prepare("INSERT INTO app_notificacoes
      (id_user, titulo, descricao, data)
      VALUES ('$id', '$titulo', '$descricao', '$this->data')");
      $sql->execute();

      //DISPARANDO NOTIFICAÇÂO
      $gcm =  new Gcm();
      switch ($type) {

        case 'aprovou-doc':
          $gcm->reprovouDoc_Android($id, $titulo, $descricao);
          $gcm->reprovouDoc_IOS($id, $titulo, $descricao);
        break;


      }
  }


}
