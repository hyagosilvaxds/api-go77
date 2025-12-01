<?php

require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Notificacoes/Notificacoes.class.php';
require_once MODELS . '/Gcm/Gcm.class.php';
require_once MODELS . '/Usuarios/Enderecos.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once HELPERS . '/UsuariosHelper.class.php';
require_once HELPERS . '/EnderecosHelper.class.php';


class NotificacoesController {

    public function __construct() {

        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();
        $this->model = new Notificacoes();
        $this->gcm = new Gcm();
        
        $this->req = $_REQUEST;
        $this->data_atual = date('Y-m-d H:i:s');
        $this->dia_atual = date('Y-m-d');
        $this->id_menu = 6;
    }
    

    public function exportarCsv() {
        // Crie o arquivo CSV
        $notificacoes =  new Notificacoes();
        $notificacoes->gerarCSV();
    
        
        $Param = [
            "status" => "01",
            "msg" => "CSV criado"
        ];

        jsonReturn(array($Param));
    }
    
   
    public function save()
    {

        $this->secure->tokens_secure($this->input->token);

        $notificacoes =  new Notificacoes();
        $consultaprofissionais = $notificacoes->saveNotificacoes($this->input->titulo,$this->input->descricao);
        // print_r("teste");exit;
        $this->gcm->notificacao_android($this->input->titulo, $this->input->descricao);
        $this->gcm->notificacao_ios($this->input->titulo, $this->input->descricao);

        jsonReturn($consultaprofissionais);
    }


    
    public function listAll()
    {

        $this->secure->tokens_secure($this->input->token);
        $this->secure->validatemenu($this->id_menu,$this->input->id_grupo);
        $notificacoes =  new Notificacoes();
        $consultaprofissionais = $notificacoes->listAll();
        jsonReturn($consultaprofissionais);
    }
   
 
   
    public function delete()
    {

        $this->secure->tokens_secure($this->input->token);

        $notificacoes =  new Notificacoes();

        $consultaprofissionais = $notificacoes->remove($this->input->id);

        jsonReturn($consultaprofissionais);
    }



}

