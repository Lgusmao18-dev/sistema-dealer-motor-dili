<?php
require_once 'config/database.php';

$stmt = $pdo->query("SELECT m.*, d.nama_dealer FROM motor_models m LEFT JOIN dealer_motor d ON m.dealer_id = d.id");
$models = $stmt->fetchAll();

echo "Current Motor Models:\n";
foreach ($models as $m) {
    echo "- " . $m['nama_model'] . " (" . $m['marka'] . ") - $" . $m['presu'] . " at " . ($m['nama_dealer'] ?? 'None') . "\n";
}
