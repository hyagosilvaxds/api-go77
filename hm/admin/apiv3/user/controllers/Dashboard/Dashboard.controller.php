<?php

require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Dashboard/Dashboard.class.php';
require_once MODELS . '/Usuarios/Enderecos.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once HELPERS . '/UsuariosHelper.class.php';
require_once HELPERS . '/EnderecosHelper.class.php';

class DashboardController {

    public function __construct() {

        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();

        $this->req = $_REQUEST;
        $this->data_atual = date('Y-m-d H:i:s');
        $this->dia_atual = date('Y-m-d');
    }


    public function cartoesDash()
    {

        $this->secure->tokens_secure($this->input->token);

        $dashboard = new Dashboard();
        $consultadash = $dashboard->cartoesDash();

        jsonReturn($consultadash);
    }
    public function graficosDash()
    {

        $this->secure->tokens_secure($this->input->token);

        $dashboard = new Dashboard();
        $consultadash = $dashboard->graficosDash();

        jsonReturn($consultadash);
    }

    public function ultimosPlanos()
    {

        $this->secure->tokens_secure($this->input->token);

        $dashboard = new Dashboard();
        $consultadash = $dashboard->ultimosPlanos($this->input->limite);

        jsonReturn($consultadash);
    }

    public function listLastCompanies() {

        $this->secure->tokens_secure($this->input->token);

        $dashboard = new Dashboard();

        $consultadash = $dashboard->listLastCompanies($this->input->limite);

        jsonReturn($consultadash);
    }
    public function listLastUsuarios() {

        $this->secure->tokens_secure($this->input->token);

        $dashboard = new Dashboard();

        $consultadash = $dashboard->listLastUsuarios($this->input->limite);

        jsonReturn($consultadash);
    }

    public function listAnuncios() {

        $this->secure->tokens_secure($this->input->token);

        $dashboard = new Dashboard();

        $consultadash = $dashboard->listAnuncios($this->input->limite);

        jsonReturn($consultadash);
    }
    public function listReservas() {

        $this->secure->tokens_secure($this->input->token);

        $dashboard = new Dashboard();

        $consultadash = $dashboard->listReservas($this->input->limite);

        jsonReturn($consultadash);
    }
    public function ultimasCompras() {

        $this->secure->tokens_secure($this->input->token);

        $dashboard = new Dashboard();

        $consultadash = $dashboard->ultimasCompras($this->input->limite);

        jsonReturn($consultadash);
    }


}
