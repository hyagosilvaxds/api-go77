<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';
require_once MODELS . '/Emails/Emails.class.php';
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
        (`app_users_id`,`cep`, `estado`, `cidade`, `endereco`, `numero`, `complemento`, `latitude`, `longitude`, `bairro`)
        VALUES ('$id_user', '$cep','$estado', '$cidade', '$endereco', '$numero', '$complemento', '$latitude', '$longitude', '$bairro')"
        );

        $sql_cadastro->execute();
        
        $this->id_cadastro = $sql_cadastro->insert_id;

        $mensagem = [
            "status" => "1",
            "msg" => "Endereço adicionado.",
            "cep" => $cep,
            "uf" => $estado,
            "cidade" => $cidade,
            "endereco" => $endereco,
            "bairro" => $bairro,
            "numero" => $numero,
            "complemento" => $complemento,
            "latitude" => $latitude,
            "longitude" => $longitude
        ];

        return $mensagem;
    }

    public function saveLocation($id_user, $latitude, $longitude)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "
        INSERT INTO `app_users_location`
        (`app_users_id`, `latitude`, `longitude`, `data`)
        VALUES ('$id_user', '$latitude', '$longitude', '$this->data_atual')"
        );

        $sql_cadastro->execute();
    }

    public function updateLocationApp($id_user, $latitude, $longitude)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "UPDATE `app_users_location`
            SET latitude='$latitude', longitude='$longitude', data='$this->data_atual'
            WHERE app_users_id='$id_user'"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Localização atulizada"
        ];

        return $Param;
    }

    public function saveLocationHistorico($id_user, $latitude, $longitude)
    {

        $sql_cadastro = $this->mysqli->prepare(
            "
        INSERT INTO `app_users_location_historico`
        (`app_users_id`, `latitude`, `longitude`, `data`)
        VALUES ('$id_user', '$latitude', '$longitude', '$this->data_atual')"
        );

        $sql_cadastro->execute();
    }

    public function update($nome,$id_endereco,$cep, $estado, $cidade, $endereco, $bairro, $numero, $complemento, $latitude, $longitude)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `$this->tabela`
        SET  nome='$nome' ,cep='$cep',estado='$estado', cidade='$cidade', endereco='$endereco', numero='$numero', complemento='$complemento', latitude='$latitude', longitude='$longitude'
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


    public function listAllID($id)
    {

        $sql = $this->mysqli->prepare(
            "
        SELECT nome,id, estado, cidade, bairro, endereco, numero, complemento, latitude, longitude,cep
        FROM `$this->tabela`
        WHERE app_users_id='$id'
        ORDER BY id DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->nome,$this->id, $this->estado, $this->cidade, $this->bairro, $this->endereco, $this->numero, $this->complemento, $this->latitude, $this->longitude ,$this->cep);
        $sql->store_result();
        $rows = $sql->num_rows;

        $enderecos = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($enderecos, $Param);
        } else {
            while ($row = $sql->fetch()) {
                $Param['id'] = $this->id;
                $Param['nome'] = $this->nome;
                $Param['cep'] = $this->cep;
                $Param['estado'] = $this->estado;
                $Param['cidade'] = $this->cidade;
                $Param['bairro'] = $this->bairro;
                $Param['numero'] = $this->numero;
                $Param['complemento'] = $this->complemento;
                $Param['latitude'] = $this->latitude;
                $Param['longitude'] = $this->longitude;
                $Param['endereco_completo'] = $this->endereco . ' ' . $this->numero . ', ' . $this->cidade . '/' . $this->estado . ', '. $this->cep;

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
        SELECT nome,id, estado, cidade, endereco, numero, complemento, latitude, longitude, cep
        FROM `$this->tabela`
        WHERE id='$id'
        ORDER BY id DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->nome,$this->id, $this->estado, $this->cidade, $this->endereco, $this->numero, $this->complemento, $this->latitude, $this->longitude, $this->cep);
        $sql->store_result();
        $rows = $sql->num_rows;

        $enderecos = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($enderecos, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['nome'] = $this->nome;
                $Param['endereco'] = $this->endereco;
                $Param['estado'] = $this->estado;
                $Param['cidade'] = $this->cidade;
                $Param['numero'] = $this->numero;
                $Param['complemento'] = $this->complemento;
                $Param['latitude'] = $this->latitude;
                $Param['longitude'] = $this->longitude;
                $Param['cep'] = $this->cep;
                $Param['endereco_completo'] = $this->endereco . ' ' . $this->numero . ', ' . $this->cidade . '/' . $this->estado . ', '. $this->cep;
                $Param['rows'] = $rows;

                array_push($enderecos, $Param);
            }
        }
        return $enderecos;
    }
    public function findRetirada($id)
    {

        $sql = $this->mysqli->prepare(
            "
        SELECT nome,id, estado, cidade, endereco, numero, complemento, latitude, longitude, cep
        FROM `app_pontos_retirada`
        WHERE id='$id'
        ORDER BY id DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->nome,$this->id, $this->estado, $this->cidade, $this->endereco, $this->numero, $this->complemento, $this->latitude, $this->longitude, $this->cep);
        $sql->store_result();
        $rows = $sql->num_rows;

        $enderecos = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($enderecos, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $this->id;
                $Param['nome'] = $this->nome;
                $Param['endereco'] = $this->endereco;
                $Param['estado'] = $this->estado;
                $Param['cidade'] = $this->cidade;
                $Param['numero'] = $this->numero;
                $Param['complemento'] = $this->complemento;
                $Param['latitude'] = $this->latitude;
                $Param['longitude'] = $this->longitude;
                $Param['cep'] = $this->cep;
                $Param['endereco_completo'] = $this->endereco . ' ' . $this->numero . ', ' . $this->cidade . '/' . $this->estado . ', '. $this->cep;
                $Param['rows'] = $rows;

                array_push($enderecos, $Param);
            }
        }
        return $enderecos;
    }
    public function deleteEndereco($id_endereco)
    {

        $sql_limpa = $this->mysqli->prepare(
            "DELETE FROM `$this->tabela` WHERE id='$id_endereco'"
        );

        $sql_limpa->execute();

            
        $Param = [
            "status" => "01",
            "msg" => "Endereço deletado"
        ];

        return $Param;

    }
}
