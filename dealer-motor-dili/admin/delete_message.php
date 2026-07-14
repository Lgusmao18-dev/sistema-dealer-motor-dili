<?php
require_once '../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');

$id = $_GET['id'] ?? null;
if (!$id) redirect('/dealer-motor-dili/admin/messages.php');

// Verify message exists
$stmt = $pdo->prepare("SELECT * FROM messages WHERE id = ?");
$stmt->execute([$id]);
$msg = $stmt->fetch();

if (!$msg) {
    redirect('/dealer-motor-dili/admin/messages.php?error=Mensajen la eziste!');
}

// Proceed with deletion
$stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
if ($stmt->execute([$id])) {
    redirect('/dealer-motor-dili/admin/messages.php?success=Mensajen hamoos ona ho susesu!');
} else {
    redirect('/dealer-motor-dili/admin/messages.php?error=Falha atu hamoos mensajen!');
}
?>
