<?php
require_once __DIR__ . '/../config/database.php';

$updates = [
    'DEALER HONDA MEFA-OSSO-MESSA' => 'honda_mefa.png',
    'DEALER HONDA DIOGO MOTO FORTE' => 'Honda diego.png',
    'Cedars Motor' => 'cedars.png',
    'Gilsanrem Unipessoal Lda' => 'gilsanren.png',
    'Palma Motor – Dili Timor Leste' => 'palm_motor.png'
];

try {
    $stmt = $pdo->prepare("UPDATE dealer_motor SET foto = ? WHERE nama_dealer = ?");
    $count = 0;
    foreach ($updates as $name => $img) {
        $stmt->execute([$img, $name]);
        if ($stmt->rowCount() > 0) {
            echo "Updated image for $name to $img\n";
            $count++;
        } else {
            echo "Failed to update or no changes for $name\n";
        }
    }
    echo "Total updated: $count\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
