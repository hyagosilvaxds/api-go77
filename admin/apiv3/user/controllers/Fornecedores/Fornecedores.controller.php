<?php

require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Fornecedores/Fornecedores.class.php';
require_once MODELS . '/Usuarios/Enderecos.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once HELPERS . '/UsuariosHelper.class.php';
require_once HELPERS . '/EnderecosHelper.class.php';

class FornecedoresController {

    public function __construct() {

        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();
        
        $this->req = $_REQUEST;
        $this->data_atual = date('Y-m-d H:i:s');
        $this->dia_atual = date('Y-m-d');
        $this->id_menu = 2;
    }
    

    public function listAllFornecedores()
    {

        $this->secure->tokens_secure($this->input->token);
        $this->secure->validatemenu($this->id_menu,$this->input->id_grupo);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->listAllFornecedores($this->input->id_usuario,$this->input->nome,dataUS($this->input->data_de),dataUS($this->input->data_ate),
        $this->input->cidade,$this->input->estado);
        jsonReturn($consultafornecedores);
    }
    
    public function listPendentes()
    {

        $this->secure->tokens_secure($this->input->token);
        $this->secure->validatemenu($this->id_menu,$this->input->id_grupo);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->listPendentes();
        jsonReturn($consultafornecedores);
    }

    public function listAllEmpresas()
    {

        $this->secure->tokens_secure($this->input->token);
        $this->secure->validatemenu($this->id_menu,$this->input->id_grupo);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->listAllEmpresas($this->input->id_usuario,$this->input->nome,dataUS($this->input->data_de),dataUS($this->input->data_ate));
        jsonReturn($consultafornecedores);
    }
    public function ListIdDadosAprovados()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->ListIdDadosAprovados($this->input->id_usuario);
        jsonReturn($consultafornecedores);
    }
    public function listCategoriasUser()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->listCategoriasUser($this->input->id_user);

        jsonReturn($consultafornecedores);
    }
    public function addCategoria()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->addCategoria($this->input->id_user,$this->input->id_categoria);

        jsonReturn($consultafornecedores);
    }
    public function deleteCategorias()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->deleteCategorias($this->input->id_user,$this->input->id_categoria);

        jsonReturn($consultafornecedores);
    }
    public function listAllPlanos()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->listAllPlanos($this->input->id_plano);

        jsonReturn($consultafornecedores);
    }

    public function exportarCsv() {
        // Crie o arquivo CSV
        $fornecedores = new Fornecedores();
        $fornecedores->gerarCSV();
    
        
        $Param = [
            "status" => "01",
            "msg" => "CSV criado"
        ];

        jsonReturn(array($Param));
    }
    
    public function saveCupons()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->saveCupons($this->input->id_usuario,$this->input->tipo_desc,moneySQL($this->input->valor),dataUS($this->input->data_in),dataUS($this->input->data_out));

        jsonReturn($consultafornecedores);
    }

    public function updateCupons()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->updateCupons($this->input->id_usuario,$this->input->id_cupom,$this->input->tipo_desc,moneySQL($this->input->valor),dataUS($this->input->data_in),dataUS($this->input->data_out),$this->input->status);

        jsonReturn($consultafornecedores);
    }

    public function deleteCupom()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();

        $consultafornecedores = $fornecedores->deleteCupom($this->input->id_cupom);

        jsonReturn($consultafornecedores);
    }
    public function listAllCupons()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->listAllCupons($this->input->id_usuario);

        jsonReturn($consultafornecedores);
    }
    public function ListIdCupons()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->ListIdCupons($this->input->id_cupom);

        jsonReturn($consultafornecedores);
    }
    public function listAllPagamentos()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->listAllPagamentos($this->input->id_usuario);

        jsonReturn($consultafornecedores);
    }
    public function atualizaTaxa()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->atualizaTaxa($this->input->id_usuario,$this->input->taxa_mes,$this->input->taxa_perc);

        jsonReturn($consultafornecedores);
    }
    public function EstatisticasGerais()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->EstatisticasGerais($this->input->id_usuario);

        jsonReturn($consultafornecedores);
    }
    public function updatePlanos()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();
        $consultafornecedores = $fornecedores->updatePlanos($this->input->id_usuario,$this->input->id_plano,dataUS($this->input->validade_plano));

        jsonReturn($consultafornecedores);
    }
 
    public function updateCadastro()
    {

        $this->secure->tokens_secure($this->input->token);
        $fornecedores = new Fornecedores();

        $consultafornecedores = $fornecedores->updateCadastro($this->input->id_usuario, cryptitem($this->input->nome),cryptitem($this->input->nome_responsavel),$this->input->tempo_resposta,
        cryptitem($this->input->cnpj),cryptitem($this->input->razao_social),cryptitem($this->input->ie), $this->input->status_aprovado, moneySQL($this->input->taxa_mensal), $this->input->taxa_perc);

        jsonReturn($consultafornecedores);
    }

    public function updateCompany()
    {

        $this->secure->tokens_secure($this->input->token);
        $helper = new UsuariosHelper();
        $fornecedores = new Fornecedores();

        $consultafornecedores = $fornecedores->updateCompany(cryptitem($this->input->nome),$this->input->link, $this->input->saq, $this->input->url);

        jsonReturn($consultafornecedores);
    }

    public function updateCadastroAdmin()
    {

        $this->secure->tokens_secure($this->input->token);
        $helper = new UsuariosHelper();
        $fornecedores = new Fornecedores();

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

        $consultafornecedores = $fornecedores->updateCadastro($this->input->id_usuario, cryptitem($this->input->nome), cryptitem($this->input->email), cryptitem($this->input->documento),
        cryptitem($this->input->celular), $this->input->data_nascimento, $this->input->status_aprovado);

        jsonReturn($consultafornecedores);
    }

    public function saveEmpresa()
    {

        $this->nome = cryptitem($_POST['nome']);
        $this->link = $_POST['link']; 
        $this->saq = $_POST['saq'];
        $this->secure->tokens_secure($_POST['token']);
        $this->pasta = '../../../uploads/avatar';

        $usuarios =  new Fornecedores();

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

        $fornecedores = new Fornecedores();
        $lat_long = geraLatLong($this->input->endereco,$this->input->numero,$this->input->bairro, $this->input->cidade);
        // print_r($lat_long);exit;
        $consultafornecedores = $fornecedores->updateEndereco($this->input->id_usuario, cryptitem($this->input->cep), cryptitem($this->input->estado), cryptitem($this->input->cidade),
        cryptitem($this->input->endereco),cryptitem($this->input->bairro),cryptitem($this->input->numero),cryptitem($this->input->complemento),cryptitem($lat_long[0]),cryptitem($lat_long[1]));

        jsonReturn($consultafornecedores);
    }
    public function deleteCadastro()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();

        $consultafornecedores = $fornecedores->deleteCadastro($this->input->id_usuario);

        jsonReturn($consultafornecedores);
    }
    public function aprovaCadastro()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();

        $consultafornecedores = $fornecedores->aprovaCadastro($this->input->id_usuario);

        jsonReturn($consultafornecedores);
    }

    public function reprovaCadastro()
    {

        $this->secure->tokens_secure($this->input->token);

        $fornecedores = new Fornecedores();

        $consultafornecedores = $fornecedores->reprovaCadastro($this->input->id_usuario);

        jsonReturn($consultafornecedores);
    }

    public function updatepassword()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $fornecedores = new Fornecedores();

        //$usuarioDados = $usuarios->listid_franqueado($this->input->id);

        // print_r($this->input->password);exit;
        $this->hash = $helper->cryptPassword2($this->input->password);
        $consultafornecedores = $fornecedores->updatePassword($this->input->id_usuario, $this->hash);

        jsonReturn(array($consultafornecedores));
    }

}

