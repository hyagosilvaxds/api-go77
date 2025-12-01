<?php

require_once MODELS . '/Configuracoes/Configuracoes.class.php';
require_once MODELS . '/Secure/Secure.class.php';


class ConfiguracoesController {

    public function __construct() {

        $request = file_get_contents('php://input');
        $this->input = json_decode($request);
        $this->secure = new Secure();

        $this->req = $_REQUEST;
        $this->data_atual = date('Y-m-d H:i:s');
        $this->dia_atual = date('Y-m-d');
        $this->id_menu = 17;
    }


    public function listAllConfiguracoes() {

        $this->secure->tokens_secure($this->input->token);
        $this->secure->validatemenu($this->id_menu,$this->input->id_grupo);
        $configuracoes =  new Configuracoes();

        $lista_configuracoes = $configuracoes->listAllConfiguracoes();

        jsonReturn($lista_configuracoes);
    }


    public function updateConfig() {

        $this->secure->tokens_secure($this->input->token);
        $configuracoes =  new Configuracoes();
        // $lat_long = geraLatLong($this->input->endereco,$this->input->numero,$this->input->bairro, $this->input->cidade);

        $lista_configuracoes = $configuracoes->updateConfig(
          $this->input->celular,
          $this->input->instagram,
          $this->input->raio_km,
          $this->input->perc_imoveis,
          $this->input->perc_eventos,
          $this->input->tempo_cancelamento,
          $this->input->perc_cartao,
          $this->input->perc_pix
          );

        jsonReturn($lista_configuracoes);
    }





}
