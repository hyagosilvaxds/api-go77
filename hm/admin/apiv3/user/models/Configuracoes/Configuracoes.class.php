<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/Estados/Estados.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';


class Configuracoes extends Conexao {


    public function __construct() {
        $this->Conecta();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->tabela = "app_config";
    }



    public function listAllConfiguracoes()
    {

        $sql = $this->mysqli->prepare("SELECT * FROM `$this->tabela`");

        $sql->execute();
        $sql->bind_result(
          $this->id, $this->whatsapp, $this->facebook, $this->instagram, $this->manutencao, $this->credito, $this->dinheiro, $this->pix,
          $this->raio_km, $this->perc_imoveis, $this->perc_eventos, $this->tempo_cancelamento, $this->perc_cartao, $this->perc_pix
        );
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

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

              array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function updateConfig($celular,$instagram,$raio_km,$perc_imoveis,$perc_eventos,$tempo_cancelamento,$perc_cartao,$perc_pix)
    {
        $sql = $this->mysqli->prepare("UPDATE `app_config` SET whatsapp='$celular', instagram='$instagram', raio_km='$raio_km',
        perc_imoveis='$perc_imoveis', perc_eventos='$perc_eventos', tempo_cancelamento='$tempo_cancelamento', perc_cartao='$perc_cartao',
        perc_pix='$perc_pix'
         WHERE id='1'");
        $sql->execute();
        $Param = [
            "status" => "01",
            "msg" => "Configurações Atualizadas!"
        ];

        return $Param;
    }


}
