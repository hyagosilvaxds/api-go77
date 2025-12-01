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

        return $this->hash;
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

        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tabela` WHERE email = '$email' AND id_grupo='4' ");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Email em uso, por favor tente outros dados.';

            return $error;
        }
    }

    public function validateCod($codigo)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tabela` WHERE cod='$codigo' AND tipo='2'");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->store_result();
        $rows = $sql->num_rows;

        if($rows > 0){

          $param['status'] = "02";
          $param['msg'] = "Código já possui cadastro, tente outros dados";

          $lista[] = $param;

        }else{

          $usuarios = new Usuarios();
          $nome_tecnico = $usuarios->loginTecnico($codigo);

          if(isset($nome_tecnico)){
            $param['status'] = "01";
            $param['msg'] = "OK";
            $param['nome'] = $nome_tecnico;

            $lista[] = $param;
          }else{
            $param['status'] = "02";
            $param['msg'] = "Código inválido, entre outros dados";

            $lista[] = $param;
          }



        }

        return $lista;
    }

    public function validateIdade($data_nascimento)
    {

      $firstDate  = new DateTime($data_nascimento);
      $secondDate = new DateTime(date('Y-m-d'));
      $intvl = $firstDate->diff($secondDate);

      if($intvl->y < 18){
        $error['status'] = '2';
        $error['msg'] = 'Este aplicativo requer maior idade para ser utilizado." e não prosseguir com o cadastro.';

        return $error;
      }



    }

    public function validateEmailEtapa1($email)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tabela` WHERE email = '$email'");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Email em uso, por favor tente outros dados.';

            return $error;
        }else{
          $error['status'] = '01';
          $error['msg'] = 'E-mail disponível';
        }

        return $error;
    }


    public function validateCelular($celular)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tabela` WHERE celular = '$celular'");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Celular em uso, por favor tente outros dados.';

            return $error;
        }
    }

    public function validateEmailUpdate($email, $id)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tabela` WHERE email = '$email' AND id<>'$id'");
        $sql->execute();
        $sql->bind_result($this->id);
        $sql->fetch();

        if (isset($this->id)) {
            $error['status'] = '02';
            $error['msg'] = 'Já existe um usuário com este email, por favor tente outros dados.';

            return $error;
        }
    }

    public function consultaPaixoes($id)
    {

        $sql = $this->mysqli->prepare("SELECT app_paixoes_id FROM `app_users_paixoes` WHERE app_users_id = '$id'");
        $sql->execute();
        $sql->bind_result($this->app_paixoes_id);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param = $rows;
        } else {
            while ($row = $sql->fetch()) {

                $Param[] = $this->app_paixoes_id;
            }
        }
        return $Param;
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
    public function validateDoisFatores($email, $password, $latitude, $longitude)
    {

        $sql = $this->mysqli->prepare(
            "SELECT id,nome, email,password, documento, celular, avatar, data_nascimento, 
        data_cadastro, u_login, token_senha, status, status_aprovado
        FROM `$this->tabela` WHERE email ='$email' AND id_grupo='4'"
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

    public function verificaCod($id_usuario,$codigo)
    {
        // DEV MODE: Código curinga "0000" sempre funciona
        if ($codigo === '0000') {
            // Marca qualquer código pendente como usado
            $sql_cadastro = $this->mysqli->prepare("
            UPDATE `app_users_two` SET `status`='1' WHERE app_users_id = '$id_usuario'
            ");
            $sql_cadastro->execute();
            
            $error['status'] = '01';
            $error['msg'] = 'Código confirmado (DEV MODE), prossiga para o app.';
            return $error;
        }

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

    public function validateLogin($email, $password,$tipo)
    {
        // print_r(crypt($password, $this->password));exit;
        // //Update último acesso
        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela` SET `u_login`='$this->data_atual' , online='2' WHERE email = '$email' AND id_grupo='4'
        ");
        $sql_cadastro->execute();

        $sql = $this->mysqli->prepare(
            "
        SELECT id,nome,email,password, documento, celular, avatar, data_nascimento, 
        data_cadastro, u_login, token_senha, status, status_aprovado
        FROM `$this->tabela` WHERE email ='$email' AND id_grupo='4'"
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
                    $success['id'] = $this->id;
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
                    // $success['data_nascimento'] = data($this->data_nascimento);
                    $success['data_cadastro'] = data($this->data_cadastro);
                    $success['u_login'] = data($this->u_login);
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

    public function loginMidias($email){


        $sql = $this->mysqli->prepare("
        SELECT id, nome, email, password, celular, avatar, data_nascimento,
        data_cadastro, u_login, status, status_aprovado
        FROM `$this->tabela`
        WHERE email = '$email' AND id_grupo = 4"
        );
        $sql->execute();
        $sql->bind_result($this->id,$this->nome,$this->email, $this->password, $this->celular, $this->avatar,  $this->data_nascimento, $this->data_cadastro, $this->u_login, $this->status, $this->status_aprovado);
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


    public function login($email, $password)
    {

        //Update último acesso
        $sql_cadastro = $this->mysqli->prepare("UPDATE `$this->tabela` SET `u_login`='$this->data_atual' WHERE email = '$email'");
        $sql_cadastro->execute();
        $sql_cadastro->store_result();
        $sql_cadastro->close();

        $sql = $this->mysqli->prepare("SELECT id, nome, email, password, celular, status FROM `$this->tabela` WHERE email = '$email' AND tipo='2' AND tipo_equipe='1'");
        $sql->execute();
        $sql->bind_result($this->id, $this->nome, $this->email, $this->password, $this->celular, $this->status);
        $sql->store_result();
        $sql->fetch();


        if (crypt($password, $this->password) === $this->password) {

            if ($this->confirmado == 2) {
                $error['status'] = '03';
                $error['msg'] = 'Email não confirmado.';

                return $error;
            } else {


                if ($this->desativado == 2) {
                    $error['status'] = '04';
                    $error['msg'] = 'Cadastro desativado, deseja reativar?';

                    return $error;
                } else {

                    if ($this->status == 2) {
                        $error['status'] = '05';
                        $error['msg'] = 'Cadastro desativado pelo administrador.';

                        return $error;
                    } else {

                        $success['id'] = $this->id;
                        $success['cod_cliente'] = $this->cod_cliente;
                        $success['nome_fantasia'] = $this->nome_fantasia;
                        $success['nome'] = $this->nome;
                        $success['email'] = $this->email;
                        $success['celular'] = $this->celular;
                        $success['status'] = '01';
                        $success['msg'] = 'Login efetuado com sucesso.';

                        return $success;
                    }
                }
            }
        } else {
            $error['status'] = '02';
            $error['msg'] = 'E-mail ou Senha incorretos, tente outros dados!';

            return $error;
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

    public function validateCpfUpdate($cpf, $tipo, $id)
    {

        $sql = $this->mysqli->prepare("SELECT id FROM `$this->tabela` WHERE cpf = '$cpf' AND tipo='$tipo' AND id<>'$id'");
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
}
