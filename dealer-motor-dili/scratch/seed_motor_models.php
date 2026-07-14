<?php
require_once 'config/database.php';

$models = [];
$honda_models = [
    ['Honda Vario 160', 'Honda', 2850, 'Motor matic premium Honda 160cc.', '160cc, Keyless, ABS', 'vario.jfif'],
    ['Honda Beat Deluxe', 'Honda', 1950, 'Motor matic irit Honda.', '110cc, CBS, ISS', 'beat.jfif'],
    ['Honda Scoopy', 'Honda', 2100, 'Motor matic stylish retro.', '110cc, Keyless, USB Charger', 'scoopy.jfif'],
    ['Honda ADV 160', 'Honda', 3600, 'Motor matic adventure premium.', '160cc, HSTC, ABS', 'adv.jfif'],
    ['Honda CRF150L', 'Honda', 3200, 'Motor on-off road handal.', '150cc, Injeksi, Upside Down', 'crf.jfif'],
    ['Honda PCX 160', 'Honda', 3500, 'Motor matic besar comfort.', '160cc, ABS, HSTC', 'pcx.jfif'],
    ['Honda CBR150R', 'Honda', 3800, 'Motor sport fairing Honda.', '150cc, DOHC, 6-Speed', 'cbr150.jfif']
];

// Distribute models across the 5 Honda dealers
for ($dealer_id = 1; $dealer_id <= 5; $dealer_id++) {
    // Each dealer gets a slightly different selection of models
    $selection = array_rand($honda_models, 4); 
    foreach ($selection as $idx) {
        $m = $honda_models[$idx];
        $models[] = [$m[0], $m[1], $m[2], $m[3], $m[4], $m[5], $dealer_id];
    }
}

try {
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $pdo->exec("TRUNCATE TABLE motor_models");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    
    $stmt = $pdo->prepare("INSERT INTO motor_models (nama_model, marka, presu, deskrisaun, especificasaun, foto, dealer_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($models as $m) {
        $stmt->execute($m);
        echo "Inserted Model: " . $m[0] . "\n";
    }
    echo "Successfully seeded " . count($models) . " motor models with prices.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
