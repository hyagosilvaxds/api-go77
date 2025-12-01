<?php

$url = $_GET['url'];
$url = explode('/', $url);


$action = $url[0];
$action_ucfirst = ucfirst($url[0]);
$action_url = ucfirst($url[0]) . 'Controller';
$action_paginas = $url[0];
$param = $url[1];


if (empty($action)) :

    $action_index = 'login';

    require_once 'controllers/' . 'Paginas.controller.php';

    $action_controller = str_replace('-', '_', $action_index);
    $acao = new PaginasController();
    $acao->$action_controller($action, $param);


endif;

if (!empty($action)) :

    require_once 'controllers/' . 'Paginas.controller.php';

    $action_controller = str_replace('-', '_', $action);
    $acao = new PaginasController();
    $acao->$action_controller($action, $param);
endif;
