<?php
require 'config/database.php';
try {
    $pdo->exec("ALTER TABLE dealer_motor ADD COLUMN foto VARCHAR(255) AFTER deskripsi");
    echo "Column 'foto' added successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
