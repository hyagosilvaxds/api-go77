<?php
$mysqli = new mysqli('localhost', 'root', 'root', 'go77app');
$result = $mysqli->query("DESCRIBE app_anuncios_valor");
while($row = $result->fetch_assoc()) {
    echo $row['Field'] . " | " . $row['Type'] . "\n";
}
