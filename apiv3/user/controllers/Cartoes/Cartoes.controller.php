<?php

require_once MODELS . '/Usuarios/Usuarios.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once HELPERS . '/UsuariosHelper.class.php';
require_once MODELS . '/Gcm/Gcm.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';
require_once MODELS . '/Cartoes/Cartoes.class.php';

class CartoesController
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

    public function listCartoes()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Cartoes();

        $result = $model->listCartoes($this->input->id_user);

        jsonReturn($result);


    }
    public function deleteCartao()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Cartoes();

        $result = $model->deleteCartao($this->input->id_user,$this->input->id_cartao);

        jsonReturn(array($result));


    }
    public function selecionarFavorito()
    {
        $this->secure->tokens_secure($this->input->token);

        $model = new Cartoes();

        $result = $model->selecionarFavorito($this->input->id_user,$this->input->id_cartao);

        jsonReturn(array($result));


    }

    public function saveCartao()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Cartoes();

        $cartaoQtd = $model->listCartoes($this->input->id_user);
        if($cartaoQtd[0]['rows'] > 2){
            $Param = [
                "status" => "02",
                "msg" => "Você já possui 3 cartões cadastros.",
            ];
            jsonReturn(array($Param));
        }
        $result = $model->saveCartao($this->input->id_user,$this->input->card_number,$this->input->expiration_month,$this->input->expiration_year,$this->input->security_code,
        $this->input->nome, $this->input->cpf, $this->input->cep, $this->input->numero);


        jsonReturn(array($result));


    }

    public function saveCartaoSandbox()
    {

        $this->secure->tokens_secure($this->input->token);

        $model = new Cartoes();

        $cartaoQtd = $model->listCartoes($this->input->id_user);
        if($cartaoQtd[0]['rows'] > 2){
            $Param = [
                "status" => "02",
                "msg" => "Você já possui 3 cartões cadastros.",
            ];
            jsonReturn(array($Param));
        }
        $result = $model->saveCartaoSandbox($this->input->id_user,$this->input->card_number,$this->input->expiration_month,$this->input->expiration_year,$this->input->security_code,
        $this->input->nome, $this->input->cpf, $this->input->cep, $this->input->numero);


        jsonReturn(array($result));


    }

}
