<?php
/**
 * iCal de Demonstração para Testes
 * 
 * URL: http://localhost:8888/www/apiv3/test/ical_demo.php?room=102
 * 
 * Retorna um calendário iCal com reservas fictícias para testar
 * a importação de calendários externos (Airbnb, Booking, etc)
 */

// Identificar qual quarto
$room = isset($_GET['room']) ? $_GET['room'] : '102';

// Gerar UID único baseado no quarto
$baseUid = "demo-" . $room;

// Data atual
$now = new DateTime();
$nowStr = $now->format('Ymd\THis\Z');

// Gerar algumas reservas de exemplo
$events = [];

// ==========================================
// RESERVAS DE DEZEMBRO 2025
// ==========================================

// Reserva 1: Próxima semana (5 dias)
$start1 = clone $now;
$start1->modify('+3 days');
$end1 = clone $start1;
$end1->modify('+4 days');

$events[] = [
    'uid' => $baseUid . '-res001@airbnb.com',
    'summary' => 'Reserva - João Silva',
    'start' => $start1->format('Ymd'),
    'end' => $end1->format('Ymd'),
    'description' => 'Hóspede: João Silva\n2 adultos\nAirbnb Confirmation: ABC123'
];

// Reserva 2: Final de semana próximo (2 dias)
$start2 = clone $now;
$start2->modify('+10 days');
$end2 = clone $start2;
$end2->modify('+2 days');

$events[] = [
    'uid' => $baseUid . '-res002@booking.com',
    'summary' => 'Reserva - Maria Santos',
    'start' => $start2->format('Ymd'),
    'end' => $end2->format('Ymd'),
    'description' => 'Hóspede: Maria Santos\n3 adultos + 1 criança\nBooking.com'
];

// Reserva 3: Semana do Natal (7 dias)
$events[] = [
    'uid' => $baseUid . '-res003@airbnb.com',
    'summary' => 'Reserva - Família Oliveira',
    'start' => '20251220',
    'end' => '20251227',
    'description' => 'Hóspede: Carlos Oliveira\n4 adultos + 2 crianças\nNatal em família'
];

// Reserva 4: Réveillon (5 dias)
$events[] = [
    'uid' => $baseUid . '-res004@airbnb.com',
    'summary' => 'Reserva - Pedro Almeida',
    'start' => '20251228',
    'end' => '20260102',
    'description' => 'Réveillon\nHóspede: Pedro Almeida\n2 casais'
];

// ==========================================
// RESERVAS DE JANEIRO 2026
// ==========================================

// Reserva 5: Primeira semana de Janeiro
$events[] = [
    'uid' => $baseUid . '-res005@booking.com',
    'summary' => 'Reserva - Ana Costa',
    'start' => '20260105',
    'end' => '20260110',
    'description' => 'Hóspede: Ana Costa\n2 adultos\nLua de mel'
];

// Bloqueio: Manutenção
$events[] = [
    'uid' => $baseUid . '-block001@go77.com.br',
    'summary' => 'Blocked - Manutenção',
    'start' => '20260112',
    'end' => '20260114',
    'description' => 'Manutenção do ar-condicionado'
];

// Reserva 6: Meio de Janeiro
$events[] = [
    'uid' => $baseUid . '-res006@airbnb.com',
    'summary' => 'Reserva - Roberto Lima',
    'start' => '20260115',
    'end' => '20260120',
    'description' => 'Hóspede: Roberto Lima\nViagem de negócios'
];

// Reserva 7: Fim de Janeiro
$events[] = [
    'uid' => $baseUid . '-res007@vrbo.com',
    'summary' => 'Reserva - Fernanda Souza',
    'start' => '20260125',
    'end' => '20260131',
    'description' => 'Hóspede: Fernanda Souza\nVRBO\n2 adultos + 1 pet'
];

// ==========================================
// RESERVAS DE FEVEREIRO 2026
// ==========================================

// Reserva 8: Início de Fevereiro
$events[] = [
    'uid' => $baseUid . '-res008@booking.com',
    'summary' => 'Reserva - Lucas Mendes',
    'start' => '20260201',
    'end' => '20260205',
    'description' => 'Hóspede: Lucas Mendes\nBooking.com'
];

// Reserva 9: Dia dos Namorados (reserva especial)
$events[] = [
    'uid' => $baseUid . '-res009@airbnb.com',
    'summary' => 'Reserva - Casal Romântico',
    'start' => '20260212',
    'end' => '20260215',
    'description' => 'Pacote Dia dos Namorados\nDecoração especial incluída'
];

// Reserva 10: Carnaval (5 dias)
$events[] = [
    'uid' => $baseUid . '-res010@airbnb.com',
    'summary' => 'Reserva - Grupo Carnaval',
    'start' => '20260214',
    'end' => '20260219',
    'description' => 'Carnaval 2026\nGrupo de 6 amigos'
];

// Reserva 11: Pós-Carnaval
$events[] = [
    'uid' => $baseUid . '-res011@booking.com',
    'summary' => 'Reserva - Patricia Gomes',
    'start' => '20260220',
    'end' => '20260225',
    'description' => 'Hóspede: Patricia Gomes\nDescanso pós-carnaval'
];

// ==========================================
// RESERVAS DE MARÇO 2026
// ==========================================

// Reserva 12: Primeira semana de Março
$events[] = [
    'uid' => $baseUid . '-res012@airbnb.com',
    'summary' => 'Reserva - Empresa Tech Corp',
    'start' => '20260302',
    'end' => '20260306',
    'description' => 'Reserva corporativa\n4 executivos'
];

// Bloqueio: Pintura
$events[] = [
    'uid' => $baseUid . '-block002@go77.com.br',
    'summary' => 'Blocked - Pintura',
    'start' => '20260310',
    'end' => '20260313',
    'description' => 'Renovação - pintura do quarto'
];

// Reserva 13: Meio de Março
$events[] = [
    'uid' => $baseUid . '-res013@booking.com',
    'summary' => 'Reserva - Juliana Martins',
    'start' => '20260315',
    'end' => '20260322',
    'description' => 'Hóspede: Juliana Martins\nHome office remoto\n7 noites'
];

// Reserva 14: Fim de Março
$events[] = [
    'uid' => $baseUid . '-res014@airbnb.com',
    'summary' => 'Reserva - Família Pereira',
    'start' => '20260328',
    'end' => '20260402',
    'description' => 'Semana Santa\nFamília com 2 crianças'
];

// ==========================================
// MONTAR O iCAL
// ==========================================

$ical = "BEGIN:VCALENDAR\r\n";
$ical .= "VERSION:2.0\r\n";
$ical .= "PRODID:-//GO77 Demo//iCal Test//PT-BR\r\n";
$ical .= "CALSCALE:GREGORIAN\r\n";
$ical .= "METHOD:PUBLISH\r\n";
$ical .= "X-WR-CALNAME:Suite " . $room . " - Demo\r\n";
$ical .= "X-WR-TIMEZONE:America/Sao_Paulo\r\n";

foreach ($events as $event) {
    $ical .= "BEGIN:VEVENT\r\n";
    $ical .= "UID:" . $event['uid'] . "\r\n";
    $ical .= "DTSTAMP:" . $nowStr . "\r\n";
    $ical .= "DTSTART;VALUE=DATE:" . $event['start'] . "\r\n";
    $ical .= "DTEND;VALUE=DATE:" . $event['end'] . "\r\n";
    $ical .= "SUMMARY:" . $event['summary'] . "\r\n";
    if (!empty($event['description'])) {
        $ical .= "DESCRIPTION:" . str_replace("\n", "\\n", $event['description']) . "\r\n";
    }
    $ical .= "STATUS:CONFIRMED\r\n";
    $ical .= "TRANSP:OPAQUE\r\n";
    $ical .= "END:VEVENT\r\n";
}

$ical .= "END:VCALENDAR\r\n";

// Enviar headers corretos para iCal
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename="suite-' . $room . '.ics"');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

echo $ical;
