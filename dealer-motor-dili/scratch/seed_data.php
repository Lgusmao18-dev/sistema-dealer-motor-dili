<?php
require_once 'config/database.php';

$dealers = [
    ['Honda Motor Dili Prima',   'Honda',    'Rua Formosa, Dili, Timor-Leste',    -8.5534, 125.5780, '08:00 - 18:00', '+670 7711 1111', 'Dealer resmi Honda — Beat, Vario, Supra X.'],
    ['Yamaha Motor Dili Sport',  'Yamaha',   'Av. Marginal, Dili, Timor-Leste',   -8.5520, 125.5760, '08:00 - 17:30', '+670 7722 2222', 'Dealer resmi Yamaha — Mio, NMAX, Jupiter.'],
    ['Suzuki Timor Motor',       'Suzuki',   'Rua de Balide, Dili, Timor-Leste',  -8.5560, 125.5800, '08:30 - 17:00', '+670 7733 3333', 'Dealer resmi Suzuki — Smash, Satria, Address.'],
    ['Kawasaki Dili Center',     'Kawasaki', 'Rua Kaikoli, Dili, Timor-Leste',    -8.5545, 125.5820, '09:00 - 18:00', '+670 7744 4444', 'Dealer resmi Kawasaki — KLX, Ninja, W175.'],
    ['TVS Motor Timor',          'TVS',      'Rua Caicoli, Dili, Timor-Leste',    -8.5510, 125.5740, '08:00 - 17:00', '+670 7755 5555', 'Dealer resmi TVS — Apache, Star City.']
];

try {
    $pdo->exec("TRUNCATE TABLE dealer_motor");
    $stmt = $pdo->prepare("INSERT INTO dealer_motor (nama_dealer, marka, alamat, latitude, longitude, jam_buka, telepon, deskripsi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($dealers as $d) {
        $stmt->execute($d);
        echo "Inserted: " . $d[0] . "\n";
    }
    echo "Successfully seeded " . count($dealers) . " dealers.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
