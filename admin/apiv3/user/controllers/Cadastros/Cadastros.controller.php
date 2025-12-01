<?php

require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Cadastros/Cadastros.class.php';
require_once MODELS . '/Usuarios/Enderecos.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once HELPERS . '/UsuariosHelper.class.php';
require_once HELPERS . '/EnderecosHelper.class.php';
require_once MODELS . '/phpMailer/Enviar.class.php';
require_once MODELS . '/Notificacoes/Notificacoes.class.php';

class CadastrosController {

    public function __construct() {

        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();

        $this->req = $_REQUEST;
        $this->data_atual = date('Y-m-d H:i:s');
        $this->dia_atual = date('Y-m-d');
        $this->id_menu = 2;
    }


    public function listAllCadastros()
    {

        $this->secure->tokens_secure($this->input->token);
        $this->secure->validatemenu($this->id_menu,$this->input->id_grupo);

        $cadastros = new Cadastros();
        $consultacadastros = $cadastros->listAllCadastros($this->input->id_usuario,$this->input->nome,dataUS($this->input->data_de),dataUS($this->input->data_ate),
        $this->input->cidade,$this->input->estado);
        jsonReturn($consultacadastros);
    }

    public function listPendentes()
    {

        $this->secure->tokens_secure($this->input->token);
        $this->secure->validatemenu($this->id_menu,$this->input->id_grupo);

        $cadastros = new Cadastros();
        $consultacadastros = $cadastros->listPendentes();
        jsonReturn($consultacadastros);
    }

    public function listAllEmpresas()
    {

        $this->secure->tokens_secure($this->input->token);
        $this->secure->validatemenu($this->id_menu,$this->input->id_grupo);

        $cadastros = new Cadastros();
        $consultacadastros = $cadastros->listAllEmpresas($this->input->id_usuario,$this->input->nome,dataUS($this->input->data_de),dataUS($this->input->data_ate));
        jsonReturn($consultacadastros);
    }
    public function ListIdDadosAprovados()
    {

        $this->secure->tokens_secure($this->input->token);

        $cadastros = new Cadastros();
        $consultacadastros = $cadastros->ListIdDadosAprovados($this->input->id_usuario);
        jsonReturn($consultacadastros);
    }
    public function listAllPlanos()
    {

        $this->secure->tokens_secure($this->input->token);

        $cadastros = new Cadastros();
        $consultacadastros = $cadastros->listAllPlanos($this->input->id_plano);

        jsonReturn($consultacadastros);
    }

    public function exportarCsv() {
        // Crie o arquivo CSV
        $cadastros = new Cadastros();
        $cadastros->gerarCSV();


        $Param = [
            "status" => "01",
            "msg" => "CSV criado"
        ];

        jsonReturn(array($Param));
    }

    public function saveCupons()
    {

        $this->secure->tokens_secure($this->input->token);

        $cadastros = new Cadastros();
        $consultacadastros = $cadastros->saveCupons($this->input->id_usuario,$this->input->tipo_desc,moneySQL($this->input->valor),dataUS($this->input->data_in),dataUS($this->input->data_out));

        jsonReturn($consultacadastros);
    }

    public function updateCupons()
    {

        $this->secure->tokens_secure($this->input->token);

        $cadastros = new Cadastros();
        $consultacadastros = $cadastros->updateCupons($this->input->id_usuario,$this->input->id_cupom,$this->input->tipo_desc,moneySQL($this->input->valor),dataUS($this->input->data_in),dataUS($this->input->data_out),$this->input->status);

        jsonReturn($consultacadastros);
    }

    public function deleteCupom()
    {

        $this->secure->tokens_secure($this->input->token);

        $cadastros = new Cadastros();

        $consultacadastros = $cadastros->deleteCupom($this->input->id_cupom);

        jsonReturn($consultacadastros);
    }
    public function listAllCupons()
    {

        $this->secure->tokens_secure($this->input->token);

        $cadastros = new Cadastros();
        $consultacadastros = $cadastros->listAllCupons($this->input->id_usuario);

        jsonReturn($consultacadastros);
    }
    public function ListIdCupons()
    {

        $this->secure->tokens_secure($this->input->token);

        $cadastros = new Cadastros();
        $consultacadastros = $cadastros->ListIdCupons($this->input->id_cupom);

        jsonReturn($consultacadastros);
    }
    public function listAllPagamentos()
    {

        $this->secure->tokens_secure($this->input->token);

        $cadastros = new Cadastros();
        $consultacadastros = $cadastros->listAllPagamentos($this->input->id_usuario);

        jsonReturn($consultacadastros);
    }
    public function EstatisticasGerais()
    {

        $this->secure->tokens_secure($this->input->token);

        $cadastros = new Cadastros();
        $consultacadastros = $cadastros->EstatisticasGerais($this->input->id_usuario);

        jsonReturn($consultacadastros);
    }
    public function updatePlanos()
    {

        $this->secure->tokens_secure($this->input->token);

        $cadastros = new Cadastros();
        $consultacadastros = $cadastros->updatePlanos($this->input->id_usuario,$this->input->id_plano,dataUS($this->input->validade_plano));

        jsonReturn($consultacadastros);
    }

    public function updateCadastro()
    {

        $this->secure->tokens_secure($this->input->token);
        $helper = new UsuariosHelper();
        $cadastros = new Cadastros();

        $emailCheck = $helper->validateEmailCadastro($this->input->id, cryptitem($this->input->email));

        if ($emailCheck) {
            jsonReturn(array($emailCheck));
        }

        $consultacadastros = $cadastros->updateCadastro(
          $this->input->id,
          cryptitem($this->input->nome),
          cryptitem($this->input->email),
          cryptitem($this->input->celular),
          cryptitem($this->input->documento),
          cryptitem($this->input->data_nascimento),
          $this->input->perc_imoveis,
          $this->input->perc_eventos,
          $this->input->status_aprovado,
          $this->input->status
        );

        jsonReturn($consultacadastros);
    }

    public function updateCompany()
    {

        $this->secure->tokens_secure($this->input->token);
        $helper = new UsuariosHelper();
        $cadastros = new Cadastros();

        $consultacadastros = $cadastros->updateCompany(cryptitem($this->input->nome),$this->input->link, $this->input->saq, $this->input->url);

        jsonReturn($consultacadastros);
    }

    public function updateCadastroAdmin()
    {

        $this->secure->tokens_secure($this->input->token);
        $helper = new UsuariosHelper();
        $cadastros = new Cadastros();

        $emailCheck = $helper->validateEmailUpdate(cryptitem($this->input->email), $this->input->id_usuario);
        $cnpjCheck = $helper->validateCNPJUpdate(cryptitem($this->input->documento), $this->input->id_usuario);
        $celularCheck = $helper->validateCelularClienteUpdate(cryptitem($this->input->celular),$this->input->id_usuario);
        if ($celularCheck) {
            jsonReturn(array($celularCheck));
        }
        if ($emailCheck) {
            jsonReturn(array($emailCheck));
        }
        if ($cnpjCheck) {
            jsonReturn(array($cnpjCheck));
        }

        $consultacadastros = $cadastros->updateCadastro($this->input->id_usuario, cryptitem($this->input->nome), cryptitem($this->input->email), cryptitem($this->input->documento),
        cryptitem($this->input->celular), $this->input->data_nascimento, $this->input->status_aprovado);

        jsonReturn($consultacadastros);
    }

    public function saveEmpresa()
    {

        $this->nome = cryptitem($_POST['nome']);
        $this->link = $_POST['link'];
        $this->saq = $_POST['saq'];
        $this->secure->tokens_secure($_POST['token']);
        $this->pasta = '../../../uploads/avatar';

        $usuarios =  new Cadastros();

        // $this->app_users_id = $id;
        //echo $this->app_users_id;
        // exit;

        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->avatar)) {
            $this->avatar_final = $this->avatar;
            move_uploaded_file($this->avatar_tmp, $this->pasta . "/" . $this->avatar_final);
        } else {
            $this->avatar_final = "avatar.png";
        }

        $result = $usuarios->saveEmpresa($this->nome,$this->link,$this->saq, $this->avatar_final);

        jsonReturn(array($result));
    }

    public function updateavatar()
    {

        $this->app_users_id = $_POST['id_user'];

        $this->secure->tokens_secure($_POST['token']);

        $this->pasta = '../../uploads/avatar';

        $usuarios =  new Usuarios();

        // echo $this->pasta;exit;

        $this->avatar = renameUpload(basename($_FILES['url']['name']));
        $this->avatar_tmp = $_FILES['url']['tmp_name'];

        if (!empty($this->avatar)) {

            //ENVIA PARA PASTA IMAGEM TEMPORÁRIA
            $this->avatar_final = $this->avatar;
            move_uploaded_file($this->avatar_tmp, $this->pasta . "/temporarias/" . $this->avatar_final);

            $imagem = new TutsupRedimensionaImagem();

            $imagem->imagem = $this->pasta . '/temporarias/' . $this->avatar_final;
            $imagem->imagem_destino = $this->pasta . '/' . $this->avatar_final;

            // print_r($imagem->imagem_destino);exit;

            $imagem->largura = 250;
            $imagem->altura = 0;
            $imagem->qualidade = 100;

            $nova_imagem = $imagem->executa();

            unlink($this->pasta . "/temporarias/" . $this->avatar_final); // remove o arquivo da pasta temporária
        } else {
            $this->avatar_final = "avatar.png";
        }

        $result = $usuarios->updateAvatar($this->app_users_id, $this->avatar_final);

        jsonReturn($result);
    }
    public function updateEndereco()
    {

        $this->secure->tokens_secure($this->input->token);

        $cadastros = new Cadastros();
        $lat_long = geraLatLong($this->input->endereco,$this->input->numero,$this->input->bairro, $this->input->cidade);
        // print_r($lat_long);exit;
        $consultacadastros = $cadastros->updateEndereco($this->input->id_usuario, cryptitem($this->input->cep), cryptitem($this->input->estado), cryptitem($this->input->cidade),
        cryptitem($this->input->endereco),cryptitem($this->input->bairro),cryptitem($this->input->numero),cryptitem($this->input->complemento),cryptitem($lat_long[0]),cryptitem($lat_long[1]));

        jsonReturn($consultacadastros);
    }
    public function deleteCadastro()
    {

        $this->secure->tokens_secure($this->input->token);

        $cadastros = new Cadastros();

        $consultacadastros = $cadastros->deleteCadastro($this->input->id_usuario);

        jsonReturn($consultacadastros);
    }
    public function aprovaCadastro()
    {

        $this->secure->tokens_secure($this->input->token);

        $cadastros = new Cadastros();
        $mail = new EnviarEmail();
        $notificacoes = new Notificacoes();

        $consultacadastros = $cadastros->aprovaCadastro($this->input->id_usuario);

        $user = $cadastros->perfil($this->input->id_usuario);
        $mail->confirmaFornecedor($user['nome'],$user['email']);
        $notificacoes->notificacaoUser("Cadastro aprovado!","A partir de agora sua empresa vai atender novos clientes.",$this->input->id_usuario);

        jsonReturn($consultacadastros);
    }
    public function perfil()
    {

        $this->secure->tokens_secure($this->input->token);

        $usuarios = new Cadastros();
        $perfil = $usuarios->Perfil($this->input->id);

        jsonReturn($perfil);
    }

    public function reprovaCadastro()
    {

        $this->secure->tokens_secure($this->input->token);

        $cadastros = new Cadastros();

        $consultacadastros = $cadastros->reprovaCadastro($this->input->id_usuario);

        jsonReturn($consultacadastros);
    }

    public function updatepassword()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $cadastros = new Cadastros();

        //$usuarioDados = $usuarios->listid_franqueado($this->input->id);

        // print_r($this->input->password);exit;
        $this->hash = $helper->cryptPassword2($this->input->password);
        $consultacadastros = $cadastros->updatePassword($this->input->id_usuario, $this->hash);

        jsonReturn(array($consultacadastros));
    }

}
