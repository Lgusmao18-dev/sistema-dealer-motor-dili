<?php
require_once 'config/database.php';
$dealers = $pdo->query("SELECT * FROM dealer_motor ORDER BY id DESC")->fetchAll();
echo "Number of dealers: " . count($dealers) . "\n";
foreach ($dealers as $d) {
    echo "ID: " . $d['id'] . " - " . $d['nama_dealer'] . "\n";
}
