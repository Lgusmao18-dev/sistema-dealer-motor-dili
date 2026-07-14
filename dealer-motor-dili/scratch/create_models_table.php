<?php
require_once 'config/database.php';

$sql = "
CREATE TABLE IF NOT EXISTS motor_models (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_model VARCHAR(200) NOT NULL,
    marka VARCHAR(100) NOT NULL,
    presu DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    deskrisaun TEXT,
    especificasaun TEXT,
    foto VARCHAR(255),
    dealer_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (dealer_id) REFERENCES dealer_motor(id) ON DELETE SET NULL
)";

try {
    $pdo->exec($sql);
    echo "Table 'motor_models' created successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
