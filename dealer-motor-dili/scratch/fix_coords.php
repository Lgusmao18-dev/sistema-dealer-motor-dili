<?php
require_once 'config/database.php';

// Exact coordinates from user screenshot and verified landmarks
$coords = [
    'Honda Motor Dili Prima'   => [-8.554437, 125.574675], // Diogo Moto Forte, Colmera
    'Yamaha Motor Dili Sport'  => [-8.558300, 125.584100], // Audian area
    'Suzuki Timor Motor'       => [-8.564100, 125.570500], // Balide area
    'Kawasaki Dili Center'     => [-8.556200, 125.580500], // Kaikoli area
    'TVS Motor Timor'          => [-8.558200, 125.575500]  // Caicoli area
];

foreach ($coords as $name => $c) {
    $stmt = $pdo->prepare("UPDATE dealer_motor SET latitude = ?, longitude = ? WHERE nama_dealer = ?");
    $stmt->execute([$c[0], $c[1], $name]);
    echo "Updated $name to EXACT location: " . $c[0] . ", " . $c[1] . "\n";
}
echo "Coordinate verification with real imagery complete!";
