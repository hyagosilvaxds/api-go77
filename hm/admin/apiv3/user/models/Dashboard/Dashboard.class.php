<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once MODELS . '/Estados/Estados.class.php';
require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Cadastros/Cadastros.class.php';
require_once MODELS . '/Anuncios/Anuncios.class.php';
require_once MODELS . '/Configuracoes/Configuracoes.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';

class Dashboard extends Conexao {


    public function __construct() {
        $this->Conecta();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->tabela = "app_planos_pagamentos";
    }

    public function listAllUsuariosAdmin()
    {

        $sql = $this->mysqli->prepare("
        SELECT id, id_grupo, nome, email, celular, status, status_aprovado
        FROM app_users");

        $sql->execute();
        $sql->bind_result($id_usuario, $id_grupo, $nome, $email, $celular, $status, $status_aprovado);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id_usuario'] = $id_usuario;
                $Param['id_grupo'] = $id_grupo;
                $Param['nome'] = decryptitem($nome);
                $Param['email'] = decryptitem($email);
                $Param['celular'] = decryptitem($celular);
                $Param['status'] = $status;
                $Param['status_aprovado'] = $status_aprovado;
                $Param['rows'] = $rows;
                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function cartoesDash()
    {
        $sql = $this->mysqli->prepare("
        SELECT COUNT(id)
        FROM app_users WHERE id_grupo='4'");
        $sql->execute();
        $sql->bind_result($usuarios_qtd);
        $sql->fetch();
        $sql->close();

        $sql = $this->mysqli->prepare("
        SELECT COUNT(id)
        FROM app_anuncios WHERE status_aprovado='1'");
        $sql->execute();
        $sql->bind_result($anuncios_ativos);
        $sql->fetch();
        $sql->close();

        $sql = $this->mysqli->prepare("
        SELECT COUNT(id)
        FROM app_anuncios WHERE status_aprovado='2'");
        $sql->execute();
        $sql->bind_result($anuncios_pendentes);
        $sql->fetch();
        $sql->close();

        $sql = $this->mysqli->prepare("
        SELECT COUNT(id)
        FROM app_reservas WHERE status='1'");
        $sql->execute();
        $sql->bind_result($qtd_reservas);
        $sql->fetch();
        $sql->close();

        $sql = $this->mysqli->prepare("
        SELECT SUM(valor_final)
        FROM app_pagamentos WHERE status IN('CONFIRMED', 'RECEIVED')");
        $sql->execute();
        $sql->bind_result($valor_pagamentos);
        $sql->fetch();
        $sql->close();


        $CadastrosModel['usuarios_qtd'] = $usuarios_qtd;
        $CadastrosModel['anuncios_ativos'] = $anuncios_ativos;
        $CadastrosModel['anuncios_pendentes'] = $anuncios_pendentes;
        $CadastrosModel['qtd_reservas'] = $qtd_reservas;
        $CadastrosModel['valor_pagamentos'] = moneyView($valor_pagamentos);



        $lista[] = $CadastrosModel;
        // print_r($lista);
        return $lista;
    }
    public function graficosDash()
    {
        $ano_atual = date('Y'); // Obtém o ano atual
        $lista = array();

        // Loop through each month
        for ($mes = 1; $mes <= 12; $mes++) {
            // Contagem de usuários por grupo e por mês
            $sql = $this->mysqli->prepare("
            SELECT
                (SELECT COUNT(id) FROM app_users WHERE id_grupo='4' AND MONTH(data_cadastro) = ?) as usuarios_qtd,
                (SELECT COUNT(id) FROM app_anuncios WHERE status_aprovado='1' AND MONTH(data_cadastro) = ?) as anuncios_ativos,
                (SELECT COUNT(id) FROM app_anuncios WHERE status_aprovado='2' AND MONTH(data_cadastro) = ?) as anuncios_pendentes,
                (SELECT COUNT(id) FROM app_reservas WHERE status='1' AND MONTH(data_cadastro) = ?) as qtd_reservas,
                (SELECT SUM(valor_final) FROM app_pagamentos WHERE status IN('CONFIRMED', 'RECEIVED') AND MONTH(data) = ?) as valor_pagamentos
            ");

            $sql->bind_param("iiiii", $mes, $mes, $mes, $mes, $mes);
            $sql->execute();
            $sql->bind_result($usuarios_qtd, $anuncios_ativos, $anuncios_pendentes, $qtd_reservas, $valor_pagamentos);

            if ($sql->fetch()) {
                $CadastrosModel = array();
                $CadastrosModel['mes'] = $mes;
                $CadastrosModel['usuarios_qtd'] = $usuarios_qtd;
                $CadastrosModel['anuncios_ativos'] = $anuncios_ativos;
                $CadastrosModel['anuncios_pendentes'] = $anuncios_pendentes;
                $CadastrosModel['qtd_reservas'] = $qtd_reservas;
                $CadastrosModel['valor_pagamentos'] = moneyView($valor_pagamentos);

            } else {
                $CadastrosModel = array();
                $CadastrosModel['mes'] = $mes;
                $CadastrosModel['usuarios_qtd'] = 0;
                $CadastrosModel['anuncios_ativos'] = 0;
                $CadastrosModel['anuncios_pendentes'] = 0;
                $CadastrosModel['qtd_reservas'] = 0;
                $CadastrosModel['valor_pagamentos'] = 0;
            }

            $lista[] = $CadastrosModel;
            $sql->close();
        }



        //Conta pa descobrir qual vai ser o maior valor , assim calibrando a altura do grafico
        foreach ($lista as $item) {
            $valor_maximo_grafico = max(
                $valor_maximo_grafico,
                $item['usuarios_qtd'],
                $item['anuncios_ativos'],
                $item['anuncios_pendentes'],
                $item['qtd_reservas'],
                $item['valor_pagamentos']
            );
        }

        // Armazena o valor máximo no primeiro item da lista
        $lista[0]['valor_maximo_grafico'] = $valor_maximo_grafico;

        return $lista;
    }

// public function graficosDash()
// {
//     $ano_atual = date('Y'); // Obtém o ano atual
//     $lista = array();

//     // Loop through each month
//     for ($mes = 1; $mes <= 12; $mes++) {

//         $sql = $this->mysqli->prepare("SELECT COUNT(id) as empresas_cadastradas,
//         (SELECT COUNT(id) FROM app_users WHERE saq ='1' AND MONTH(data_cadastro) = $mes AND id_grupo='5') as empresas_saq
//          FROM app_users WHERE MONTH(data_cadastro) = $mes AND id_grupo='5'");

//         $sql->execute();
//         $sql->bind_result($empresas_cadastradas,$empresas_saq);

//         // Fetch results
//         if ($sql->fetch()) {

//             $CadastrosModel = array();
//             $CadastrosModel['mes'] = $mes;
//             $CadastrosModel['empresas_cadastradas'] = $empresas_cadastradas;
//             $CadastrosModel['empresas_saq'] = $empresas_saq;

//             $lista[] = $CadastrosModel;

//         } else {

//             $CadastrosModel = array();
//             $CadastrosModel['mes'] = $mes;
//             $CadastrosModel['empresas_cadastradas'] = 0;
//             $CadastrosModel['empresas_saq'] = 0;


//             $lista[] = $CadastrosModel;
//         }

//         $sql->close();
//     }

//     return $lista;
// }
public function listCompras($limite)
{

    $sql = $this->mysqli->prepare("
    SELECT DISTINCT a.id,a.categoria_id,b.nome,a.descricao,a.data_cadastro,a.status,c.nome_fantasia,c.avatar
    FROM `app_cotacao` AS a
    INNER JOIN `app_categorias_fornecedores` AS b ON a.categoria_id=b.id
    INNER JOIN `app_users` AS c ON a.app_users_id=c.id
    WHERE a.status = '5'
    LIMIT $limite ;
    ");
    $sql->execute();
    $sql->bind_result($id,$categoria_id,$categoria_nome,$descricao,$data_cadastro,$status,$nome,$logotipo);
    $sql->store_result();
    $rows = $sql->num_rows();

    $lista=[];
    if ($rows == 0) {
        $param['rows'] = $rows;
        $lista[] = $param;
    } else {
        while ($row = $sql->fetch()) {
            $param['id'] = $id;
            // $param['nome_cliente'] = "cliente teste";
            // $param['avatar_cliente'] = "avatar.png";
            $param['logotipo'] = $logotipo;
            $param['nome'] = decryptitem($nome);

            $param['categoria_id'] = $categoria_id;
            $param['categoria_nome'] = $categoria_nome;
            $param['descricao'] = $descricao;
            $param['data_cadastro'] = dataBR($data_cadastro) ." " .  horarioBR($data_cadastro);
            // $param['status'] = statusCotacoes($status);
            $param['rows'] = $rows;
            array_push($lista,$param);
        }
    }


    return $lista;
}
public function listAnuncios($limite){


  $sql = $this->mysqli->prepare(
      "
      SELECT a.*, b.nome, c.*, d.nome, e.nome
      FROM `app_anuncios` as a
      INNER JOIN `app_users` as b ON a.app_users_id = b.id
      INNER JOIN `app_anuncios_location` as c ON a.id = c.app_anuncios_id
      INNER JOIN `app_categorias` as d ON a.app_categorias_id = d.id
      INNER JOIN `app_subcategorias` as e ON a.app_subcategorias_id = e.id
      INNER JOIN `app_anuncios_types` as f ON a.id = f.app_anuncios_id
      INNER JOIN `app_anuncios_info` as g ON f.id = g.app_anuncios_types_id
      INNER JOIN `app_anuncios_carac` as h ON a.id = h.app_anuncios_id
      GROUP BY a.id
      LIMIT $limite
      ")
  ;


  $sql->execute();
  $sql->bind_result(
    $id, $app_users_id, $id_categoria, $id_subcategoria, $nome, $descricao, $data_cadastro, $checkin, $checkout, $status, $status_aprovado, $finalizado, $nome_user,
    $id_location, $app_anuncios_id, $latitude, $longitude, $end, $rua, $bairro, $cidade, $estado, $numero, $complemento, $referencia,
    $nome_categoria, $nome_subcategoria
  );
  $sql->store_result();
  $rows = $sql->num_rows;

  $lista = [];

  if ($rows == 0) {
      $Param['rows'] = 0;
      array_push($lista, $Param);
  } else {
      while ($row = $sql->fetch()) {

            $model_anuncios = New Anuncios();

            $Param['id'] = $id;
            $Param['id_user'] = $app_users_id;
            $Param['nome_user'] = decryptitem($nome_user);
            $Param['id_categoria'] = $id_categoria;
            $Param['nome_categoria'] = $nome_categoria;
            $Param['id_subcategoria'] = $id_subcategoria;
            $Param['nome_subcategoria'] = $nome_subcategoria;
            $Param['nome'] = $nome;
            $Param['descricao'] = $descricao;
            $Param['checkin'] = dataBR($checkin);
            $Param['checkout'] = dataBR($checkout);
            $Param['status'] = $status;
            $Param['status_aprovado'] = $status_aprovado;
            $Param['finalizado'] = $finalizado;
            $Param['latitude'] = $latitude;
            $Param['longitude'] = $longitude;
            $Param['end'] = $end;
            $Param['rua'] = $rua;
            $Param['bairro'] = $bairro;
            $Param['cidade'] = $cidade;
            $Param['estado'] = $estado;
            $Param['numero'] = $numero;
            $Param['complemento'] = $complemento;
            $Param['referencia'] = $referencia;

            $Param['caracteristicas'] = $model_anuncios->listcaracteristicasID($id);
            $Param['imagens'] = $model_anuncios->listimagens($id);
            $Param['tipos'] = $model_anuncios->listtiposValor($id, $data_de, $data_ate);
            $Param['avaliacoes'] = $model_anuncios->avaliacoes($id);

            array_push($lista, $Param);

      }
  }

  return $lista;

}

public function listReservas($limite){


  $sql = $this->mysqli->prepare(
      "
      SELECT a.id, a.app_users_id, a.app_anuncios_id, a.adultos, a.criancas, a.data_de, a.data_ate, a.taxa_limpeza, a.obs, a.status,
      b.tipo_pagamento, b.valor_final, b.valor_anunciante, b.valor_admin, b.data, b.token
      FROM `app_reservas` as a
      INNER JOIN `app_pagamentos` as b ON a.app_pagamentos_id = b.id
      GROUP BY a.id
      ORDER BY a.id DESC
      LIMIT $limite
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

          $model_cadastros = New Cadastros();
          $model_anuncios = New Anuncios();


          $dadosAnuncio = $model_anuncios->listID($id_anuncio);


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
          $Param['tempo_cancelamento'] = $tempo_cancelamento_s;
          $Param['perfil'] = $model_cadastros->Perfil($id_user);
          $Param['anunciante'] = $model_cadastros->Perfil($dadosAnuncio[0]['id_user']);
          $Param['anuncio'] = $model_anuncios->listID($id_anuncio);


          array_push($lista, $Param);

    }


  }

  return $lista;

}

public function listLastCompanies($limite) {

  if(!empty($limite)){$limite = "LIMIT $limite";}

  $sql = $this->mysqli->prepare("SELECT DISTINCT a.id, a.nome_fantasia, a.avatar, a.data_cadastro ,b.estado,b.cidade
  FROM app_users AS a
  INNER JOIN `app_users_endereco` AS b ON a.id=b.app_users_id

  WHERE a.id_grupo = 5 AND b.favorito='1'
    GROUP BY a.id
    ORDER BY a.data_cadastro DESC

    $limite
    ");
    $sql->execute();
    $sql->bind_result($id, $nome, $logotipo, $data_cadastro, $estado, $cidade);
    $sql->store_result();
    $rows = $sql->num_rows;
    $lista = array();

    if ($rows == 0) {
      $Param['rows'] = $rows;
      array_push($lista, $Param);
    } else{
      while ($row = $sql->fetch()) {
        $Param['id'] = $id;
        $Param['nome'] = decryptitem($nome);
        $Param['estado'] = decryptitem($estado);
        $Param['cidade'] = decryptitem($cidade);
        $Param['logotipo'] = $logotipo;
        $Param['data_cadastro'] = dataBR($data_cadastro) ." " .  horarioBR($data_cadastro);


        $lista[] = $Param;
      }
    }
    return $lista;
}

public function listLastUsuarios($limite) {

    if(!empty($limite)){$limite = "LIMIT $limite";}

    $sql = $this->mysqli->prepare("SELECT DISTINCT a.id, a.nome, a.email, a.celular, a.avatar, a.data_cadastro, b.latitude, b.longitude
    FROM `app_users` AS a
    LEFT JOIN `app_users_location` AS b ON a.id = b.app_users_id
    WHERE a.id_grupo = 4
    GROUP BY a.id
    ORDER BY a.data_cadastro DESC
    $limite
      ");
      $sql->execute();
      $sql->bind_result($id, $nome, $email, $celular, $logotipo, $data_cadastro, $latitude, $longitude);
      $sql->store_result();
      $rows = $sql->num_rows;

      $lista = array();

      if ($rows == 0) {

        $Param['rows'] = $rows;
        array_push($lista, $Param);

      } else{

        while ($row = $sql->fetch()) {
          $Param['id'] = $id;
          $Param['nome'] = decryptitem($nome);
          $Param['email'] = decryptitem($email);
          $Param['celular'] = decryptitem($celular);
          $Param['logotipo'] = $logotipo;
          $Param['latitude'] = $latitude;
          $Param['longitude'] = $longitude;
          $Param['data_cadastro'] = dataBR($data_cadastro) ." " .  horarioBR($data_cadastro);

          $lista[] = $Param;
        }
      }
      return $lista;
  }















            public function ultimasCompras($limite) {

            if(!empty($limite)){$limite = "LIMIT $limite";}

            $sql = $this->mysqli->prepare("SELECT DISTINCT a.id, b.nome, b.id, a.data, c.nome FROM app_recibos AS a
            INNER JOIN app_users AS b ON a.app_users_id = b.id
            INNER JOIN app_categoria_recibos AS c ON c.id = a.app_categoria_id
            WHERE a.status = 1
              GROUP BY a.id
              ORDER BY a.data DESC

              $limite
              ");
              $sql->execute();
              $sql->bind_result($id, $nome, $id_usuario, $data, $nome_categoria);
              $sql->store_result();
              $rows = $sql->num_rows;
              $lista = array();

              if ($rows == 0) {
                $Param['rows'] = $rows;
                array_push($lista, $Param);
              } else{
                while ($row = $sql->fetch()) {
                  $Param['id'] = $id;
                  $Param['id_usuario'] = $id_usuario;
                  $Param['nome'] = decryptitem($nome);
                  $Param['data'] = dataBR($data);
                  $Param['nome_categoria'] = $nome_categoria;


                  $lista[] = $Param;
                }
              }
              return $lista;
          }






}
