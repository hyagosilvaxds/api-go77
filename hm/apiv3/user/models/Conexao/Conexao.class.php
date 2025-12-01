<?php

class Conexao {

    var $host = MYSQL;
    var $usuario = USER;
    var $senha = PASS;
    var $banco = BD;
    public $mysqli;

    public function Conecta() {

        $this->mysqli = new mysqli($this->host, $this->usuario, $this->senha, $this->banco);
        $this->mysqli->set_charset('utf8');

        return $this->mysqli;
    }

    public function Close() {
        $this->mysqli->close();
    }

    //banco de dados do Admin do topcar no wordpress
    public function ConectaWordPress() {

        if($this->mysqliWordPress == null){
            $this->mysqliWordPress = new mysqli('srv803.hstgr.io', 'u485068207_G2YFw', 'Nlh2xiB9Y6', 'u485068207_tnS4b');
            $this->mysqliWordPress->set_charset('utf8');
        }

        return $this->mysqliWordPress;
    }

    public function CloseWordPress() {
        $this->mysqliWordPress->close();
    }

}
