<?php
require_once 'config/database.php';
$s = $pdo->query('SELECT * FROM dealer_motor');
foreach($s->fetchAll(PDO::FETCH_ASSOC) as $r) {
    echo $r['id'] . ': ' . $r['nama_dealer'] . " (" . $r['marka'] . ")\n";
}
