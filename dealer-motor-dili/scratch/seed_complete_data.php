<?php
require_once 'config/database.php';

$dealers = [
    ['DEALER HONDA MEFA-OSSO-MESSA', 'Honda', 2500, 'R. Dom Luís dos Reis Noronha, Díli', -8.5575619, 125.5713350, '07:30 - 23:59', '+670 7700 1111', 'mefa.osso@hondadealer.tl', 'fb.com/mefaossomessa', '@mefa_osso', 'Dealer resmi Honda iha area Motael.'],
    ['DEALER HONDA DIOGO MOTO FORTE', 'Honda', 2800, 'Colmera, Vera Cruz, Díli (Blok B1 No. A8)', -8.5544938, 125.5746839, '09:00 - 17:00', '+670 7700 2222', 'diogo.moto@hondadealer.tl', 'fb.com/diogomotoforte', '@diogo_moto', 'Dealer resmi Honda — Diogo Moto Forte.'],
    ['Cedars Motor', 'Honda', 2300, 'Av. Liberdade de Imprensa, Díli', -8.5562760, 125.5866170, '08:00 - 17:00', '+670 7700 3333', 'cedars.motor@hondadealer.tl', 'fb.com/cedarsmotor', '@cedars_motor', 'Dealer resmi Honda iha Santa Cruz.'],
    ['Gilsanrem Unipessoal Lda', 'Honda', 2100, 'Estr. de Balide, Díli', -8.5657724, 125.5748401, '08:00 - 17:00', '+670 7700 4444', 'gilsanrem@hondadealer.tl', 'fb.com/gilsanrem', '@gilsanrem', 'Dealer resmi Honda — Gilsanrem Unipessoal.'],
    ['Palma Motor – Dili Timor Leste', 'Honda', 2600, 'Lecidere, Bidau Lecidere, Díli', -8.5521980, 125.5842762, '08:30 - 17:30', '+670 7700 5555', 'palma.motor@hondadealer.tl', 'fb.com/palmamotor', '@palma_motor', 'Dealer resmi Honda iha area Bidau.']
];

try {
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $pdo->exec("TRUNCATE TABLE dealer_motor");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    
    $stmt = $pdo->prepare("INSERT INTO dealer_motor (nama_dealer, marka, presu, alamat, latitude, longitude, jam_buka, telepon, email, facebook, instagram, deskripsi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($dealers as $d) {
        $stmt->execute($d);
        echo "Inserted: " . $d[0] . "\n";
    }
    echo "Successfully seeded " . count($dealers) . " dealers with complete data including price attribute.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
