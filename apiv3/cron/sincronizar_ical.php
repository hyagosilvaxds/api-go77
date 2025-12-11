<?php
/**
 * Script de Sincronização de Calendários iCal Externos
 * 
 * Este script deve ser executado via cron a cada 6 horas:
 * 0 * /6 * * * /usr/bin/php /caminho/para/www/apiv3/cron/sincronizar_ical.php >> /var/log/ical_sync.log 2>&1
 * 
 * Ou no MAMP:
 * 0 * /6 * * * /Applications/MAMP/bin/php/php8.3.14/bin/php /Applications/MAMP/htdocs/www/apiv3/cron/sincronizar_ical.php
 */

// Configurações
define('CRON_MODE', true);
define('MAX_ERROS', 5); // Máximo de erros antes de desativar um link

// Conectar ao banco
$config = [
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'go77app',
    'user' => 'root',
    'pass' => 'root'
];

try {
    $pdo = new PDO(
        "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset=utf8mb4",
        $config['user'],
        $config['pass'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    logMsg("ERRO: Não foi possível conectar ao banco: " . $e->getMessage());
    exit(1);
}

logMsg("========================================");
logMsg("Iniciando sincronização de calendários iCal");
logMsg("Data/Hora: " . date('Y-m-d H:i:s'));
logMsg("========================================");

// Buscar todos os links ativos
$stmt = $pdo->prepare("
    SELECT l.*, a.nome as nome_anuncio, t.titulo as nome_type
    FROM app_ical_links l
    INNER JOIN app_anuncios a ON l.app_anuncios_id = a.id
    LEFT JOIN app_anuncios_types t ON l.app_anuncios_types_id = t.id
    WHERE l.status = 1 AND l.erros < ?
    ORDER BY l.ultima_sincronizacao ASC
");
$stmt->execute([MAX_ERROS]);
$links = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_links = count($links);
logMsg("Links encontrados: $total_links");

if ($total_links === 0) {
    logMsg("Nenhum link para sincronizar.");
    exit(0);
}

$sucesso = 0;
$erros = 0;
$eventos_total = 0;

foreach ($links as $link) {
    logMsg("");
    $type_info = !empty($link['nome_type']) ? " (Quarto: {$link['nome_type']})" : " (Anúncio inteiro)";
    logMsg("Processando: {$link['nome']} - Anúncio: {$link['nome_anuncio']}{$type_info}");
    logMsg("URL: " . substr($link['url'], 0, 80) . "...");
    
    $resultado = sincronizarLink($pdo, $link);
    
    if ($resultado['sucesso']) {
        $sucesso++;
        $eventos_total += $resultado['eventos'];
        logMsg("✅ Sucesso! Eventos importados: {$resultado['eventos']}");
    } else {
        $erros++;
        logMsg("❌ Erro: {$resultado['erro']}");
    }
    
    // Pequena pausa para não sobrecarregar
    usleep(500000); // 0.5 segundo
}

logMsg("");
logMsg("========================================");
logMsg("Sincronização concluída!");
logMsg("Links processados: $total_links");
logMsg("Sucesso: $sucesso");
logMsg("Erros: $erros");
logMsg("Total de eventos importados: $eventos_total");
logMsg("========================================");

/**
 * Sincroniza um link iCal específico
 */
function sincronizarLink($pdo, $link) {
    $resultado = [
        'sucesso' => false,
        'eventos' => 0,
        'erro' => null
    ];
    
    try {
        // Faz download do iCal
        $contexto = stream_context_create([
            'http' => [
                'timeout' => 30,
                'user_agent' => 'GO77-iCal-Sync/1.0',
                'follow_location' => true
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false
            ]
        ]);
        
        $conteudo = @file_get_contents($link['url'], false, $contexto);
        
        if ($conteudo === false) {
            throw new Exception('Não foi possível acessar a URL');
        }
        
        if (empty($conteudo)) {
            throw new Exception('Conteúdo vazio');
        }
        
        // Verifica se é um iCal válido
        if (strpos($conteudo, 'BEGIN:VCALENDAR') === false) {
            throw new Exception('Conteúdo não é um calendário iCal válido');
        }
        
        // Limpa bloqueios anteriores deste link
        $stmt = $pdo->prepare("DELETE FROM app_ical_bloqueios WHERE app_ical_links_id = ?");
        $stmt->execute([$link['id']]);
        
        // Faz parse do iCal
        $eventos = parseIcal($conteudo);
        
        // Insere novos bloqueios
        $stmt = $pdo->prepare("
            INSERT INTO app_ical_bloqueios 
            (app_anuncios_id, app_anuncios_types_id, app_ical_links_id, uid, data_inicio, data_fim, resumo, data_importacao)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE 
            data_inicio = VALUES(data_inicio), 
            data_fim = VALUES(data_fim), 
            resumo = VALUES(resumo), 
            data_importacao = NOW()
        ");
        
        $hoje = date('Y-m-d');
        
        // Pega o id_type do link (pode ser NULL para anúncio inteiro)
        $id_type = $link['app_anuncios_types_id'];
        
        foreach ($eventos as $evento) {
            if (!empty($evento['dtstart']) && !empty($evento['dtend'])) {
                // Ignora eventos passados
                if ($evento['dtend'] < $hoje) {
                    continue;
                }
                
                $stmt->execute([
                    $link['app_anuncios_id'],
                    $id_type,
                    $link['id'],
                    $evento['uid'] ?? uniqid('evt_'),
                    $evento['dtstart'],
                    $evento['dtend'],
                    substr($evento['summary'] ?? '', 0, 255)
                ]);
                $resultado['eventos']++;
            }
        }
        
        // Atualiza status de sincronização
        $stmt = $pdo->prepare("
            UPDATE app_ical_links 
            SET ultima_sincronizacao = NOW(), erros = 0, ultimo_erro = NULL 
            WHERE id = ?
        ");
        $stmt->execute([$link['id']]);
        
        $resultado['sucesso'] = true;
        
    } catch (Exception $e) {
        $resultado['erro'] = $e->getMessage();
        
        // Atualiza contador de erros
        $stmt = $pdo->prepare("
            UPDATE app_ical_links 
            SET erros = erros + 1, ultimo_erro = ? 
            WHERE id = ?
        ");
        $stmt->execute([$e->getMessage(), $link['id']]);
        
        // Desativa link com muitos erros
        if ($link['erros'] + 1 >= MAX_ERROS) {
            $stmt = $pdo->prepare("UPDATE app_ical_links SET status = 0 WHERE id = ?");
            $stmt->execute([$link['id']]);
            logMsg("⚠️ Link desativado após " . MAX_ERROS . " erros consecutivos");
        }
    }
    
    return $resultado;
}

/**
 * Faz parse de um arquivo iCal e extrai os eventos
 */
function parseIcal($conteudo) {
    $eventos = [];
    
    // Normaliza quebras de linha
    $conteudo = str_replace("\r\n ", "", $conteudo);
    $conteudo = str_replace("\r\n\t", "", $conteudo);
    
    $linhas = preg_split('/\r\n|\r|\n/', $conteudo);
    
    $evento = null;
    
    foreach ($linhas as $linha) {
        $linha = trim($linha);
        
        if ($linha === 'BEGIN:VEVENT') {
            $evento = [];
            continue;
        }
        
        if ($linha === 'END:VEVENT' && $evento !== null) {
            $eventos[] = $evento;
            $evento = null;
            continue;
        }
        
        if ($evento !== null) {
            // Parse propriedade
            $pos = strpos($linha, ':');
            if ($pos !== false) {
                $chave = substr($linha, 0, $pos);
                $valor = substr($linha, $pos + 1);
                
                // Remove parâmetros da chave (ex: DTSTART;VALUE=DATE -> DTSTART)
                if (strpos($chave, ';') !== false) {
                    $chave = substr($chave, 0, strpos($chave, ';'));
                }
                
                $chave = strtolower($chave);
                
                // Converte datas
                if (in_array($chave, ['dtstart', 'dtend'])) {
                    $valor = parseDataIcal($valor);
                }
                
                $evento[$chave] = $valor;
            }
        }
    }
    
    return $eventos;
}

/**
 * Converte data iCal para formato MySQL
 */
function parseDataIcal($data) {
    // Remove Z se presente
    $data = rtrim($data, 'Z');
    
    // Formato: YYYYMMDD ou YYYYMMDDTHHmmss
    if (strlen($data) >= 8) {
        return substr($data, 0, 4) . '-' . substr($data, 4, 2) . '-' . substr($data, 6, 2);
    }
    
    return $data;
}

/**
 * Log com timestamp
 */
function logMsg($msg) {
    $timestamp = date('Y-m-d H:i:s');
    echo "[$timestamp] $msg\n";
}
