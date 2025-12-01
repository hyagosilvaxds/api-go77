<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once MODELS . '/Estados/Estados.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';


class Enderecos extends Conexao
{


    public function __construct()
    {
        $this->Conecta();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->tabela = "app_users_endereco";
    }


    public function save($id_user, $cep, $estado, $cidade, $endereco, $bairro, $numero, $complemento, $latitude, $longitude)
    {


        $sql_cadastro = $this->mysqli->prepare(
            "
        INSERT INTO `$this->tabela`
        (`app_users_id`, `uf`, `cidade`, `endereco`, `numero`, `complemento`, `latitude`, `longitude`, `bairro`)
        VALUES ('$id_user', '$estado', '$cidade', '$endereco', '$numero', '$complemento', '$latitude', '$longitude', '$bairro')"
        );

        $sql_cadastro->execute();
    }

    public function update($id_endereco, $estado, $cidade, $endereco, $bairro, $numero, $complemento, $latitude, $longitude)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela`
        SET uf='$estado', cidade='$cidade', endereco='$endereco', numero='$numero', complemento='$complemento', latitude='$latitude', longitude='$longitude'
        WHERE id='$id_endereco'
        ");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Endereço atulizado"
        ];

        return $Param;
    }


    public function updateLocation($id_user, $cep, $estado, $cidade, $endereco, $bairro, $numero, $complemento, $latitude, $longitude)
    {



        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela`
        SET uf='$estado', cidade='$cidade', endereco='$endereco', numero='$numero', complemento='$complemento', latitude='$latitude', longitude='$longitude'
        WHERE app_users_id='$id_user'
        ");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Endereço atulizado"
        ];

        return $Param;
    }


    public function listID($id)
    {

        $sql = $this->mysqli->prepare(
            "
        SELECT id, uf, cidade, bairro, endereco, numero, complemento, latitude, longitude
        FROM `$this->tabela`
        WHERE app_users_id='$id'
        ORDER BY id DESC
        LIMIT 1
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->estado, $this->cidade, $this->bairro, $this->endereco, $this->numero, $this->complemento, $this->latitude, $this->longitude);
        $sql->store_result();
        $rows = $sql->num_rows;

        $enderecos = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($enderecos, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['estado'] = $this->estado;
                $Param['cidade'] = $this->cidade;
                $Param['bairro'] = $this->bairro;
                $Param['numero'] = $this->numero;
                $Param['complemento'] = $this->complemento;
                $Param['latitude'] = $this->latitude;
                $Param['longitude'] = $this->longitude;
                $Param['endereco_completo'] = $this->endereco . ' ' . $this->numero . ', ' . $cidade . ' ' . $this->estado;

                array_push($enderecos, $Param);
            }
        }
        // print_r($enderecos); exit;
        return $enderecos;
    }


    public function listIDPaciente($id)
    {

        $sql = $this->mysqli->prepare(
            "
        SELECT id, cep, estado, cidade, bairro, endereco, numero, complemento, latitude, longitude
        FROM app_users_end
        WHERE app_users_id='$id'
        ORDER BY id DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->cep, $this->estado, $this->cidade, $this->bairro, $this->endereco, $this->numero, $this->complemento, $this->latitude, $this->longitude);
        $sql->store_result();
        $rows = $sql->num_rows;

        $enderecos = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($enderecos, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['cep'] = $this->cep;
                $Param['estado'] = $this->estado;
                $Param['cidade'] = $this->cidade;
                $Param['bairro'] = $this->bairro;
                $Param['numero'] = $this->numero;
                $Param['complemento'] = $this->complemento;
                $Param['latitude'] = $this->latitude;
                $Param['longitude'] = $this->longitude;
                $Param['endereco_completo'] = $this->endereco . ' ' . $this->numero . ', ' . $cidade . ' ' . $this->estado;

                array_push($enderecos, $Param);
            }
        }
        // print_r($enderecos); exit;
        return $enderecos;
    }

    public function find($id)
    {

        $sql = $this->mysqli->prepare(
            "
        SELECT id, estado, cidade, endereco, numero, complemento, latitude, longitude, cep
        FROM `$this->tabela`
        WHERE app_users_id='$id'
        ORDER BY id DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->estado, $this->cidade, $this->endereco, $this->numero, $this->complemento, $this->latitude, $this->longitude, $this->cep);
        $sql->store_result();
        $rows = $sql->num_rows;

        $enderecos = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($enderecos, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['endereco'] = $this->endereco;
                $Param['estado'] = $this->estado;
                $Param['cidade'] = $this->cidade;
                $Param['numero'] = $this->numero;
                $Param['complemento'] = $this->complemento;
                $Param['latitude'] = $this->latitude;
                $Param['longitude'] = $this->longitude;
                $Param['cep'] = $this->cep;
                $Param['rows'] = $rows;

                array_push($enderecos, $Param);
            }
        }
        return $enderecos;
    }
}
