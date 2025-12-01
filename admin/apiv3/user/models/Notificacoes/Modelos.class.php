<?php

class Modelos
{


  public function montaModelos($type)
  {
    // print_r("chegou no modelos");exit;
    switch ($type) {

      case 'aprovou-cadastro':
        $Param = ["titulo" => "Cadastro Aprovado!",  "descricao" => "Cadastro aprovado com sucesso, acesse o aplicativo agora mesmo."];
        break;
    }
    // print_r($Param);exit;
    return $Param;
  }
  public function aprovouCompra($type){


    switch ($type) {

      case 'aprovou-compra':
        $Param = ["titulo" => "Recibo aprovado!",  "descricao" => "O valor já se encontra para consulta em seu aplicativo!"];
      break;

    }

    return $Param;

  }
  public function aprovouDoc($type){


    switch ($type) {

      case 'aprovou-doc':
        $Param = ["titulo" => "Documento aprovado!",  "descricao" => "Seu documento enviado para análise foi aprovado!"];
      break;

    }

    return $Param;

  }
  public function reprovouDoc($type){


    switch ($type) {

      case 'aprovou-doc':
        $Param = ["titulo" => "Documento reprovado!",  "descricao" => "Seu documento enviado para análise foi reprovado!"];
      break;

    }

    return $Param;

  }


}
