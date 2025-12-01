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


    public function save($id_user, $cep, $uf, $cidade, $endereco, $bairro, $numero, $complemento, $latitude, $longitude)
    {


        $sql = $this->mysqli->prepare(
            "INSERT INTO `$this->tabela`
        (`app_users_id`, `cep`, `estado`, `cidade`, `endereco`, `bairro`, `numero`, `complemento`, `latitude`, `longitude`)
        VALUES ('$id_user', '$cep', '$uf', '$cidade', '$endereco', '$bairro', '$numero', '$complemento', '$latitude', '$longitude')"
        );


        $sql->execute();
        $this->id_cadastro = $sql->insert_id;

        $mensagem = [
            "status" => "1",
            "msg" => "Endereço adicionado.",
            "cep" => decryptitem($cep),
            "uf" => decryptitem($uf),
            "cidade" => decryptitem($cidade),
            "endereco" => decryptitem($endereco),
            "bairro" => decryptitem($bairro),
            "numero" => decryptitem($numero),
            "complemento" => $complemento,
            "latitude" => $latitude,
            "longitude" => $longitude
        ];

        return $mensagem;
    }

    public function update($id_endereco, $cep, $uf, $cidade, $endereco, $bairro, $numero, $complemento, $latitude, $longitude)
    {

        $sql_cadastro = $this->mysqli->prepare("
        UPDATE `app_users_endereco`
        SET cep='$cep', estado='$uf', cidade='$cidade', endereco='$endereco', bairro='$bairro', numero='$numero', complemento='$complemento', latitude='$latitude', longitude='$longitude'
        WHERE id='$id_endereco'
        ");

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Endereço atualizado"
        ];

        return $Param;
    }

    public function removeEndereco($id_endereco)
    {

        $sql = $this->mysqli->prepare("DELETE FROM app_users_enderecos WHERE id = ?");
        $sql->bind_param('i', $id_endereco);
        $sql->execute();

        $Param = [
            "status" => "01",
            "msg" => "Endereço removido com sucesso."
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

    public function listEnderecos($id)
    {

        $sql = $this->mysqli->prepare(
            "
        SELECT id, cep, uf, cidade, endereco, bairro, endereco, numero, complemento, latitude, longitude
        FROM `$this->tabela`
        WHERE app_users_id='$id'
        ORDER BY id DESC
        "
        );
        $sql->execute();
        $sql->bind_result($this->id, $this->cep, $this->uf, $this->cidade, $this->endereco, $this->bairro, $this->endereco, $this->numero, $this->complemento, $this->latitude, $this->longitude);
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
                $Param['uf'] = $this->uf;
                $Param['cidade'] = $this->cidade;
                $Param['endereco'] = $this->endereco;
                $Param['bairro'] = $this->bairro;
                $Param['numero'] = $this->numero;
                $Param['complemento'] = $this->complemento;
                $Param['latitude'] = $this->latitude;
                $Param['longitude'] = $this->longitude;

                array_push($enderecos, $Param);
            }
        }
        // print_r($enderecos); exit;
        return $enderecos;
    }

    public function listID($id)
    {

        $sql = $this->mysqli->prepare(
            "
        SELECT id, estado, cidade, bairro, endereco, numero, complemento, latitude, longitude
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
                $Param['estado'] = decryptitem($this->estado);
                $Param['cidade'] = decryptitem($this->cidade);
                $Param['bairro'] = decryptitem($this->bairro);
                $Param['numero'] = decryptitem($this->numero);
                $Param['complemento'] = decryptitem($this->complemento);
                $Param['latitude'] = decryptitem($this->latitude);
                $Param['longitude'] = decryptitem($this->longitude);
                $Param['endereco_completo'] = decryptitem($this->endereco) . ' ' . decryptitem($this->numero) . ', ' . decryptitem($cidade) . ' ' . decryptitem($this->estado);

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

    public function consultaId($id_endereco)
    {

        $sql = $this->mysqli->prepare(
            "SELECT app_users_id
        FROM `app_users_enderecos`
        WHERE id='$id_endereco'
        "
        );
        $sql->execute();
        $sql->bind_result($this->app_users_id);
        $sql->store_result();
        $sql->fetch();
        $rows = $sql->num_rows;



        if ($rows == 0) {
            $Param['rows'] = $rows;
            $enderecos = $Param;
            return $enderecos;
        } else {

            $Param['app_users_id'] = $this->app_users_id;
            $enderecos = $Param;
            return $enderecos;
        }
    }
}
