<?php
require_once 'config/database.php';

try {
    $stmt = $pdo->query("SELECT * FROM dealer_motor");
    $dealers = $stmt->fetchAll();
    echo "Found " . count($dealers) . " dealers.\n";
    foreach ($dealers as $d) {
        echo "- ID: " . $d['id'] . ", Name: " . $d['nama_dealer'] . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
