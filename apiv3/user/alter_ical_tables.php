<?php
/**
 * Script para alterar tabelas de iCal para suportar tipos/quartos
 */

$pdo = new PDO('mysql:host=localhost;dbname=go77app;port=3306', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Adicionar coluna app_anuncios_types_id na tabela app_ical_links
    $pdo->exec("ALTER TABLE `app_ical_links` 
                ADD COLUMN `app_anuncios_types_id` INT DEFAULT NULL AFTER `app_anuncios_id`,
                ADD INDEX `idx_type` (`app_anuncios_types_id`)");
    echo "✅ Coluna app_anuncios_types_id adicionada em app_ical_links<br>";
    
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column') !== false) {
        echo "⚠️ Coluna app_anuncios_types_id já existe em app_ical_links<br>";
    } else {
        echo "❌ Erro: " . $e->getMessage() . "<br>";
    }
}

try {
    // Adicionar coluna app_anuncios_types_id na tabela app_ical_bloqueios
    $pdo->exec("ALTER TABLE `app_ical_bloqueios` 
                ADD COLUMN `app_anuncios_types_id` INT DEFAULT NULL AFTER `app_anuncios_id`,
                ADD INDEX `idx_type` (`app_anuncios_types_id`)");
    echo "✅ Coluna app_anuncios_types_id adicionada em app_ical_bloqueios<br>";
    
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column') !== false) {
        echo "⚠️ Coluna app_anuncios_types_id já existe em app_ical_bloqueios<br>";
    } else {
        echo "❌ Erro: " . $e->getMessage() . "<br>";
    }
}

echo "<br><strong>Alterações concluídas! Pode deletar este arquivo.</strong>";
