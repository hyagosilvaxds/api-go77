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
        
        // Desabilita only_full_group_by para compatibilidade com queries legadas
        $this->mysqli->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

        return $this->mysqli;
    }

    public function Close() {
        $this->mysqli->close();
    }

}
