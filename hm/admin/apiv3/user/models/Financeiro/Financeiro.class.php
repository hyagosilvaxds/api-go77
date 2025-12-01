<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once MODELS . '/Estados/Estados.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';

class Financeiro extends Conexao {


    public function __construct() {
        $this->Conecta();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->tabela = "app_planos_pagamentos";
    }

    public function listAllFinanceiro($id_financeiro,$nome,$email,$data_de,$data_ate)
    {

      $nome_final = cryptitem($nome);
      $email_final = cryptitem($email);


      $filter = "WHERE a.id>'0'";
      if(!empty($id_financeiro)){$filter .= "AND a.id = '$id_financeiro'";}
      if(!empty($nome)){$filter .= "AND c.nome LIKE '%$nome_final%'";}
      if(!empty($email)){$filter .= "AND c.nome LIKE '%$email_final%'";}
      if(!empty($data_de)){$filter .= "AND a.data>='$data_de'";}
      if(!empty($data_ate)){$filter .= "AND a.data<='$data_ate 23:59:59' ";}
        $sql = $this->mysqli->prepare("
        SELECT
        a.id, a.tipo_pagamento, a.valor_final, a.valor_anunciante, a.valor_admin, a.data, a.token, a.status,
        b.id, b.nome,
        c.id, c.nome
        FROM app_pagamentos AS a
        LEFT JOIN app_anuncios AS b ON a.app_anuncios_id = b.id
        LEFT JOIN app_users AS c ON a.app_users_id = c.id
        $filter ORDER BY a.id DESC");

        $sql->execute();
        $sql->bind_result($id, $tipo_pagamento, $valor_final, $valor_anunciante, $valor_admin, $data, $token, $status, $id_anuncio, $nome_anuncio, $id_usuario, $nome_usuario);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];
        $usuariosEncontrados = false;
        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['tipo_pagamento'] = nomePagamento($tipo_pagamento);
                $Param['valor_final'] = moneyView($valor_final);
                $Param['valor_anunciante'] = moneyView($valor_anunciante);
                $Param['valor_admin'] = moneyView($valor_admin);
                $Param['data'] = date('d/m/Y', strtotime($data));
                $Param['hora'] = date('H:i', strtotime($data));
                $Param['token'] = $token;
                $Param['id_usuario'] = $id_usuario;
                $Param['nome_usuario'] = decryptitem($nome_usuario);
                $Param['id_anuncio'] = $id_anuncio;
                $Param['nome_anuncio'] = $nome_anuncio;
                $Param['status'] = statusPayment($status);

                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }

        }
        return $usuarios;
    }

    public function gerarCSV() {
        // Abrir o arquivo de log (criar se não existir)
        $arquivo = fopen("uploads/planilhas/exportarFinanceiro.csv", "w");

        $sql = $this->mysqli->prepare("
        SELECT a.id, a.app_users_id, a.tipo, a.tipo_pagamento, a.valor_total, a.token, a.status, a.data_cadastro, b.nome, b.email
        FROM app_pedidos AS a
        LEFT JOIN app_users AS b ON a.app_users_id = b.id");

        $sql->execute();
        $sql->bind_result($id, $id_usuario, $tipo, $tipo_pagamento, $valor_total, $token, $status, $data, $nome_comprador, $email_comprador);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {


                $Param['id'] = $id;
                $Param['id_usuario'] = $id_usuario;
                $Param['tipo'] = $tipo;
                $Param['tipo_pagamento'] = $tipo_pagamento;
                $Param['token'] = $token;
                $Param['valor_total'] = moneyView($valor_total);
                $Param['data'] = date('d/m/Y', strtotime($data));
                $Param['hora'] = date('H:i', strtotime($data));
                $Param['nome'] = decryptitem($nome_comprador);
                $Param['email'] = decryptitem($email_comprador);
                $Param['status'] = statusPayment($status);



                array_push($usuarios, $Param);
            }
        }

        $cabecalho = ['id','id_usuario','tipo', 'tipo_pagamento', 'token', 'valor_total', 'data', 'hora', 'nome', 'email', 'status'];

        fputcsv($arquivo, $cabecalho, ';');

        // Escrever o conteúdo no arquivo
        foreach($usuarios as $row_usuario){
            fputcsv($arquivo, $row_usuario, ';');
        }
        // Fechar arquivo
        fclose($arquivo);

    }

    public function listIDFinanceiro($id_financeiro)
    {
      $filter = "WHERE a.id>'0'";
      if(!empty($id_financeiro)){$filter .= "AND a.id = '$id_financeiro'";}

        $sql = $this->mysqli->prepare("
        SELECT a.id, a.app_users_id, a.tipo, a.tipo_pagamento, a.valor_total, a.token, a.status, a.data_cadastro, b.nome, b.email
        FROM app_pedidos AS a
        LEFT JOIN app_users AS b ON a.app_users_id = b.id
        $filter");

        $sql->execute();
        $sql->bind_result($id, $id_usuario, $tipo, $tipo_pagamento, $valor_total, $token, $status, $data, $nome_comprador, $email_comprador);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['id_usuario'] = $id_usuario;
                $Param['tipo'] = $tipo ==1 ? 'Shop' : 'Plano';
                $Param['tipo_num'] = $tipo;
                $Param['id_anuncio_plano'] = $id_anuncio_plano;
                $Param['tipo_pagamento'] = $tipo_pagamento;
                $Param['token'] = $token;

                $Param['valor_total'] = moneyView($valor_total);
                $Param['data'] = dataBR($data);
                $Param['nome'] = decryptitem($nome_comprador);
                $Param['email'] = decryptitem($email_comprador);
                $Param['status'] = statusPayment($status);
                $Param['rows'] = $rows;


                array_push($usuarios, $Param);


            }
        }
        return $usuarios;
    }

    public function findNomeAnuncio($id){

        $sql = $this->mysqli->prepare("
        SELECT nome FROM `app_anuncios`
        WHERE id='$id'

        ");
        $sql->execute();
        $sql->bind_result($this->nome_anuncio);
        $sql->store_result();
        $sql->fetch();

        return $this->nome_anuncio;

    }
    public function findNomePlano($id){

        $sql = $this->mysqli->prepare("
        SELECT nome FROM `app_planos`
        WHERE id='$id'

        ");
        $sql->execute();
        $sql->bind_result($this->nome_plano);
        $sql->store_result();
        $sql->fetch();

        return $this->nome_plano;

    }

    public function AprovarEstabelecimento($param)
    {

        $sql = $this->mysqli->prepare("UPDATE `app_users` SET status_aprovado='1' WHERE id='$param'");
        $sql->execute();
        $Param = [
            "status" => "01",
            "msg" => "Estabelecimento aprovado!"
        ];

        return $Param;
    }
    public function ReprovarEstabelecimento($param)
    {

        $sql = $this->mysqli->prepare("UPDATE `app_users` SET status_aprovado='2' WHERE id='$param'");
        $sql->execute();
        $Param = [
            "status" => "01",
            "msg" => "Estabelecimento reprovado!"
        ];

        return $Param;
    }

    public function listAllEstabelecimentosPendentes($id_usuario,$nome,$email,$data_de,$data_ate)
    {
      $filter = "WHERE a.id_grupo='6' AND a.status_aprovado='2'";
      if(!empty($id_usuario)){$filter .= "AND a.id = '$id_usuario'";}
      if(!empty($data_de)){$filter .= "AND a.data_cadastro>='$data_de'";}
      if(!empty($data_ate)){$filter .= "AND a.data_cadastro<='$data_ate 23:59:59' ";}
        $sql = $this->mysqli->prepare("
        SELECT a.id, a.id_grupo, a.nome, a.avatar, a.email, a.documento, a.celular, a.status, a.status_aprovado, a.data_cadastro, b.cep,b.estado,b.cidade,b.endereco,b.bairro,
        b.numero,b.complemento,b.latitude,b.longitude
        FROM app_users AS a
        LEFT JOIN app_users_endereco AS b ON a.id = b.app_users_id
        $filter");

        $sql->execute();
        $sql->bind_result($id_usuario_cad, $id_grupo, $nome_user, $avatar_user, $email_user, $documento, $celular, $status, $status_aprovado, $data_cadastro, $cep,
      $estado,$cidade,$endereco,$bairro,$numero,$complemento,$latitude,$longitude);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id_usuario'] = $id_usuario_cad;
                $Param['id_grupo'] = $id_grupo;
                $Param['avatar_user'] = $avatar_user;
                // $Param['dados_plano'] = $this->planoUser($id_usuario_cad);
                $Param['nome'] = decryptitem($nome_user);
                $Param['email'] = decryptitem($email_user);
                $Param['celular'] = decryptitem($celular);
                $Param['documento'] = decryptitem($documento);
                $Param['cep'] = decryptitem($cep);
                $Param['estado'] = decryptitem($estado);
                $Param['cidade'] = decryptitem($cidade);
                $Param['endereco'] = decryptitem($endereco);
                $Param['bairro'] = decryptitem($bairro);
                $Param['numero'] = decryptitem($numero);
                $Param['complemento'] = decryptitem($complemento);
                $Param['status'] = $status;
                $Param['status_aprovado'] = $status_aprovado;
                $Param['data_cadastro'] = dataBR($data_cadastro);
                $Param['rows'] = $rows;

                 //FILTRO DENTRO DO WHILE INICIO
                $filtro = "(1 > 0)";
                //se a variavel q busca nao for vazia concatena um filtro
                //  print_r($nome);exit;
                if (!empty($nome)) {
                    $filtro .= " && (stripos(\$Param['nome'], \$nome) !== false)";
                }
                if (!empty($email)) {
                  $filtro .= " && (stripos(\$Param['email'], \$email) !== false)";
                }
                //se a variavel q busca nao for vazia concatena um filtro

                eval("\$condicao = ({$filtro});");
                if ($condicao) {
                  // print_r($condicao);exit;
                  array_push($usuarios, $Param);
                }else{
                    foreach ($usuarios as &$item) {
                        $contador_filtro = COUNT($usuarios);
                        // print_r($contador_filtro);exit;
                        $item['rows'] = $contador_filtro;
                    }
                }
                //FILTRO DENTRO DO WHILE FIM



            }
        }
        return $usuarios;
    }


    public function deleteEstabelecimento($id)
    {

        $sql_cadastro = $this->mysqli->prepare("DELETE FROM app_users WHERE id='$id'");
        $sql_cadastro->execute();

        $linhas_afetadas = $sql_cadastro->affected_rows;

        if ($linhas_afetadas > 0) {
            $param = [
                "status" => "01",
                "msg" => "Estabelecimento deletado"
            ];
        } else {
            $param = [
                "status" => "02",
                "msg" => "Falha ao deletar o cadastro"
            ];
        }

        return $param;
    }

    public function updatePassword($id, $password)
    {
      // print_r($password);exit;
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE app_users
        SET password='$password'
        WHERE id='$id'
        ");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Senha atualizada"
        ];

        return $Param;
    }

    public function updatePlanos($id_usuario, $id_plano, $data_validade)
    {

      // print_r($password);exit;
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE app_users_planos
        SET app_planos_id='$id_plano',data_validade='$data_validade'
        WHERE app_users_id='$id_usuario'
        ");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Plano atualizado."
        ];

        return $Param;
    }

    public function planoUser($id)
    {

        $sql = $this->mysqli->prepare("SELECT app_planos_id, data_cadastro, data_validade FROM app_users_planos WHERE app_users_id='$id'");

        $sql->execute();
        $sql->bind_result($id_plano, $data_cadastro_plano, $data_validade_plano);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {


                $Param['id_plano'] = $id_plano;
                $Param['data_cadastro_plano'] = dataBR($data_cadastro_plano);
                $Param['data_validade_plano'] = dataBR($data_validade_plano);



                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }
    public function listAllPlanos($id)
    {

        $sql = $this->mysqli->prepare("SELECT id, nome, descricao, valor, validade_dias FROM app_planos");

        $sql->execute();
        $sql->bind_result($id_plano, $nome_plano, $descricao_plano, $valor_plano, $validade_dias);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {


                $Param['id_plano'] = $id_plano;
                $Param['nome_plano'] = $nome_plano;
                $Param['descricao_plano'] = $descricao_plano;
                $Param['valor_plano'] = $valor_plano;
                $Param['validade_dias'] = $validade_dias;



                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }
    public function listAllPagamentos($id)
    {

        $sql = $this->mysqli->prepare("SELECT tipo, tipo_pagamento, data, valor_total FROM app_pagamentos WHERE id_usuario='$id'");

        $sql->execute();
        $sql->bind_result($tipo_compra, $tipo_pagamento, $data, $valor_total);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['tipo_compra'] = $tipo_compra == 1 ? "Plano" : "Turbinar";
                $Param['tipo_pagamento'] = $tipo_pagamento == 4 ? "Google Pay" : "Apple Pay";
                $Param['data'] = dataBR($data);
                $Param['valor_total'] = 'R$' . $valor_total;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function updateCadastro($id_usuario, $nome, $email, $documento, $celular, $data_nascimento, $status, $status_aprovado)
    {
        $sql_cadastro = $this->mysqli->prepare("UPDATE app_users SET nome='$nome',email='$email',documento='$documento',celular='$celular'
        ,data_nascimento='$data_nascimento',status='$status',status_aprovado='$status_aprovado' WHERE id='$id_usuario'");
        $sql_cadastro->execute();

            $Param = [
                "status" => "01",
                "msg" => "Cadastro atualizado",
            ];



        return $Param;
    }


    public function graficosDash()
    {
        $sql = $this->mysqli->prepare( "SELECT COUNT(id) as total_ferramenta,
        (SELECT COUNT(id) FROM app_anuncios) as total_anuncios,
        (SELECT COUNT(id) FROM app_pagamentos WHERE tipo = '1' AND status = 'approved') as total_assinaturas,
        (SELECT COUNT(id) FROM app_pagamentos WHERE tipo = '2' AND status = 'approved') as total_turbinar,
        (SELECT SUM(valor_total) FROM app_pagamentos WHERE tipo = '1' AND status = 'approved') as valor_assinatura,
        (SELECT SUM(valor_total) FROM app_pagamentos WHERE tipo = '2' AND status = 'approved') as valor_turbinar
         FROM app_users");
        $sql->execute();
        $sql->bind_result($total_cadastros,$total_anuncios,$total_assinaturas,$total_turbinar,$valor_assinaturas,$valor_turbinar);
        $sql->fetch();
        $sql->close();

        $valor_turbinar = ($valor_turbinar === null) ? 0 : $valor_turbinar;
        $valor_assinaturas = ($valor_assinaturas === null) ? 0 : $valor_assinaturas;
        $CadastrosModel['total_cadastros'] = $total_cadastros;
        $CadastrosModel['total_anuncios'] = $total_anuncios;
        $CadastrosModel['total_assinaturas'] = $total_assinaturas;
        $CadastrosModel['total_turbinar'] = $total_turbinar;
        $CadastrosModel['valor_assinatura'] ='R$' . $valor_assinaturas;
        $CadastrosModel['valor_turbinar'] ='R$' . $valor_turbinar;


        $lista[] = $CadastrosModel;
        // print_r($lista);
        return $lista;
        }
    public function EstatisticasGerais($id)
    {
        $sql = $this->mysqli->prepare("SELECT COUNT(id) as total_anuncios,
        (SELECT COUNT(id) FROM app_pagamentos WHERE tipo = '1' AND status = 'approved' AND id_usuario='$id') as total_assinaturas,
        (SELECT COUNT(id) FROM app_pagamentos WHERE tipo = '2' AND status = 'approved' AND id_usuario='$id') as total_turbinar,
        (SELECT SUM(valor_total) FROM app_pagamentos WHERE tipo = '1' AND status = 'approved' AND id_usuario='$id') as valor_assinatura,
        (SELECT SUM(valor_total) FROM app_pagamentos WHERE tipo = '2' AND status = 'approved' AND id_usuario='$id') as valor_turbinar
        FROM app_anuncios WHERE id_usuario ='$id'");
        $sql->execute();
        $sql->bind_result($total_anuncios,$total_assinaturas,$total_turbinar,$valor_assinaturas,$valor_turbinar);
        $sql->fetch();
        $sql->close();

        $valor_turbinar = ($valor_turbinar === null) ? 0 : $valor_turbinar;
        $valor_assinaturas = ($valor_assinaturas === null) ? 0 : $valor_assinaturas;
        $CadastrosModel['total_anuncios'] = $total_anuncios;
        $CadastrosModel['total_assinaturas'] = $total_assinaturas;
        $CadastrosModel['total_turbinar'] = $total_turbinar;
        $CadastrosModel['valor_assinatura'] ='R$' . $valor_assinaturas;
        $CadastrosModel['valor_turbinar'] ='R$' . $valor_turbinar;


        $lista[] = $CadastrosModel;
        // print_r($lista);
        return $lista;
        }










}
