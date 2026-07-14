<?php
require_once 'config/database.php';

try {
    $pdo->exec("ALTER TABLE dealer_motor ADD COLUMN email VARCHAR(100) AFTER telepon");
    $pdo->exec("ALTER TABLE dealer_motor ADD COLUMN facebook VARCHAR(255) AFTER email");
    $pdo->exec("ALTER TABLE dealer_motor ADD COLUMN instagram VARCHAR(255) AFTER facebook");
    echo "Columns added successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
