<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once MODELS . '/Estados/Estados.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';

class Compras extends Conexao {


    public function __construct() {
        $this->Conecta();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->tabela = "app_planos_pagamentos";
    }
    public function listPendentes()
    {
      $filter = "WHERE id_grupo='4' AND status_aprovado='2' ";
        $sql = $this->mysqli->prepare("
        SELECT DISTINCT id, id_grupo, nome, avatar, status, status_aprovado, data_cadastro, saq, link,celular,email
        FROM app_users
        $filter 
        GROUP BY id
        ORDER BY saq ASC
        ");

        $sql->execute();
        $sql->bind_result($id_usuario_cad, $id_grupo, $nome_user, $avatar_user, $status, $status_aprovado, $data_cadastro, $saq, $link, $celular, $email);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];
        $usuariosEncontrados = false;
        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id_usuario'] = $id_usuario_cad;
                $Param['id_grupo'] = $id_grupo;
                $Param['avatar_user'] = $avatar_user;
                $Param['nome'] = decryptitem($nome_user);
                $Param['status'] = $status;
                $Param['link'] = $link;
                $Param['status_aprovado'] = $status_aprovado;
                $Param['saq'] = $saq == 1 ? 'Sim' : 'Não';
                $Param['saq_update'] = $saq;
                $Param['data_cadastro'] = dataBR($data_cadastro);
                $Param['celular'] = decryptitem($celular);
                $Param['email'] = decryptitem($email);
                $Param['rows'] = $rows;
                
                $filtro = "(1 > 0)";
            
                    
                    if (!empty($nome)) {
                        $nomeSemAcento = removerAcentos($nome);
                        $filtro .= " && (stripos(removerAcentos(\$Param['nome']), '$nomeSemAcento') !== false)";
                    }
                    // FILTRO DENTRO DO WHILE FIM

                    eval("\$condicao = ({$filtro});");
                    if ($condicao) {
                        $usuariosEncontrados = true; // Define como true quando um usuário é encontrado
                        array_push($usuarios, $Param);
                    }
            }
            
            // Verifica se nenhum usuário foi encontrado durante a primeira passagem
            if (!$usuariosEncontrados) {
                return [['rows' => 0]];
            }
        }
        return $usuarios;
    }
    public function listAllCompras($id_usuario,$comprador,$fornecedor,$data_de,$data_ate,$cidade,$estado)
    {
      $filter = "WHERE c.status ='5' AND e.status='1' ";
      if(!empty($id_usuario)){$filter .= "AND c.id = '$id_usuario'";}
      if(!empty($data_de)){$filter .= "AND c.data_cadastro>='$data_de'";}
      if(!empty($data_ate)){$filter .= "AND c.data_cadastro<='$data_ate 23:59:59' ";}
      if(!empty($cidade)){
        $cidade = cryptitem($cidade);
        $filter .= "AND b.cidade ='$cidade' ";
        }
      if(!empty($estado)){
        $estado = cryptitem($estado);
        $filter .= "AND b.estado ='$estado' ";
        }
        $sql = $this->mysqli->prepare("
        SELECT DISTINCT c.id, d.nome, c.descricao, c.data_cadastro, c.status ,b.estado, b.cidade,a.id, a.nome_fantasia,a.avatar,f.id,f.nome_fantasia,f.avatar,
        e.id,e.metodo_pagamento,e.id_endereco,e.valor,e.valor_admin,e.perc_admin
        FROM app_cotacao AS c
        INNER JOIN `app_users` AS a ON a.id=c.app_users_id
        INNER JOIN `app_users_endereco` AS b ON a.id=b.app_users_id
        INNER JOIN `app_categorias_fornecedores` AS d ON c.categoria_id = d.id
        INNER JOIN `app_orcamentos` AS e ON e.app_cotacoes_id=c.id
        INNER JOIN `app_users` AS f ON f.id=e.app_users_id
        $filter 
        ORDER BY c.id DESC
        ");


        $sql->execute();
        $sql->bind_result($id_cotacao, $categoria_nome, $descricao,$data_cadastro, $status, $estado, $cidade, $id_cliente,$nome_user, $avatar,$id_fornecedor, $nome_fornecedor, $avatar_fornecedor,
        $id_orcamento, $metodo_pagamento, $id_endereco, $valor, $valor_admin,$perc_admin);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];
        $usuariosEncontrados = false;
        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id_orcamento'] = $id_orcamento;
                
                if($metodo_pagamento == 1){
                    $metodo_pagamento = "Crédito";
                }
                if($metodo_pagamento == 2){
                    $metodo_pagamento = "Boleto";
                }
                if($metodo_pagamento == 3){
                    $metodo_pagamento = "Pix";
                }
                $Param['metodo_pagamento'] = $metodo_pagamento;
                $Param['id_endereco'] = $id_endereco;
                $Param['valor'] = moneyView($valor);
                $Param['valor_admin'] = moneyView($valor_admin);

                $Param['valor_var'] = (float)$valor;
                $Param['valor_admin_var'] = (float)$valor_admin;

                $Param['perc_admin'] = $perc_admin;

                
                $endereco_completo = $this->findEnderecoCliente($id_endereco);

                $Param['estado_cliente'] = $endereco_completo['estado'];
                $Param['cidade_cliente'] = $endereco_completo['cidade'];
                $Param['bairro_cliente'] = $endereco_completo['bairro'];
                $Param['endereco_cliente'] = $endereco_completo['endereco'];
                $Param['numero_cliente'] = $endereco_completo['numero'];
                $Param['cep_cliente'] =$endereco_completo['cep'];

                $Param['id_cotacao'] = $id_cotacao;
                $Param['categoria_nome'] = $categoria_nome;

                $Param['status'] = statusCotacoes($status);

                $Param['id_cliente'] = $id_cliente;
                $Param['avatar_user'] = $avatar;
                $Param['descricao'] = $descricao;


                $Param['id_fornecedor'] = $id_fornecedor;
                $Param['nome_fornecedor'] = decryptitem($nome_fornecedor);
                $Param['avatar_fornecedor'] = $avatar_fornecedor;

                $Param['nome'] = decryptitem($nome_user);
                $Param['estado'] = decryptitem($estado);
                $Param['cidade'] = decryptitem($cidade);
                $Param['data_cadastro'] = dataBR($data_cadastro) . " ". horaBR($data_cadastro);
                $Param['imagens'] = $this->galeriaOrcamento($id_orcamento);

                $Param['rows'] = $rows;
                
                $filtro = "(1 > 0)";
            
                    
                    if (!empty($comprador)) {
                        $compradorSemAcento = removerAcentos($comprador);
                        $filtro .= " && (stripos(removerAcentos(\$Param['nome']), '$compradorSemAcento') !== false)";
                    }
                    if (!empty($fornecedor)) {
                        $fornecedorSemAcento = removerAcentos($fornecedor);
                        $filtro .= " && (stripos(removerAcentos(\$Param['nome_fornecedor']), '$fornecedorSemAcento') !== false)";
                    }
                    // FILTRO DENTRO DO WHILE FIM

                    eval("\$condicao = ({$filtro});");
                    if ($condicao) {
                        $usuariosEncontrados = true; // Define como true quando um usuário é encontrado
                        array_push($usuarios, $Param);
                    }
            }
            
            // Verifica se nenhum usuário foi encontrado durante a primeira passagem
            if (!$usuariosEncontrados) {
                return [['rows' => 0]];
            }
        }
        return $usuarios;
    }
    public function galeriaOrcamento($id)
    {

        $sql = $this->mysqli->prepare("
        SELECT id,url
        FROM `app_orcamentos_galeria` 
        WHERE id_orcamento='$id'
        ");

        $sql->execute();
        $sql->bind_result($id, $url);
        $sql->store_result();
        $rows = $sql->num_rows();

        $lista=[];
        if ($rows == 0) {
            $param['rows'] = $rows;
            $lista[] = $param;
        } else {
            while ($row = $sql->fetch()) {
                $param['id'] = $id;
                $param['url'] = $url;
                $param['rows'] = $rows;
                array_push($lista,$param);
            }
        }
        return $lista;
    }
    public function findEnderecoCliente($id)
    {

        $sql = $this->mysqli->prepare("
        SELECT DISTINCT id,cep,estado,cidade,bairro,endereco,numero,complemento,latitude,longitude
        FROM `app_users_endereco` 
        WHERE id='$id'
        ");

        $sql->execute();
        $sql->bind_result($id, $cep,  $estado, $cidade, $bairro, $endereco, $numero, $complemento, $latitude, $longitude);
        $sql->store_result();
        $rows = $sql->num_rows();

        $lista = [];
        while ($row = $sql->fetch()) {
            $param['id'] = decryptitem($id);
            $param['cep'] = decryptitem($cep);
            $param['estado'] = decryptitem($estado);
            $param['cidade'] = decryptitem($cidade);
            $param['bairro'] = decryptitem($bairro);
            $param['endereco'] = decryptitem($endereco);
            $param['numero'] = decryptitem($numero);
            $param['complemento'] = decryptitem($complemento);
            $param['latitude'] = decryptitem($latitude);
            $param['longitude'] = decryptitem($longitude);
            $param['rows'] = $rows;
            array_push($lista,$param);
        }
        
        return $lista[0];
    }
    public function listAllEmpresas($id_usuario,$nome,$data_de,$data_ate)
    {
      $filter = "WHERE id_grupo='5'";
      if(!empty($id_usuario)){$filter .= "AND id = '$id_usuario'";}
      if(!empty($data_de)){$filter .= "AND data_cadastro>='$data_de'";}
      if(!empty($data_ate)){$filter .= "AND data_cadastro<='$data_ate 23:59:59' ";}
        $sql = $this->mysqli->prepare("
        SELECT DISTINCT id, id_grupo, nome, avatar, status, status_aprovado, data_cadastro, saq, link,celular,email
        FROM app_users
        $filter 
        GROUP BY id
        ORDER BY saq ASC
        ");

        $sql->execute();
        $sql->bind_result($id_usuario_cad, $id_grupo, $nome_user, $descricao, $status, $status_aprovado, $data_cadastro, $saq, $link, $celular, $email);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];
        $usuariosEncontrados = false;
        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id_usuario'] = $id_usuario_cad;
                $Param['id_grupo'] = $id_grupo;
                $Param['avatar_user'] = $avatar_user;
                $Param['nome'] = decryptitem($nome_user);
                $Param['status'] = $status;
                $Param['link'] = $link;
                $Param['status_aprovado'] = $status_aprovado;
                $Param['saq'] = $saq == 1 ? 'Sim' : 'Não';
                $Param['saq_update'] = $saq;
                $Param['data_cadastro'] = dataBR($data_cadastro);
                $Param['celular'] = decryptitem($celular);
                $Param['email'] = decryptitem($email);
                $Param['rows'] = $rows;
                
                $filtro = "(1 > 0)";
            
                    
                    if (!empty($nome)) {
                        $nomeSemAcento = removerAcentos($nome);
                        $filtro .= " && (stripos(removerAcentos(\$Param['nome']), '$nomeSemAcento') !== false)";
                    }
                    // FILTRO DENTRO DO WHILE FIM

                    eval("\$condicao = ({$filtro});");
                    if ($condicao) {
                        $usuariosEncontrados = true; // Define como true quando um usuário é encontrado
                        array_push($usuarios, $Param);
                    }
            }
            
            // Verifica se nenhum usuário foi encontrado durante a primeira passagem
            if (!$usuariosEncontrados) {
                return [['rows' => 0]];
            }
        }
        return $usuarios;
    }

    public function gerarCSV() {
        // Abrir o arquivo de log (criar se não existir)
        $arquivo = fopen("uploads/planilhas/exportarCompras.csv", "w");

        $sql = $this->mysqli->prepare("
        SELECT DISTINCT id, id_grupo, nome, avatar, status, status_aprovado, data_cadastro, saq, link
        FROM app_users
        WHERE id_grupo='5'
        GROUP BY id
        ORDER BY saq ASC");

        $sql->execute();
        $sql->bind_result($id_usuario_cad, $id_grupo, $nome_user, $avatar_user, $status, $status_aprovado, $data_cadastro, $saq, $link);
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
                $Param['nome'] = decryptitem($nome_user);
                $Param['status'] = $status;
                $Param['link'] = $link;
                $Param['status_aprovado'] = $status_aprovado;
                $Param['saq'] = $saq == 1 ? 'Sim' : 'Não';
                $Param['data_cadastro'] = dataBR($data_cadastro);




                array_push($usuarios, $Param);
            }
        }

        $cabecalho = ['id_usuario','id_grupo','avatar_user', 'nome', 'status','link', 'status_aprovado','saq', 'data_cadastro'];

        fputcsv($arquivo, $cabecalho, ';');

        // Escrever o conteúdo no arquivo
        foreach($usuarios as $row_usuario){
            fputcsv($arquivo, $row_usuario, ';');
        }
        // Fechar arquivo
        fclose($arquivo);

    }

    
    public function updateAvatar($app_users_id, $avatar)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela`
        SET avatar='$avatar'
        WHERE id='$app_users_id'
        ");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Imagem de perfil atualizada"
        ];

        return $Param;
    }
    public function deleteCompras($id)
    {

        $sql_cadastro = $this->mysqli->prepare("DELETE FROM app_cotacao WHERE id='$id'");
        $sql_cadastro->execute();

        $linhas_afetadas = $sql_cadastro->affected_rows;

        if ($linhas_afetadas > 0) {
            $param = [
                "status" => "01",
                "msg" => "Item deletado"
            ];
        } else {
            $param = [
                "status" => "02",
                "msg" => "Falha ao deletar o cadastro"
            ];
        }

        return $param;
    }
    public function deleteCadastro($id)
    {

        $sql_cadastro = $this->mysqli->prepare("DELETE FROM app_users WHERE id='$id'");
        $sql_cadastro->execute();

        $linhas_afetadas = $sql_cadastro->affected_rows;

        if ($linhas_afetadas > 0) {
            $param = [
                "status" => "01",
                "msg" => "Cadastro deletado"
            ];
        } else {
            $param = [
                "status" => "02",
                "msg" => "Falha ao deletar o cadastro"
            ];
        }

        return $param;
    }
    public function aprovaCadastro($id)
    {

        $sql_cadastro = $this->mysqli->prepare("UPDATE app_users SET status_aprovado='1' WHERE id='$id'");
        $sql_cadastro->execute();

        $linhas_afetadas = $sql_cadastro->affected_rows;

        if ($linhas_afetadas > 0) {
            $param = [
                "status" => "01",
                "msg" => "Cadastro aprovado"
            ];
        } else {
            $param = [
                "status" => "02",
                "msg" => "Falha ao aprovado o cadastro"
            ];
        }

        return $param;
    }
    public function reprovaCadastro($id)
    {

        $sql_cadastro = $this->mysqli->prepare("UPDATE app_users SET status_aprovado='2' WHERE id='$id'");
        $sql_cadastro->execute();

        $linhas_afetadas = $sql_cadastro->affected_rows;

        if ($linhas_afetadas > 0) {
            $param = [
                "status" => "01",
                "msg" => "Cadastro reprovado"
            ];
        } else {
            $param = [
                "status" => "02",
                "msg" => "Falha ao reprovar o cadastro"
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
    
//     public function updatePlanos($id_usuario, $id_plano, $data_validade)
// {
//     // Verificar se o id_plano é diferente do que estava cadastrado antes
//     $sql_check_plano = $this->mysqli->prepare("
//         SELECT app_planos_id, data_validade
//         FROM app_users_planos
//         WHERE app_users_id = '$id_usuario'
//     ");
//     $sql_check_plano->execute();
//     $result = $sql_check_plano->get_result();
//     $row = $result->fetch_assoc();
//     $plano_anterior = $row['app_planos_id'];
//     $data_validade_anterior = $row['data_validade'];

//     if ($plano_anterior != $id_plano) {
//         // Obter os dias de validade do novo plano
//         $sql_get_dias = $this->mysqli->prepare("
//             SELECT validade_dias
//             FROM app_planos
//             WHERE id = '$id_plano'
//         ");
//         $sql_get_dias->execute();
//         $result_dias = $sql_get_dias->get_result();
//         $row_dias = $result_dias->fetch_assoc();
//         $validade_dias = $row_dias['validade_dias'];

//         // Somar os dias do novo plano à data atual
//         $data_validade = date('Y-m-d', strtotime("+ $validade_dias days"));
//     }

//     // Atualizar os dados no banco de dados
//     $sql_update = $this->mysqli->prepare("
//         UPDATE app_users_planos
//         SET app_planos_id = '$id_plano', data_validade = '$data_validade'
//         WHERE app_users_id = '$id_usuario'
//     ");
//     $sql_update->execute();

//     $Param = [
//         "status" => "01",
//         "msg" => "Plano atualizado."
//     ];

//     return $Param;
// }

public function updatePlanos($id_usuario, $id_plano, $data_validade)
{
    // Verificar se o id_plano é diferente do que estava cadastrado antes
    $sql_check_plano = $this->mysqli->prepare("
        SELECT app_planos_id, data_validade
        FROM app_users_planos
        WHERE app_users_id = ?
    ");
    $sql_check_plano->bind_param('s', $id_usuario);
    $sql_check_plano->execute();
    $result = $sql_check_plano->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        // Se não houver registro para o usuário, executar INSERT
        $sql_insert = $this->mysqli->prepare("
            INSERT INTO app_users_planos (app_users_id, app_planos_id, data_validade ,data_cadastro) VALUES (?, ?, ?, ?)
        ");
        $sql_insert->bind_param('ssss', $id_usuario, $id_plano, $data_validade, $this->data_atual);
        $sql_insert->execute();

        $param = [
            "status" => "01",
            "msg" => "Plano inserido."
        ];

        return $param;
    }

    $plano_anterior = $row['app_planos_id'];

    if ($plano_anterior != $id_plano) {
        // Obter os dias de validade do novo plano
        $sql_get_dias = $this->mysqli->prepare("
            SELECT validade_dias
            FROM app_planos
            WHERE id = ?
        ");
        $sql_get_dias->bind_param('s', $id_plano);
        $sql_get_dias->execute();
        $result_dias = $sql_get_dias->get_result();
        $row_dias = $result_dias->fetch_assoc();
        $validade_dias = $row_dias['validade_dias'];

        // Somar os dias do novo plano à data atual
        $data_validade = date('Y-m-d', strtotime("+ $validade_dias days"));
    }

    // Atualizar os dados no banco de dados
    $sql_update = $this->mysqli->prepare("
        UPDATE app_users_planos
        SET app_planos_id = ?, data_validade = ?
        WHERE app_users_id = ?
    ");
    $sql_update->bind_param('sss', $id_plano, $data_validade, $id_usuario);
    $sql_update->execute();

    $param = [
        "status" => "01",
        "msg" => "Plano atualizado."
    ];

    return $param;
} 

    public function planoUser($id)
{
    $sql = $this->mysqli->prepare("SELECT a.app_planos_id, a.data_cadastro, a.data_validade, b.validade_dias FROM app_users_planos
        AS a INNER JOIN app_planos AS b ON a.app_planos_id = b.id WHERE a.app_users_id='$id'");

    $sql->execute();
    $sql->bind_result($id_plano, $data_cadastro_plano, $data_validade_plano, $validade_dias);
    $sql->store_result();
    $rows = $sql->num_rows;

    $usuarios = [];

    if ($rows == 0) {
        $Param['rows'] = $rows;
        array_push($usuarios, $Param);
    } else {
        while ($row = $sql->fetch()) {
            $data_cadastro = new DateTime($data_cadastro_plano);
            $data_validade = new DateTime($data_validade_plano);

            $diferenca = $data_cadastro->diff($data_validade);
            $dias_totais = $validade_dias;
            $dias_restantes = $diferenca->days;

            $hoje = new DateTime();
            $dias_consumidos = $data_cadastro->diff($hoje)->days;

            if ($diferenca->days > $validade_dias) {
                $dias_totais = $diferenca->days;
            }

            $porcentagem_consumida = ($dias_totais - $dias_restantes) / $dias_totais * 100;

            $Param['id_plano'] = $id_plano;
            $Param['data_cadastro_plano'] = dataBR($data_cadastro_plano);
            $Param['data_validade_plano'] = $data_validade_plano;
            $Param['dias_restantes'] = $dias_restantes;
            // Verifica se $porcentagem_consumida é negativo
            if ($porcentagem_consumida < 0) {
                $porcentagem_consumida = 100; // Define como 100
            }
            $Param['porcentagem_consumida'] = $porcentagem_consumida;

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

    public function listAllCupons($id)
    {
     
        $sql = $this->mysqli->prepare("SELECT id, cod, tipo_desc, valor, data_in, data_out, status FROM app_cupons WHERE id_usuario='$id' ORDER BY id DESC");

        $sql->execute();
        $sql->bind_result($id, $cod, $tipo, $valor, $data_in, $data_out, $status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {


                $Param['id'] = $id;
                $Param['cod'] = $cod;
                $Param['tipo'] = $tipo;
                $Param['valor'] = moneyView($valor);
                $Param['porcentagem'] = intval($valor);
                $Param['data_in'] = dataBR($data_in);
                $Param['data_out'] = dataBR($data_out);
                $Param['status'] = $status;
              


                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }
    public function ListIdCupons($id)
    {
     
        $sql = $this->mysqli->prepare("SELECT id, cod, tipo_desc, valor, data_in, data_out, status FROM app_cupons WHERE id='$id'");

        $sql->execute();
        $sql->bind_result($id, $cod, $tipo, $valor, $data_in, $data_out, $status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {


                $Param['id'] = $id;
                $Param['cod'] = $cod;
                $Param['tipo'] = $tipo;
                $Param['valor'] = moneyView($valor);
                $Param['porcentagem'] = intval($valor);
                $Param['data_in'] = dataBR($data_in);
                $Param['data_out'] = dataBR($data_out);
                $Param['data_inUpdate'] = $data_in;
                $Param['data_outUpdate'] = $data_out;
                $Param['status'] = $status;
              


                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function ListIdDadosAprovados($id)
    {
     
        $sql = $this->mysqli->prepare("SELECT n_paciente, n_estudo, nome_visita FROM app_users WHERE id='$id'");

        $sql->execute();
        $sql->bind_result($n_paciente, $n_estudo, $nome_visita);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['n_paciente'] = $n_paciente;
                $Param['n_estudo'] = $n_estudo;
                $Param['nome_visita'] = $nome_visita;
               
                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function saveCupons($id_usuario, $tipo_desc, $valor, $data_in, $data_out){

        $sql_conflito = $this->mysqli->prepare("SELECT COUNT(*) FROM `app_cupons` WHERE (`id_usuario` = ?) AND ((`data_in` <= ? AND `data_out` >= ?) OR (`data_in` <= ? AND `data_out` >= ?))");
        $sql_conflito->bind_param("issss", $id_usuario, $data_in, $data_in, $data_out, $data_out);
        $sql_conflito->execute();
        $sql_conflito->bind_result($conflito_count);
        $sql_conflito->fetch();
        $sql_conflito->close();
        

        if ($conflito_count > 0) {
            $Param = [
                "status" => "02",
                "msg" => "Já existe um cupom cadastrado para este usuário dentro do intervalo de datas fornecido."
            ];
            return $Param;
        }
    
        do {

            $cod = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
    

            $sql_verificacao = $this->mysqli->prepare("SELECT COUNT(*) FROM `app_cupons` WHERE `cod` = ?");
            $sql_verificacao->bind_param("s", $cod);
            $sql_verificacao->execute();
            $sql_verificacao->bind_result($count);
            $sql_verificacao->fetch();
            $sql_verificacao->close();
        } while ($count > 0);

        $sql_cadastro = $this->mysqli->prepare("INSERT INTO `app_cupons`(`id_usuario`, `cod`, `tipo_desc`, `valor`, `data_in`, `data_out`, `status`)
            VALUES ('$id_usuario', '$cod', '$tipo_desc', '$valor','$data_in','$data_out', '1')");
    
        $sql_cadastro->execute();
    

        $Param = [
            "status" => "01",
            "msg" => "Cupom adicionado"
        ];
    
        return $Param;
    }

    public function saveEmpresa($nome,$link,$saq,$avatar){
        // print_r($avatar);exit;
   
        $sql_cadastro = $this->mysqli->prepare(
            "
        INSERT INTO `app_users`(`nome`, `link`, `saq`,`avatar`,`data_cadastro`,`status`,`status_aprovado`,`id_grupo`)
            VALUES ('$nome', '$link','$saq', '$avatar', '$this->data_atual', '1', '1','5')"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Empresa adicionada com sucesso."
        ];

        return $Param;
    }

    public function updateCupons($id_usuario, $id_cupom, $tipo_desc, $valor, $data_in, $data_out, $status){

        // Verifica conflitos de datas excluindo o próprio cupom sendo editado e considerando o ID do usuário
        $sql_conflito = $this->mysqli->prepare("SELECT COUNT(*) FROM `app_cupons` WHERE ((`id_usuario` = ?) AND ((`data_in` <= ? AND `data_out` >= ?) OR (`data_in` <= ? AND `data_out` >= ?))) AND id <> ?");
        $sql_conflito->bind_param("issssi", $id_usuario, $data_in, $data_in, $data_out, $data_out, $id_cupom);
        $sql_conflito->execute();
        $sql_conflito->bind_result($conflito_count);
        $sql_conflito->fetch();
        $sql_conflito->close();
        
        // Se houver conflitos de datas, retorne uma mensagem de erro
        if ($conflito_count > 0) {
            $Param = [
                "status" => "02",
                "msg" => "Já existe um cupom cadastrado para este usuário no intervalo de datas fornecido."
            ];
            return $Param;
        } else {

        $sql_cadastro = $this->mysqli->prepare("UPDATE `app_cupons`SET id_usuario='$id_usuario', tipo_desc='$tipo_desc', valor='$valor', data_in='$data_in', data_out='$data_out', status='$status' WHERE id='$id_cupom'");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cupom atualizado."
        ];

        return $Param;
    }
    }

    public function deleteCupom($id)
    {

        $sql_cadastro = $this->mysqli->prepare("DELETE FROM app_cupons WHERE id='$id'");
        $sql_cadastro->execute();
      
            $param = [
                "status" => "01",
                "msg" => "Cupom deletado"
            ];

        return $param;
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

    public function updateCadastro($id_usuario, $nome, $link, $saq, $status_aprovado)
    {
        $sql_cadastro = $this->mysqli->prepare("UPDATE app_users SET nome='$nome',link='$link',saq='$saq',status_aprovado='$status_aprovado' WHERE id='$id_usuario'");
        $sql_cadastro->execute();

            $Param = [
                "status" => "01",
                "msg" => "Cadastro atualizado",
            ];



        return $Param;
    }
    // public function updateEndereco($id_usuario, $cep, $estado, $cidade, $endereco, $bairro, $numero, $complemento)
    // {
    //     $sql_cadastro = $this->mysqli->prepare("UPDATE app_users_endereco SET cep='$cep',estado='$estado',cidade='$cidade',endereco='$endereco'
    //     ,bairro='$bairro',numero='$numero',complemento='$complemento' WHERE app_users_id='$id_usuario'");
    //     $sql_cadastro->execute();

    //         $Param = [
    //             "status" => "01",
    //             "msg" => "Endereço atualizado",
    //         ];



    //     return $Param;
    // }

    public function updateEndereco($id_usuario, $cep, $estado, $cidade, $endereco, $bairro, $numero, $complemento, $latitude, $longitude)
    {

    $sql_verifica = $this->mysqli->prepare("SELECT COUNT(*) FROM app_users_endereco WHERE app_users_id=?");
    $sql_verifica->bind_param("i", $id_usuario);
    $sql_verifica->execute();
    $result = $sql_verifica->get_result();
    $row = $result->fetch_assoc();
    

    if ($row['COUNT(*)'] == 0) {
        // $teste="INSERT INTO app_users_endereco (app_users_id, cep, estado, cidade, endereco, bairro, numero, complemento, latitude, longitude) 
        // VALUES ($id_usuario, $cep, $estado, $cidade, $endereco, $bairro, $numero, $complemento, $latitude, $longitude)";
        // print_r($teste);exit;
        $sql_cadastro = $this->mysqli->prepare("INSERT INTO app_users_endereco (app_users_id, cep, estado, cidade, endereco, bairro, numero, complemento, latitude, longitude) 
        VALUES ('$id_usuario', '$cep', '$estado', '$cidade', '$endereco', '$bairro', '$numero', '$complemento', '$latitude', '$longitude')");

        $sql_cadastro->execute();
    } else {

        $sql_cadastro = $this->mysqli->prepare("UPDATE app_users_endereco SET cep='$cep',estado='$estado',cidade='$cidade',endereco='$endereco'
        ,bairro='$bairro',numero='$numero',complemento='$complemento',latitude='$latitude',longitude='$longitude' WHERE app_users_id='$id_usuario'");
        $sql_cadastro->execute();
    }

    $Param = [
        "status" => "01",
        "msg" => "Endereço atualizado",
    ];

    return $Param;
    }

    
    
    public function EstatisticasGerais($id)
    {
        $sql = $this->mysqli->prepare("
            SELECT
                (SELECT COUNT(a.id) 
                 FROM app_cotacao AS a 
                 INNER JOIN app_users AS b ON a.app_users_id = b.id 
                 WHERE b.id = '$id') AS pedidos_qtd,
    
                (SELECT COUNT(a.id) 
                 FROM app_orcamentos AS a 
                 INNER JOIN app_users AS b ON a.app_users_id = b.id 
                 WHERE b.id = '$id' AND a.status = '1') AS vendas_qtd,
    
                (SELECT SUM(a.valor) 
                 FROM app_orcamentos AS a 
                 INNER JOIN app_users AS b ON a.app_users_id = b.id 
                 WHERE b.id = '$id' AND a.status = '1') AS vendas_total,
    
                (SELECT id_franqueador 
                 FROM app_users  WHERE id = '$id') AS id_franqueador
        ");

    
        $sql->execute();
        $sql->bind_result($pedidos_qtd, $vendas_qtd, $vendas_total, $id_franqueador);
        $sql->fetch();
        $sql->close();



        // $sql = $this->mysqli->prepare("
        //     SELECT avatar , nome FROM app_users  WHERE id = '$id_franqueador';
        // ");
        // $sql->execute();
        // $sql->bind_result($franqueador_avatar, $franqueador_nome);
        // $sql->fetch();
        // $sql->close();
    
        // Prepara o array de retorno
        $FornecedoresModel = [
            'pedidos_qtd' => $pedidos_qtd,
            'vendas_qtd' => $vendas_qtd,
            'vendas_total' => $vendas_total > 0? $vendas_total : 0,
            // 'id_franqueador' => $id_franqueador,
            // 'franqueador_avatar' => $franqueador_avatar,
            // 'franqueador_nome' => decryptitem($franqueador_nome)
        ];
    
        // Retorna o resultado como uma lista (array com um único elemento)
        return [$FornecedoresModel];
    }

    // public function EstatisticasGerais($id)
    // {
    //     $sql = $this->mysqli->prepare("SELECT COUNT(id) as total_anuncios,
    //     (SELECT COUNT(id) FROM app_pagamentos WHERE tipo = '1' AND status = 'approved' AND id_usuario='$id') as total_assinaturas,
    //     (SELECT COUNT(id) FROM app_pagamentos WHERE tipo = '2' AND status = 'approved' AND id_usuario='$id') as total_turbinar,
    //     (SELECT SUM(valor_total) FROM app_pagamentos WHERE tipo = '1' AND status = 'approved' AND id_usuario='$id') as valor_assinatura,
    //     (SELECT SUM(valor_total) FROM app_pagamentos WHERE tipo = '2' AND status = 'approved' AND id_usuario='$id') as valor_turbinar
    //     FROM app_anuncios WHERE id_usuario ='$id'");
    //     $sql->execute();
    //     $sql->bind_result($total_anuncios,$total_assinaturas,$total_turbinar,$valor_assinaturas,$valor_turbinar);
    //     $sql->fetch();
    //     $sql->close();

    //     $valor_turbinar = ($valor_turbinar === null) ? 0 : $valor_turbinar;
    //     $valor_assinaturas = ($valor_assinaturas === null) ? 0 : $valor_assinaturas;
    //     $ComprasModel['total_anuncios'] = $total_anuncios;
    //     $ComprasModel['total_assinaturas'] = $total_assinaturas;
    //     $ComprasModel['total_turbinar'] = $total_turbinar;
    //     $ComprasModel['valor_assinatura'] ='R$' . $valor_assinaturas;
    //     $ComprasModel['valor_turbinar'] ='R$' . $valor_turbinar;

        
    //     $lista[] = $ComprasModel;
    //     // print_r($lista);
    //     return $lista;
    //     }



     

           
           
    


}
