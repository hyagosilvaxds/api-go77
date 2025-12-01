<?php

require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Estatisticas/Estatisticas.class.php';
require_once MODELS . '/Usuarios/Enderecos.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once HELPERS . '/UsuariosHelper.class.php';
require_once HELPERS . '/EnderecosHelper.class.php';

class EstatisticasController {

    public function __construct() {

        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();
        
        $this->req = $_REQUEST;
        $this->data_atual = date('Y-m-d H:i:s');
        $this->dia_atual = date('Y-m-d');
        $this->id_menu = 14;
    }
    

    public function listAll()
    {

        $this->secure->tokens_secure($this->input->token);
        $this->secure->validatemenu($this->id_menu,$this->input->id_grupo);
        $estatisticas = new Estatisticas();
        $consultaestatisticas = $estatisticas->listAll(dataUS($this->input->data_de),dataUS($this->input->data_ate));

        jsonReturn($consultaestatisticas);
    }
    
   
}

