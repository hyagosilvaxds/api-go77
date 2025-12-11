<?php

//DISPARA OS ERROS
ini_set('display_errors', 0);
//ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Detectar ambiente
$host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
$isProduction = (strpos($host, 'go77destinos.online') !== false);

$dominiowww = $_SERVER['SERVER_NAME'] ?? 'localhost';
$dominio = str_replace('www.', '', $host);
$porta = ($_SERVER['SERVER_PORT'] ?? '80') != '80' ? ':' . $_SERVER['SERVER_PORT'] : '';

// Title Raiz
define('TITLE', "ADMIN");

// Caminho para a raiz
define('RAIZ', dirname(__FILE__));
define('PASTA_RAIZ', '/iusui1872a5a78512rew');

// URL da home - Detectar ambiente
if ($isProduction) {
    define('HOME_URI', 'https://go77destinos.online/admin');
    define('HOME_URI_ROOT', 'https://go77destinos.online');
} else {
    define('HOME_URI', 'http://' . $dominiowww . $porta . '/www/admin');
    define('HOME_URI_ROOT', 'http://' . $dominiowww . $porta . '/www');
}
// var_dump(HOME_URI);
// define('HOME_URI', 'http://localhost' . '/skipt/user');

// email remetente padrão
define('EMAIL_REMETENTE', "contato@" . $dominio);
// URL de UPLOADS
define('UPLOAD', HOME_URI_ROOT . '/uploads');
// URL de UPLOADS DE AVATAR
define('AVATAR', HOME_URI_ROOT . '/uploads/avatar');
define('ANUNCIOS', HOME_URI_ROOT . '/uploads/anuncios');
define('RECIBOS', HOME_URI_ROOT . '/uploads/recibos_fotos');
define('BANNERS', HOME_URI . '/uploads/banners');
define('SEGMENTOS', HOME_URI . '/uploads/segmentos');
define('ANUNCIOS', HOME_URI . '/uploads/anuncios');
define('ICON', HOME_URI_ROOT . '/uploads/icon');
define('DOCUMENTOS', HOME_URI . '/uploads/documentos');

define('VITRINES', HOME_URI_ROOT . '/uploads/vitrines');
// URL de UPLOADS DE FOTOS DE PRODUTOS
define('PRODUTOS', HOME_URI_ROOT . '/uploads/produtos');
define('VIDEOS', HOME_URI_ROOT . '/uploads/videos');
// URL de UPLOADS DE FOTOS DE PRODUTOS
define('CATEGORIAS', HOME_URI_ROOT . '/uploads/categorias');
// URL de CSS
define('CSS', HOME_URI . '/views/_css');
// URL de CSS
define('FONTS', HOME_URI . '/views/_fonts');
// URL de JS
define('JS', HOME_URI . '/views/_js');
// URL de VUE
define('VUE', HOME_URI . '/views/_js/vue');
// URL de PLUGINS
define('PLUGINS', HOME_URI . '/views/_plugins');
// URL de images
define('IMAGES', HOME_URI . '/views/_images');
// URL de INCLUDE
define('INCLUSAO', 'views/_include');
// URL de API
// define('CORS', 'https://cors-anywhere.herokuapp.com/');
define('API', HOME_URI . '/apiv3/user');
define('API_ROOT', HOME_URI . '/apiv3/user');
// TOKEN
define('TK', '96J95vTx');

define('TK_ROOT', '72J77vQa');

// URL de sliders DO PAINEL
define('PAINEL_SLIDERS', HOME_URI . '/admin/views/_sliders');
// URL de depoimentos DO PAINEL
define('PAINEL_NOTICIAS', HOME_URI . '/admin/views/_noticias/redimensionadas');
// URL de depoimentos DO PAINEL
define('PAINEL_DEPOIMENTOS', HOME_URI . '/admin/views/_depoimentos');
// URL de arquivos DO PAINEL
define('PAINEL_ARQUIVOS', HOME_URI . '/admin/views/_arquivos');
// URL de geral DO PAINEL
define('PAINEL_GERAL', HOME_URI . '/admin/views/_geral/redimensionadas');
// URL de galerias DO PAINEL
define('PAINEL_GALERIA', HOME_URI . '/admin/views/_galerias/redimensionadas');
// URL de equipes DO PAINEL
define('PAINEL_EQUIPES', HOME_URI . '/admin/views/_equipes');
// URL de páginas DO PAINEL
define('PAINEL_PAGINAS', HOME_URI . '/admin/views/_paginas/redimensionadas');

//CONEXAO BD - Detectar ambiente
if ($isProduction) {
    define('MYSQL', 'localhost');
    define('USER', 'go77app');
    define('PASS', 'Go77@2024Secure!');
    define('BD', 'go77app');
} else {
    define('MYSQL', 'localhost');
    define('USER', 'root');
    define('PASS', 'root');
    define('BD', 'go77app');
}

define('VIEWS', 'views');
define('MODELS', 'models');
define('CONTROLLERS', 'controllers');

define('DEBUG', true);

require_once 'includes/functions.php';
require_once 'load.php';
