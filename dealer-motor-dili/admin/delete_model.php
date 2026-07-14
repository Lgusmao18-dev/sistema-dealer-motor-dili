<?php
require_once '../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Get photo filename to delete it
    $stmt = $pdo->prepare("SELECT foto FROM motor_models WHERE id = ?");
    $stmt->execute([$id]);
    $model = $stmt->fetch();
    
    if ($model && !empty($model['foto'])) {
        $path = '../assets/images/motors/' . $model['foto'];
        if (file_exists($path)) {
            unlink($path);
        }
    }
    
    $stmt = $pdo->prepare("DELETE FROM motor_models WHERE id = ?");
    $stmt->execute([$id]);
}

redirect('/dealer-motor-dili/admin/models.php?success=Modelu motor apaga ho susesu!');
