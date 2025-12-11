<?php

class Modelos
{


  public function montaModelos($type, $param)
  {
    // print_r("chegou no modelos");exit;
    switch ($type) {

      case 'reserva-iniciada-anfitriao':
        $Param = ["titulo" => "Nova Reserva",  "descricao" => "Você recebeu uma nova reserva no imóvel: " . $param];
      break;

      case 'reserva-cortesia-anfitriao':
        $Param = ["titulo" => "Nova Reserva Cortesia",  "descricao" => "Você recebeu uma nova reserva cortesia (gratuita) no anúncio: " . $param];
      break;

      case 'reserva-cancelada-hospede':
        $Param = ["titulo" => "Reserva Cancelada",  "descricao" => "A reserva no imóvel: " . $param . " acabou de ser cancelada."];
      break;

      case 'reserva-cancelada-anfitrao':
        $Param = ["titulo" => "Reserva Cancelada",  "descricao" => "A reserva no seu imóvel: " . $param . " foi cancelada pelo usuário."];
      break;

      case 'pagamento-confirmado-hospede':
        $Param = ["titulo" => "Pagamento Confirmado",  "descricao" => "Pagamento confirmado da sua reserva no imóvel: " . $param];
      break;

      case 'pagamento-confirmado-anfitrao':
        $Param = ["titulo" => "Reserva Cancelada",  "descricao" => "Pagamento confirmado para a reserva no seu imóvel: " . $param];
      break;

      case 'pagamento-cancelado-hospede':
        $Param = ["titulo" => "Pagamento Cancelado",  "descricao" => "Pagamento com estorno iniciado da sua reserva no imóvel: " . $param];
      break;

      case 'pagamento-cancelado-anfitrao':
        $Param = ["titulo" => "Pagamento Cancelado",  "descricao" => "Pagamento com estorno iniciado para a reserva no seu imóvel: " . $param];
      break;

      case 'lembrete-reserva-anfitriao':
        $Param = ["titulo" => "Lembrete de reserva",  "descricao" => $param];
      break;

      case 'pagamento-comissao':
        $Param = ["titulo" => "Pagamento de comissão",  "descricao" => "Você recebeu uma comissão no valor de: " . $param];
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
