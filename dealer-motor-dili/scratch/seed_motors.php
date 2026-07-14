<?php
require_once 'config/database.php';

// Get some dealer IDs
$dealers = $pdo->query("SELECT id, marka FROM dealer_motor")->fetchAll(PDO::FETCH_KEY_PAIR);

$motors = [
    ['Honda Vario 160', 'Honda', 2850.00, 'Motor matic foun ho teknolojia ESP+ no kbiit mesin 160cc ne\'ebé forte no ekonomia.'],
    ['Honda Beat Deluxe', 'Honda', 1950.00, 'Motor favorit iha Timor-Leste, lójiku ba uza loron-loron no hemu kombustível uitoan deit.'],
    ['Yamaha NMAX 155', 'Yamaha', 3400.00, 'Skuter matic premium ho kbiit VVA ne\'ebé fó performansa másimu iha estrada luan.'],
    ['Yamaha Mio M3', 'Yamaha', 1800.00, 'Design foun ne\'ebé sporti no kbiit mesin Blue Core ne\'ebé lójiku no tahan kleur.'],
    ['Suzuki Satria F150', 'Suzuki', 2700.00, 'Motor bebek sport ne\'ebé iha performansa kbiit mesin DOHC ne\'ebé kibi\'it liu iha ninia klase.'],
    ['Kawasaki KLX 150', 'Kawasaki', 3200.00, 'Motor trail ne\'ebé prontu atu konkista estrada foho no rai-rahun iha Timor-Leste.'],
    ['TVS Apache RTR', 'TVS', 2400.00, 'Motor sport naked ne\'ebé fó performansa lójiku no kbiit mesin ne\'ebé agressivu.']
];

try {
    $stmt = $pdo->prepare("INSERT INTO motor_models (nama_model, marka, presu, deskrisaun, dealer_id) VALUES (?,?,?,?,?)");
    
    foreach ($motors as $m) {
        // Find a matching dealer ID for the brand
        $dealer_id = null;
        foreach ($dealers as $id => $marka) {
            if (strtolower($marka) === strtolower($m[1])) {
                $dealer_id = $id;
                break;
            }
        }
        
        $stmt->execute([$m[0], $m[1], $m[2], $m[3], $dealer_id]);
        echo "Inserted model: " . $m[0] . "\n";
    }
    echo "Successfully added sample motor models.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
