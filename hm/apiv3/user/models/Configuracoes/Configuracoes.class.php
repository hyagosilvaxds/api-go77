<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
// require_once MODELS . '/Estados/Estados.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';


class Configuracoes extends Conexao {


    public function __construct() {
        $this->Conecta();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->tabela = "app_config";
    }


    public function listConfig() {

        $sql = $this->mysqli->prepare("SELECT * FROM `$this->tabela`");
        $sql->execute();
        $sql->bind_result(
          $this->id, $this->whatsapp, $this->facebook, $this->instagram, $this->manutencao, $this->credito, $this->dinheiro, $this->pix,
          $this->raio_km, $this->perc_imoveis, $this->perc_eventos, $this->tempo_cancelamento, $this->perc_cartao, $this->perc_pix
        );
        $sql->fetch();

        $Param['whatsapp'] = $this->whatsapp;
        $Param['facebook'] = $this->facebook;
        $Param['instagram'] = $this->instagram;
        $Param['manutencao'] = $this->manutencao;
        $Param['credito'] = $this->credito;
        $Param['dinheiro'] = $this->dinheiro;
        $Param['pix'] = $this->pix;
        $Param['raio_km'] = $this->raio_km;
        $Param['perc_imoveis'] = $this->perc_imoveis;
        $Param['perc_eventos'] = $this->perc_eventos;
        $Param['tempo_cancelamento'] = $this->tempo_cancelamento;
        $Param['perc_cartao'] = $this->perc_cartao;
        $Param['perc_pix'] = $this->perc_pix;

        return $Param;
    }

    public function listConfigPerc($id_categoria){

      if($id_categoria == 1){$campo = "perc_imoveis";}else{$campo = "perc_eventos";}

        $sql = $this->mysqli->prepare("SELECT $campo FROM `$this->tabela`");
        $sql->execute();
        $sql->bind_result($this->perc);
        $sql->store_result();
        $sql->fetch();


        return $this->perc;
    }

    public function listConfigPagamento($tipo_pagamento){

      if($tipo_pagamento == 1){$campo = "perc_cartao";}else{$campo = "perc_pix";}

        $sql = $this->mysqli->prepare("SELECT $campo FROM `$this->tabela`");
        $sql->execute();
        $sql->bind_result($this->perc);
        $sql->store_result();
        $sql->fetch();

        return $this->perc;
    }

    // public function find($query) {

    //     $sql = $this->mysqli->prepare($query);
    //     $sql->execute();
    //     $sql->bind_result($this->id, $this->nome, $this->valor, $this->taxa_servico);
    //     $sql->store_result();
    //     $rows = $sql->num_rows;

    //     $ofertas = [];

    //     if($rows == 0){
    //         $Param['rows'] = $rows;
    //         array_push($ofertas, $Param);
    //     }
    //     else {
    //         while($row = $sql->fetch()) {

    //             $Param['id'] = $this->id;
    //             $Param['nome'] = $this->nome;
    //             $Param['valor'] = moneyView($this->valor);
    //             $Param['taxa_servico'] = moneyView($this->taxa_servico);
    //             $Param['rows'] = $rows;

    //             array_push($ofertas, $Param);
    //         }
    //     }
    //     return $ofertas;
    // }




}
