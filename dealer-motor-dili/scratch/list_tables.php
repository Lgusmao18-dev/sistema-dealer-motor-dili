<?php
require_once 'config/database.php';
$stmt = $pdo->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
echo "Tables in database:\n";
foreach ($tables as $t) {
    echo "- " . $t . "\n";
    $stmt2 = $pdo->query("DESCRIBE $t");
    $cols = $stmt2->fetchAll();
    foreach ($cols as $c) {
        echo "  * " . $c['Field'] . " (" . $c['Type'] . ")\n";
    }
}
