<?php
/**
 * Script de teste para debug do endpoint icalUnidade
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== Teste de icalUnidade ===\n\n";

// Define constantes necessárias
define('MYSQL', 'localhost');
define('USER', 'root');
define('PASS', 'root');
define('BD', 'go77app');
define('HOME_URI_ROOT', 'http://localhost:8888/www');
define('RAIZ', realpath(__DIR__ . '/../user'));
define('MODELS', 'models');
define('CONTROLLERS', 'controllers');
date_default_timezone_set('America/Sao_Paulo');

// Muda para o diretório correto
chdir(RAIZ);

echo "Carregando Conexao...\n";
require_once(__DIR__ . '/../user/models/Conexao/Conexao.class.php');
echo "Conexao OK\n\n";

echo "Carregando model Anuncios...\n";
require_once(__DIR__ . '/../user/models/Anuncios/Anuncios.class.php');
echo "Model OK\n\n";

$id_anuncio = 108;
$id_type = 89;
$id_unidade = 17; // suite 102

try {
    echo "Criando instância do model...\n";
    $model = new Anuncios();
    echo "Instância OK\n\n";
    
    echo "Etapa 1: getAnuncioById($id_anuncio)...\n";
    $anuncio = $model->getAnuncioById($id_anuncio);
    echo "Anuncio: " . ($anuncio['nome'] ?? 'NULL') . "\n\n";
    
    echo "Etapa 2: getTypesAnuncio($id_anuncio)...\n";
    $types = $model->getTypesAnuncio($id_anuncio);
    echo "Types: " . count($types) . "\n\n";
    
    echo "Etapa 3: listarUnidadesTipo($id_type)...\n";
    $unidades = $model->listarUnidadesTipo($id_type);
    echo "Unidades: " . count($unidades) . "\n";
    print_r($unidades);
    echo "\n";
    
    echo "Etapa 4: getReservasAnuncioPorUnidade($id_anuncio, $id_type, $id_unidade)...\n";
    $reservas = $model->getReservasAnuncioPorUnidade($id_anuncio, $id_type, $id_unidade);
    echo "Reservas: " . count($reservas) . "\n";
    print_r($reservas);
    
} catch (Exception $e) {
    echo "ERRO: " . $e->getMessage() . "\n";
    echo "Stack: " . $e->getTraceAsString() . "\n";
} catch (Error $e) {
    echo "FATAL: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Stack: " . $e->getTraceAsString() . "\n";
}
