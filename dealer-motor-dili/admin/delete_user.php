<?php
require_once '../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');

$id = $_GET['id'] ?? null;
if (!$id) redirect('/dealer-motor-dili/admin/users.php');

// Verify user exists and check if it's not the currently logged in admin
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    redirect('/dealer-motor-dili/admin/users.php?error=Utilizador la eziste!');
}

if ($user['username'] === $_SESSION['admin_username']) {
    redirect('/dealer-motor-dili/admin/users.php?error=Ita labele hamoos Ita-nia konta rasik ne\'ebé sei ativu hela!');
}

// Proceed with deletion
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
if ($stmt->execute([$id])) {
    redirect('/dealer-motor-dili/admin/users.php?success=Utilizador hamoos ona ho susesu!');
} else {
    redirect('/dealer-motor-dili/admin/users.php?error=Falha atu hamoos utilizador!');
}
?>
