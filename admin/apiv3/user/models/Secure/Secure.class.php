<?php

require_once MODELS . '/Conexao/Conexao.class.php';
class Secure extends Conexao {

  public function __construct()
  {
      $this->tabela = "app_users";
      $this->data_atual = date('Y-m-d H:i:s');
      $this->Conecta();
  }
    public function tokens_secure($token) {
  
      // print_r(crypt($token, COD_API));exit;

      if (crypt($token, COD_API) === COD_API) {

      }else{
        $Param['msg'] = 'falha na autenticação 401';
        $Param['status'] = '03';

        $lista[] = $Param;

        $json = json_encode($lista);
        echo $json;

        exit;
      }

    }
    
    public function validatemenu($id_menu, $id_grupo) {
      // Se o id_grupo for igual a 1, retorna true imediatamente
      if ($id_grupo == 1) {
          return true;
      }
  
      $arraymenus = $this->listMenusPermitidos($id_grupo);
      // Inicializa uma flag para verificar se $id_menu foi encontrado
      $encontrado = false;
  
      // Itera sobre os subarrays para verificar se $id_menu está presente
      foreach ($arraymenus as $subarray) {
          if (isset($subarray['id_menu']) && $subarray['id_menu'] == $id_menu) {
              // Se encontrado, define a flag como true e sai do loop
              $encontrado = true;
              break;
          }
      }
  
      // Verifica a flag para imprimir a mensagem adequada
      if ($encontrado) {
          // Se encontrado, retorna true
          return true;
      } else {
          $Param['msg'] = 'Não tem permissão para acessar esse menu.';
          $Param['status'] = '04';
  
          $lista[] = $Param;
  
          $json = json_encode($lista);
          echo $json;
  
          exit;
      }
  }
  

  public function listMenusPermitidos($id_grupo)
    {
      // print_r($id_grupo);exit;
        $sql = $this->mysqli->prepare("SELECT id_menu FROM `app_users_grupos_permissoes` WHERE id_grupo = '$id_grupo'");
        $sql->execute();
        $sql->bind_result($id_menu);
        $sql->store_result();
        $rows = $sql->num_rows;
       

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id_menu'] = $id_menu;
                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }


}
