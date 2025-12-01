<?php
/**
 * Script para criar usuário administrador
 * Acesse: http://localhost:8888/www/admin/criar_admin.php
 * REMOVA ESTE ARQUIVO APÓS USAR!
 */

// Configurações do banco
$host = 'localhost';
$user = 'root';
$pass = 'root';
$db = 'go77app';

// Chave de criptografia (mesma do sistema)
define('KEY_CRYPT', '04548734389515792144107234366421');

// Função de criptografia (mesma do sistema)
function cryptitem($item) {
    $encryptedValue = openssl_encrypt($item, 'aes-256-cbc', KEY_CRYPT, 0, KEY_CRYPT);
    return $encryptedValue;
}

// Dados do novo admin
$admin_email = 'admin@go77app.com';
$admin_senha = 'admin123'; // Troque para uma senha segura!
$admin_nome = 'Administrador';

// Dados do novo usuário comum
$user_email = 'usuario@go77app.com';
$user_senha = 'usuario123';
$user_nome = 'Usuário Teste';

// Criptografar dados
$admin_email_crypt = cryptitem($admin_email);
$admin_nome_crypt = cryptitem($admin_nome);
$user_email_crypt = cryptitem($user_email);
$user_nome_crypt = cryptitem($user_nome);

echo "<h1>Criar Usuário Administrador</h1>";

// Conectar ao banco
$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_error) {
    die("<p style='color:red;'>Erro de conexão: " . $mysqli->connect_error . "</p>");
}

echo "<p style='color:green;'>✓ Conectado ao banco de dados!</p>";

// Listar todas as tabelas
echo "<h3>Tabelas no banco de dados:</h3>";
$tables = $mysqli->query("SHOW TABLES");
echo "<ul>";
while ($row = $tables->fetch_array()) {
    echo "<li>{$row[0]}</li>";
}
echo "</ul>";

// Verificar se a tabela app_users existe
$result = $mysqli->query("SHOW TABLES LIKE 'app_users'");
if ($result->num_rows == 0) {
    echo "<p style='color:red;'>✗ Tabela 'app_users' não existe!</p>";
    
    // Verificar outras tabelas de usuários
    $alt_tables = ['usuarios', 'users', 'f5_Cadastros', 'tb_usuarios', 'tb_admin'];
    foreach ($alt_tables as $table) {
        $check = $mysqli->query("SHOW TABLES LIKE '$table'");
        if ($check->num_rows > 0) {
            echo "<p style='color:orange;'>⚠ Encontrada tabela alternativa: <strong>$table</strong></p>";
        }
    }
    
    die("<p style='color:red;'>Você precisa importar o banco de dados primeiro ou criar a tabela app_users.</p>");
}

echo "<p style='color:green;'>✓ Tabela 'app_users' existe!</p>";

// Mostrar estrutura da tabela
$result = $mysqli->query("DESCRIBE app_users");
echo "<h3>Estrutura da tabela app_users:</h3>";
echo "<table border='1' cellpadding='5'><tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th></tr>";
$columns = [];
while ($row = $result->fetch_assoc()) {
    $columns[] = $row['Field'];
    echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Null']}</td><td>{$row['Key']}</td><td>{$row['Default']}</td></tr>";
}
echo "</table><br>";

// Listar todos os usuários existentes
echo "<h3>Usuários existentes na tabela:</h3>";
$users = $mysqli->query("SELECT * FROM app_users LIMIT 10");
if ($users->num_rows > 0) {
    echo "<table border='1' cellpadding='5'><tr>";
    // Headers
    $first_row = $users->fetch_assoc();
    foreach (array_keys($first_row) as $col) {
        echo "<th>$col</th>";
    }
    echo "</tr><tr>";
    // First row data
    foreach ($first_row as $val) {
        $display = is_null($val) ? '<em>NULL</em>' : htmlspecialchars(substr($val, 0, 50));
        echo "<td>$display</td>";
    }
    echo "</tr>";
    // Rest of rows
    while ($row = $users->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $val) {
            $display = is_null($val) ? '<em>NULL</em>' : htmlspecialchars(substr($val, 0, 50));
            echo "<td>$display</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nenhum usuário encontrado na tabela.</p>";
}

echo "<hr>";
echo "<h3>Criar novo administrador:</h3>";

// Opção para resetar senha de admin existente (ID 280 ou 308)
echo "<h4>Ou resetar senha de admin existente:</h4>";
if (isset($_GET['reset_id'])) {
    $reset_id = intval($_GET['reset_id']);
    $salt = '$2a$08$' . substr(str_replace('+', '.', base64_encode(random_bytes(16))), 0, 22);
    $senha_hash = crypt($admin_senha, $salt);
    $update = $mysqli->query("UPDATE app_users SET password = '$senha_hash', email = '$admin_email_crypt', nome = '$admin_nome_crypt' WHERE id = $reset_id");
    if ($update) {
        echo "<p style='color:green;'>✓ Admin ID $reset_id atualizado!</p>";
        echo "<p><strong>Novo Email:</strong> $admin_email (criptografado: $admin_email_crypt)</p>";
        echo "<p><strong>Nova Senha:</strong> $admin_senha</p>";
    } else {
        echo "<p style='color:red;'>✗ Erro: " . $mysqli->error . "</p>";
    }
} else {
    echo "<p><a href='?reset_id=280' style='background:orange;color:white;padding:10px 20px;text-decoration:none;margin-right:10px;'>Resetar Admin ID 280</a>";
    echo "<a href='?reset_id=308' style='background:orange;color:white;padding:10px 20px;text-decoration:none;'>Resetar Admin ID 308</a></p>";
}

echo "<hr>";

// Verificar se o email já existe
$check_email = $mysqli->query("SELECT * FROM app_users WHERE email = '$admin_email_crypt'");
if ($check_email->num_rows > 0) {
    $existing = $check_email->fetch_assoc();
    echo "<p style='color:orange;'>⚠ Email '$admin_email' já existe no banco!</p>";
    echo "<p>ID: {$existing['id']}</p>";
    echo "<p>Para resetar a senha, clique abaixo:</p>";
    
    // Botão para resetar senha
    if (isset($_GET['reset']) && $_GET['reset'] == '1') {
        $salt = '$2a$08$' . substr(str_replace('+', '.', base64_encode(random_bytes(16))), 0, 22);
        $senha_hash = crypt($admin_senha, $salt);
        $update = $mysqli->query("UPDATE app_users SET password = '$senha_hash' WHERE email = '$admin_email_crypt'");
        if ($update) {
            echo "<p style='color:green;'>✓ Senha resetada para: <strong>$admin_senha</strong></p>";
        } else {
            echo "<p style='color:red;'>✗ Erro ao resetar: " . $mysqli->error . "</p>";
        }
    } else {
        echo "<a href='?reset=1' style='background:blue;color:white;padding:10px 20px;text-decoration:none;'>Resetar senha para '$admin_senha'</a>";
    }
} else {
    // Gerar hash da senha (compatível com o sistema - usa $2a$08$)
    $salt = '$2a$08$' . substr(str_replace('+', '.', base64_encode(random_bytes(16))), 0, 22);
    $senha_hash = crypt($admin_senha, $salt);
    
    // Montar INSERT dinâmico baseado nas colunas existentes
    $insert_cols = ['nome', 'email', 'password'];
    $insert_vals = ["'$admin_nome_crypt'", "'$admin_email_crypt'", "'$senha_hash'"];
    
    // Adicionar campos opcionais se existirem
    if (in_array('tipo', $columns)) {
        $insert_cols[] = 'tipo';
        $insert_vals[] = '2';
    }
    if (in_array('tipo_pessoa', $columns)) {
        $insert_cols[] = 'tipo_pessoa';
        $insert_vals[] = '1'; // 1 = pessoa física
    }
    if (in_array('id_grupo', $columns)) {
        $insert_cols[] = 'id_grupo';
        $insert_vals[] = '1'; // Grupo admin
    }
    if (in_array('id_empresa', $columns)) {
        $insert_cols[] = 'id_empresa';
        $insert_vals[] = '0';
    }
    if (in_array('documento', $columns)) {
        $insert_cols[] = 'documento';
        $insert_vals[] = "''";
    }
    if (in_array('cnpj', $columns)) {
        $insert_cols[] = 'cnpj';
        $insert_vals[] = "''";
    }
    if (in_array('razao_social', $columns)) {
        $insert_cols[] = 'razao_social';
        $insert_vals[] = "''";
    }
    if (in_array('nome_fantasia', $columns)) {
        $insert_cols[] = 'nome_fantasia';
        $insert_vals[] = "''";
    }
    if (in_array('ie', $columns)) {
        $insert_cols[] = 'ie';
        $insert_vals[] = "''";
    }
    if (in_array('celular', $columns)) {
        $insert_cols[] = 'celular';
        $insert_vals[] = "''";
    }
    if (in_array('status', $columns)) {
        $insert_cols[] = 'status';
        $insert_vals[] = '1';
    }
    if (in_array('status_aprovado', $columns)) {
        $insert_cols[] = 'status_aprovado';
        $insert_vals[] = '1';
    }
    if (in_array('online', $columns)) {
        $insert_cols[] = 'online';
        $insert_vals[] = '0';
    }
    if (in_array('data_cadastro', $columns)) {
        $insert_cols[] = 'data_cadastro';
        $insert_vals[] = 'NOW()';
    }
    
    $sql = "INSERT INTO app_users (" . implode(', ', $insert_cols) . ") VALUES (" . implode(', ', $insert_vals) . ")";
    
    echo "<p>SQL: <code>$sql</code></p>";
    
    if ($mysqli->query($sql)) {
        echo "<p style='color:green;'>✓ Administrador criado com sucesso!</p>";
        echo "<h3>Credenciais:</h3>";
        echo "<p><strong>Email:</strong> $admin_email</p>";
        echo "<p><strong>Senha:</strong> $admin_senha</p>";
    } else {
        echo "<p style='color:red;'>✗ Erro ao criar admin: " . $mysqli->error . "</p>";
    }
}

// ========================================
// CRIAR USUÁRIO COMUM (id_grupo = 4)
// ========================================
echo "<hr>";
echo "<h2>Criar Usuário Comum (id_grupo = 4)</h2>";

// Verificar se o email do usuário já existe
$check_user = $mysqli->query("SELECT * FROM app_users WHERE email = '$user_email_crypt'");
if ($check_user->num_rows > 0) {
    $existing_user = $check_user->fetch_assoc();
    echo "<p style='color:orange;'>⚠ Usuário '$user_email' já existe! (ID: {$existing_user['id']})</p>";
    
    if (isset($_GET['reset_user']) && $_GET['reset_user'] == '1') {
        $salt = '$2a$08$' . substr(str_replace('+', '.', base64_encode(random_bytes(16))), 0, 22);
        $senha_hash = crypt($user_senha, $salt);
        $update = $mysqli->query("UPDATE app_users SET password = '$senha_hash' WHERE email = '$user_email_crypt'");
        if ($update) {
            echo "<p style='color:green;'>✓ Senha do usuário resetada para: <strong>$user_senha</strong></p>";
        } else {
            echo "<p style='color:red;'>✗ Erro: " . $mysqli->error . "</p>";
        }
    } else {
        echo "<a href='?reset_user=1' style='background:purple;color:white;padding:10px 20px;text-decoration:none;'>Resetar senha do usuário</a>";
    }
} else {
    // Criar usuário comum
    if (isset($_GET['create_user']) && $_GET['create_user'] == '1') {
        $salt = '$2a$08$' . substr(str_replace('+', '.', base64_encode(random_bytes(16))), 0, 22);
        $senha_hash = crypt($user_senha, $salt);
        
        $sql_user = "INSERT INTO app_users (nome, email, password, tipo_pessoa, id_grupo, cnpj, razao_social, nome_fantasia, ie, celular, status, status_aprovado, online, data_cadastro) 
                     VALUES ('$user_nome_crypt', '$user_email_crypt', '$senha_hash', 1, 4, '', '', '', '', '', 1, 1, 0, NOW())";
        
        if ($mysqli->query($sql_user)) {
            echo "<p style='color:green;'>✓ Usuário comum criado com sucesso!</p>";
            echo "<h3>Credenciais do Usuário:</h3>";
            echo "<p><strong>Email:</strong> $user_email</p>";
            echo "<p><strong>Senha:</strong> $user_senha</p>";
            echo "<p><strong>id_grupo:</strong> 4 (usuário comum)</p>";
        } else {
            echo "<p style='color:red;'>✗ Erro ao criar usuário: " . $mysqli->error . "</p>";
        }
    } else {
        echo "<p>Usuário '$user_email' não existe. Clique para criar:</p>";
        echo "<a href='?create_user=1' style='background:green;color:white;padding:10px 20px;text-decoration:none;'>Criar Usuário Comum</a>";
    }
}

$mysqli->close();

echo "<hr>";
echo "<p style='color:red;'><strong>⚠ IMPORTANTE: Delete este arquivo após criar os usuários!</strong></p>";
?>
