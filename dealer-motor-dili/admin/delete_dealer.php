<?php
require_once '../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');
$id = (int)($_GET['id'] ?? 0);
if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM dealer_motor WHERE id=?");
        $stmt->execute([$id]);
        $success_msg = "Dealer motor apaga ho susesu!";
        redirect('/dealer-motor-dili/admin/dealers.php?success=' . urlencode($success_msg));
    } catch (Exception $e) {
        $error_msg = "Error: " . $e->getMessage();
        redirect('/dealer-motor-dili/admin/dealers.php?error=' . urlencode($error_msg));
    }
}
