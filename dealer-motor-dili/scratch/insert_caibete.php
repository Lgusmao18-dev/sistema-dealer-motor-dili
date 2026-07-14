<?php
require_once __DIR__ . '/../config/database.php';

$dealer = [
    'nama_dealer' => 'Dealer Honda Caibete Motor Dili',
    'marka' => 'Honda',
    'presu' => 2450,
    'alamat' => 'Avenida de Hudi Laran, Delta 2, Díli',
    'latitude' => -8.5615000,
    'longitude' => 125.5450000,
    'jam_buka' => '08:00 - 17:00',
    'telepon' => '+670 7700 6666',
    'email' => 'caibete.motor@hondadealer.tl',
    'facebook' => 'fb.com/caibetemotor',
    'instagram' => '@caibete_motor',
    'deskripsi' => 'Dealer resmi Honda — Caibete Motor iha area Hudi Laran.',
    'foto' => 'caibete.png'
];

try {
    // Check if it already exists
    $stmt = $pdo->prepare("SELECT id FROM dealer_motor WHERE nama_dealer = ?");
    $stmt->execute([$dealer['nama_dealer']]);
    if ($stmt->fetch()) {
        echo "Dealer already exists!\n";
    } else {
        $stmt = $pdo->prepare("INSERT INTO dealer_motor (nama_dealer, marka, presu, alamat, latitude, longitude, jam_buka, telepon, email, facebook, instagram, deskripsi, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $dealer['nama_dealer'],
            $dealer['marka'],
            $dealer['presu'],
            $dealer['alamat'],
            $dealer['latitude'],
            $dealer['longitude'],
            $dealer['jam_buka'],
            $dealer['telepon'],
            $dealer['email'],
            $dealer['facebook'],
            $dealer['instagram'],
            $dealer['deskripsi'],
            $dealer['foto']
        ]);
        
        echo "Successfully inserted new dealer: " . $dealer['nama_dealer'] . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
