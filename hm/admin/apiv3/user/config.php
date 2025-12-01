<?php
header('Access-Control-Allow-Origin: *');
//DISPARA OS ERROS
ini_set('display_errors', 0);
error_reporting(E_ALL);


$dominiowww = $_SERVER['SERVER_NAME'];
$dominio = str_replace('www.', '', $_SERVER['HTTP_HOST']);
date_default_timezone_set('America/Sao_Paulo');
$porta = $_SERVER['SERVER_PORT'] != '80' ? ':' . $_SERVER['SERVER_PORT'] : '';

define('RAIZ', dirname(__FILE__));
define('PASTA_RAIZ', '/iusui1872a5a78512rew');
// URL da home
define('HOME_URI', 'http://' . $dominiowww . $porta . '/www/hm/admin/apiv3/user');
define('LINK_LOGIN', 'http://' . $dominiowww . $porta . '/www/hm/admin/login');
// usado para acessos no front

// email remetente padrão
define('EMAIL_REMETENTE', 'contato@go77app.com');
define('NOME_PROJETO', 'GO77');
define('TOKEN', '96J95vTx');
define('LOGO_EMAIL', 'https://go77app.com/admin/views/_css/app-assets/img/logo/logo-com-white.png');

// KEY_CRYPT SEMPRE 32 CARACTERES, SÓ NÚMEROS

define('KEY_CRYPT', '04548734389515792144107234366421');

define('KEY_API', 'AIzaSyBYCDOvIKTCqNsynolLckow1ReRDN06skE'); //ADMIN 2024
//define('KEY_API', 'AIzaSyDno-wR3t7yPAsZ3wvAqh5nIM9Si5N8lvo');
define('COD_API', '$1$V6g1NzPc$a6YVZ17HnK.2Ha7gq1d1X/');
/*
    por medidas de usuabilidade, estamos setando
    a DEVELOPER_KEY e a APP_ID diretamente no código
*/
// define('DEVELOPER_KEY', '5d40eb0193f745409e182b04ef08d30a');
// define('APP_ID', 'f31b50.vidyo.io');

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

// DEFINE BANNERS
define('LARGURA_PIXELS', '1920');
define('ALTURA_PIXELS', '1080');
define('QUALIDADE_IMAGEM', '100');


define('AVATAR_WIDTH', '200');
define('AVATAR_HEIGHT', '0');
define('AVATAR_QUALITY', '100');
define('PLANO_FREE', 'sd4gtth6');
//CONSTANTES PARA USO GLOBAL
define('LOJAS_PROXIMAS', '20');//distancia em km do estabelecimento para o user
define('NOTIFICACAO_PROXIMAS', '20');//notificao para users nesse raio de km ao lançar novo produto
define('USUARIO', 1);
define('FRANQUEADO', 2);
define('BARBEIRO', 3);

define('PEDIDO_AGENDADO', 1);
define('PEDIDO_FINALIZADO', 2);
define('PEDIDO_CANCELADO', 3);

define('PERC_EMPRESA', 20);

//CONEXAO BD
define('MYSQL', 'localhost');
define('USER', 'root');
define('PASS', 'root');
define('BD', 'go77app');

// ASAAS sandbox teste
define('ASAAS_URL', 'https://sandbox.asaas.com/api/');
define('ASAAS_URL_PRODUCTION', 'https://sandbox.asaas.com/api/');
define('ASAAS_KEY', '$aact_MzkwODA2MWY2OGM3MWRlMDU2NWM3MzJlNzZmNGZhZGY6OmYyMGMyMzA1LWI3ZDMtNDJlNi1hNGMzLWE0NDM4NGY3YWQxZDo6JGFhY2hfN2NkNTQ5YWQtOGNlNy00N2Y3LTk1NzktYTc1ZDEzYjM1N2Q2');
define('ASAAS_CUSTOMER_PIX', 'cus_000005781325');

//DADOS ACESSO MOIP
define('TOKEN_MOIP', 'IGKME8SRD1ZOLYP9PYJJZF3R6HMGKDOL');
define('KEY_MOIP', 'XAOMJZGLOMMUC5ZXVAJCAXTUANNZEDESH5HNJHIF');
define('TOKEN_MOIP_PRODUCTION', 'RKSUZV6VN2XJMPPJA1NW13YT8FCCSOYU');
define('KEY_MOIP_PRODUCTION', 'GDSNIX2XHAG3ZYJFKGQE2QLBUHYSI1ECKKXLLX3U');
define('TOKEN_NOTIFICATION', '715db9472eb3456099e0fc684a47e20e');
define('TOKEN_NOTIFICATION_SANDBOX', '29a0752e63234a459c836ebd3a968d73');
define('ACCESS_TOKEN', 'dc061ed54107408d816a745092fb0a40_v2');
define('ACCESS_TOKEN_PRODUCTION', 'e5dfed8d04504bb19b2496f0f20a240e_v2');
define('secret', 'f54edebb323f4f7b8831946fc46cd122');


define('VIEWS', 'views');
define('MODELS', 'models');
define('HELPERS', 'helpers');
define('DAOS', 'daos');
define('CONTROLLERS', 'controllers');

define('DEBUG', false);

require_once 'includes/functions.php';
require_once 'load.php';
