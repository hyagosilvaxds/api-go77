<?php


class Secure {

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


}
