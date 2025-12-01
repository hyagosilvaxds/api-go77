<?php

//SESSION START
ob_start();
session_start();

//nome de sessão diferente para cada usuário
session_name(md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));

//FUNCÕES GLOBAIS
function dataBR($data) {
    $data = implode("/", array_reverse(explode("-", $data)));
    return $data;
}

function dataUS($data) {
    $data = implode("-", array_reverse(explode("/", $data)));
    return $data;
}

function md5_hash($string) {
    $string = md5($string);
    return $string;
}

function limitarTexto($texto, $limite = 100) {
    $contador = mb_strlen($texto);
    if ($contador >= $limite) {
        $texto = mb_substr($texto, 0, mb_strrpos(mb_substr($texto, 0, $limite), ' '), 'UTF-8') . '...';
        return $texto;
    } else {
        return $texto;
    }
}

function load_view($action = null, $view = null, $view2 = null, $mensagem = null) {

    require_once VIEWS . '/' . $action . '.php';
}

function secure($string) {
    $_GET = array_map('trim', $_GET);
    $_POST = array_map('trim', $_POST);
    $_COOKIE = array_map('trim', $_COOKIE);
    $_REQUEST = array_map('trim', $_REQUEST);
    if (get_magic_quotes_gpc()) {
        $_GET = array_map('stripslashes', $_GET);
        $_POST = array_map('stripslashes', $_POST);
        $_COOKIE = array_map('stripslashes', $_COOKIE);
        $_REQUEST = array_map('stripslashes', $_REQUEST);
    }
    $_GET = array_map('mysql_real_escape_string', $_GET);
    $_POST = array_map('mysql_real_escape_string', $_POST);
    $_COOKIE = array_map('mysql_real_escape_string', $_COOKIE);
    $_REQUEST = array_map('mysql_real_escape_string', $_REQUEST);

    return $string;
}

function geraSalt($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false) {
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '!@#$%*-';
    $retorno = '';
    $caracteres = '';
    $caracteres .= $lmin;
    if ($maiusculas)
        $caracteres .= $lmai;
    if ($numeros)
        $caracteres .= $num;
    if ($simbolos)
        $caracteres .= $simb;
    $len = strlen($caracteres);
    for ($n = 1; $n <= $tamanho; $n++) {
        $rand = mt_rand(1, $len);
        $retorno .= $caracteres[$rand - 1];
    }
    return $retorno;
}
