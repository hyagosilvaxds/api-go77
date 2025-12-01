<?php

require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Relatorios/Relatorios.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once HELPERS . '/UsuariosHelper.class.php';
require_once MODELS . '/Gcm/Gcm.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';

class RelatoriosController
{

    public function __construct()
    {

        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();
        $this->req = $_REQUEST;
        $this->data_atual = date('Y-m-d H:i:s');
        $this->dia_atual = date('Y-m-d');
    }

    public function avaliarCorrida()
    {

        $this->secure->tokens_secure($this->input->token);
        $model =  new Relatorios();
        // gerarLogUserEntrada($this->input,$this->input->id_de,"avaliarCorrida");
        $usuarios =  new Usuarios();
        $latLong = $usuarios->listLocation($this->input->id_de);

        $result = $model->avaliarCorrida($this->input->id_de,$this->input->id_para,$this->input->id_corrida,$this->input->estrelas,$this->input->descricao,$latLong['lat'],$latLong['long']);

        gerarLogUserSaida($result,$this->input->id_de,"avaliarCorrida");
        jsonReturn($result);


    }
    public function avaliarCorridaIgnorar()
    {

        $this->secure->tokens_secure($this->input->token);
        $model =  new Relatorios();
        // gerarLogUserEntrada($this->input,$this->input->id_de,"avaliarCorridaIgnorar");
        $usuarios =  new Usuarios();
        $latLong = $usuarios->listLocation($this->input->id_de);

        $result = $model->avaliarCorridaIgnorar($this->input->id_de,$this->input->id_para,$this->input->id_corrida,$latLong['lat'],$latLong['long']);

        // gerarLogUserSaida($result,$this->input->id_de,"avaliarCorridaIgnorar");
        jsonReturn($result);


    }

    public function relatarProblemas()
    {

        $this->secure->tokens_secure($this->input->token);
        $model =  new Relatorios();
        
        $result = $model->relatarProblemas($this->input->id_de,$this->input->id_para,$this->input->id_anuncio,$this->input->id_motivo,$this->input->estrelas,$this->input->descricao,$this->input->latitude,$this->input->longitude);

        jsonReturn($result);


    }
    public function entrouNoAnuncio()
    {

        $this->secure->tokens_secure($this->input->token);
        $model =  new Relatorios();
        
        $result = $model->entrouNoAnuncio($this->input->id_de,$this->input->id_para,$this->input->id_anuncio,$this->input->latitude,$this->input->longitude);

        jsonReturn($result);


    }
    public function listAvaliacaoPendente()
    {

        $this->secure->tokens_secure($this->input->token);
        $model =  new Relatorios();
        $result = $model->listAvaliacaoPendente($this->input->id_user);

        jsonReturn($result);


    }
    
    public function listSorteioCorrida()
    {

        $this->secure->tokens_secure($this->input->token);
        $model =  new Relatorios();

        $verificaPassageiro = $model->verificaPassageiro($this->input->id_user);
        
        if($verificaPassageiro == 1){

            $result = $model->listSorteioCorridaPassageiro($this->input->id_corrida,$this->input->id_user);
        }else{
            $result = $model->listSorteioCorridaMotorista($this->input->id_corrida,$this->input->id_user);
        }

        jsonReturn($result);
    }
    public function meusNumeros()
    {

        $this->secure->tokens_secure($this->input->token);
        $model =  new Relatorios();

        $verificaPassageiro = $model->verificaPassageiro($this->input->id_user);

        if($verificaPassageiro == 1){

            $result = $model->meusNumerosPassageiro($this->input->id_user,$this->input->status);
        }else{
            $result = $model->meusNumerosMotorista($this->input->id_user,$this->input->status);
        }


        jsonReturn($result);
    }
}
