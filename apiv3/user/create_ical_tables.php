<?php
/**
 * Script para criar tabelas de iCal externo
 * Execute uma vez e depois delete este arquivo
 */

$pdo = new PDO('mysql:host=localhost;dbname=go77app;port=3306', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Tabela para armazenar links iCal externos
    $pdo->exec("CREATE TABLE IF NOT EXISTS `app_ical_links` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `app_anuncios_id` INT NOT NULL,
        `nome` VARCHAR(100) NOT NULL COMMENT 'Ex: Airbnb, Booking, etc',
        `url` TEXT NOT NULL COMMENT 'URL do calendario iCal',
        `ultima_sincronizacao` DATETIME DEFAULT NULL,
        `status` TINYINT(1) DEFAULT 1 COMMENT '1=ativo, 0=inativo',
        `erros` INT DEFAULT 0 COMMENT 'Contador de erros consecutivos',
        `ultimo_erro` TEXT DEFAULT NULL,
        `data_cadastro` DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX `idx_anuncio` (`app_anuncios_id`),
        INDEX `idx_status` (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "✅ Tabela app_ical_links criada!<br>";

    // Tabela para armazenar bloqueios importados via iCal
    $pdo->exec("CREATE TABLE IF NOT EXISTS `app_ical_bloqueios` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `app_anuncios_id` INT NOT NULL,
        `app_ical_links_id` INT NOT NULL,
        `uid` VARCHAR(255) NOT NULL COMMENT 'UID do evento iCal',
        `data_inicio` DATE NOT NULL,
        `data_fim` DATE NOT NULL,
        `resumo` VARCHAR(255) DEFAULT NULL COMMENT 'SUMMARY do evento',
        `data_importacao` DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX `idx_anuncio` (`app_anuncios_id`),
        INDEX `idx_link` (`app_ical_links_id`),
        INDEX `idx_datas` (`data_inicio`, `data_fim`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "✅ Tabela app_ical_bloqueios criada!<br>";

    echo "<br><strong>Tabelas criadas com sucesso! Pode deletar este arquivo.</strong>";

} catch (PDOException $e) {
    echo "❌ Erro: " . $e->getMessage();
}
