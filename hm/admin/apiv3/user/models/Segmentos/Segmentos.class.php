<?php

// require_once MODELS . '/Conexao/Conexao.class.php';
require_once MODELS . '/Secure/Secure.class.php';
require_once MODELS . '/ResizeFiles/ResizeFiles.class.php';
require_once MODELS . '/Emails/Emails.class.php';
require_once MODELS . '/Estados/Estados.class.php';
require_once MODELS . '/Conexao/Conexao.class.php';

class Segmentos extends Conexao {


    public function __construct() {
        $this->Conecta();
        $this->data_atual = date('Y-m-d H:i:s');
        $this->tabela = "app_planos_pagamentos";
    }

    public function listAllSegmentos($id_banner)
    {
      $filter = "WHERE id > '0'";
      if(!empty($id_banner)){$filter .= "AND id = '$id_banner'";}
        $sql = $this->mysqli->prepare("
        SELECT id, nome, url, descricao, status
        FROM app_categorias_fornecedores
        $filter ORDER BY nome ASC");

        $sql->execute();
        $sql->bind_result($id, $nome, $url, $descricao, $status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {

                $Param['id'] = $id;
                $Param['nome'] = $nome;
                $Param['url'] = $url;
                $Param['descricao'] = $descricao;
                $Param['status'] = $status;
                $Param['rows'] = $rows;
                array_push($usuarios, $Param);
            }
        }
        return $usuarios;
    }

    public function gerarCSV() {
        // Abrir o arquivo de log (criar se não existir)
        $arquivo = fopen("uploads/planilhas/exportarSegmentos.csv", "w");

        $sql = $this->mysqli->prepare("SELECT id, nome, descricao, status FROM app_categorias_fornecedores");

        $sql->execute();
        $sql->bind_result($id, $nome, $descricao, $status);
        $sql->store_result();
        $rows = $sql->num_rows;

        $usuarios = [];

        if ($rows == 0) {
            $Param['rows'] = $rows;
            array_push($usuarios, $Param);
        } else {
            while ($row = $sql->fetch()) {


                $Param['id'] = $id;
                $Param['nome'] = $nome;
                $Param['descricao'] = $descricao;
                $Param['status'] = $status;


                array_push($usuarios, $Param);
            }
        }

        $cabecalho = ['id', 'nome', 'descricao', 'status'];

        fputcsv($arquivo, $cabecalho, ';');

        // Escrever o conteúdo no arquivo
        foreach($usuarios as $row_usuario){
            fputcsv($arquivo, $row_usuario, ';');
        }
        // Fechar arquivo
        fclose($arquivo);

    }






    public function saveSegmento($nome, $url, $descricao){


        $sql_cadastro = $this->mysqli->prepare(
            "
        INSERT INTO `app_categorias_fornecedores`(`nome`, `url`, `descricao`,`status`)
            VALUES ('$nome', '$url', '$descricao', '1')"
        );

        $sql_cadastro->execute();

        $Param = [
            "status" => "01",
            "msg" => "Segmento adicionado"
        ];

        return $Param;
    }
    public function updateSegmento($id_segmento, $nome, $url, $descricao, $status)
    {
        // print_r($url);exit;
        if ($url === null) {
        $sql = $this->mysqli->prepare("UPDATE `app_categorias_fornecedores` SET nome='$nome',descricao='$descricao',status='$status' WHERE id='$id_segmento'");
        } else {
        $sql = $this->mysqli->prepare("UPDATE `app_categorias_fornecedores` SET nome='$nome',url='$url',descricao='$descricao',status='$status' WHERE id='$id_segmento'");
        }
        $sql->execute();
        $Param = [
            "status" => "01",
            "msg" => "Segmento Atualizado!"
        ];

        return $Param;
    }




    public function deleteSegmento($id)
    {

        $sql_cadastro = $this->mysqli->prepare("DELETE FROM app_categorias_fornecedores WHERE id='$id'");
        $sql_cadastro->execute();

        $linhas_afetadas = $sql_cadastro->affected_rows;

        if ($linhas_afetadas > 0) {
            $param = [
                "status" => "01",
                "msg" => "Segmento deletado"
            ];
        } else {
            $param = [
                "status" => "02",
                "msg" => "Falha ao deletar o segmento"
            ];
        }

        return $param;
    }



}
