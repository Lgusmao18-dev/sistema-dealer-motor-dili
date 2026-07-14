<?php
require_once __DIR__ . '/../../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');
?>
<!DOCTYPE html>
<html lang="tl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — Dellear Motor Dili</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/dealer-motor-dili/admin/assets/css/admin-style.css?v=<?= time() ?>">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">
                <i class="fas fa-motorcycle"></i>
            </div>
            <h4>ADMIN PANEL</h4>
        </div>
        
        <div class="admin-label">
            <i class="fas fa-shield-alt me-2"></i> Aksesu Autorizadu
        </div>

        <nav class="sidebar-menu">
            <ul>
                <li>
                    <a href="/dealer-motor-dili/admin/dashboard.php" class="<?= basename($_SERVER['PHP_SELF'])=='dashboard.php'?'active':'' ?>">
                        <i class="fas fa-chart-pie"></i><span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/dealer-motor-dili/admin/dealers.php" class="<?= in_array(basename($_SERVER['PHP_SELF']),['dealers.php','add_dealer.php','edit_dealer.php'])?'active':'' ?>">
                        <i class="fas fa-motorcycle"></i><span>Jere Dellear</span>
                    </a>
                </li>
                <li>
                    <a href="/dealer-motor-dili/admin/users.php" class="<?= in_array(basename($_SERVER['PHP_SELF']),['users.php','add_user.php','edit_user.php'])?'active':'' ?>">
                        <i class="fas fa-users"></i><span>Jere Utilizador</span>
                    </a>
                </li>
                <li>
                    <a href="/dealer-motor-dili/admin/messages.php" class="<?= basename($_SERVER['PHP_SELF'])=='messages.php'?'active':'' ?>">
                        <i class="fas fa-envelope"></i><span>Komentariu Cliente</span>
                    </a>
                </li>
                <li>
                    <a href="/dealer-motor-dili/index.php" target="_blank">
                        <i class="fas fa-globe"></i><span>Vizita Site</span>
                    </a>
                </li>
                <li class="mt-5">
                    <a href="/dealer-motor-dili/admin/logout.php" style="background: rgba(255,107,107,0.1); color: #ff6b6b !important;">
                        <i class="fas fa-sign-out-alt"></i><span>Sai husi Sesaun</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <?php if (!in_array(basename($_SERVER['PHP_SELF']), ['dealers.php', 'add_dealer.php', 'edit_dealer.php'])): ?>
        <div class="top-navbar px-4 py-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="navbar-brand-icon">
                    <i class="fas fa-motorcycle text-primary fs-2"></i>
                </div>
                <h4 class="mb-0 fw-bold text-dark" style="font-size: 1.5rem;">Bemvindu Administrator!</h4>
            </div>
            
            <div class="d-flex align-items-center gap-4">
                <div class="text-dark fw-medium" style="font-size: 1.1rem;">
                    <?= date('l, d F Y') ?>
                </div>
                <div class="d-flex align-items-center gap-3 border-start border-2 ps-4">
                    <div class="admin-profile-info text-end d-none d-md-block">
                        <p class="mb-0 fw-bold text-dark lh-1" style="font-size: 1.1rem;"><?= $_SESSION['admin_name'] ?? 'Admin' ?></p>
                        <small class="text-muted fw-bold" style="font-size: 0.85rem;">Administrator</small>
                    </div>
                    <a href="logout.php" class="logout-btn-circle" title="Sair" style="width: 45px; height: 45px; font-size: 1.2rem;">
                        <i class="fas fa-power-off text-danger"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
