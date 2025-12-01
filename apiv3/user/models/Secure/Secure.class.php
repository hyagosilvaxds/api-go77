<?php


class Secure {

  public function tokens_secure($token) {

    // COD_API original de produção (corresponde ao token "Qd721n2E" usado pelo app Flutter)
    $cod_api_app = '$1$IYO8W82K$N.9AjuHhWF2S10kaE9kZn0';
    
    // Aceita o token se corresponder ao COD_API atual OU ao do app
    if (crypt($token, COD_API) === COD_API || crypt($token, $cod_api_app) === $cod_api_app) {
      // Token válido
    }else{
      $Param['msg'] = 'falha na autenticação 401';
      $Param['status'] = '03';

      $lista[] = $Param;

      $json = json_encode($lista);
      echo $json;

      exit;
    }

  }


}
