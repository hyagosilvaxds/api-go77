<?php
// Ativar todos os erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Debug Test</h1>";
echo "<p>PHP está funcionando!</p>";
echo "<p>Versão PHP: " . phpversion() . "</p>";

// Testar se o config.php pode ser carregado
echo "<h2>Testando config.php...</h2>";
try {
    require_once 'config.php';
    echo "<p style='color:green;'>✓ config.php carregado com sucesso!</p>";
    
    // Mostrar constantes de banco
    echo "<h3>Configurações do Banco:</h3>";
    echo "MYSQL: " . MYSQL . "<br>";
    echo "USER: " . USER . "<br>";
    echo "BD: " . BD . "<br>";
    
    // Testar conexão com banco
    echo "<h2>Testando conexão MySQL...</h2>";
    $conn = new mysqli(MYSQL, USER, PASS, BD);
    
    if ($conn->connect_error) {
        echo "<p style='color:red;'>✗ Erro na conexão: " . $conn->connect_error . "</p>";
    } else {
        echo "<p style='color:green;'>✓ Conexão com MySQL bem-sucedida!</p>";
        echo "Servidor: " . $conn->host_info . "<br>";
        $conn->close();
    }
    
} catch (Exception $e) {
    echo "<p style='color:red;'>✗ Erro: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h2>Arquivos necessários:</h2>";
$files = [
    'config.php',
    'load.php',
    'includes/functions.php',
    'controllers/Paginas.controller.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "<p style='color:green;'>✓ $file existe</p>";
    } else {
        echo "<p style='color:red;'>✗ $file NÃO existe</p>";
    }
}
?>
