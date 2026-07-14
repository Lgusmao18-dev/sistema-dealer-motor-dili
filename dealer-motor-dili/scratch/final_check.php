<?php
require_once 'config/database.php';
$stmt = $pdo->query("SELECT COUNT(*) FROM dealer_motor");
echo "TOTAL_DEALERS:" . $stmt->fetchColumn();
