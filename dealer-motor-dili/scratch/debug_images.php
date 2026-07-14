<?php
require_once 'config/database.php';
$stmt = $pdo->query("SELECT id, nama_dealer, marka, foto FROM dealer_motor");
while($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    print_r($r);
}
?>
