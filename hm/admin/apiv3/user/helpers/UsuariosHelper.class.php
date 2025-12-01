<?php

require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/phpMailer/Enviar.class.php';
/**
 * Helpers são responsáveis por todas validaçoes e regras de negócio que o Modelo pode possuir
 *
 */

class UsuariosHelper extends Conexao
{

    public function __construct()
    {
        $this->tabela = "app_users";
        $this->data_atual = date('Y-m-d H:i:s');
        $this->Conecta();
    }

    public function loginPainel($email, $password)
    {
        //Update último acesso
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela` SET `u_login`='$this->data_atual' WHERE email = '$email' AND tipo = 2
        ");
        $sql_cadastro->execute();

        $sql = $this->mysqli->prepare(
            "
        SELECT id, tipo, nome, nome_fantasia, razao_social, email, password, cpf,cnpj, celular, avatar, data_nascimento, data_cadastro, u_login, status, status_aprovado
        FROM `$this->tabela`
        WHERE email = '$email' AND tipo = 2 AND status_aprovado=1"
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->tipo, $this->nome, $this->nome_fantasia, $this->razao_social,  $this->email, $this->password, $this->cpf,$this->cnpj, $this->celular, $this->avatar,  $this->data_nascimento, $this->data_cadastro, $this->u_login, $this->status, $this->status_aprovado);
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();
        $sql->close();

        if (crypt($password, $this->password) === $this->password) {

            if ($this->status == 2) {
                $error['status'] = '2';
                $error['msg'] = 'Cadastro inativo.';

                return $error;
            } else {
                $success['id'] = $this->id;
                $success['tipo'] = $this->tipo;
                $success['nome'] = decryptitem($this->nome);
                $success['nome_fantasia'] = $this->nome_fantasia;
                $success['razao_social'] = $this->razao_social;
                $success['email'] = $this->email;
                $success['cpf'] = formataCpf($this->cpf);
                $success['cnpj'] = formataCpf($this->cpf);
                $success['celular'] = $this->celular;
                $success['avatar'] = $this->avatar;
                $success['data_nascimento'] = $this->data_nascimento;
                $success['data_cadastro'] = $this->data_cadastro;
                $success['u_login'] = $this->u_login;
                $success['status'] = $this->status == 1 ? 'Ativo' : 'Inativo';
                $success['status_aprovado'] = $this->status_aprovado ==  1 ? 'Ativo' : 'Pendente';
                $success['msg'] = 'Login efetuado com sucesso.';

                return $success;
            }
        } else {
            $error['status'] = '02';
            $error['msg'] = 'E-mail ou Senha incorretos, tente outros dados!';

            return $error;
        }
    }

    public function loginMidias($email){


      $sql = $this->mysqli->prepare("
      SELECT id, tipo, nome, nome_fantasia, razao_social, email, password, celular, avatar, data_nascimento,
      data_cadastro, u_login, status, status_aprovado
      FROM `$this->tabela`
      WHERE email = '$email' AND tipo = 1"
      );
      $sql->execute();
      $sql->bind_result($this->id, $this->tipo, $this->nome, $this->nome_fantasia, $this->razao_social,  $this->email, $this->password, $this->celular, $this->avatar,  $this->data_nascimento, $this->data_cadastro, $this->u_login, $this->status, $this->status_aprovado);
      $sql->store_result();
      $rows = $sql->num_rows;
      $sql->fetch();

      if($rows > 0){

        $success['id'] = $this->id;
        $success['nome'] = decryptitem($this->nome);
        $success['email'] = decryptitem( $this->email);
        $success['avatar'] = $this->avatar;
        $success['status'] = "01";
        $success['msg'] = 'Login efetuado com sucesso.';
        $success['rows'] = $rows;

        return $success;

        exit;

      }else{

        $success['rows'] = $rows;
        return $success;

      }


    }

    public function loginApp($email, $password)
    {
        //Update último acesso
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela` SET `u_login`='$this->data_atual' WHERE email = '$email' AND tipo = 1
        ");
        $sql_cadastro->execute();

        $sql = $this->mysqli->prepare(
            "
        SELECT id, tipo, nome, nome_fantasia, razao_social, email, password, cpf, celular, avatar, data_nascimento, data_cadastro, u_login, status, status_aprovado
        FROM `$this->tabela`
        WHERE email = '$email' AND tipo = 1"
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->tipo, $this->nome, $this->nome_fantasia, $this->razao_social,  $this->email, $this->password, $this->cpf, $this->celular, $this->avatar,  $this->data_nascimento, $this->data_cadastro, $this->u_login,$this->status, $this->status_aprovado);
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();
        $sql->close();

        if (crypt($password, $this->password) === $this->password) {

            if ($this->status == 2) {
                $error['status'] = '2';
                $error['msg'] = 'Cadastro inativo.';

                return $error;
            } else {
                $success['id'] = $this->id;
                $success['tipo'] = $this->tipo;
                $success['nome'] = $this->nome;
                // $success['nome_fantasia'] = $this->nome_fantasia;
                // $success['razao_social'] = $this->razao_social;
                $success['email'] = $this->email;
                $success['cpf'] = formataCpf($this->cpf);
                $success['celular'] = $this->celular;
                $success['avatar'] = $this->avatar;
                $success['data_nascimento'] = dataBR($this->data_nascimento);
                $success['data_cadastro'] = dataBR($this->data_cadastro);
                $success['u_login'] = dataBR($this->u_login);
                $success['status'] = $this->status == 1 ? 'Ativo' : 'Inativo';
                $success['status_aprovado'] = $this->status_aprovado ==  1 ? 'Ativo' : 'Pendente';
                $success['msg'] = 'Login efetuado com sucesso.';

                return $success;
            }
        } else {
            $error['status'] = '02';
            $error['msg'] = 'E-mail ou Senha incorretos, tente outros dados!';

            return $error;
        }
    }

    public function listAllMenusAdmin()
    {

        $sql = $this->mysqli->prepare("
        SELECT id, nome, link, ativo, icone
        FROM tb_menus WHERE ativo='1' ORDER BY id ASC
        ");


        $sql->execute();
        $sql->bind_result($id_menu, $nome_menu, $link_menu, $status_menu, $icone_menu);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id_menu'] = $id_menu;
                $Param['nome_menu'] = $nome_menu;
                $Param['link_menu'] = $link_menu;
                $Param['status_menu'] = $status_menu;
                $Param['icone_menu'] = $icone_menu;
                $Param['rows'] = $rows;
                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function listId($id_user)
    {
        $sql = $this->mysqli->prepare(
            "
        SELECT id, tipo, nome, nome_fantasia, razao_social, email, password, documento, telefone, celular, avatar, data_nascimento, data_cadastro, u_login, dest, status, status_aprovado
        FROM `$this->tabela`
        WHERE id = '$id_user' AND tipo = 1"
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->tipo, $this->nome, $this->nome_fantasia, $this->razao_social,  $this->email, $this->password, $this->documento, $this->telefone, $this->celular, $this->avatar,  $this->data_nascimento, $this->data_cadastro, $this->u_login, $this->dest, $this->status, $this->status_aprovado);
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();
        $sql->close();


        if ($this->status == 2) {
            $error['status'] = '2';
            $error['msg'] = 'Cadastro inativo.';

            return $error;
        } else {
            $success['id'] = $this->id;
            $success['tipo'] = $this->tipo;
            $success['nome'] = $this->nome;
            $success['nome_fantasia'] = $this->nome_fantasia;
            $success['razao_social'] = $this->razao_social;
            $success['email'] = $this->email;
            $success['documento'] = formataCpf($this->documento);
            $success['telefone'] = $this->telefone;
            $success['celular'] = $this->celular;
            $success['avatar'] = $this->avatar;
            $success['data_nascimento'] = dataBR($this->data_nascimento);
            $success['data_cadastro'] = dataBR($this->data_cadastro);
            $success['u_login'] = dataBR($this->u_login);
            $success['dest'] = $this->dest;
            $success['status'] = $this->status == 1 ? 'Ativo' : 'Inativo';
            $success['status_aprovado'] = $this->status_aprovado ==  1 ? 'Ativo' : 'Pendente';

            return $success;
        }
    }
    public function listIdUsuariosAdmin($id_user)
    {
        $sql = $this->mysqli->prepare(
            "
        SELECT id, id_grupo, nome, email, celular, data_cadastro, status, status_aprovado FROM `app_users` WHERE id = '$id_user'");
        $sql->execute();
        $sql->bind_result($id, $id_grupo, $nome, $email, $celular, $data_cadastro, $status, $status_aprovado);
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();
        $sql->close();


        if ($rows == 0) {
            $error['status'] = '02';
            $error['msg'] = 'Nenhum registro encontrado.';

            return $error;
        } else {

            if ($status == 2) {
                $error['status'] = '03';
                $error['msg'] = 'Cadastro inativo.';

                return $error;
            } else {
            $success['id'] = $id;
            $success['nome'] = decryptitem($nome);
            $success['email'] = decryptitem($email);
            $success['celular'] = decryptitem($celular);
            $success['data_cadastro'] = dataBR($data_cadastro);
            $success['status'] = $status == 1 ? 'Ativo' : 'Inativo';
            $success['status_aprovado'] = $status_aprovado ==  1 ? 'Ativo' : 'Inativo';

            return $success;
        }
    }}
    public function listIdPerfil($id_user)
    {
        $sql = $this->mysqli->prepare(
            "
        SELECT id, id_grupo, avatar, nome, email, celular, data_cadastro, status, status_aprovado, documento, data_nascimento FROM `app_users` WHERE id = '$id_user'");
        $sql->execute();
        $sql->bind_result($id, $id_grupo, $avatar, $nome, $email, $celular, $data_cadastro, $status, $status_aprovado, $documento, $data_nascimento);
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();
        $sql->close();


        if ($rows == 0) {
            $error['status'] = '02';
            $error['msg'] = 'Nenhum registro encontrado.';

            return $error;
        } else {

            if ($status == 2) {
                $error['status'] = '03';
                $error['msg'] = 'Cadastro inativo.';

                return $error;
            } else {
            $success['id'] = $id;
            $success['avatar'] = $avatar;
            $success['documento'] = decryptitem($documento);
            $success['data_nascimento'] = $data_nascimento;
            $success['data_nascimento_view'] = dataBR($data_nascimento);
            $success['nome'] = decryptitem($nome);
            $success['email'] = decryptitem($email);
            $success['celular'] = decryptitem($celular);
            $success['data_cadastro'] = dataBR($data_cadastro);
            $success['status'] = $status == 1 ? 'Ativo' : 'Inativo';
            $success['status_aprovado'] = $status_aprovado ==  1 ? 'Ativo' : 'Inativo';

            return $success;
        }
    }}

    public function cryptPassword($password, $nome, $email)
    {

        $this->custo = '08';
        $this->salt = geraSalt(22);
        $this->token = geraToken($nome, $email);
        $this->hash = crypt($password, '$2a$' . $this->custo . '$' . $this->salt . '$');

        return $this->hash;
    }

    public function cryptPassword2($password)
    {

        $this->custo = '08';
        $this->salt = geraSalt(22);
        $this->hash = crypt($password, '$2a$' . $this->custo . '$' . $this->salt . '$');
        // print_r($this->hash);exit;
        return $this->hash;
    }

    public function validateCNPJ($documento)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tabela` WHERE cnpj = '$documento'");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'CNPJ em uso, por favor tente outros dados.';

            return $error;
        }
    }



    public function filters($nome, $email, $cpf, $tipo)
    {

        $filter = "";

        if (isset($nome)) {
            $filter .= "AND nome like'%$nome%'";
        }
        if (isset($email)) {
            $filter .= "AND email like'%$email%'";
        }
        if (isset($cpf)) {
            $filter .= "AND cpf='$cpf'";
        }
        if (isset($tipo)) {
            $filter .= "AND tipo='$tipo'";
        }

        return $filter;
    }

    public function validateEmail($email)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tabela` WHERE email = '$email' AND id_grupo IN (1,2,3)");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Email em uso, por favor tente outros dados.';

            return $error;
        }
    }
    public function validateEmailCliente($email)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `app_users`  WHERE email = '$email' AND id_grupo IN (1,2,3)");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Email em uso, por favor tente outros dados.';

            return $error;
        }
    }

    public function validateEmailCadastro($id, $email)
    {


        $sql = $this->mysqli->prepare("SELECT id FROM `app_users` WHERE email = '$email' AND id <> '$id' AND id_grupo='4'");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Email em uso, por favor tente outros dados.';

            return $error;
        }
    }

    public function find_estabelecimento($id_cliente)
    {

        $sql = $this->mysqli->prepare("SELECT app_users_id FROM `app_clientes`  WHERE id = '$id_cliente'");
        $sql->execute();
        $sql->bind_result($this->id_cliente);
        $sql->fetch();

        if (isset($this->id_cliente)) {

            return $this->id_cliente;
        }
    }

    public function validateEmailClienteUpdate($email,$id)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `app_users` WHERE email = '$email' AND id<>'$id' AND id_grupo IN (1,2,3)");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Já existe um usuário com este email, por favor tente outros dados.';

            return $error;
        }
    }

    public function validateEmailUpdate($email, $id)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tabela` WHERE email = '$email' AND id<>'$id' AND id_grupo IN (1,2,3) ");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Já existe um usuário com este email, por favor tente outros dados.';

            return $error;
        }
    }

    public function validateEmailUpdateCadastros($email, $id)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tabela` WHERE email = '$email' AND id<>'$id' AND id_grupo=4 ");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Já existe um usuário com este email, por favor tente outros dados.';

            return $error;
        }
    }

    public function validateCNPJUpdateCadastro($documento, $id)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tabela` WHERE documento = '$documento' AND id<>'$id' AND id_grupo=4");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Já existe um usuário com este documento, por favor tente outros dados.';

            return $error;
        }
    }
    public function validateCNPJUpdate($documento, $id)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tabela` WHERE documento = '$documento' AND id<>'$id' AND id_grupo IN (1,2,3)");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Já existe um usuário com este documento, por favor tente outros dados.';

            return $error;
        }
    }
    public function validateCelularClienteUpdate($celular, $id)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `app_users` WHERE celular = '$celular' AND id<>'$id'  AND id_grupo IN (1,2,3) ");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Já existe um usuário com este celular, por favor tente outros dados.';

            return $error;
        }
    }
    public function validateCelularClienteUpdateCadastro($celular, $id)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `app_users` WHERE celular = '$celular' AND id<>'$id'  AND id_grupo=4 ");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Já existe um usuário com este celular, por favor tente outros dados.';

            return $error;
        }
    }
    public function validateCelularCliente($celular)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `app_users` WHERE celular = '$celular'  AND id_grupo IN (1,2,3) ");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Já existe um usuário com este celular, por favor tente outros dados.';

            return $error;
        }
    }

    public function validateDoisFatores($email, $password, $latitude, $longitude)
    {

        $sql = $this->mysqli->prepare(
            "SELECT id,nome, email,password, documento, celular, avatar, data_nascimento,
        data_cadastro, u_login, token_senha, status, status_aprovado
        FROM `$this->tabela` WHERE email ='$email' AND id_grupo IN (1,2,3)"
        );

        $sql->execute();
        $sql->bind_result($this->id,$this->nome, $this->email, $this->password , $this->documento,
         $this->celular, $this->avatar, $this->data_nascimento, $this->data_cadastro, $this->u_login, $this->token_senha, $this->status, $this->status_aprovado);
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();
        $sql->close();

         if (crypt($password, $this->password) === $this->password) {
            if ($this->status == 2) {
                $error['status'] = '02';
                $error['msg'] = 'Cadastro desativado pelo administrador.';

                return $error;
            }
             else {
                    //verifica codigo pedido recentemente

                    $recente=$this->verificaCodRecente($this->id);
                    if ($recente['status']==2) {
                        return($recente);
                    }
                    //gera o codigo
                    $codigo=$this->geraCodDoisFatores($this->id,$latitude, $longitude);
                    // print_r($codigo);exit;
                    //ENVIA E-MAIL PARA VERIFICACAO DUAS ETAPAS
                    $mail = new EnviarEmail();
                    $mail->doisFatores(decryptitem($this->nome), decryptitem($email), $codigo);
                    $success['status'] = '01';
                    $success['msg'] = 'O código de verificação foi enviado para seu email.';
                    $success['msg2'] = $codigo;

                    return $success;




            }
        }
        else {
            $error['status'] = '02';
            $error['msg'] = 'E-mail ou Senha incorretos, tente outros dados!';

            return $error;
        }



    }

    public function geraCodDoisFatores($id_user,$lat,$long)
    {

        $numero_aleatorio = mt_rand(1000, 9999);

        $sql_cadastro = $this->mysqli->prepare(
            "INSERT INTO `app_users_two`(`app_users_id`,`code`,`data_cadastro`,`latitude`,`longitude`, `status`)
            VALUES ('$id_user','$numero_aleatorio','$this->data_atual','$lat','$long','2')"
        );

        $sql_cadastro->execute();
        return $numero_aleatorio;

    }

    public function verificaCod($id_usuario,$codigo)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `app_users_two` WHERE code = '$codigo' AND app_users_id='$id_usuario' AND status='2'  AND data_cadastro > DATE_SUB(NOW(), INTERVAL 1 HOUR)");
        $sql->execute();
        $sql->bind_result($encontrou);
        $sql->fetch();
        $sql->close();

        if ($encontrou) {
            $sql_cadastro = $this->mysqli->prepare("
            UPDATE `app_users_two` SET `status`='1' WHERE app_users_id = '$id_usuario'
            ");
            $sql_cadastro->execute();

            $error['status'] = '01';
            $error['msg'] = 'Código confirmado, prossiga para o app.';
            return $error;
        }else{
            $error['status'] = '02';
            $error['msg'] = 'Código incorreto.';
            return $error;
        }
    }
    public function validateLogin($email, $password)
    {
        // print_r(crypt($password, $this->password));exit;
        // //Update último acesso
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela` SET `u_login`='$this->data_atual' WHERE email = '$email' AND id_grupo IN (1,2,3)
        ");
        $sql_cadastro->execute();

        $sql = $this->mysqli->prepare(
            "
        SELECT id,id_grupo,nome,email,password, documento, celular, avatar, data_nascimento,
        data_cadastro, u_login, token_senha, status, status_aprovado
        FROM `$this->tabela` WHERE email ='$email' AND id_grupo IN (1,2,3)"
        );

        $sql->execute();
        $sql->bind_result($this->id,$this->id_grupo,$this->nome, $this->email, $this->password , $this->documento,
         $this->celular, $this->avatar, $this->data_nascimento, $this->data_cadastro, $this->u_login, $this->token_senha, $this->status, $this->status_aprovado);
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();
        $sql->close();

         if (crypt($password, $this->password) === $this->password) {
            if ($this->status == 2) {
                $error['status'] = '02';
                $error['msg'] = 'Cadastro desativado pelo administrador.';

                return $error;
            }
             else {
                    $success['id'] = $this->id;
                    $success['id_grupo'] = $this->id_grupo;
                    $success['nome'] = decryptitem($this->nome);
                    $success['email'] = decryptitem($this->email);
                    // $success['documento'] = decryptitem($this->documento);
                    $success['celular'] = decryptitem($this->celular);
                    if($this->avatar){
                        $success['avatar'] = $this->avatar;
                    }
                    else{
                        $success['avatar'] = "avatar.png";
                    }
                    // $success['data_nascimento'] = data($this->data_nascimento);cryptPassword2
                    $success['data_cadastro'] = dataBR($this->data_cadastro);
                    $success['u_login'] = dataBR($this->u_login);
                    $success['token_senha'] = $this->token_senha;
                    $success['status'] = '01';
                    $success['msg'] = 'Login efetuado com sucesso.';

                    return $success;


            }
        }
        else {
            $error['status'] = '02';
            $error['msg'] = 'E-mail ou Senha incorretos, tente outros dados!';

            return $error;
        }



    }


    public function verificaCodRecente($id_usuario)
    {
        $sql = $this->mysqli->prepare("SELECT data_cadastro FROM `app_users_two` WHERE app_users_id='$id_usuario' ORDER BY data_cadastro DESC LIMIT 1");
        $sql->execute();
        $sql->bind_result($data_cadastro);
        $sql->fetch();
        $sql->close();

        if ($data_cadastro) {
            $dataCadastro = strtotime($data_cadastro);
            $tempoAtual = time();
            $diferenca = $tempoAtual - $dataCadastro;

            if ($diferenca < 60) {
                $tempoRestante = 60 - $diferenca;
                $error['status'] = '02';
                $error['msg'] = 'Aguarde ' . $tempoRestante . ' segundos para pedir um novo código.';
                return $error;
            } else {
                $error['status'] = '01';
                $error['msg'] = 'Liberado para pedir um novo código.';
                return $error;
            }
        }
    }

    public function validateLoginPainel($email, $password)
    {
        //Update último acesso
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela` SET `u_login`='$this->data_atual' WHERE email = '$email' AND tipo = 2
        ");
        $sql_cadastro->execute();

        $sql = $this->mysqli->prepare(
            "
        SELECT id, tipo, tipo_pessoa, id_empresa, nome, razao_social, email, password, documento, telefone, celular, avatar, data_nascimento, data_cadastro, u_login, token_Senha, status
        FROM `$this->tabela`
        WHERE email = '$email' AND tipo = 2"
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->tipo, $this->tipo_pessoa, $this->id_empresa, $this->nome, $this->razao_social, $this->email, $this->password, $this->documento, $this->telefone, $this->celular, $this->avatar, $this->data_nascimento, $this->data_cadastro, $this->u_login, $this->token_senha, $this->status);
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();
        $sql->close();

        if (crypt($password, $this->password) === $this->password) {

            if ($this->status == 2) {
                $error['status'] = '2';
                $error['msg'] = 'Cadastro inativo.';

                return $error;
            } else {
                $success['id'] = $this->id;
                $success['tipo'] = $this->tipo;
                $success['tipo_pessoa'] = $this->tipo_pessoa;
                $success['id_empresa'] = $this->id_empresa;
                $success['nome'] = $this->nome;
                $success['razao_social'] = $this->razao_social;
                $success['email'] = $this->email;
                $success['documento'] = $this->documento;
                $success['telefone'] = $this->telefone;
                $success['celular'] = $this->celular;
                $success['avatar'] = $this->avatar;
                $success['data_nascimento'] = $this->data_nascimento;
                $success['data_cadastro'] = $this->data_cadastro;
                $success['u_login'] = $this->u_login;
                $success['token_senha'] = $this->token_senha;
                $success['status'] = '01';
                $success['msg'] = 'Login efetuado com sucesso.';

                return $success;
            }
        } else {
            $error['status'] = '02';
            $error['msg'] = 'E-mail ou Senha incorretos, tente outros dados!';

            return $error;
        }
    }



    public function validatePerfil($id)
    {
        $sql = $this->mysqli->prepare(
            "
        SELECT a.id, a.tipo_loja, a.tipo, a.nome, a.nome_fantasia, a.razao_social, a.email, a.cpf,a.cnpj, a.celular, a.avatar, a.data_nascimento, a.data_cadastro, a.u_login, a.token_Senha, a.status,
        b.cep,b.cidade,b.estado,b.bairro,b.endereco,b.numero,b.complemento,b.id,c.site,c.twitter,c.instagram,c.facebook,c.id,c.link,d.url
        FROM `$this->tabela` AS a
        INNER JOIN `app_users_endereco` AS b ON a.id=b.app_users_id
        LEFT JOIN `app_users_info` AS c ON a.id=c.app_users_id
        LEFT JOIN `app_users_imagens` AS d ON a.id = d.app_users_id
        WHERE a.id = '$id'"
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->tipo_loja, $this->tipo, $this->nome, $this->nome_fantasia, $this->razao_social, $this->email, $this->cpf,$this->cnpj, $this->celular, $this->avatar,
        $this->data_nascimento, $this->data_cadastro, $this->u_login, $this->token_senha, $this->status,$this->cep,$this->cidade,$this->estado,$this->bairro,$this->endereco,$this->numero,$this->complemento,$this->id_endereco,
        $this->site,$this->twitter,$this->instagram,$this->facebook,$this->id_info,$this->link_externo,$this->url_vitrine);
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();
        $sql->close();

        //  if (crypt($password, $this->password_hash) === $this->password_hash) {

        if ($rows == 0) {
            $error['status'] = '02';
            $error['msg'] = 'Nenhum registro encontrado.';

            return $error;
        } else {

            if ($this->status == 2) {
                $error['status'] = '2';
                $error['msg'] = 'Cadastro inativo.';

                return $error;
            } else {
                $success['id'] = $this->id;
                $success['tipo'] = $this->tipo;
                $success['url_vitrine'] = $this->url_vitrine;
                $success['tipo_loja'] = $this->tipo_loja;
                $success['link_externo'] = $this->link_externo;
                $success['nome'] = decryptitem($this->nome);
                $success['nome_fantasia'] = $this->nome_fantasia;
                $success['razao_social'] = $this->razao_social;
                $success['email'] = decryptitem($this->email);
                $success['cpf'] = decryptitem($this->cpf);
                $success['cnpj'] = decryptitem($this->cnpj);
                $success['celular'] = decryptitem($this->celular);
                $success['avatar'] = $this->avatar;
                $success['data_nascimento'] = dataBR($this->data_nascimento);
                $success['data_cadastro'] = dataBR($this->data_cadastro);
                $success['u_login'] = dataBR($this->u_login);
                $success['id_endereco'] = $this->id_endereco;
                $success['cep'] = decryptitem($this->cep);
                $success['cidade'] = decryptitem($this->cidade);
                $success['estado'] = decryptitem($this->estado);
                $success['bairro'] = decryptitem($this->bairro);
                $success['endereco'] = decryptitem($this->endereco);
                $success['numero'] = decryptitem($this->numero);
                $success['complemento'] = decryptitem($this->complemento);
                $success['id_info'] = $this->id_info;
                $success['site'] = $this->site;
                $success['twitter'] = $this->twitter;
                $success['instagram'] = $this->instagram;
                $success['facebook'] = $this->facebook;

                // $success['status'] = '01';
                // $success['msg'] = 'Login efetuado com sucesso.';

                return $success;
            }
        }
    }
    public function validatePerfilApp($id)
    {
        $sql = $this->mysqli->prepare(
            "
        SELECT a.id, a.tipo, a.nome, a.nome_fantasia, a.razao_social, a.email, a.cpf,a.cnpj, a.celular, a.avatar, a.data_nascimento, a.data_cadastro, a.u_login,
         a.token_Senha, a.status , b.latitude,b.longitude,c.site,c.twitter,c.instagram,c.facebook,c.id
        FROM `$this->tabela` AS a
        LEFT JOIN `app_users_location` AS b ON b.app_users_id = a.id
        LEFT JOIN `app_users_info` AS c ON a.id=c.app_users_id
        WHERE a.id = '$id'"
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->tipo, $this->nome, $this->nome_fantasia, $this->razao_social, $this->email, $this->cpf,$this->cnpj, $this->celular, $this->avatar,
        $this->data_nascimento, $this->data_cadastro, $this->u_login, $this->token_senha, $this->status, $this->latitude, $this->longitude, $this->site,$this->twitter,$this->instagram,$this->facebook,$this->id_info);
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();
        $sql->close();

        //  if (crypt($password, $this->password_hash) === $this->password_hash) {

        if ($rows == 0) {
            $error['status'] = '02';
            $error['msg'] = 'Nenhum registro encontrado.';

            return $error;
        } else {

            if ($this->status == 2) {
                $error['status'] = '2';
                $error['msg'] = 'Cadastro inativo.';

                return $error;
            } else {
                $helper_enderecos = new EnderecosHelper();
                $endereco_final = $helper_enderecos->gerarEndereco($this->latitude, $this->longitude,"","","","","","","");

                $success['id'] = $this->id;
                $success['tipo'] = $this->tipo;
                $success['nome'] = decryptitem($this->nome);
                $success['email'] = decryptitem($this->email);
                $success['cpf'] = decryptitem($this->cpf);
                $success['celular'] = decryptitem($this->celular);
                $success['avatar'] = $this->avatar;
                $success['data_nascimento'] = decryptitem($this->data_nascimento);
                $success['data_cadastro'] = dataBR($this->data_cadastro);
                $success['u_login'] = dataBR($this->u_login);
                $success['latitude'] = $this->latitude;
                $success['longitude'] = $this->longitude;
                // $success['cep'] = str_replace('-', '', $endereco_final['cep']);
                $success['estado'] = $endereco_final['uf'];
                $success['cidade'] = $endereco_final['cidade'];
                $success['bairro'] = $endereco_final['bairro'] ?? "";
                $success['endereco'] = $endereco_final['endereco'];
                $success['id_info'] = $this->id_info ?? "";
                $success['site'] = $this->site ?? "";
                $success['twitter'] = $this->twitter ?? "";
                $success['instagram'] = $this->instagram ?? "";
                $success['facebook'] = $this->facebook ?? "";
                $success['status'] = "01";
                // $success['numero'] = $endereco_final['numero'];
                // $success['complemento'] = $endereco_final['complemento'];
                // $success['status'] = '01';
                // $success['msg'] = 'Login efetuado com sucesso.';

                return $success;
            }
        }
    }

    public function verificaPlano($id)
    {

        $sql = $this->mysqli->prepare(
            "
            SELECT `app_planos_v`.`validade_dias`, `app_users_planos`.`app_users_id`, `app_planos_v`.`cod`, `app_planos`.`nome`, `app_planos`.`descricao`,`app_users_planos`.`data_validade`, datediff(`app_users_planos`.`data_validade`, now()) as data_plano FROM `app_users_planos`
            INNER JOIN `app_planos_v` ON `app_users_planos`.`cod` = `app_planos_v`.`cod`
            INNER JOIN `app_planos` ON `app_planos_v`.`app_planos_id` = `app_planos`.`id`
        WHERE `app_users_planos`.`app_users_id` = '$id'"
        );
        $sql->execute();
        $sql->bind_result($this->validade_dias, $this->app_users_id, $this->cod, $this->nome, $this->descricao, $this->data_validade, $this->data_plano/*, $this->email, $this->password, $this->documento, $this->telefone, $this->celular, $this->avatar, $this->data_nascimento, $this->data_cadastro, $this->u_login, $this->token_senha, $this->status*/);
        $sql->store_result();
        $rows = $sql->num_rows;
        $sql->fetch();
        $sql->close();

        $progresso = $this->data_plano / $this->validade_dias * 100;
        $progresso2 = number_format($progresso, 2, '.', '');

        //  if (crypt($password, $this->password_hash) === $this->password_hash) {

        if ($rows == 0) {
            $error['msg'] = 'Nenhum plano encontrado.';

            return $error;
        } else {

            $success['app_users_id'] = $this->app_users_id;
            $success['cod'] = $this->cod;
            $success['nome'] = $this->nome;
            $success['data_validade'] = $this->data_validade;
            $success['data_plano'] = "Restam " . $this->data_plano . " dias";
            $success['dias'] = $this->validade_dias;
            $success['progresso'] = $progresso2;
            $success['descricao'] = $this->descricao;
            $success['msg'] = 'Plano consultado com sucesso.';

            return $success;

            //  } else {
            //     $error['status'] = '02';
            //      $error['msg'] = 'E-mail ou Senha incorretos, tente outros dados!';

            //     return $error;
            //  }
        }
    }



    public function validateCpf($cpf, $tipo)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tabela` WHERE cpf = '$cpf' AND tipo='$tipo'");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();
        $sql->close();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Já existe um usuário com este cpf, por favor tente outros dados.';

            return $error;
        }
    }

    public function listMenusPermitidos($id_grupo)
    {

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

    public function validateCpfUpdate($cpf, $id)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tabela` WHERE cpf = '$cpf' AND id<>'$id'");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();
        $sql->close();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Já existe um usuário com este cpf, por favor tente outros dados.';

            return $error;
        }
    }

    public function checkReserva($id_de, $id_para, $data, $horario)
    {

        $sql = $this->mysqli->prepare("
        SELECT * FROM app_reservas
        WHERE id_de='$id_de' AND id_para='$id_para' AND data='$data' AND horario='$horario' AND status='1'
        ");
        $sql->execute();
        $sql->store_result();
        $rows = $sql->num_rows;


        return $rows;
    }

    public function checkCardapio($id){


        $sql = $this->mysqli->prepare("SELECT * FROM app_cardapios WHERE app_users_id='$id'");
        $sql->execute();
        $sql->store_result();
        $rows = $sql->num_rows;


        return $rows;
    }

    public function lista()
    {

        $sql = $this->mysqli->prepare("SELECT id, nome, email, password FROM `app_users` WHERE id_grupo IN (1,2,3)");
        $sql->execute();
        $sql->bind_result($id, $nome, $email, $password);
        $sql->store_result();
        $rows = $sql->num_rows;


        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['nome'] = decryptitem($nome);
                $Param['email'] = decryptitem($email);
                $Param['password'] = $password;

                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }
}
