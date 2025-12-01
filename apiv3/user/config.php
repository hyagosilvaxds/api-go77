<?php
header('Access-Control-Allow-Origin: *');
//DISPARA OS ERROS - Desabilitado para retornar JSON limpo
ini_set('display_errors', 0);
error_reporting(0);


$dominiowww = $_SERVER['SERVER_NAME'];
$dominio = str_replace('www.', '', $_SERVER['HTTP_HOST']);
date_default_timezone_set('America/Sao_Paulo');
$porta = $_SERVER['SERVER_PORT'] != '80' ? ':' . $_SERVER['SERVER_PORT'] : '';

// define('DOMINIO', $dominio);
define('RAIZ', dirname(__FILE__));
define('PASTA_RAIZ', '/iusui1872a5a78512rew');
// URL da home
define('HOME_URI', 'http://' . $dominiowww . $porta . '/www/apiv3/user');
define('HOME_URI_ROOT', 'http://' . $dominiowww . $porta . '/www');
// usado para acessos no front

// email remetente padrão
define('EMAIL_REMETENTE', 'contato@go77app.com');
define('NOME_REMETENTE', 'GO77 Destinos');
// define('LINK_CONFIRMAR', "https://icontrolssd.com.br/confirmar/");
define('LINK_RECUPERAR_SENHA', "http://go77app.compages/change_password.html?token=");
define('LOGO_EMAIL', HOME_URI_ROOT .'/admin/views/_css/app-assets/img/logo/logo-com-white.png');
define('TOKEN', '4kPlj10p');
define('KEY_API', 'AIzaSyC-o2a37S-9yq81-xdXYe1lTq1vrLYYKII');//oficial
// define('KEY_API', 'AIzaSyBYCDOvIKTCqNsynolLckow1ReRDN06skE');//teste dev
define('COD_API', '$1$IYO8W82K$w41L2455wkw7tJJ8HUcbV.');
define('LINK_API', '');
define('TOKEN_API', '0965da256a23d5aad37374453da0ae3eda237e35fd3a9b065edb382341a9bcd74a8b38');

// KEY_CRYPT SEMPRE 32 CARACTERES, SÓ NÚMEROS
define('KEY_CRYPT', '04548734389515792144107234366421');

// URL de INCLUDE
define('INCLUSAO', '/views/_include');
// URL de INCLUDE HEAD
define('INCLUDE_HEAD', HOME_URI . '/views/_include');
// URL de CSS
define('CSS', HOME_URI . '/views/_css');
// URL de JS
define('JS', HOME_URI . '/views/_js');
// URL de images
define('IMAGES', HOME_URI . '/views/_images');

// URL DE LOAD VIEWS
define('LOAD_VIEW', HOME_URI . '/views/');

define('AVATAR_WIDTH', '200');
define('AVATAR_HEIGHT', '0');
define('AVATAR_QUALITY', '100');
define('PLANO_FREE', 'sd4gtth6');

//CONSTANTES PARA USO GLOBAL
define('RAIO_PARADA', '100');//metros
define('RAIO_KM', '100');//KM

//CONEXAO BD
define('MYSQL', 'localhost');
define('USER', 'root');
define('PASS', 'root');
define('BD', 'go77app');


// ASAAS

// ASAAS sandbox teste
define('ASAAS_URL', 'https://api-sandbox.asaas.com/');
define('ASAAS_URL_PRODUCTION', 'https://api.asaas.com/');
define('ASAAS_KEY', '$aact_prod_000MzkwODA2MWY2OGM3MWRlMDU2NWM3MzJlNzZmNGZhZGY6OjJiZTE1ZTU4LTYxNmUtNDBkMS1hYzA2LTg1ZmI4MmRlM2EyZTo6JGFhY2hfMDAxYTg1ZjktMjk2MS00ZGYyLThmMzctMWJkYzc3M2ZiOTNl');
define('ASAAS_KEY_SANDBOX', '$aact_hmlg_000MzkwODA2MWY2OGM3MWRlMDU2NWM3MzJlNzZmNGZhZGY6OjVkMDUyNDAwLTk3MTQtNGU4MC1hMDZhLTY5NGJlNjI5M2RkMzo6JGFhY2hfMGNkY2UxNTAtMjhkMy00ZjI4LWFiMjctNWRkNzNkYzFhOGRk');
define('ASAAS_CUSTOMER_PIX', 'cus_000005781325');


//ASAAS production official GO77
/*define('ASAAS_URL', 'https://api.asaas.com/');
define('ASAAS_KEY', '$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDA0ODk2Njc6OiRhYWNoXzhmZmQ2OWE1LTFhOGMtNDJmMS04NmVjLWZmYTBhMWE1OTkyZQ==');
define('ASAAS_CUSTOMER_PIX', 'cus_000100083709');*/


define('VIEWS', 'views');
define('MODELS', 'models');
define('HELPERS', 'helpers');
define('DAOS', 'daos');
define('CONTROLLERS', 'controllers');

define('DEBUG', true);

require_once 'includes/functions.php';
require_once 'load.php';
