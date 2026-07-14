<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/languages.php';

// Handle Language Switch
if (isset($_GET['lang'])) {
    $allowed_langs = ['tl', 'pt', 'en', 'id'];
    if (in_array($_GET['lang'], $allowed_langs)) {
        $_SESSION['lang'] = $_GET['lang'];
    }
}

$lang = $_SESSION['lang'] ?? 'tl';
$translations = get_translations();
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Informasaun Dealer Motor Dili — Timor-Leste</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
</head>
<body>


    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid px-lg-5">
            <a class="navbar-brand py-2" href="index.php">
                <div class="d-flex align-items-center">
                    <div class="brand-icon">
                        <i class="fas fa-motorcycle fa-lg text-white"></i>
                    </div>
                    <div class="ms-3">
                        <div class="brand-text-top fw-bold text-dark lh-1">Dealer<span class="text-primary-mid"> Motor</span></div>
                        <small class="text-muted brand-text-bottom">Dili, Timor-Leste</small>
                    </div>
                </div>
            </a>
            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                <i class="fas fa-bars-staggered fa-lg text-dark"></i>
            </button>

            <!-- Offcanvas Sidebar -->
            <div class="offcanvas offcanvas-end bg-white" tabindex="-1" id="offcanvasNavbar">
                <div class="offcanvas-header border-bottom d-lg-none">
                    <div class="d-flex align-items-center">
                        <div class="brand-icon">
                            <i class="fas fa-motorcycle text-white"></i>
                        </div>
                        <h5 class="offcanvas-title ms-3 fw-bold" id="offcanvasNavbarLabel">Dealer Motor</h5>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasNavbar" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav ms-auto gap-2">
                        <li class="nav-item">
                            <a class="nav-link px-lg-3 py-lg-2 rounded-pill <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active bg-primary-pale text-primary-mid fw-bold' : '' ?>" href="index.php">
                                <i class="fas fa-home me-2"></i><?= __('home') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-lg-3 py-lg-2 rounded-pill <?= basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active bg-primary-pale text-primary-mid fw-bold' : '' ?>" href="about.php">
                                <i class="fas fa-info-circle me-2"></i><?= __('about') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-lg-3 py-lg-2 rounded-pill <?= basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active bg-primary-pale text-primary-mid fw-bold' : '' ?>" href="contact.php">
                                <i class="fas fa-envelope me-2"></i><?= __('contact') ?>
                            </a>
                        </li>
                        
                        <!-- Language Menu -->
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link px-lg-4 py-lg-2 rounded-pill bg-light border d-flex align-items-center gap-2 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-globe text-primary-mid"></i>
                                <span class="fw-semibold"><?= __('language') ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 overflow-hidden animate slideIn mt-2">
                                <li>
                                    <a class="dropdown-item py-2 px-4 d-flex align-items-center gap-3 <?= $lang == 'tl' ? 'active' : '' ?>" href="?lang=tl">
                                        <img src="https://flagcdn.com/w20/tl.png" width="20" alt="Tetun"> Tetun
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 px-4 d-flex align-items-center gap-3 <?= $lang == 'pt' ? 'active' : '' ?>" href="?lang=pt">
                                        <img src="https://flagcdn.com/w20/pt.png" width="20" alt="Português"> Português
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 px-4 d-flex align-items-center gap-3 <?= $lang == 'en' ? 'active' : '' ?>" href="?lang=en">
                                        <img src="https://flagcdn.com/w20/us.png" width="20" alt="English"> English
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 px-4 d-flex align-items-center gap-3 <?= $lang == 'id' ? 'active' : '' ?>" href="?lang=id">
                                        <img src="https://flagcdn.com/w20/id.png" width="20" alt="Indonesia"> Indonesia
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <div class="mt-auto p-4 border-top d-lg-none">
                        <small class="text-muted d-block mb-2"><?= __('call_us') ?>:</small>
                        <div class="d-flex flex-column gap-2">
                            <a href="tel:+67077000000" class="text-decoration-none text-dark small"><i class="fas fa-phone-alt text-primary-mid me-2"></i>+670 7700 0000</a>
                            <a href="mailto:info@dealermotor.tl" class="text-decoration-none text-dark small"><i class="fas fa-envelope text-primary-mid me-2"></i>info@dealermotor.tl</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main>
