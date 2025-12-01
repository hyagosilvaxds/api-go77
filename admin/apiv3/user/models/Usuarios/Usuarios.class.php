<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once MODELS . '/Estados/Estados.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/phpMailer/Enviar.class.php';
require_once HELPERS . '/UsuariosHelper.class.php';


class Usuarios extends Conexao
{


    public function __construct()
    {
        $this->Conecta();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->helper = new UsuariosHelper();
        $this->tabela = "app_users";
    }



    public function save($tipo,$tipo_loja,$razao_social,$nome_fantasia,$nome, $cpf,$cnpj,$email, $celular,$password, $avatar,$data_cadastro, $status, $status_aprovado)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "
        INSERT INTO `app_users`(`tipo`, `tipo_loja`, `nome`, `nome_fantasia`, `razao_social`, `email`, `password`, `cpf`,`cnpj`,  `celular`, `avatar`, `data_cadastro`, `status`, `status_aprovado`)
            VALUES (
                '$tipo', '$tipo_loja', '$nome', '$nome_fantasia', '$razao_social', '$email', '$password', '$cpf', '$cnpj', '$celular', '$avatar',  '$data_cadastro',  '$status', '$status_aprovado'
            )"
        );

        $sql_cadastro->execute();
        $this->id_cadastro = $sql_cadastro->insert_id;

        $Param = [
            "status" => "01",
            "msg" => "Cadastro efetuado com sucesso, aguarde aprovação do administrador em até 48 horas",
            "id" => $this->id_cadastro,
            "nome" => decryptitem($nome),
            "email" => decryptitem($email),
            "avatar" => $avatar
        ];

        return $Param;
    }
    public function criahorarios($id) {

        for ($i=1; $i <= 7 ; $i++) {
            $sql = $this->mysqli->prepare("
            INSERT INTO `app_atendimento_day`
            (`app_users_id`, `day`, `status`)
            VALUES ('$id','$i', '1')"
            );
            $sql->execute();
        }
    }

    public function updateMenusCheck($id_grupo, $id_menu)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `app_users_grupos_permissoes` WHERE id_grupo='$id_grupo'"
        );

        $sql_limpa->execute();

        foreach ($id_menu as $item) {
            $sql_cadastro = $this->mysqli->prepare(
                "INSERT INTO `app_users_grupos_permissoes` (`id_grupo`, `id_menu`)
                VALUES ('$id_grupo', '$item')"
            );

            $sql_cadastro->execute();
        }

        $Param = [
            "status" => "01",
            "msg" => "Menus atualizados."
        ];

        return $Param;

    }

    public function findSaldo($id){

        $sql = $this->mysqli->prepare("SELECT saldo FROM app_users_saldo WHERE app_users_id='$id'");
        $sql->execute();
        $sql->bind_result($this->saldo);
        $sql->store_result();
        $sql->fetch();


        return $this->saldo;
    }

    public function updateSaldo($id, $saldo)
    {

        $sql_cadastro = $this->mysqli->prepare("UPDATE app_users_saldo SET saldo='$saldo' WHERE app_users_id='$id'");
        $sql_cadastro->execute();

        $Param['status'] = '01';
        $Param['msg'] = 'Reserva cancelada com sucesso, iremos analisar e fazer o reembolso se necessário.';

        return $Param;
    }

    public function gerarCSV() {
        // Abrir o arquivo de log (criar se não existir)
        $arquivo = fopen("uploads/planilhas/exportarUsuarios.csv", "w");

        $sql = $this->mysqli->prepare("
        SELECT nome, email, celular, data_nascimento, data_cadastro, status, status_aprovado FROM app_users WHERE id_grupo IN (1, 2, 3)");

        $sql->execute();
        $sql->bind_result($nome_user, $email_user, $celular, $data_nascimento, $data_cadastro, $status, $status_aprovado);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {


                $Param['nome'] = decryptitem($nome_user);
                $Param['email'] = decryptitem($email_user);
                $Param['celular'] = decryptitem($celular);
                $Param['data_nascimento'] = dataBR($data_nascimento);
                $Param['data_cadastro'] = dataBR($data_cadastro);
                $Param['status'] = $status;
                $Param['status_aprovado'] = $status_aprovado;


                array_push($usuarios, $Param);
            }
        }

        $cabecalho = ['nome', 'email', 'celular', 'data_nascimento', 'data_cadastro', 'status', 'status_aprovado'];

        fputcsv($arquivo, $cabecalho, ';');

        // Escrever o conteúdo no arquivo
        foreach($usuarios as $row_usuario){
            fputcsv($arquivo, $row_usuario, ';');
        }
        // Fechar arquivo
        fclose($arquivo);

    }

    public function saveMenuCheck($id_grupo, $id_menu){

        foreach ($id_menu as $item) {
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_users_grupos_permissoes` (`id_grupo`, `id_menu`)
            VALUES ('$id_grupo', '$item')"
        );

        $sql_cadastro->execute();
    }
        $Param = [
            "status" => "01",
            "msg" => "Menus salvos com sucesso.",
        ];

        return $Param;
    }

    public function saveApp($tipo, $nome, $email, $password, $celular, $avatar, $data_cadastro, $status, $status_aprovado,$data_nascimento,$cpf)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "
        INSERT INTO `app_users`(`tipo`, `nome`, `email`, `password`, `celular`, `avatar`, `data_cadastro`, `status`, `status_aprovado`,`data_nascimento`,`cpf`)
            VALUES (
                '$tipo', '$nome', '$email', '$password', '$celular', '$avatar', '$data_cadastro', '$status', '$status_aprovado','$data_nascimento','$cpf'
            )"
        );

        $sql_cadastro->execute();
        $this->id_cadastro = $sql_cadastro->insert_id;

        $sql_cadastro2 = $this->mysqli->prepare(
            "
        INSERT INTO `app_users_location`(`app_users_id`, `latitude`, `longitude`, `data`)
            VALUES (
                '$this->id_cadastro', '0', '0', '$this->data_atual'
            )"
        );

        $sql_cadastro2->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cadastro adicionado",
            "id" => $this->id_cadastro,
            "nome" => decryptitem($nome),
            "email" => decryptitem($email),
            "avatar" => $avatar
        ];

        return $Param;
    }
    public function saveLatLong($id_usuario, $lat, $long)
    {
        $sql_cadastro = $this->mysqli->prepare("UPDATE app_users_location SET latitude='$lat',longitude='$long',data='$this->data_atual' WHERE app_users_id='$id_usuario'");
        $sql_cadastro->execute();

            $Param = [
                "status" => "01",
                "msg" => "Localização atualizada",
            ];



        return $Param;
    }

    public function aprovarUsuario($id_usuario, $numero_paciente, $numero_estudo, $nome_visita)
    {
        $sql_cadastro = $this->mysqli->prepare("UPDATE app_users SET n_paciente='$numero_paciente',n_estudo='$numero_estudo',nome_visita='$nome_visita', status_aprovado='1' WHERE id='$id_usuario'");
        $sql_cadastro->execute();

            $Param = [
                "status" => "01",
                "msg" => "Usuário aprovado com sucesso.",
            ];



        return $Param;
    }
    public function saveSetor($nome)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "
        INSERT INTO `app_setores`(`nome`, `status`)
            VALUES (
                '$nome', '1'
            )"
        );

        $sql_cadastro->execute();
        $this->id_cadastro = $sql_cadastro->insert_id;

        $Param = [
            "status" => "01",
            "msg" => "Setor adicionado",
            "id" => $this->id_cadastro,
        ];

        return $Param;
    }

    public function favoritarApp($id_de, $id_para)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "
        INSERT INTO `app_favoritos`(`id_de`, `id_para`, `data`)
            VALUES (
                '$id_de', '$id_para', '$this->data_atual'
            )"
        );

        $sql_cadastro->execute();
        $this->id_cadastro = $sql_cadastro->insert_id;

        $Param = [
            "status" => "01",
            "msg" => "Favorito adicionado",
            "id" => $this->id_cadastro,
        ];

        return $Param;
    }

    public function desfavoritarApp($id_de, $id_para)
    {

        $sql_cadastro = $this->mysqli->prepare("DELETE FROM app_favoritos WHERE id_de='$id_de' AND id_para='$id_para'");
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Favorito removido",

        ];

        return $Param;
    }
    public function deleteVitrine($id_cliente)
    {

        $sql_cadastro = $this->mysqli->prepare("DELETE FROM app_users_imagens WHERE app_users_id='$id_cliente'");
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Vitrine removida",

        ];

        return $Param;
    }
    public function deleteSetor($id)
    {

        $sql_cadastro = $this->mysqli->prepare("DELETE FROM app_setores WHERE id='$id'");
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Setor removido",

        ];

        return $Param;
    }
    public function deleteUsuario($id_user)
    {

        $sql_cadastro = $this->mysqli->prepare("DELETE FROM app_users WHERE id='$id_user'");
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Usuário removido",

        ];

        return $Param;
    }

    public function desativarConta($id_user) {

        $sql_cadastro = $this->mysqli->prepare("UPDATE app_users SET status='2' WHERE id='$id_user'");
        $sql_cadastro->execute();

        return array("status"=>"01", "msg"=>"Conta desativada com sucesso.");
    }

    public function saveHorario($id_user, $day){

        $status = 1;

        $sql_cadastro = $this->mysqli->prepare(
            "
        INSERT INTO `app_filas`(`app_users_id`, `day`, `status`)
            VALUES ('$id_user', '$day', '$status')"
        );

        $sql_cadastro->execute();
        $this->id_cadastro = $sql_cadastro->insert_id;

        $Param = [
            "status" => "01",
            "msg" => "Horário adicionado",
            "id" => $this->id_cadastro
        ];

        return $Param;
    }
    public function saveVitrine($id_user, $url){

        // print_r($id_user);exit;
        $sql_cadastro = $this->mysqli->prepare(
            "
        INSERT INTO `app_users_imagens`(`app_users_id`, `tipo`, `url`,`data_cadastro`)
            VALUES ('$id_user', '1', '$url', '$this->data_atual')"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Vitrine adicionada"
        ];

        return $Param;
    }

    public function saveCardapio($id, $url){

        $sql = $this->mysqli->prepare("INSERT INTO `app_cardapios`(`app_users_id`, `url`, `data`) VALUES ('$id', '$url', '$this->data_atual')");
        $sql->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cardápio adicionado com sucesso."
        ];

        return $Param;
    }



    public function updatePerfil($id, $nome, $nome_fantasia, $razao_social, $celular, $email, $documento, $tipo_loja)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "UPDATE app_users SET nome='$nome', nome_fantasia='$nome_fantasia', razao_social='$razao_social', email='$email', cnpj='$documento', celular='$celular', tipo_loja='$tipo_loja'
            WHERE id='$id'"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cadastro alterado com sucesso.",
            "id" => $id
        ];

        return $Param;
    }
    public function updatePerfilApp($id, $nome, $data_nascimento, $celular, $email, $documento)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "UPDATE app_users SET nome='$nome', data_nascimento='$data_nascimento', email='$email', cpf='$documento', celular='$celular'
            WHERE id='$id'"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cadastro alterado com sucesso.",
            "id" => $id
        ];

        return $Param;
    }

    public function updateCardapio($id, $url)
    {

        $sql = $this->mysqli->prepare("UPDATE app_cardapios SET url='$url', data='$this->data_atual' WHERE app_users_id='$id'");
        $sql->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cardápio atualizado com sucesso.",
            "id" => $id
        ];

        return $Param;
    }

    public function saveCategorias($id_user, $id_categoria)
    {
        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_users_catg`(`app_users_id`, `app_categorias_id`)
            VALUES ('$id_user', '$id_categoria')"
        );
        $sql_cadastro->execute();

        $this->id_cadastro = $sql_cadastro->insert_id;

        $Param = [
            "status" => "01",
            "msg" => "Cadastro adicionado",
            "id" => $this->id_cadastro,
            "id_user" => $id_user,
            "id_categoria" => $id_categoria
        ];

        return $Param;
    }

    /*public function saveApp($tipo, $id_empresa, $tipo_barbeiro, $nome, $razao_social, $email, $password, $cnpj, $cpf, $telefone, $celular, $avatar, $data_nascimento, $data_cadastro, $u_login, $descricao, $qtd_trucks, $moip_id, $access_token, $perc_moip, $dest, $status, $status_aprovado, $customer_id)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "
        INSERT INTO `app_users`(`tipo`, `id_empresa`, `tipo_barbeiro`, `nome`, `razao_social`, `email`, `password`, `cnpj`, `cpf`, `telefone`, `celular`, `avatar`, `data_nascimento`, `data_cadastro`, `u_login`, `descricao`, `qtd_trucks`, `moip_id`, `access_token`, `perc_moip`, `dest`, `status`, `status_aprovado`, `costumer_id`)
            VALUES (
                '$tipo', '$id_empresa', '$tipo_barbeiro', '$nome', '$razao_social', '$email', '$password', '$cnpj', '$cpf', '$telefone', '$celular', '$avatar', '$data_nascimento', '$data_cadastro', '$u_login', '$descricao', '$qtd_trucks', '$moip_id', '$access_token', '$perc_moip', '$dest', '$status', '$status_aprovado', '$customer_id'
            )"
        );

        $sql_cadastro->execute();
        $this->id_cadastro = $sql_cadastro->insert_id;

        $Param = [
            "status" => "01",
            "msg" => "Cadastro adicionado",
            "id" => $this->id_cadastro,
            "nome" => $nome,
            "email" => $email,
            "avatar" => $avatar,
            "customer_id" => $customer_id
        ];

        return $Param;
    }*/

    public function savePaciente($tipo, $nome, $nome_responsavel, $email, $password, $razao_social, $documento, $telefone, $celular, $data_nascimento, $avatar, $data_cadastro, $u_login, $status, $status_aprovado, $destaque, $id_clinica, $id_vendedor)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "
            INSERT INTO `app_users`(`tipo`, `nome`, `nome_responsavel`, `email`, `password`, `razao_social`,
            `documento`, `telefone`, `celular`, `data_nascimento`, `avatar`, `data_cadastro`, `u_login`, `destaque`, `status`, `status_aprovado`, `id_clinica`, `id_vendedor`)
            VALUES (
                '$tipo', '$nome', '$nome_responsavel', '$email', '$password', '$razao_social', '$documento', '$telefone', '$celular',
                '$data_nascimento', '$avatar', '$data_cadastro', '$u_login', '$destaque', '$status', '$status_aprovado', '$id_clinica', '$id_vendedor'
            )"
        );

        $sql_cadastro->execute();
        $this->id_cadastro = $sql_cadastro->insert_id;

        $Param = [
            "status" => "01",
            "msg" => "Novo usuário adicionado com sucesso.",
            "id" => $this->id_cadastro,
            "nome" => $nome,
            "email" => $email,
            "avatar" => $avatar
        ];

        return $Param;
    }

    public function saveUsersInfo($id_user, $instagram, $facebook, $twitter, $site, $link)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "
            INSERT INTO `app_users_info`(`app_users_id`, `instagram`, `facebook`, `twitter`, `site`, `link`)
            VALUES ('$id_user', '$instagram', '$facebook', '$twitter', '$site', '$link')"
        );
        $sql_cadastro->execute();
        return array(
            "status" => "01",
            "msg" => "Redes sociais adicionadas."
        );
    }

    public function updateInfo($id_info, $instagram, $facebook, $twitter, $site, $link)
    {

        $sql_cadastro = $this->mysqli->prepare("UPDATE app_users_info SET instagram='$instagram', facebook='$facebook', twitter='$twitter', site='$site', link='$link' WHERE id='$id_info'");
        $sql_cadastro->execute();

        return array("status" => "01", "msg" => "Redes sociais atualizadas.");
    }

    public function saveFoto($id_user, $foto)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "
            INSERT INTO `app_users_fotos`(`app_users_id`, `url`, `data`)
            VALUES ('$id_user', '$foto', '$this->data_atual')"
        );
        $sql_cadastro->execute();

        return array(
            "status" => "01",
            "msg" => "Imagem adicionada."
        );
    }

    public function saveSubcategorias($id_user, $id_subcategoria)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "
            INSERT INTO `app_users_subcategorias`(`app_users_id`, `app_subcategorias_id`)
            VALUES ('$id_user', '$id_subcategoria')"
        );
        $sql_cadastro->execute();
    }

    public function avaliarApp($id_de, $id_para, $estrelas, $descricao)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "
            INSERT INTO `app_avaliacoes`(`id_de`, `id_para`, `estrelas`, `descricao`, `data`)
            VALUES ('$id_de', '$id_para', '$estrelas', '$descricao', '$this->data_atual')"
        );
        $sql_cadastro->execute();
        $result = array(
            "status" => "01",
            "msg" => "Avaliação cadastrada"
        );

        return $result;
    }

    public function listAvaliacoes($id)
    {


        $sql = $this->mysqli->prepare("
        SELECT a.id, a.estrelas, a.descricao, a.data, b.nome, b.avatar FROM app_avaliacoes as a
        LEFT JOIN app_users as b
        ON a.id_de = b.id
        WHERE a.id_para='$id'
        ");

        $sql->execute();
        $sql->bind_result($this->id, $this->estrelas, $this->descricao, $this->data, $this->nome, $this->avatar);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {


                $Param['id'] = $this->id;
                $Param['data'] = dataBR($this->data);
                $Param['estrelas'] = $this->estrelas;
                $Param['descricao'] = $this->descricao;
                $Param['nome'] = $this->nome;
                $Param['avatar'] = $this->avatar;
                $Param['rows'] = $rows;


                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }
    public function listAllChamados($status,$setor)
    {
        $filter = "WHERE a.id > 0 ";
        if(!empty($status)){$filter .= " AND  a.status = '$status'";}
        if(!empty($setor)){$filter .= " AND  a.app_setor_id = '$setor'";}
        $sql = $this->mysqli->prepare("
        SELECT a.id, a.app_users_id, a.app_setor_id, a.status, b.nome, c.nome
        FROM `app_chamado` AS a
        INNER JOIN `app_users` AS b ON a.app_users_id=b.id
        LEFT JOIN `app_setores` AS c ON a.app_setor_id=c.id
        $filter
        ORDER BY a.id DESC
        ");

        $sql->execute();
        $sql->bind_result($id, $id_usuario, $id_setor, $status, $nome_usuario, $nome_setor);
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
                $Param['id_setor'] = $id_setor;
                $Param['status'] = $status;
                $Param['nome_usuario'] = decryptitem($nome_usuario);
                $Param['nome_setor'] = $nome_setor;

                $Param['rows'] = $rows;
                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }
    public function listAllSetores()
    {


        $sql = $this->mysqli->prepare("
        SELECT id, nome , status FROM app_setores");

        $sql->execute();
        $sql->bind_result($id, $nome,$status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['nome'] = $nome;
                $Param['status'] = $status;
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function listPermissoes()
    {


        $sql = $this->mysqli->prepare("
        SELECT id, nome FROM app_users_grupos");

        $sql->execute();
        $sql->bind_result($id, $nome_grupo);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['nome_grupo'] = $nome_grupo;
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function verificaBtnAvaliar($id_de, $id_para){

        $sql_fila = $this->mysqli->prepare("SELECT * FROM app_filas_c WHERE id_de='$id_de' AND id_para='$id_para' AND status='2'");
        $sql_fila->execute();
        $sql_fila->store_result();
        $rows_fila = $sql_fila->num_rows;

        $sql_reserva = $this->mysqli->prepare("SELECT * FROM app_reservas WHERE id_de='$id_de' AND id_para='$id_para' AND status='1'");
        $sql_reserva->execute();
        $sql_reserva->store_result();
        $rows_reserva = $sql_reserva->num_rows;

        $usuarios = [];

        if (($rows_fila > 0) || ($rows_reserva > 0)) {
          $Param['status'] = "01";
          array_push($usuarios, $Param);
        }else{
          $Param['status'] = "02";
          array_push($usuarios, $Param);
        }

        return $usuarios;
    }

    public function deleteAllSubcategorias($id_user)
    {

        $sql_cadastro = $this->mysqli->prepare("DELETE FROM app_users_subcategorias WHERE app_users_id='$id_user'");
        $sql_cadastro->execute();
    }
    public function deleteChamado($id_chamado)
    {

        $sql_cadastro = $this->mysqli->prepare("DELETE FROM app_chamado WHERE id='$id_chamado'");
        $sql_cadastro->execute();

        $result = array(
            "status" => "01",
            "msg" => "Chamado removido"
        );

        return $result;
    }
    public function finalizarChamado($id_chamado)
    {

        $sql_cadastro = $this->mysqli->prepare("UPDATE `app_chamado` SET `status`='1' WHERE id='$id_chamado'");
        $sql_cadastro->execute();

        $result = array(
            "status" => "01",
            "msg" => "Chamado Finalizado"
        );

        return $result;
    }
    public function reabrirChamado($id_chamado)
    {

        $sql_cadastro = $this->mysqli->prepare("UPDATE `app_chamado` SET `status`='2' WHERE id='$id_chamado'");
        $sql_cadastro->execute();

        $result = array(
            "status" => "01",
            "msg" => "Chamado Aberto"
        );

        return $result;
    }

    public function delete($id_user)
    {

        $sql_cadastro = $this->mysqli->prepare("DELETE FROM app_users WHERE id='$id_user'");
        $sql_cadastro->execute();

        $result = array(
            "status" => "01",
            "msg" => "Usuário removido"
        );

        return $result;
    }

    public function update($id, $tipo_barbeiro, $nome, $razao_social, $email, $cnpj, $cpf, $telefone, $celular, $data_nascimento, $descricao, $perc_moip, $qtd_trucks)
    {

        // echo "UPDATE `$this->tabela`
        //   SET tipo_barbeiro='$tipo_barbeiro', nome='$nome', razao_social='$razao_social', email='$email', cnpj='$cnpj', cpf='$cpf', telefone='$telefone', celular='$celular',
        //   data_nascimento='$data_nascimento', descricao='$descricao'. perc_moip='$perc_moip'
        // WHERE id='$id'"; exit;

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela`
          SET tipo_barbeiro='$tipo_barbeiro', nome='$nome', razao_social='$razao_social', email='$email', cnpj='$cnpj', cpf='$cpf', telefone='$telefone', celular='$celular',
          data_nascimento='$data_nascimento', descricao='$descricao', perc_moip='$perc_moip', qtd_trucks='$qtd_trucks'
        WHERE id='$id'
        ");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cadastro atualizado"
        ];

        return $Param;
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
            "msg" => "Imagem atualizada"
        ];

        return $Param;
    }
    public function updateVitrine($app_users_id, $avatar)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_users_imagens`
        SET url='$avatar'
        WHERE app_users_id='$app_users_id'
        ");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Vitrine atualizada"
        ];

        return $Param;
    }

    public function updateApp($id_user, $nome, $email, $celular, $hash)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela`
        SET nome='$nome', email='$email', celular='$celular', password='$hash'
        WHERE id='$id_user'
        ");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Cadastro atualizado."
        ];

        return $Param;
    }


    // verificar pois não esta salvando certo a senha
    public function updatePassword($id, $password)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela`
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

    public function listid_franqueado($id)
    {

        // echo "SELECT id, nome, email, documento, data_nascimento, celular, avatar FROM `$this->tabela` WHERE id='$id'"; exit;

        $sql = $this->mysqli->prepare(
            "
          SELECT `id`, `tipo`, `id_empresa`, `tipo_barbeiro`, `nome`, `razao_social`, `email`, `cnpj`, `cpf`, `telefone`, `celular`, `avatar`, `data_nascimento`, `data_cadastro`, `u_login`,
          `descricao`, `qtd_trucks`, `moip_id`, `access_token`, `perc_moip`, `dest`, `status`, `status_aprovado`, `costumer_id`, `tipo_barbeiro`
          FROM `$this->tabela`
          WHERE id='$id'"
        );
        $sql->execute();
        $sql->bind_result(
            $this->id,
            $this->tipo,
            $this->id_empresa,
            $this->tipo_barbeiro,
            $this->nome,
            $this->razao_social,
            $this->email,
            $this->cnpj,
            $this->cpf,
            $this->telefone,
            $this->celular,
            $this->avatar,
            $this->data_nascimento,
            $this->data_cadastro,
            $this->u_login,
            $this->descricao,
            $this->qtd_trucks,
            $this->moip_id,
            $this->access_token,
            $this->perc_moip,
            $this->dest,
            $this->status,
            $this->status_aprovado,
            $this->customer_id,
            $this->tipo_barbeiro
        );
        $sql->fetch();

        $Param['id'] = $this->id;
        $Param['nome'] = ucwords($this->nome);
        $Param['email'] = $this->email;
        $Param['tipo'] = getNomeTipo($this->tipo);
        $Param['telefone'] = $this->telefone;
        $Param['celular'] = $this->celular;
        $Param['cpf'] = $this->cpf;
        $Param['cnpj'] = $this->cnpj;
        $Param['razao_social'] = $this->razao_social;
        $Param['data_nascimento'] = dataBR($this->data_nascimento);
        $Param['data_cadastro'] = dataBR($this->data_cadastro);
        $Param['u_login'] = dataBR($this->u_login) . ' - ' . horarioBR($this->u_login);
        $Param['avatar'] = $this->avatar;
        $Param['descricao'] = $this->descricao;
        $Param['qtd_trucks'] = $this->qtd_trucks;
        $Param['moip_id'] = $this->moip_id;
        $Param['access_token'] = $this->access_token;
        $Param['perc_moip'] = $this->perc_moip;
        $Param['customer_id'] = $this->customer_id;
        $Param['tipo_barbeiro'] = $this->tipo_barbeiro;

        return $Param;
    }

    public function listidchecks($id_grupo)
    {

        $sql = $this->mysqli->prepare("
        SELECT id, id_menu
        FROM `app_users_grupos_permissoes`
        WHERE id_grupo='$id_grupo'");

        $sql->execute();
        $sql->bind_result($id,$id_menu_permitido);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['id_menu_permitido'] = $id_menu_permitido;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }



    public function percentuais()
    {

        // echo "SELECT id, nome, email, documento, data_nascimento, celular, avatar FROM `$this->tabela` WHERE id='$id'"; exit;

        $sql = $this->mysqli->prepare("SELECT perc_barbeiro_chefe, perc_barbeiro FROM app_config");
        $sql->execute();
        $sql->bind_result($this->perc_barbeiro_chefe, $this->perc_barbeiro);
        $sql->fetch();

        $Param['perc_barbeiro_chefe'] = $this->perc_barbeiro_chefe;
        $Param['perc_barbeiro'] = $this->perc_barbeiro;

        return $Param;
    }

    public function listFavoritos($id_de)
    {

        // echo "SELECT id, nome, email, documento, data_nascimento, celular, avatar FROM `$this->tabela` WHERE id='$id'"; exit;

        $sql = $this->mysqli->prepare(
            "SELECT f.id, f.id_para, u.id, u.nome, u.nome_fantasia, u.razao_social, e.cep, e.uf, e.cidade, e.endereco, e.bairro, e.numero, e.complemento, e.latitude, e.longitude, u.email, u.documento, u.telefone, u.celular, u.avatar
            FROM app_favoritos as f
            INNER JOIN app_users as u ON f.id_para = u.id
            LEFT JOIN  app_users_enderecos as e ON u.id = e.app_users_id
            WHERE f.id_de='$id_de'
            "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->id_para, $this->id, $this->nome, $this->nome_fantasia, $this->razao_social, $this->cep, $this->uf, $this->cidade, $this->endereco, $this->bairro, $this->numero, $this->complemento, $this->lat_para, $this->lon_para, $this->email, $this->documento, $this->telefone, $this->celular, $this->avatar);
        $sql->store_result();
        $rows = $sql->num_rows;


        $sql2 = $this->mysqli->prepare(
            "SELECT latitude, longitude  FROM app_users_enderecos
        WHERE app_users_id='$id_de'
        "
        );
        $sql2->execute();
        $sql2->bind_result($this->lat_de, $this->lon_de);
        $sql2->store_result();
        $sql2->fetch();
        $sql2->close();

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id_para;
                $Param['nome'] = $this->nome;
                $Param['nome_fantasia'] = $this->nome_fantasia;
                $Param['razao_social'] = $this->razao_social;
                $Param['email'] = $this->email;
                $Param['documento'] = formataCpf($this->documento);
                $Param['cep'] = formataCep($this->cep);
                $Param['telefone'] = $this->telefone;
                $Param['celular'] = $this->celular;
                $Param['avatar'] = $this->avatar;
                $Param['uf'] = $this->uf;
                $Param['cidade'] = $this->cidade;
                $Param['endereco'] = $this->endereco;
                $Param['bairro'] = $this->bairro;
                $Param['numero'] = $this->numero;
                $Param['complemento'] = $this->complemento;
                $Param['avaliacao'] = $this->avaliacao($this->id);
                $Param['lat_de'] = $this->lat_de;
                $Param['lon_de'] = $this->lon_de;
                $Param['lat_para'] = $this->lat_para;
                $Param['lon_para'] = $this->lon_para;

                $Param['distancia'] = distLatLongDistancia($this->lat_de, $this->lon_de, $this->lat_para, $this->lon_para);
                $Param['duracao'] = distLatLongDuracao($this->lat_de, $this->lon_de, $this->lat_para, $this->lon_para);

                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }


    public function verificaFcmUser($id){

        $sql = $this->mysqli->prepare("SELECT id FROM app_fcm WHERE app_users_id='$id'");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;

        return $rows;
    }


    public function saveFcmUser($id_user, $type, $registration_id)
    {

        $sql = $this->mysqli->prepare("INSERT INTO app_fcm (app_users_id, type, registration_id) VALUES ('$id_user', '$type', '$registration_id')");
        $sql->execute();

        $Param['status'] = '01';
        $Param['msg'] = 'OK';

        return $Param;
    }
    public function geraLatLong($endereco, $numero, $nome_cidade)
    {
        $novo_endereco= geraLatLong($endereco, $numero, $nome_cidade);

        return $novo_endereco;
    }

    public function updateFcmUser($id_user, $type, $registration_id)
    {

        $sql_cadastro = $this->mysqli->prepare("UPDATE app_fcm SET type='$type', registration_id='$registration_id' WHERE app_users_id='$id_user'");
        $sql_cadastro->execute();

        $Param['status'] = '01';
        $Param['msg'] = 'OK';

        return $Param;
    }

    public function listBarbeiros($id_empresa)
    {

        $sql = $this->mysqli->prepare(
            "
        SELECT id, nome, celular, avatar, IF(status=1,'Ativo', 'Inativo'), cpf, email, IF(tipo_barbeiro=1,'BARBEIRO CHEFE', 'BARBEIRO'), tipo_barbeiro
        FROM `$this->tabela`
        WHERE id_empresa ='$id_empresa' and tipo = 3
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->celular, $this->avatar, $this->status, $this->documento, $this->email, $this->tipo_barbeiro, $this->tipo_barbeiro_int);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['nome'] = ucwords($this->nome);
                $Param['celular'] = $this->celular;
                $Param['avatar'] = $this->avatar;
                $Param['status'] = $this->status;
                $Param['documento'] = $this->documento;
                $Param['celular'] = $this->celular;
                $Param['email'] = $this->email;
                $Param['tipo_barbeiro'] = $this->tipo_barbeiro;
                $Param['tipo_barbeiro_int'] = $this->tipo_barbeiro_int;
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }


    public function listPacientes($id_vendedor)
    {

        $sql = $this->mysqli->prepare(
            "
        SELECT id, nome, celular, avatar, IF(status=1,'Ativo', 'Inativo'), documento, email
        FROM `$this->tabela`
        WHERE id_vendedor ='$id_vendedor' and tipo = 1
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->celular, $this->avatar, $this->status, $this->documento, $this->email);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['nome'] = ucwords($this->nome);
                $Param['celular'] = $this->celular;
                $Param['avatar'] = $this->avatar;
                $Param['status'] = $this->status;
                $Param['documento'] = $this->documento;
                $Param['celular'] = $this->celular;
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }


    public function listPacientesClinica($id_clinica)
    {

        $sql = $this->mysqli->prepare(
            "
        SELECT id, nome, celular, avatar, IF(status=1,'Ativo', 'Inativo'), documento, email
        FROM `$this->tabela`
        WHERE id_clinica ='$id_clinica' and tipo = 1
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->celular, $this->avatar, $this->status, $this->documento, $this->email);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['nome'] = ucwords($this->nome);
                $Param['celular'] = $this->celular;
                $Param['avatar'] = $this->avatar;
                $Param['status'] = $this->status;
                $Param['documento'] = $this->documento;
                $Param['celular'] = $this->celular;
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function listCategorias($clinica)
    {

        $sql = $this->mysqli->prepare(
            "
        SELECT id, nome
        FROM app_categorias
        WHERE status=1
        "
        );
        $sql->execute();
        $sql->bind_result($this->id_categ, $this->nome_categ);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id_categ;
                $Param['nome'] = $this->nome_categ;
                $Param['rows'] = $rows;
                $Param['subcategorias'] = $this->listSubcategorias($this->id_categ, $clinica);

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function isChecked($sub, $clinica)
    {

        $sql = $this->mysqli->prepare(
            "
        SELECT id
        FROM app_users_subcategorias
        WHERE app_users_id='$clinica' and app_subcategorias_id='$sub'
        "
        );
        $sql->execute();
        $sql->bind_result($this->id_cli_sub);
        $sql->store_result();
        $sql->fetch();

        if ($this->id_cli_sub != "") {
            return 'checked';
        } else {
            return '';
        }
    }

    public function verificaFavorito($id_de, $id_para)
    {

        $sql = $this->mysqli->prepare(
            "
        SELECT id
        FROM app_favoritos
        WHERE id_de='$id_de' and id_para='$id_para'
        "
        );
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->store_result();
        $sql->fetch();

        if ($this->id != "") {
            return '1';
        } else {
            return '2';
        }
    }

    public function buscarDados($id_de, $id_para)
    {

        $sql = $this->mysqli->prepare(
            "SELECT latitude, longitude  FROM app_users_enderecos
        WHERE app_users_id='$id_de'
        "
        );
        $sql->execute();
        $sql->bind_result($this->latDe, $this->lonDe);
        $sql->store_result();
        $sql->fetch();
        $sql->close();

        $sql2 = $this->mysqli->prepare(
            "SELECT latitude, longitude  FROM app_users_enderecos
        WHERE app_users_id='$id_para'
        "
        );
        $sql2->execute();
        $sql2->bind_result($this->latPara, $this->lonPara);
        $sql2->store_result();
        $sql2->fetch();



        $Param['latDe'] = $this->latDe;
        $Param['lonDe'] = $this->lonDe;
        $Param['latPara'] = $this->latPara;
        $Param['lonPara'] = $this->lonPara;

        array_push($Param);

        return $Param;
    }

    public function listSubcategorias($id_categoria, $clinica)
    {

        $sql = $this->mysqli->prepare(
            "
        SELECT id, nome
        FROM app_subcategorias
        WHERE status=1 and app_categorias_id='$id_categoria'
        "
        );
        $sql->execute();
        $sql->bind_result($this->id_subcateg, $this->nome_subcateg);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id_subcateg;
                $Param['nome'] = $this->nome_subcateg;
                $Param['checked'] = $this->isChecked($this->id_subcateg, $clinica);
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    //RESERVAS
    public function reservarApp($id_de, $id_para, $data, $horario, $obs, $status)
    {

        $helper = new UsuariosHelper();
        $check = $helper->checkReserva($id_de, $id_para, $data, $horario);

        if ($check > 0) {

            $result = array(
                "status" => "02",
                "msg" => "Já possui reserva nessa data e horário, tente outros dados."
            );
        } else {


            $sql_cadastro = $this->mysqli->prepare(
                "
              INSERT INTO `app_reservas`(`id_de`, `id_para`, `data`, `horario`, `obs`, `status`)
              VALUES ('$id_de', '$id_para', '$data', '$horario', '$obs', '$status')"
            );
            $sql_cadastro->execute();
            $result = array(
                "status" => "01",
                "msg" => "Reserve solicitada, aguarde uma resposta do estabelecimento."
            );
        }

        return $result;
    }

    public function listreservas($id_de, $id_para, $data_de, $data_ate)
    {

        if (!empty($id_de)) {
            $p = "id_para";
        } else {
            $p = "id_de";
        }

        $query = "
        SELECT a.id, a.data, a.horario, a.obs, a.status, b.nome, b.nome_fantasia, b.celular, b.email, b.avatar FROM app_reservas as a
        LEFT JOIN app_users as b
        ON a.$p = b.id
        WHERE ";

        if (!empty($id_de)) {
            $query .= "id_de='$id_de'";
        } else {
            $query .= "id_para='$id_para'";
        }
        if ((!empty($data_de)) && (!empty($data_ate))) {
            $query .= "AND data between '$data_de' and '$data_ate'";
        }

        $query .= "ORDER BY id DESC";

        $sql = $this->mysqli->prepare($query);

        $sql->execute();
        $sql->bind_result($this->id, $this->data, $this->horario, $this->obs, $this->status, $this->nome, $this->nome_fantasia, $this->celular, $this->email, $this->avatar);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                if (!empty($id_de)) {
                    $n = $this->nome_fantasia;
                } else {
                    $n = $this->nome;
                }

                $Param['id'] = $this->id;
                $Param['data'] = dataBR($this->data);
                $Param['horario'] = $this->horario;
                $Param['obs'] = $this->obs;
                $Param['status'] = $this->status;
                $Param['nome'] = $n;
                $Param['celular'] = $this->celular;
                $Param['email'] = $this->email;
                $Param['avatar'] = $this->avatar;
                $Param['rows'] = $rows;


                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function aceitereserva($id, $status)
    {


        $sql_cadastro = $this->mysqli->prepare("UPDATE `app_reservas` SET status='$status' WHERE id='$id'");
        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Reserva alterada com sucessso"
        ];

        return $Param;
    }

    public function buscaApp($id_de, $nome)
    {


        $sql = $this->mysqli->prepare(
            "SELECT `app_users`.`id`, `app_users`.`nome`, `app_users`.`nome_fantasia`, `app_users`.`razao_social`, `app_users_enderecos`.`cep`, `app_users_enderecos`.`uf`, `app_users_enderecos`.`cidade`, `app_users_enderecos`.`endereco`, `app_users_enderecos`.`bairro`, `app_users_enderecos`.`numero`, `app_users_enderecos`.`complemento`, `app_users_enderecos`.`latitude`, `app_users_enderecos`.`longitude`, `app_users`.`email`, `app_users`.`documento`, `app_users`.`telefone`, `app_users`.`celular`, `app_users`.`avatar`
        FROM `app_users`
        LEFT JOIN  `app_users_enderecos` ON `app_users`.`id` = `app_users_enderecos`.`app_users_id`
        WHERE (`app_users`.`nome` LIKE '%$nome%' OR `app_users`.`nome_fantasia` LIKE '%$nome%' OR `app_users`.`razao_social` LIKE '%$nome%') AND `app_users`.`tipo`=2 AND `app_users`.`status_aprovado` = 1 AND `app_users`.`status` = 1
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->nome_fantasia, $this->razao_social, $this->cep, $this->uf, $this->cidade, $this->endereco, $this->bairro, $this->numero, $this->complemento, $this->latPara, $this->LonPara, $this->email, $this->documento, $this->telefone, $this->celular, $this->avatar);
        $sql->store_result();
        $rows = $sql->num_rows;

        $sql2 = $this->mysqli->prepare(
            "SELECT latitude, longitude FROM `app_users_enderecos`
        WHERE app_users_id='$id_de'
        "
        );
        $sql2->execute();
        $sql2->bind_result($this->latDe, $this->lonDe);
        $sql2->store_result();
        $sql2->fetch();
        $sql2->close();

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['nome'] = $this->nome;
                $Param['nome_fantasia'] = $this->nome_fantasia;
                $Param['razao_social'] = $this->razao_social;
                $Param['email'] = $this->email;
                $Param['documento'] = formataCpf($this->documento);
                $Param['cep'] = formataCep($this->cep);
                $Param['telefone'] = $this->telefone;
                $Param['celular'] = $this->celular;
                $Param['avatar'] = $this->avatar;
                $Param['uf'] = $this->uf;
                $Param['cidade'] = $this->cidade;
                $Param['endereco'] = $this->endereco;
                $Param['bairro'] = $this->bairro;
                $Param['numero'] = $this->numero;
                $Param['complemento'] = $this->complemento;
                $Param['latDe'] = $this->latDe;
                $Param['lonDe'] = $this->lonDe;
                $Param['latPara'] = $this->latPara;
                $Param['LonPara'] = $this->LonPara;

                $Param['distancia'] = distLatLongDistancia($this->latDe, $this->lonDe, $this->latPara, $this->LonPara);
                $Param['duracao'] = distLatLongDuracao($this->latDe, $this->lonDe, $this->latPara, $this->LonPara);


                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function buscaCoordApp($lat_de, $lon_de, $nome, $id_de){



        $sql = $this->mysqli->prepare(
        "SELECT
        a.id, a.nome, a.nome_fantasia, a.razao_social, a.email, a.documento, a.telefone, a.celular, a.avatar,
        b.cep, b.uf, b.cidade, b.endereco, b.bairro, b.numero, b.complemento, b.latitude, b.longitude
        FROM app_users as a
        LEFT JOIN  app_users_enderecos as b
        ON a.id = b.app_users_id
        WHERE (a.nome LIKE '%$nome%' OR a.nome_fantasia LIKE '%$nome%' OR a.razao_social LIKE '%$nome%') AND a.tipo=2
        ORDER BY RAND()
        LIMIT 50
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->nome_fantasia, $this->razao_social, $this->email, $this->documento, $this->telefone, $this->celular, $this->avatar, $this->cep, $this->uf, $this->cidade, $this->endereco, $this->bairro, $this->numero, $this->complemento, $this->lat_para, $this->lon_para);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {


                  $Param['id'] = $this->id;
                  $Param['nome'] = $this->nome;
                  $Param['nome_fantasia'] = $this->nome_fantasia;
                  $Param['razao_social'] = $this->razao_social;
                  $Param['email'] = $this->email;
                  $Param['documento'] = formataCpf($this->documento);
                  $Param['cep'] = formataCep($this->cep);
                  $Param['telefone'] = $this->telefone;
                  $Param['celular'] = $this->celular;
                  $Param['avatar'] = $this->avatar;
                  $Param['uf'] = $this->uf;
                  $Param['cidade'] = $this->cidade;
                  $Param['endereco'] = $this->endereco;
                  $Param['bairro'] = $this->bairro;
                  $Param['numero'] = $this->numero;
                  $Param['complemento'] = $this->complemento;
                  $Param['avaliacao'] = $this->avaliacao($this->id);
                  $Param['lat_de'] = $lat_de;
                  $Param['lon_de'] = $lon_de;
                  $Param['lat_para'] = $this->lat_para;
                  $Param['lon_para'] = $this->lon_para;

                  $Param['distancia'] = distLatLongDistancia($lat_de, $lon_de, $this->lat_para, $this->lon_para);
                  //$Param['duracao'] = distLatLongDuracao($lat_de, $lon_de, $this->lat_para, $this->lon_para);
                  $Param['favorito'] = $this->verificaFavorito($id_de, $this->id);

                  $Param['rows'] = $rows;


                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function buscaCoordAppNome($nome)
    {


        $sql = $this->mysqli->prepare(
            "SELECT `app_users`.`id`, `app_users`.`nome`, `app_users`.`nome_fantasia`, `app_users`.`razao_social`, `app_users_enderecos`.`cep`, `app_users_enderecos`.`uf`, `app_users_enderecos`.`cidade`, `app_users_enderecos`.`endereco`, `app_users_enderecos`.`bairro`, `app_users_enderecos`.`numero`, `app_users_enderecos`.`complemento`, `app_users_enderecos`.`latitude`, `app_users_enderecos`.`longitude`, `app_users`.`email`, `app_users`.`documento`, `app_users`.`telefone`, `app_users`.`celular`, `app_users`.`avatar`
        FROM `app_users`
        LEFT JOIN  `app_users_enderecos` ON `app_users`.`id` = `app_users_enderecos`.`app_users_id`
        WHERE (`app_users`.`nome` LIKE '%$nome%' OR `app_users`.`nome_fantasia` LIKE '%$nome%' OR `app_users`.`razao_social` LIKE '%$nome%') AND `app_users`.`tipo`=2
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->nome_fantasia, $this->razao_social, $this->cep, $this->uf, $this->cidade, $this->endereco, $this->bairro, $this->numero, $this->complemento, $this->lat_para, $this->lon_para, $this->email, $this->documento, $this->telefone, $this->celular, $this->avatar);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['nome'] = $this->nome;
                $Param['nome_fantasia'] = $this->nome_fantasia;
                $Param['razao_social'] = $this->razao_social;
                $Param['email'] = $this->email;
                $Param['documento'] = formataCpf($this->documento);
                $Param['cep'] = formataCep($this->cep);
                $Param['telefone'] = $this->telefone;
                $Param['celular'] = $this->celular;
                $Param['avatar'] = $this->avatar;
                $Param['uf'] = $this->uf;
                $Param['cidade'] = $this->cidade;
                $Param['endereco'] = $this->endereco;
                $Param['bairro'] = $this->bairro;
                $Param['numero'] = $this->numero;
                $Param['complemento'] = $this->complemento;
                $Param['avaliacao'] = $this->avaliacao($this->id);
                //$Param['lat_para'] = $this->lat_para;
                // $Param['lon_para'] = $this->lon_para;

                //$Param['distancia'] = distLatLongDistancia($lat_de, $lon_de, $this->lat_para, $this->lon_para);
                // $Param['duracao'] = distLatLongDuracao($lat_de, $lon_de, $this->lat_para, $this->lon_para);


                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }


    public function avaliacao($id)
    {


        $sql = $this->mysqli->prepare("SELECT sum(estrelas), count(estrelas) FROM app_avaliacoes WHERE id_para='$id'");
        $sql->execute();
        $sql->bind_result($this->soma, $this->quantidade);
        $sql->fetch();


        if ($this->quantidade == 0) {
            $nota = "Sem avaliação";
        } else {
            $nota = number_format(($this->soma / $this->quantidade), 2);
        }

        return $nota;
    }

    public function destApp($lat_de, $lon_de, $id_de)
    {

        $sql = $this->mysqli->prepare(
            "SELECT `app_users`.`id`, `app_users`.`nome`, `app_users`.`nome_fantasia`, `app_users`.`razao_social`, `app_users_enderecos`.`latitude`, `app_users_enderecos`.`longitude`, `app_users`.`email`, `app_users`.`documento`, `app_users_enderecos`.`cep`, `app_users_enderecos`.`uf`, `app_users_enderecos`.`cidade`, `app_users_enderecos`.`endereco`, `app_users_enderecos`.`bairro`, `app_users_enderecos`.`numero`, `app_users_enderecos`.`complemento`, `app_users`.`telefone`, `app_users`.`celular`, `app_users`.`avatar`
        FROM `app_users`
        LEFT JOIN `app_users_enderecos` ON `app_users`.`id` = `app_users_enderecos`.`app_users_id`
        WHERE `app_users`.`dest`=1 AND `app_users`.`tipo`=2 AND `app_users`.`status_aprovado` = 1 AND `app_users`.`status` = 1
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->nome_fantasia, $this->razao_social, $this->latPara, $this->lonPara, $this->email, $this->documento, $this->cep, $this->uf, $this->cidade, $this->endereco, $this->bairro, $this->numero, $this->complemento, $this->telefone, $this->celular, $this->avatar);
        $sql->store_result();
        $rows = $sql->num_rows;

        /*
        $sql2 = $this->mysqli->prepare(
            "SELECT latitude, longitude  FROM app_users_enderecos
        WHERE app_users_id='$id_de'
        "
        );
        $sql2->execute();
        $sql2->bind_result($this->latDe, $this->lonDe);
        $sql2->store_result();
        $sql2->fetch();
        $sql2->close();
*/

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['nome'] = $this->nome;
                $Param['nome_fantasia'] = $this->nome_fantasia;
                $Param['razao_social'] = $this->razao_social;
                $Param['email'] = $this->email;
                $Param['documento'] = formataCpf($this->documento);
                $Param['cep'] = formataCep($this->cep);
                $Param['telefone'] = $this->telefone;
                $Param['celular'] = $this->celular;
                $Param['avatar'] = $this->avatar;
                $Param['uf'] = $this->uf;
                $Param['cidade'] = $this->cidade;
                $Param['endereco'] = $this->endereco;
                $Param['bairro'] = $this->bairro;
                $Param['numero'] = $this->numero;
                $Param['complemento'] = $this->complemento;
                $Param['avaliacao'] = $this->avaliacao($this->id);
                $Param['lat_de'] = $lat_de;
                $Param['lon_de'] = $lon_de;
                $Param['lat_para'] = $this->latPara;
                $Param['lon_para'] = $this->lonPara;

                $Param['distancia'] = distLatLongDistancia($lat_de, $lon_de, $this->latPara, $this->lonPara);
                $Param['duracao'] = distLatLongDuracao($lat_de, $lon_de, $this->latPara, $this->lonPara);
                $Param['favorito'] = $this->verificaFavorito($id_de, $this->id);
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function destApp2()
    {

        $sql = $this->mysqli->prepare(
            "SELECT `app_users`.`id`, `app_users`.`nome`, `app_users`.`nome_fantasia`, `app_users`.`razao_social`, `app_users_enderecos`.`latitude`, `app_users_enderecos`.`longitude`, `app_users`.`email`, `app_users`.`documento`, `app_users_enderecos`.`cep`, `app_users_enderecos`.`uf`, `app_users_enderecos`.`cidade`, `app_users_enderecos`.`endereco`, `app_users_enderecos`.`bairro`, `app_users_enderecos`.`numero`, `app_users_enderecos`.`complemento`, `app_users`.`telefone`, `app_users`.`celular`, `app_users`.`avatar`
        FROM `app_users`
        LEFT JOIN `app_users_enderecos` ON `app_users`.`id` = `app_users_enderecos`.`app_users_id`
        WHERE `app_users`.`dest`=1 AND `app_users`.`tipo`=2
        "
        );
        $sql->execute();
      $sql->bind_result($this->id, $this->nome, $this->nome_fantasia, $this->razao_social, $this->latPara, $this->lonPara, $this->email, $this->documento, $this->cep, $this->uf, $this->cidade, $this->endereco, $this->bairro, $this->numero, $this->complemento, $this->telefone, $this->celular, $this->avatar);
        $sql->store_result();
        $rows = $sql->num_rows;

        /*
        $sql2 = $this->mysqli->prepare(
            "SELECT latitude, longitude  FROM app_users_enderecos
        WHERE app_users_id='$id_de'
        "
        );
        $sql2->execute();
        $sql2->bind_result($this->latDe, $this->lonDe);
        $sql2->store_result();
        $sql2->fetch();
        $sql2->close();
*/

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

              $Param['id'] = $this->id;
              $Param['nome'] = $this->nome;
              $Param['nome_fantasia'] = $this->nome_fantasia;
              $Param['razao_social'] = $this->razao_social;
              $Param['email'] = $this->email;
              $Param['documento'] = formataCpf($this->documento);
              $Param['cep'] = formataCep($this->cep);
              $Param['telefone'] = $this->telefone;
              $Param['celular'] = $this->celular;
              $Param['avatar'] = $this->avatar;
              $Param['uf'] = $this->uf;
              $Param['cidade'] = $this->cidade;
              $Param['endereco'] = $this->endereco;
              $Param['bairro'] = $this->bairro;
              $Param['numero'] = $this->numero;
              $Param['complemento'] = $this->complemento;
              $Param['avaliacao'] = $this->avaliacao($this->id);
              $Param['lat_para'] = $this->latPara;
              $Param['lon_para'] = $this->lonPara;
                //$Param['distancia'] = distLatLongDistancia($lat_de, $lon_de, $this->latPara, $this->lonPara);
                //$Param['duracao'] = distLatLongDuracao($lat_de, $lon_de, $this->latPara, $this->lonPara);

                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function listEstabCateg($id_de, $id_categoria)
    {

        $sql = $this->mysqli->prepare(
            "SELECT DISTINCT `app_users`.`id`, `app_users`.`nome`, `app_users`.`nome_fantasia`, `app_users`.`razao_social`, `app_users_enderecos`.`latitude`, `app_users_enderecos`.`longitude`, `app_users_catg`.`app_categorias_id`, `app_categorias`.`nome`,  `app_users_enderecos`.`cep`, `app_users_enderecos`.`uf`, `app_users_enderecos`.`cidade`, `app_users_enderecos`.`endereco`, `app_users_enderecos`.`bairro`, `app_users_enderecos`.`numero`, `app_users_enderecos`.`complemento`, `app_users`.`telefone`, `app_users`.`celular`, `app_users`.`avatar`, `app_users`.`email`, `app_users`.`documento`
        FROM `app_users`
        LEFT JOIN `app_users_enderecos` ON `app_users`.`id` = `app_users_enderecos`.`app_users_id`
        LEFT JOIN `app_users_catg` ON `app_users`.`id` = `app_users_catg`.`app_users_id`
        LEFT JOIN `app_categorias` ON `app_users_catg`.`app_categorias_id` = `app_categorias`.`id`
        WHERE `app_users`.`tipo`=2 AND `app_users_catg`.`app_categorias_id` = $id_categoria
        ORDER BY RAND()
        LIMIT 20
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->nome_fantasia, $this->razao_social, $this->latPara, $this->lonPara, $this->categoria_id, $this->nome_categoria, $this->cep, $this->uf, $this->cidade, $this->endereco, $this->bairro, $this->numero, $this->complemento, $this->telefone, $this->celular, $this->avatar, $this->email, $this->documento);
        $sql->store_result();
        $rows = $sql->num_rows;


        $sql2 = $this->mysqli->prepare(
            "SELECT latitude, longitude  FROM app_users_enderecos
        WHERE app_users_id='$id_de'
        "
        );
        $sql2->execute();
        $sql2->bind_result($this->latDe, $this->lonDe);
        $sql2->store_result();
        $sql2->fetch();
        $sql2->close();

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['nome'] = $this->nome;
                $Param['nome_fantasia'] = $this->nome_fantasia;
                $Param['razao_social'] = $this->razao_social;
                $Param['email'] = $this->email;
                $Param['documento'] = formataCpf($this->documento);
                $Param['categoria_id'] = $this->categoria_id;
                $Param['nome_categoria'] = $this->nome_categoria;
                $Param['lat_de'] = $this->latDe;
                $Param['lon_de'] = $this->lonDe;
                $Param['lat_para'] = $this->latPara;
                $Param['lon_para'] = $this->lonPara;
                $Param['cep'] = formataCep($this->cep);
                $Param['telefone'] = $this->telefone;
                $Param['celular'] = $this->celular;
                $Param['avatar'] = $this->avatar;
                $Param['uf'] = $this->uf;
                $Param['cidade'] = $this->cidade;
                $Param['endereco'] = $this->endereco;
                $Param['bairro'] = $this->bairro;
                $Param['numero'] = $this->numero;
                $Param['complemento'] = $this->complemento;
                $Param['avaliacao'] = $this->avaliacao($this->id);
                $Param['distancia'] = distLatLongDistancia($this->latDe, $this->lonDe, $this->latPara, $this->lonPara);
                $Param['duracao'] = distLatLongDuracao($this->latDe, $this->lonDe, $this->latPara, $this->lonPara);
                $Param['favorito'] = $this->verificaFavorito($id_de, $this->id);
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function listEstabCateg2($id_categoria)
    {

        $sql = $this->mysqli->prepare(
            "SELECT `app_users`.`id`, `app_users`.`nome`, `app_users`.`nome_fantasia`, `app_users`.`razao_social`, `app_users_enderecos`.`latitude`, `app_users_enderecos`.`longitude`, `app_users_catg`.`app_categorias_id`, `app_categorias`.`nome`, `app_users_enderecos`.`cep`, `app_users_enderecos`.`uf`, `app_users_enderecos`.`cidade`, `app_users_enderecos`.`endereco`, `app_users_enderecos`.`bairro`, `app_users_enderecos`.`numero`, `app_users_enderecos`.`complemento`, `app_users`.`telefone`, `app_users`.`celular`, `app_users`.`avatar`, `app_users`.`email`, `app_users`.`documento`
        FROM `app_users`
        LEFT JOIN `app_users_enderecos` ON `app_users`.`id` = `app_users_enderecos`.`app_users_id`
        LEFT JOIN `app_users_catg` ON `app_users`.`id` = `app_users_catg`.`app_users_id`
        LEFT JOIN `app_categorias` ON `app_users_catg`.`app_categorias_id` = `app_categorias`.`id`
        WHERE `app_users`.`tipo`=2 AND `app_users_catg`.`app_categorias_id` = $id_categoria
        ORDER BY RAND()
        LIMIT 20
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->nome_fantasia, $this->razao_social, $this->latPara, $this->lonPara, $this->categoria_id, $this->nome_categoria, $this->cep, $this->uf, $this->cidade, $this->endereco, $this->bairro, $this->numero, $this->complemento, $this->telefone, $this->celular, $this->avatar, $this->email, $this->documento);
        $sql->store_result();
        $rows = $sql->num_rows;

        /*
        $sql2 = $this->mysqli->prepare(
            "SELECT latitude, longitude  FROM app_users_enderecos
        WHERE app_users_id='$id_de'
        "
        );
        $sql2->execute();
        $sql2->bind_result($this->latDe, $this->lonDe);
        $sql2->store_result();
        $sql2->fetch();
        $sql2->close();
*/

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['nome'] = $this->nome;
                $Param['nome_fantasia'] = $this->nome_fantasia;
                $Param['razao_social'] = $this->razao_social;
                $Param['email'] = $this->email;
                $Param['documento'] = formataCpf($this->documento);
                $Param['categoria_id'] = $this->categoria_id;
                $Param['nome_categoria'] = $this->nome_categoria;
                $Param['cep'] = formataCep($this->cep);
                $Param['telefone'] = $this->telefone;
                $Param['celular'] = $this->celular;
                $Param['avatar'] = $this->avatar;
                $Param['uf'] = $this->uf;
                $Param['cidade'] = $this->cidade;
                $Param['endereco'] = $this->endereco;
                $Param['bairro'] = $this->bairro;
                $Param['numero'] = $this->numero;
                $Param['complemento'] = $this->complemento;
                $Param['avaliacao'] = $this->avaliacao($this->id);
                //$Param['latDe'] = $this->latDe;
                //$Param['lonDe'] = $this->lonDe;
                //$Param['latPara'] = $this->latPara;
                //$Param['lonPara'] = $this->lonPara;

                //$Param['distancia'] = distLatLongDistancia($this->latDe, $this->lonDe, $this->latPara, $this->lonPara);
                //$Param['duracao'] = distLatLongDuracao($this->latDe, $this->lonDe, $this->latPara, $this->lonPara);

                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    // public function loginFace(){


    //     $this->email = $_POST['email'];
    //     $this->nome = $_POST['nome'];
    //     $this->avatar = renameUpload(basename($_FILES['avatar']['name']));
    //     $this->avatar_tmp = $_FILES['avatar']['tmp_name'];
    //     $this->id_categoria = $_POST['id_categoria'];
    //     $this->latitude = $_POST['latitude'];
    //     $this->longitude = $_POST['longitude'];
    //     $this->tipo = 1;

    //     $equalsResult = $this->dao->equalsEmail($this->email);

    //     if($equalsResult['id'] != "") {
    //         $equalsResult['msg'] = "Login efetuado com sucesso.";
    //         $this->CadastrosArray[] = $equalsResult;
    //     }
    //     else {

    //             if(!empty($this->avatar)) {

    //                 $this->avatar_final = $this->avatar;
    //                 move_uploaded_file($this->avatar_tmp, $this->pasta . "/" . $this->avatar_final);

    //             }
    //             else{
    //                 $this->avatar_final = "avatarm.png";
    //             }

    //             $enderecoCompleto = geraEndCompleto($this->latitude, $this->longitude);
    //             $estados = new Estados();
    //             // [0] => RS
    //             // [1] => Porto Alegre
    //             // [2] => Protásio Alves
    //             // [3] => Av. Protásio Alves
    //             // [4] => 91310
    //             $this->estado = $enderecoCompleto[0];
    //             $this->cidade = $enderecoCompleto[1];
    //             $this->bairro = $enderecoCompleto[2];
    //             $this->endereco = $enderecoCompleto[3];
    //             $this->cep = $enderecoCompleto[4];


    //             $estados->RetornaID($this->estado, $this->cidade);


    //             $resultSave = $this->dao->save($this->nome, $this->email, $this->documento=null, $this->data_nascimento=null, $this->password=null,
    //                                         $this->tipo, $this->id_categoria, $this->latitude,
    //                                         $this->longitude, $this->avatar, $this->status=1, $this->celular=null, $estados->id_estado,
    //                                         $estados->id_cidade, $this->endereco, $this->bairro, $this->cep, $this->numero=0, $this->complemento=0
    //                                         );
    //             $resultSave['msg'] = "Login efetuado com sucesso.";

    //             $this->CadastrosArray[] = $resultSave;

    //     }
    //     $json = json_encode($this->CadastrosArray);
    //     echo $json;

    // }









    public function recuperarsenha($email)
    {

        //VERIFICA SE JÁ EXISTE E-MAIL
        $sql = $this->mysqli->prepare("SELECT * FROM `$this->tabela` WHERE email='$email'");
        $sql->execute();
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();

        // print_r($rows);exit;

        if ($rows > 0) {

            $this->token = geraToken(rand(5, 15), rand(100, 500), rand(6000, 10000));

            $sql = $this->mysqli->prepare("UPDATE `$this->tabela` SET token_senha = ? WHERE email = ?");
            $sql->bind_param('ss', $this->token, $email);
            $sql->execute();

            //ENVIA E-MAIL RECUPERACAO DE SENHA
            $mail = new EnviarEmail();
            $mail->recuperarsenha(decryptitem($this->nome), decryptitem($email), $this->token);

            $Param['status'] = '01';
            $Param['msg'] = 'As instruções para alteração de senha foram enviadas para o seu e-mail.';
            $lista[] = $Param;

            $json = json_encode($lista);
            echo $json;
        }
        if ($rows == 0) {
            $Param['status'] = '02';
            $Param['msg'] = 'Não encontramos o seu e-mail em nosso cadastro, por favor, tente outros dados';
            $lista[] = $Param;
            $json = json_encode($lista);
            echo $json;
        }
    }


    public function updatepasswordtoken($password, $token)
    {

        $this->custo = '08';
        $this->salt = geraSalt(22);

        // Gera um hash baseado em bcrypt
        $this->hash = crypt($password, '$2a$' . $this->custo . '$' . $this->salt . '$');

        $sql = $this->mysqli->prepare("UPDATE `$this->tabela` SET password = ? WHERE token_senha = ? ");
        $sql->bind_param('ss', $this->hash, $token);
        $sql->execute();

        $lista = array();

        if ($sql->affected_rows) {

            $Param['status'] = '01';
            $Param['msg'] = 'Senha alterada com sucesso!';
            $lista[] = $Param;
            $json = json_encode($lista);
            echo $json;
        } else {
            $Param['status'] = '02';
            $Param['msg'] = 'Erro ao alterar senha, tente novamente!';
            $lista[] = $Param;
            $json = json_encode($lista);
            echo $json;
        }
    }


    public function verificatoken($token)
    {

        // echo "SELECT * FROM `$this->tabela` WHERE token_senha='$token'"; exit;

        //VERIFICA SE JÁ EXISTE E-MAIL
        $sql = $this->mysqli->prepare("SELECT * FROM `$this->tabela` WHERE token_senha='$token'");
        $sql->execute();
        $sql->store_result();
        $rows = $sql->num_rows;

        if ($rows > 0) {

            $Param['status'] = '01';
            $Param['msg'] = 'Token OK';
            $lista[] = $Param;

            $json = json_encode($lista);
            echo $json;
        }
        if ($rows == 0) {
            $Param['status'] = '02';
            $Param['msg'] = 'Token Inexistente';
            $lista[] = $Param;
            $json = json_encode($lista);
            echo $json;
        }
    }
    public function Notificacoes($id){


        $sql = $this->mysqli->prepare("
        SELECT id, titulo, descricao, data FROM app_notificacoes
        WHERE id_user='0' OR id_user='$id'
        ORDER BY id DESC
        ");
        $sql->execute();
        $sql->bind_result($this->id, $this->titulo, $this->descricao, $this->data);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['titulo'] = $this->titulo;
                $Param['descricao'] = $this->descricao;
                $Param['data'] = dataBR($this->data) . " - " . horarioBR($this->data);
                $Param['rows'] = $rows;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function listNotificacoes() {

        $sql = $this->mysqli->query("
        SELECT id, titulo, descricao, DATE_FORMAT(data, '%d/%m/%Y') as data
        FROM app_notificacoes
        order by data DESC
        ");

        $itens = $sql->fetch_all(MYSQLI_ASSOC);

        $itens = (count($itens)>0) ? $itens : (array(array("rows"=>0)));

        return $itens;
    }

    public function listCardapio($id)
    {


        //VERIFICA SE JÁ EXISTE CARDAPIO
        $sql = $this->mysqli->prepare("SELECT url FROM `app_cardapios` WHERE app_users_id='$id'");
        $sql->execute();
        $sql->bind_result($this->url);
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();

        if ($rows > 0) {

            $Param['rows'] = $rows;
            $Param['url'] = $this->url;
            $lista[] = $Param;

            return $lista;
        }
        if ($rows == 0) {
            $Param['rows'] = $rows;
            $lista[] = $Param;

            return $lista;
        }
    }





    //     public function updatepassword() {

    //         $this->secure->tokens_secure($this->input->token);

    //         $result = $this->dao->updatePassword($this->input->password, $this->input->id);

    //         $resultArray[] = $result;
    //         $json = json_encode($resultArray);
    //         echo $json;

    //     }

    public function saveFcm()
    {

        $this->secure->tokens_secure($this->input->token);

        $result = $this->dao->saveFcm($this->input->id, $this->input->type, $this->input->fcm);
        $json = json_encode($result);
        echo $json;
    }

    public function listAllClientes($id_estabelecimento,$nome_cliente,$email_cliente)
    {
        $filter = "WHERE app_users_id='$id_estabelecimento'";
        if(!empty($nome_cliente)){$filter .= "AND nome LIKE '%$nome_cliente%'";}
        if(!empty($email_cliente)){$filter .= "AND email LIKE '%$email_cliente%'";}

        $sql = $this->mysqli->prepare("
        SELECT id, tipo, nome, email, celular, data_nascimento,cep,estado,cidade,endereco,bairro,numero,complemento,data_cadastro,status
        FROM app_clientes
        $filter
        ");

        $sql->execute();
        $sql->bind_result($this->id, $this->tipo, $this->nome, $this->email, $this->celular, $this->data_nascimento,$this->cep,$this->estado,
        $this->cidade,$this->endereco,$this->bairro,$this->numero,$this->complemento,$this->data_cadastro,$this->status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {


                $Param['id'] = $this->id;
                $Param['tipo'] = $this->tipo;
                $Param['nome'] = $this->nome;
                $Param['email'] = $this->email;
                $Param['celular'] = $this->celular;
                $Param['data_nascimento'] = dataBR($this->data_nascimento);
                $Param['cep'] = $this->cep;
                $Param['estado'] = $this->estado;
                $Param['cidade'] = $this->cidade;
                $Param['endereco'] = $this->endereco;
                $Param['bairro'] = $this->bairro;
                $Param['numero'] = $this->numero;
                $Param['complemento'] = $this->complemento;
                $Param['data_cadastro'] = dataBR($this->data_cadastro);
                $Param['status'] = $this->status;
                $Param['rows'] = $rows;
                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }
    public function listAllVitrines()
    {

        $sql = $this->mysqli->prepare("
        SELECT url, app_users_id
        FROM app_users_imagens ORDER BY RAND()
        ");

        $sql->execute();
        $sql->bind_result($url_vitrine, $id_estabelecimento);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['url_vitrine'] = $url_vitrine;
                $Param['id_estabelecimento'] = $id_estabelecimento;
                $Param['rows'] = $rows;
                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }
    public function listAllUsuariosAdmin($id_user,$nome_usuario,$email_usuario)
    {
        $filter = "WHERE id_grupo IN (1, 2, 3)";
        if(!empty($id_user)){$filter .= "AND id = '$id_user'";}


        $sql = $this->mysqli->prepare("
        SELECT id, id_grupo, nome, email, celular, status, status_aprovado
        FROM app_users $filter");

        $sql->execute();
        $sql->bind_result($id_usuario, $id_grupo, $nome, $email, $celular, $status, $status_aprovado);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];
        $usuariosEncontrados = false;
        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {
                $Param['id_usuario'] = $id_usuario;
                switch ($id_grupo) {
                    case 1:
                        $Param['tipo_grupo'] = 'Admin';
                        break;
                    case 2:
                        $Param['tipo_grupo'] = 'Financeiro';
                        break;
                    case 3:
                        $Param['tipo_grupo'] = 'User Admin';
                        break;
                }
                $Param['id_grupo'] = $id_grupo;
                $Param['nome'] = decryptitem($nome);
                $Param['email'] = decryptitem($email);
                $Param['celular'] = decryptitem($celular);
                $Param['status'] = $status;
                $Param['status_aprovado'] = $status_aprovado;
                $Param['rows'] = $rows;

                $filtro = "(1 > 0)";

                    if (!empty($nome_usuario)) {
                        $nomeSemAcento = removerAcentos($nome_usuario);
                        $filtro .= " && (stripos(removerAcentos(\$Param['nome']), '$nomeSemAcento') !== false)";
                    }
                    if (!empty($email_usuario)) {
                        $emailSemAcento = removerAcentos($email_usuario);
                        $filtro .= " && (stripos(removerAcentos(\$Param['email']), '$emailSemAcento') !== false)";
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

    public function deleteCliente($id)
    {

        $sql_cadastro = $this->mysqli->prepare("DELETE FROM app_clientes WHERE id='$id'");
        $sql_cadastro->execute();

        $linhas_afetadas = $sql_cadastro->affected_rows;

        if ($linhas_afetadas > 0) {
            $param = [
                "status" => "01",
                "msg" => "Cliente deletado"
            ];
        } else {
            $param = [
                "status" => "02",
                "msg" => "Falha ao deletar o cliente"
            ];
        }

        return $param;
    }
    public function listClientesId($id_cliente)
    {

        $sql = $this->mysqli->prepare("
        SELECT id, tipo, nome, email, celular, data_nascimento,cep,estado,cidade,endereco,bairro,numero,complemento,data_cadastro,status
        FROM app_clientes
        WHERE id = '$id_cliente'
        ");

        $sql->execute();
        $sql->bind_result($this->id, $this->tipo, $this->nome, $this->email, $this->celular, $this->data_nascimento,$this->cep,$this->estado,
        $this->cidade,$this->endereco,$this->bairro,$this->numero,$this->complemento,$this->data_cadastro,$this->status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {


                $Param['id'] = $this->id;
                $Param['tipo'] = $this->tipo;
                $Param['nome'] = $this->nome;
                $Param['email'] = $this->email;
                $Param['celular'] = $this->celular;
                $Param['data_nascimento'] = dataBR($this->data_nascimento);
                $Param['cep'] = $this->cep;
                $Param['estado'] = $this->estado;
                $Param['cidade'] = $this->cidade;
                $Param['endereco'] = $this->endereco;
                $Param['bairro'] = $this->bairro;
                $Param['numero'] = $this->numero;
                $Param['complemento'] = $this->complemento;
                $Param['data_cadastro'] = dataBR($this->data_cadastro);
                $Param['status'] = $this->status;
                $Param['rows'] = $rows;
                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }
    public function saveCliente($id_estabelecimento,$nome,$email,$celular, $data_nascimento,$cep,$estado, $cidade,$endereco, $bairro,$numero, $complemento)
    {
        // print_r($data_nascimento);exit;
        $sql_cadastro = $this->mysqli->prepare(
            "
        INSERT INTO `app_clientes`(`app_users_id`,`tipo`, `nome`, `email`, `celular`, `data_nascimento`, `cep`, `estado`,`cidade`,  `endereco`, `bairro`, `numero`, `complemento`, `data_cadastro`,`status`)
            VALUES (
                '$id_estabelecimento', '2', '$nome', '$email', '$celular', '$data_nascimento', '$cep', '$estado', '$cidade', '$endereco', '$bairro',  '$numero',  '$complemento', '$this->data_atual', '1'
            )"
        );

        $sql_cadastro->execute();
        $this->id_cadastro = $sql_cadastro->insert_id;

        $Param = [
            "status" => "01",
            "msg" => "Cadastro adicionado",
            "id" => $this->id_cadastro,
            "nome" => $nome,
            "email" => $email
        ];

        return $Param;
    }

    public function saveUsuarioAdmin($id_grupo,$nome,$email,$celular,$hash,$senha)
    {
        // print_r($senha);exit;
        $sql_cadastro = $this->mysqli->prepare(
            "
        INSERT INTO `app_users`(`id_grupo`,`nome`, `email`, `celular`,`data_cadastro`,`status`,`status_aprovado`,`password`)
            VALUES ('$id_grupo', '$nome', '$email', '$celular','$this->data_atual', '1', '1','$hash')");

        $sql_cadastro->execute();

        $mail = new EnviarEmail();
        $mail->novasenhaAdmin(decryptitem($nome), decryptitem($email), $senha);

        $this->id_cadastro = $sql_cadastro->insert_id;

        $Param = [
            "status" => "01",
            "msg" => "Usuário adicionado!",
            "id" => $this->id_cadastro,
            "nome" => decryptitem($nome),
            "email" => decryptitem($email)
        ];

        return $Param;
    }
    public function updateCliente($id_cliente,$nome,$email,$celular, $data_nascimento,$cep,$estado, $cidade,$endereco, $bairro,$numero, $complemento,$status)
    {


        $sql_cadastro = $this->mysqli->prepare("UPDATE `app_clientes` SET nome='$nome',email='$email',celular='$celular',data_nascimento='$data_nascimento',cep='$cep',estado='$estado',
        cidade='$cidade',endereco='$endereco',bairro='$bairro',numero='$numero',complemento='$complemento',status='$status'
        WHERE id='$id_cliente' AND tipo='2'");
        $sql_cadastro->execute();
        $linhas_afetadas = $sql_cadastro->affected_rows;

        if ($linhas_afetadas > 0) {
            $param = [
                "status" => "01",
                "msg" => "Cliente atualizado"
            ];
        } else {
            $param = [
                "status" => "02",
                "msg" => "Falha ao atualizar o cliente"
            ];
        }

        return $param;
    }

    public function updateUsuarioAdmin($id_user,$id_grupo,$nome,$email,$celular,$status)
    {


        $sql_cadastro = $this->mysqli->prepare("UPDATE `app_users` SET nome='$nome',email='$email',celular='$celular', id_grupo='$id_grupo',status_aprovado='$status' WHERE id='$id_user'");
        $sql_cadastro->execute();


            $param = [
                "status" => "01",
                "msg" => "Usuário atualizado."
            ];


        return $param;
    }

    public function listLog($id_estabelecimento,$data_in,$data_out)
    {
        $filter = "WHERE a.tipo='1' AND a.id_para ='$id_estabelecimento'";
        if(!empty($data_in)){$filter .= "AND a.data_cadastro>='$data_in'";}
        if(!empty($data_out)){$filter .= "AND a.data_cadastro<='$data_out 23:59:59' ";}

        $sql = $this->mysqli->prepare("SELECT a.id, b.nome, a.estrelas, a.descricao, a.latitude, a.longitude, a.data_cadastro,
        (SELECT AVG(estrelas) FROM `app_relatorio` WHERE id_para = '$id_estabelecimento' AND tipo= '1') AS media_estrelas
        FROM `app_relatorio` AS a
        LEFT JOIN `app_users` AS b ON a.id_de=b.id
        $filter
        ORDER BY a.data_cadastro");
        $sql->execute();
        $sql->bind_result($this->id, $this->nome_user, $this->estrelas, $this->descricao, $this->latitude, $this->longitude, $this->data_cadastro, $this->media_estrelas);
        $sql->store_result(); //verifica se tá ok
        $rows = $sql->num_rows; // quantidade de linhas na consulta

        $lista=[];
        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($lista, $Param);
        }else{
            while ($row = $sql->fetch()) {
                $Param['id'] = $this->id;
                $Param['nome_user'] = $this->nome_user;
                $Param['estrelas'] = $this->estrelas;
                $Param['descricao'] = $this->descricao;
                $Param['latitude'] = $this->latitude;
                $Param['longitude'] = $this->longitude;
                $Param['data_dia'] = dataBR($this->data_cadastro);
                $Param['data_hora'] = horaBR($this->data_cadastro);
                $Param['media_estrelas'] = number_format($this->media_estrelas, 1);
                $Param['rows'] = $rows;

                array_push($lista, $Param);
            }
        }

        // print_r($lista);exit;
        return $lista;

    }
    public function pesquisaProduto($id_usuario,$id_estabelecimento,$nome_produto,$marca,$distancia_filtro,$categoria,$subcategoria,$genero,$oferta,$cor,$latitude,$longitude) {
        $filter = "a.status='1'";
        if(!empty($id_estabelecimento)){$filter .= "AND a.app_users_id ='$id_estabelecimento'";}
        if(!empty($nome_produto)){$filter .= "AND a.nome LIKE '%$nome_produto%'";}
        if(!empty($marca)){$filter .= "AND a.marca LIKE '%$marca%'";}
        if(!empty($categoria)){$filter .= "AND e.app_categorias_id = '$categoria'";}
        if(!empty($subcategoria)){$filter .= "AND d.app_subcategorias_id = '$subcategoria'";}
        if(!empty($genero)){$filter .= "AND a.genero = '$genero'";}
        if(!empty($oferta)){$filter .= "AND a.oferta = '$oferta'";}
        if(!empty($cor)){$filter .= "AND a.app_produtos_cores_id = '$cor'";}

        $sql = $this->mysqli->prepare("SELECT DISTINCT a.id, a.nome,a.marca,a.genero,a.oferta,b.nome,b.cor,c.nome_fantasia,c.avatar,f.latitude,f.longitude,g.nome,a.valor,c.tipo_loja
          FROM `app_produtos` AS a
          INNER JOIN `app_produtos_cores` AS b ON a.app_produtos_cores_id = b.id
          INNER JOIN `app_users` AS c ON a.app_users_id = c.id
          LEFT JOIN `app_produtos_subcategorias` AS d ON a.id = d.app_produtos_id
          LEFT JOIN `app_produtos_categorias` AS e ON a.id = e.app_produtos_id
          LEFT JOIN `app_users_endereco` AS f ON a.app_users_id = f.app_users_id
          LEFT JOIN `app_categorias` AS g ON e.app_categorias_id = g.id
          WHERE $filter
          ORDER BY a.nome ASC
          ");

          $sql->execute();
          $sql->bind_result($this->id, $this->nome, $this->marca,$this->genero,$this->oferta,$this->cor_nome,$this->cor,$this->nome_estabelecimento,$this->logo_estabelecimento,
          $this->latitude,$this->longitude,$this->nome_categoria,$this->valor,$this->tipo_loja);
          $sql->store_result();
          $rows = $sql->num_rows;
          $lista = array();
          $contador_filtro=0;

          if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($lista, $Param);
          } else{
            while ($row = $sql->fetch()) {
            $distancia_produto= distLatLongDistancia($latitude,$longitude,decryptitem($this->latitude),decryptitem($this->longitude));
            //verifica se precisa filtrar por distancia
            if(!empty($distancia_filtro)){
                if($distancia_produto <= $distancia_filtro ){

                    $Param['id'] = $this->id;
                    $Param['distancia'] = $distancia_produto;
                    $Param['nome'] = ucfirst($this->nome);
                    $Param['nome_categoria'] = $this->nome_categoria;
                    $Param['nome_estabelecimento'] = $this->nome_estabelecimento;
                    $Param['logo_estabelecimento'] = $this->logo_estabelecimento;
                    $Param['tipo_loja'] = $this->tipo_loja;
                    $Param['marca'] = $this->marca;
                    $Param['genero'] = $this->genero;

                    $Param['oferta'] = $this->oferta;
                    if($this->oferta == 1){
                        $Param['oferta_nome'] = "Sim";
                    }
                    if($this->oferta == 2){
                      $Param['oferta_nome'] = "Não";
                    }
                    if($this->oferta == null){
                        $Param['oferta_nome'] = "Oferta não registrada.";
                    }
                    $Param['valor'] = $this->valor > 0? moneyView($this->valor) : null;
                    if($this->genero == 1){
                        $Param['genero_nome'] = "Masculino";
                    }
                    if($this->genero == 2){
                      $Param['genero_nome'] = "Feminino";
                  }
                  if($this->genero == 3){
                      $Param['genero_nome'] = "Infantil";
                  }
                    $Param['cor_nome'] = $this->cor_nome;
                    $Param['cor'] = $this->cor;
                    $Param['foto_capa'] = $this->findCapa($this->id);
                    $Param['favorito'] = $this->findFavorito($id_usuario,$this->id);
                    $Param['rows'] = $rows;
                    $lista[] = $Param;
                }else{
                    $contador_filtro=$contador_filtro+1;
                }
            }else{
                // echo $distancia_filtro;
                $Param['id'] = $this->id;
                $Param['distancia'] = $distancia_produto;
                $Param['latitude'] = decryptitem($this->latitude);
                $Param['longitude'] = decryptitem($this->longitude);
                $Param['nome'] = ucfirst($this->nome);
                $Param['nome_categoria'] = $this->nome_categoria;
                $Param['nome_estabelecimento'] = $this->nome_estabelecimento;
                $Param['logo_estabelecimento'] = $this->logo_estabelecimento;
                $Param['tipo_loja'] = $this->tipo_loja;
                $Param['marca'] = $this->marca;
                $Param['oferta'] = $this->oferta;
                $Param['genero'] = $this->genero;
                if($this->genero == 1){
                    $Param['genero_nome'] = "Masculino";
                }
                if($this->genero == 2){
                  $Param['genero_nome'] = "Feminino";
              }
              if($this->genero == 3){
                  $Param['genero_nome'] = "Infantil";
              }
                $Param['cor_nome'] = $this->cor_nome;
                $Param['cor'] = $this->cor;
                $Param['foto_capa'] = $this->findCapa($this->id);
                $Param['favorito'] = $this->findFavorito($id_usuario,$this->id);
                $Param['rows'] = $rows;
                $lista[] = $Param;
            }
            }
            if($contador_filtro == $rows){
                $Param['rows'] = 0;
                array_push($lista, $Param);
            }
            foreach($lista as &$item){
                $item['rows'] -= $contador_filtro;
            }
            if($lista[0]['rows'] < 1){
                $lista[0]['rows'] = 0;
            }
          }
          return $lista;
      }
    public function pesquisarProdutosLoja($id_usuario,$id_estabelecimento,$nome_produto,$marca,$distancia_filtro,$categoria,$subcategoria,$genero,$oferta,$cor,$latitude,$longitude) {
        $filter = "a.status='1'";
        if(!empty($id_estabelecimento)){$filter .= "AND a.app_users_id ='$id_estabelecimento'";}
        if(!empty($nome_produto)){$filter .= "AND a.nome LIKE '%$nome_produto%'";}
        if(!empty($marca)){$filter .= "AND a.marca LIKE '%$marca%'";}
        if(!empty($categoria)){$filter .= "AND e.app_categorias_id = '$categoria'";}
        if(!empty($subcategoria)){$filter .= "AND d.app_subcategorias_id = '$subcategoria'";}
        if(!empty($genero)){$filter .= "AND a.genero = '$genero'";}
        if(!empty($oferta)){$filter .= "AND a.oferta = '$oferta'";}
        if(!empty($cor)){$filter .= "AND a.app_produtos_cores_id = '$cor'";}

        $sql = $this->mysqli->prepare("SELECT DISTINCT a.id, a.nome,a.marca,a.genero,a.oferta,b.nome,b.cor,c.nome_fantasia,c.avatar,f.latitude,f.longitude,g.nome,a.valor,c.tipo_loja,c.id
          FROM `app_produtos` AS a
          INNER JOIN `app_produtos_cores` AS b ON a.app_produtos_cores_id = b.id
          INNER JOIN `app_users` AS c ON a.app_users_id = c.id
          LEFT JOIN `app_produtos_subcategorias` AS d ON a.id = d.app_produtos_id
          LEFT JOIN `app_produtos_categorias` AS e ON a.id = e.app_produtos_id
          LEFT JOIN `app_users_endereco` AS f ON a.app_users_id = f.app_users_id
          LEFT JOIN `app_categorias` AS g ON e.app_categorias_id = g.id
          WHERE $filter
          ORDER BY a.nome ASC
          ");

          $sql->execute();
          $sql->bind_result($this->id, $this->nome, $this->marca,$this->genero,$this->oferta,$this->cor_nome,$this->cor,$this->nome_estabelecimento,$this->logo_estabelecimento,
          $this->latitude,$this->longitude,$this->nome_categoria,$this->valor,$this->tipo_loja,$this->id_estabelecimento);
          $sql->store_result();
          $rows = $sql->num_rows;
          $produtos = array();
          $lojas = array();
          $contador_filtro=0;
          $contador_lojas = 0;

          if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($produtos, $Param);
          } else{
            while ($row = $sql->fetch()) {
            $distancia_produto= distLatLongDistancia($latitude,$longitude,decryptitem($this->latitude),decryptitem($this->longitude));
            //verifica se precisa filtrar por distancia
            if(!empty($distancia_filtro)){
                if($distancia_produto <= $distancia_filtro ){

                    $Param['id'] = $this->id;
                    $Param['distancia'] = $distancia_produto;
                    $Param['nome'] = ucfirst($this->nome);
                    $Param['nome_categoria'] = $this->nome_categoria;
                    $Param['marca'] = $this->marca;
                    $Param['genero'] = $this->genero;
                    $Param['nome_estabelecimento'] = $this->nome_estabelecimento;
                    $Param['logo_estabelecimento'] = $this->logo_estabelecimento;
                    $Param['tipo_loja'] = $this->tipo_loja;

                    $Param['oferta'] = $this->oferta;
                    if($this->oferta == 1){
                        $Param['oferta_nome'] = "Sim";
                    }
                    if($this->oferta == 2){
                      $Param['oferta_nome'] = "Não";
                    }
                    if($this->oferta == null){
                        $Param['oferta_nome'] = "Oferta não registrada.";
                    }
                    $Param['valor'] = $this->valor > 0? moneyView($this->valor) : null;
                    if($this->genero == 1){
                        $Param['genero_nome'] = "Masculino";
                    }
                    if($this->genero == 2){
                      $Param['genero_nome'] = "Feminino";
                  }
                  if($this->genero == 3){
                      $Param['genero_nome'] = "Infantil";
                  }
                    $Param['cor_nome'] = $this->cor_nome;
                    $Param['cor'] = $this->cor;
                    $Param['foto_capa'] = $this->findCapa($this->id);
                    $Param['favorito'] = $this->findFavorito($id_usuario,$this->id);
                    $Param['rows'] = $rows;
                    $produtos[] = $Param;
                    $loja['distancia'] = $distancia_produto;
                    $loja['id_estabelecimento'] = $this->id_estabelecimento;
                    $loja['nome_estabelecimento'] = $this->nome_estabelecimento;
                    $loja['logo_estabelecimento'] = $this->logo_estabelecimento;
                    $loja['tipo_loja'] = $this->tipo_loja;

                    if (!in_array($loja, $lojas)) {
                        $lojas[] = $loja;
                        $contador_lojas++;
                    }
                }else{
                    $contador_filtro=$contador_filtro+1;
                }
            }else{
                // echo $distancia_filtro;
                $Param['id'] = $this->id;
                $Param['distancia'] = $distancia_produto;
                $Param['latitude'] = decryptitem($this->latitude);
                $Param['longitude'] = decryptitem($this->longitude);
                $Param['nome'] = ucfirst($this->nome);
                $Param['nome_categoria'] = $this->nome_categoria;

                $Param['marca'] = $this->marca;
                $Param['oferta'] = $this->oferta;
                $Param['genero'] = $this->genero;
                $Param['nome_estabelecimento'] = $this->nome_estabelecimento;
                $Param['logo_estabelecimento'] = $this->logo_estabelecimento;
                $Param['tipo_loja'] = $this->tipo_loja;

                if($this->genero == 1){
                    $Param['genero_nome'] = "Masculino";
                }
                if($this->genero == 2){
                  $Param['genero_nome'] = "Feminino";
              }
              if($this->genero == 3){
                  $Param['genero_nome'] = "Infantil";
              }
                $Param['cor_nome'] = $this->cor_nome;
                $Param['cor'] = $this->cor;
                $Param['foto_capa'] = $this->findCapa($this->id);
                $Param['favorito'] = $this->findFavorito($id_usuario,$this->id);
                $Param['rows'] = $rows;

                $produtos[] = $Param;
                $loja['distancia'] = $distancia_produto;
                $loja['id_estabelecimento'] = $this->id_estabelecimento;
                $loja['nome_estabelecimento'] = $this->nome_estabelecimento;
                $loja['logo_estabelecimento'] = $this->logo_estabelecimento;
                $loja['tipo_loja'] = $this->tipo_loja;
                if (!in_array($loja, $lojas)) {
                    $lojas[] = $loja;
                    $contador_lojas++;
                }
            }
            }

            if ($rows == 0) {
                $loja['rows'] = $rows;
                array_push($lojas, $loja);
              }
            if($contador_filtro == $rows){
                $Param['rows'] = 0;
                array_push($produtos, $Param);
            }
            foreach($produtos as &$item){
                $item['rows'] -= $contador_filtro;
            }
            if($produtos[0]['rows'] < 1){
                $produtos[0]['rows'] = 0;
            }
          }

          foreach ($lojas as &$loja) {
            $loja['rows'] = $contador_lojas;
        }
            $response['produtos'] = $produtos;
            $response['lojas'] = $lojas;

            return $response;
      }

      public function pesquisaEstabelecimento($nome_fantasia,$razao_social,$latitude,$longitude) {
        $filter = "a.status='1'";
        if(!empty($nome_fantasia)){$filter .= "AND c.nome_fantasia LIKE '%$nome_fantasia%'";}
        if(!empty($razao_social)){$filter .= "AND c.razao_social LIKE '%$razao_social%'";}

        $sql = $this->mysqli->prepare("SELECT DISTINCT a.id, a.nome,a.marca,a.genero,a.oferta,b.nome,b.cor,c.id,c.nome_fantasia,c.razao_social,c.avatar,f.latitude,f.longitude,g.nome,a.valor,c.tipo_loja,h.url
          FROM `app_produtos` AS a
          INNER JOIN `app_produtos_cores` AS b ON a.app_produtos_cores_id = b.id
          INNER JOIN `app_users` AS c ON a.app_users_id = c.id
          LEFT JOIN `app_produtos_subcategorias` AS d ON a.id = d.app_produtos_id
          LEFT JOIN `app_produtos_categorias` AS e ON a.id = e.app_produtos_id
          LEFT JOIN `app_users_endereco` AS f ON a.app_users_id = f.app_users_id
          LEFT JOIN `app_categorias` AS g ON e.app_categorias_id = g.id
          LEFT JOIN `app_users_imagens` AS h ON h.app_users_id = c.id
          WHERE $filter
          ORDER BY a.nome ASC
          ");

          $sql->execute();
          $sql->bind_result($this->id, $this->nome, $this->marca,$this->genero,$this->oferta,$this->cor_nome,$this->cor,$this->id_estabelecimento,$this->nome_estabelecimento,$this->razao_social,$this->logo_estabelecimento,
          $this->latitude,$this->longitude,$this->nome_categoria,$this->valor,$this->tipo_loja,$this->url_vitrine);
          $sql->store_result();
          $rows = $sql->num_rows;
          $produtos = array();
          $contador_filtro=0;

          if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($lista, $Param);
          } else{
            while ($row = $sql->fetch()) {
            $distancia_produto= distLatLongDistancia($latitude,$longitude,decryptitem($this->latitude),decryptitem($this->longitude));
            //verifica se precisa filtrar por distancia
            if(!empty($distancia_filtro)){
                if($distancia_produto <= $distancia_filtro ){
                    $Param['distancia'] = $distancia_produto;
                    $Param['id_estabelecimento'] = $this->id_estabelecimento;
                    $Param['nome_estabelecimento'] = $this->nome_estabelecimento;
                    $Param['logo_estabelecimento'] = $this->logo_estabelecimento;
                    $Param['url_vitrine'] = $this->url_vitrine;
                    $Param['tipo_loja'] = $this->tipo_loja;
                    $Param['rows'] = $rows;
                    $lista[] = $Param;
                }else{
                    $contador_filtro=$contador_filtro+1;
                }
            }else{
                // echo $distancia_filtro;
                $Param['distancia'] = $distancia_produto;
                $Param['latitude'] = decryptitem($this->latitude);
                $Param['longitude'] = decryptitem($this->longitude);
                $Param['id_estabelecimento'] = $this->id_estabelecimento;
                $Param['nome_estabelecimento'] = $this->nome_estabelecimento;
                $Param['logo_estabelecimento'] = $this->logo_estabelecimento;
                $Param['url_vitrine'] = $this->url_vitrine;
                $Param['tipo_loja'] = $this->tipo_loja;


                $Param['rows'] = $rows;
                $lista[] = $Param;
            }
            }
            if($contador_filtro == $rows){
                $Param['rows'] = 0;
                array_push($lista, $Param);
            }
            foreach($lista as &$item){
                $item['rows'] -= $contador_filtro;
            }
            if($lista[0]['rows'] < 1){
                $lista[0]['rows'] = 0;
            }
          }
          return $lista;
      }

    public function findCapa($id) {

        $sql = $this->mysqli->prepare("SELECT url
          FROM `app_produtos_fotos` WHERE app_produtos_id='$id'
          ORDER BY capa ASC LIMIT 1
          ");
          $sql->execute();
          $sql->bind_result($this->url);
          $sql->fetch();
          return $this->url;
    }
    public function findFavorito($id_usuario,$id_produto) {

        $sql = $this->mysqli->prepare("SELECT id
          FROM `app_favoritos` WHERE id_de='$id_usuario' AND id_para='$id_produto'
          ");
          $sql->execute();
          $sql->bind_result($this->id_favorito);
          $sql->fetch();

          if($this->id_favorito){
            return true;
          }else{
              return false;
          }
    }
}
