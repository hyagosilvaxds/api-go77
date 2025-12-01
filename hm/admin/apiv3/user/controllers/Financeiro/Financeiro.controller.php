<?php

require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Financeiro/Financeiro.class.php';
require_once MODELS . '/Usuarios/Enderecos.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once HELPERS . '/UsuariosHelper.class.php';
require_once HELPERS . '/EnderecosHelper.class.php';

class FinanceiroController {

    public function __construct() {

        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();

        $this->req = $_REQUEST;
        $this->data_atual = date('Y-m-d H:i:s');
        $this->dia_atual = date('Y-m-d');
        $this->id_menu = 12;
    }


    public function listAllFinanceiro()
    {

        $this->secure->tokens_secure($this->input->token);
        $this->secure->validatemenu($this->id_menu,$this->input->id_grupo);
        
        $financeiro = new Financeiro();
        $consultafinanceiro = $financeiro->listAllFinanceiro($this->input->id_financeiro,$this->input->nome,$this->input->email,dataUS($this->input->data_de),dataUS($this->input->data_ate));

        jsonReturn($consultafinanceiro);
    }
    public function listIDFinanceiro()
    {

        $this->secure->tokens_secure($this->input->token);
        $financeiro = new Financeiro();
        $consultafinanceiro = $financeiro->listIDfinanceiro($this->input->id_financeiro);

        jsonReturn($consultafinanceiro);
    }

    public function exportarCsv() {
        // Crie o arquivo CSV
        $financeiro = new Financeiro();
        $financeiro->gerarCSV();


        $Param = [
            "status" => "01",
            "msg" => "CSV criado"
        ];

        jsonReturn(array($Param));
    }
    public function listAllEstabelecimentosPendentes()
    {

        $this->secure->tokens_secure($this->input->token);

        $estabelecimentos = new Estabelecimentos();
        $consultaestabelecimentos = $estabelecimentos->listAllEstabelecimentosPendentes($this->input->id_usuario,$this->input->nome,$this->input->email,dataUS($this->input->data_de),dataUS($this->input->data_ate));

        jsonReturn($consultaestabelecimentos);
    }
    public function listAllPlanos()
    {

        $this->secure->tokens_secure($this->input->token);

        $profissionais = new Profissionais();
        $consultaprofissionais = $profissionais->listAllPlanos($this->input->id_plano);

        jsonReturn($consultaprofissionais);
    }
    public function AprovarEstabelecimento()
    {

        $this->secure->tokens_secure($this->input->token);

        $estabelecimentos = new Estabelecimentos();
        $consultaestabelecimentos = $estabelecimentos->AprovarEstabelecimento($this->input->id_usuario);

        jsonReturn($consultaestabelecimentos);
    }
    public function ReprovarEstabelecimento()
    {

        $this->secure->tokens_secure($this->input->token);

        $estabelecimentos = new Estabelecimentos();
        $consultaestabelecimentos = $estabelecimentos->ReprovarEstabelecimento($this->input->id_usuario);

        jsonReturn($consultaestabelecimentos);
    }
    public function listAllPagamentos()
    {

        $this->secure->tokens_secure($this->input->token);

        $estabelecimentos = new Estabelecimentos();
        $consultaestabelecimentos = $estabelecimentos->listAllPagamentos($this->input->id_usuario);

        jsonReturn($consultaestabelecimentos);
    }
    public function EstatisticasGerais()
    {

        $this->secure->tokens_secure($this->input->token);

        $estabelecimentos = new Estabelecimentos();
        $consultaestabelecimentos = $estabelecimentos->EstatisticasGerais($this->input->id_usuario);

        jsonReturn($consultaestabelecimentos);
    }
    public function updatePlanos()
    {

        $this->secure->tokens_secure($this->input->token);

        $profissionais = new Profissionais();
        $consultaprofissionais = $profissionais->updatePlanos($this->input->id_usuario,$this->input->id_plano,dataUS($this->input->validade_plano));

        jsonReturn($consultaprofissionais);
    }

    public function updateCadastro()
    {

        $this->secure->tokens_secure($this->input->token);
        $helper = new UsuariosHelper();
        $estabelecimentos = new Estabelecimentos();

        $emailCheck = $helper->validateEmailUpdate(cryptitem($this->input->email), $this->input->id_user);

        if ($emailCheck) {
            jsonReturn(array($emailCheck));
        }

        $consultaestabelecimentos = $estabelecimentos->updateCadastro($this->input->id_usuario, cryptitem($this->input->nome), cryptitem($this->input->email), cryptitem($this->input->documento),
        cryptitem($this->input->celular), $this->input->data_nascimento, $this->input->status, $this->input->status_aprovado);

        jsonReturn($consultaestabelecimentos);
    }
    public function deleteEstabelecimento()
    {

        $this->secure->tokens_secure($this->input->token);

        $estabelecimentos = new Estabelecimentos();

        $consultaestabelecimentos = $estabelecimentos->deleteEstabelecimento($this->input->id_usuario);

        jsonReturn($consultaestabelecimentos);
    }

    public function updatepassword()
    {

        $this->secure->tokens_secure($this->input->token);

        $helper = new UsuariosHelper();
        $estabelecimentos = new Estabelecimentos();

        //$usuarioDados = $usuarios->listid_franqueado($this->input->id);

        // print_r($this->input->password);exit;
        $this->hash = $helper->cryptPassword2($this->input->password);
        $consultaestabelecimentos = $estabelecimentos->updatePassword($this->input->id_usuario, $this->hash);

        jsonReturn(array($consultaestabelecimentos));
    }

}
