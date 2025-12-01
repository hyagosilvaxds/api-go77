<?php

require_once MODELS . '/Tables.class.php';

class Conexao extends Tables  {

    var $host = MYSQL;
    var $usuario = USER;
    var $senha = PASS;
    var $banco = BD;
    public $mysqli;

    public function Conecta() {

        $this->mysqli = new mysqli($this->host, $this->usuario, $this->senha, $this->banco);
        $this->mysqli->set_charset('utf8');

        $this->ListAll();

        return $this->mysqli;
    }

    public function Close() {
        $this->mysqli->close();
    }

}
