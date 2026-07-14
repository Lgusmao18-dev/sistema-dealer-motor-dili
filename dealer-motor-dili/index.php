<?php
require_once 'config/database.php';
include 'includes/header.php';
?>

<!-- LEAFLET CSS -->
<link rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<!-- LEAFLET SEARCH -->
<link rel="stylesheet"
href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<style>

:root{
    --primary:#181b40;
    --secondary:#25285d;
    --dark:#041E1A;
    --light:#f4f5f8;
}

body{
    background:#f4f7fb;
    overflow-x:hidden;
    font-family:'Poppins',sans-serif;
}

/* ───────────────── HERO ───────────────── */

.hero-section{
    position:relative;
    min-height: 600px;
    display:flex;
    align-items: center;
    overflow:hidden;
    background: radial-gradient(circle at 50% 40%, #4c4d87 0%, #2f305e 100%);
    padding-top: 30px;
    padding-bottom: 60px;
}

.hero-container {
    position: relative;
    z-index: 2;
    max-width: 1300px;
}

/* Badge */
.hero-badge{
    display:inline-flex;
    align-items:center;
    gap:12px;
    padding:10px 25px;
    border-radius:50px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    color: #ffffff; /* Premium white */
    font-weight:700;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 15px;
}

@keyframes floatBadge {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.hero-badge {
    animation: fadeInUp 0.8s ease-out both, floatBadge 3s ease-in-out infinite 0.8s;
}

.hero-title {
    animation: fadeInUp 0.8s ease-out both;
    animation-delay: 0.2s;
    font-size: 3.2rem;
    font-weight: 800;
    line-height: 1.25;
    color: white;
    letter-spacing: -1px;
    margin-bottom: 15px;
}

.hero-title .highlight {
    color: white !important;
    white-space: nowrap;
}

.hero-subtitle {
    animation: fadeInUp 0.8s ease-out both;
    animation-delay: 0.4s;
    color:white;
    font-size:1.05rem;
    margin-bottom: 25px;
    max-width: 95%;
    font-weight: 500;
}

.hero-search {
    animation: fadeInUp 0.8s ease-out both;
    animation-delay: 0.6s;
    max-width: 500px;
    position:relative;
    margin-bottom: 25px;
}

.hero-search input{
    width:100%;
    height:60px;
    border:none;
    border-radius:50px;
    padding:0 70px 0 25px;
    font-size:1rem;
    outline:none;
    background:rgba(255,255,255,0.9);
    box-shadow:0 10px 30px rgba(0,0,0,0.15);
    transition: 0.3s;
}

.hero-search input:focus {
    background: #fff;
    box-shadow: 0 15px 40px rgba(77, 184, 255, 0.2);
}

.hero-search button{
    position:absolute;
    right:6px;
    top:50%;
    transform:translateY(-50%);
    width:48px;
    height:48px;
    border:none;
    border-radius:50%;
    background: #47b2e4;
    color:white;
    font-size:18px;
    cursor: pointer;
    transition: 0.3s;
}

.hero-search button:hover {
    background: #209dd8;
    transform: translateY(-50%) scale(1.05);
}

.hero-buttons {
    animation: fadeInUp 0.8s ease-out both;
    animation-delay: 0.6s;
    display:flex;
    align-items:center;
    gap:20px;
    flex-wrap:wrap;
}

.hero-btn{
    background: #47b2e4;
    border:none;
    padding:12px 35px;
    border-radius:50px;
    color:white !important;
    font-weight:600;
    font-size: 1rem;
    text-decoration:none;
    transition:.3s;
    display:inline-flex;
    align-items:center;
}

.hero-btn:hover{
    background: #209dd8;
    transform:translateY(-3px);
    box-shadow:0 8px 20px rgba(71, 178, 228, 0.4);
}

.hero-btn-outline{
    background:transparent;
    border:none;
    padding:10px 15px;
    color:white !important;
    font-weight:600;
    font-size: 1rem;
    text-decoration:none;
    transition:.3s;
    display:inline-flex;
    align-items:center;
}

.hero-btn-outline:hover{
    color: #47b2e4 !important;
    transform:translateY(-2px);
}

.hero-btn i,
.hero-btn-outline i {
    font-size: 20px;
    margin-right: 8px;
}

.hero-img-col {
    position: relative;
}

.hero-img-col::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 700px;
    height: 700px;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 65%);
    border-radius: 50%;
    z-index: 0;
    pointer-events: none;
}

.hero-illustration {
    animation: floatIcon 6s ease-in-out infinite;
    max-width: 100%;
    height: auto;
    filter: drop-shadow(0 20px 40px rgba(255,255,255,0.35));
    position: relative;
    margin-top: 50px;
    z-index: 1;
}

@keyframes floatIcon {
    0%, 100% { transform: translateY(0) scale(1.15); }
    50% { transform: translateY(-20px) scale(1.15); }
}

.parallax-icon-anim {
    animation: floatIcon 6s ease-in-out infinite;
}

/* ───────────────── SECTION ───────────────── */

.section-title{
    font-size:2.5rem;
    font-weight:800;
    color:var(--dark);
}

.section-subtitle{
    color:var(--primary);
    font-weight:700;
    letter-spacing:1px;
}

/* ───────────────── MAP ───────────────── */

.map-wrapper{
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 20px 50px rgba(0,0,0,.12);
}

#map{
    height:700px;
    width:100%;
}

/* ───────────────── MARKER ───────────────── */

.custom-marker{
    background:none;
    border:none;
}

.map-marker{
    width:55px;
    height:55px;
    border-radius:50%;
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:22px;
    border:4px solid white;
    box-shadow:0 10px 25px rgba(0,0,0,.3);
    animation:pulse 2s infinite;
}

@keyframes pulse{
    0%{transform:scale(1);}
    50%{transform:scale(1.08);}
    100%{transform:scale(1);}
}

/* ───────────────── FEATURE ───────────────── */

.feature-box{
    background:white;
    padding:40px 30px;
    border-radius:25px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
    transition:.3s;
    height:100%;
}

.feature-box:hover{
    transform:translateY(-8px);
}

.feature-icon{
    width:70px;
    height:70px;
    border-radius:50%;
    margin:auto;
    margin-bottom:20px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    color:white;
    background:linear-gradient(135deg,var(--primary),var(--secondary));
}

/* ───────────────── DEALER CARD ───────────────── */

.dealer-card{
    background:white;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
    transition:.3s;
    height:100%;
}

.dealer-card:hover{
    transform:translateY(-8px);
    box-shadow:0 20px 40px rgba(0,0,0,.12);
}

.dealer-info{
    padding:20px;
}

.dealer-img{
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-bottom: 3px solid var(--primary);
    transition: transform 0.5s ease;
}

.dealer-card:hover .dealer-img {
    transform: scale(1.1);
}

.dealer-img-wrapper {
    overflow: hidden;
    position: relative;
}

.marka-badge{
    display:inline-block;
    padding:7px 15px;
    border-radius:50px;
    background:var(--light);
    color:var(--primary);
    font-size:12px;
    font-weight:700;
    margin-bottom:15px;
}

.dealer-title{
    font-size:1.15rem;
    font-weight:800;
    color:var(--dark);
    margin-bottom: 10px;
}

.dealer-text{
    color:#64748b;
    margin-bottom:8px;
    font-size: 0.85rem;
}

/* Button */
.btn-modern{
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    border:none;
    color:white;
    border-radius:50px;
    padding:10px 20px;
    font-weight:600;
    font-size: 0.85rem;
    transition:.3s;
}

.btn-modern:hover{
    transform:translateY(-2px);
    color:white;
    box-shadow:0 8px 20px rgba(0,200,150,.35);
}

/* ───────────────── CTA ───────────────── */

.cta-section{
    background:linear-gradient(135deg,var(--primary),var(--secondary));
    border-radius:35px;
    padding:40px 30px;
    margin:10px 0;
}

/* ───────────────── POPUP ───────────────── */

@keyframes popupScaleIn {
    0% { opacity: 0; transform: scale(0.8) translateY(20px); }
    100% { opacity: 1; transform: scale(1) translateY(0); }
}

@keyframes contentSlideIn {
    0% { opacity: 0; transform: translateX(-15px); }
    100% { opacity: 1; transform: translateX(0); }
}

.leaflet-popup-content-wrapper {
    border-radius: 20px;
    padding: 0;
    overflow: hidden;
    box-shadow: 0 15px 45px rgba(0,0,0,0.2) !important;
    animation: popupScaleIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.leaflet-popup-tip-container {
    opacity: 0;
    animation: fadeIn 0.5s forwards;
    animation-delay: 0.3s;
}

.leaflet-popup-content {
    margin: 0;
    width: 280px !important;
}

.popup-img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-bottom: 3px solid var(--primary);
}

.popup-body {
    padding: 20px;
}

.popup-title {
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 8px;
    animation: contentSlideIn 0.5s ease-out both;
    animation-delay: 0.1s;
}

.popup-address, .popup-hours, .popup-phone {
    font-size: 0.85rem;
    color: #475569;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 10px;
    animation: contentSlideIn 0.5s ease-out both;
}

.popup-address { animation-delay: 0.2s; }
.popup-hours { animation-delay: 0.3s; }
.popup-phone { animation-delay: 0.4s; }

.popup-address i, .popup-hours i, .popup-phone i {
    color: var(--primary);
    font-size: 14px;
}

.marka-badge-popup {
    position: absolute;
    top: 15px;
    left: 15px;
    background: white;
    padding: 4px 10px;
    border-radius: 50px;
    font-size: 10px;
    font-weight: 700;
    color: var(--primary);
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.section-padding {
    padding: 40px 0 !important;
    position: relative;
}

.bg-light {
    background: radial-gradient(at 50% 100%, rgba(0, 200, 150, 0.05) 0%, #f8fafc 70%) !important;
}

.bg-white {
    background: radial-gradient(at 50% 100%, rgba(0, 140, 255, 0.03) 0%, #ffffff 70%) !important;
}

/* ───────────────── RESPONSIVE ───────────────── */

@media(max-width:768px){

    .hero-section {
        padding-top: 25px;
        padding-bottom: 50px;
        min-height: auto;
    }

    .hero-text-col {
        text-align: center !important;
    }

    .hero-badge {
        font-size: 10px;
        padding: 8px 18px;
        letter-spacing: 1px;
        margin-bottom: 10px;
        white-space: normal;
        display: inline-flex;
    }

    .hero-title {
        font-size: 2rem !important;
        line-height: 1.25;
        margin-bottom: 12px;
    }

    .hero-subtitle {
        font-size: 0.95rem;
        margin-bottom: 20px;
        max-width: 100%;
    }

    .hero-search {
        margin-bottom: 20px;
        max-width: 100%;
    }

    .hero-search input {
        height: 52px;
        font-size: 0.9rem;
        padding: 0 60px 0 20px;
    }

    .hero-search button {
        width: 42px;
        height: 42px;
        font-size: 16px;
        right: 5px;
    }

    .hero-buttons {
        gap: 12px;
        flex-direction: column;
    }

    .hero-btn,
    .hero-btn-outline {
        width: 100%;
        justify-content: center;
        padding: 12px 25px;
        font-size: 0.95rem;
    }

    .hero-illustration {
        margin-top: 30px;
        max-width: 85%;
    }

    .section-title {
        font-size: 1.8rem;
    }

    .section-subtitle {
        font-size: 0.85rem;
    }

    #map {
        height: 380px;
    }

    .feature-box {
        padding: 30px 20px;
    }

    .process-step {
        padding: 30px 20px;
    }

}

@media(max-width:480px){
    .hero-title {
        font-size: 1.7rem !important;
    }
    .hero-badge {
        font-size: 9px;
        padding: 6px 14px;
    }
}

</style>

<!-- ───────────────── HERO ───────────────── -->

<!-- ───────────────── HERO ───────────────── -->

<section class="hero-section">

<div class="container hero-container">
    <div class="row align-items-center">
        <!-- Left Text Column -->
        <div class="col-lg-5 hero-text-col text-start mb-5 mb-lg-0">
            <!-- BADGE -->
            <div class="hero-badge">
                <i class="fas fa-map-marked-alt"></i>
                <?= __('gis_platform') ?>
            </div>

            <!-- TITLE -->
            <h1 class="hero-title">
                <?= __('welcome_gis') ?>
            </h1>

            <!-- SUBTITLE -->
            <p class="hero-subtitle">
                <?= __('hero_desc') ?>
            </p>

            <!-- SEARCH -->
            <div class="hero-search">
                <input type="text" id="heroSearchInput" 
                       placeholder="<?= __('search_placeholder') ?>">
                <button id="heroSearchBtn">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <!-- BUTTONS -->
            <div class="hero-buttons">
                <a href="#map-section" class="hero-btn">
                    <i class="fas fa-map-marked-alt"></i>
                    <?= __('view_map') ?>
                </a>
                <a href="#dealer-list" class="hero-btn-outline">
                    <i class="fas fa-list-ul"></i>
                    <?= __('dealer_list') ?>
                </a>
            </div>
        </div>

        <!-- Right Image Column -->
        <div class="col-lg-7 hero-img-col text-center">
            <img src="assets/images/Deller_motor.png?v=<?= time() ?>" alt="GIS System" class="img-fluid hero-illustration">
        </div>
    </div>
</div>

</section>

<!-- ───────────────── MAP ───────────────── -->

<section id="map-section" class="section-padding position-relative overflow-hidden">
    <i class="fas fa-circle parallax-icon parallax-icon-anim" style="top: -100px; right: -100px; font-size: 300px; filter: blur(120px); color: rgba(0, 200, 150, 0.05); position: absolute; pointer-events: none; z-index: 0;"></i>
    <i class="fas fa-square parallax-icon parallax-icon-anim" style="bottom: -50px; left: -50px; font-size: 200px; filter: blur(100px); color: rgba(0, 140, 255, 0.04); position: absolute; pointer-events: none; z-index: 0; animation-delay: -3s;"></i>

<div class="container-fluid px-lg-5 position-relative" style="z-index: 1;">

    <div class="text-center mb-4">
        <div class="section-subtitle">GIS MAPS</div>
        <h2 class="section-title">
            <?= __('interactive_map') ?>
        </h2>
    </div>

    <div class="map-wrapper">
        <div id="map"></div>
    </div>

</div>

</section>

<!-- ───────────────── FEATURES ───────────────── -->

<section class="section-padding bg-white position-relative overflow-hidden">
    <i class="fas fa-circle parallax-icon parallax-icon-anim" style="bottom: -150px; right: -50px; font-size: 400px; filter: blur(150px); color: rgba(245, 158, 11, 0.04); position: absolute; pointer-events: none; z-index: 0; animation-delay: -1s;"></i>
    <i class="fas fa-motorcycle fa-10x" style="position: absolute; top: 10%; left: -50px; opacity: 0.02; transform: rotate(15deg); pointer-events: none;"></i>

<div class="container-fluid px-lg-5 position-relative" style="z-index: 1;">

    <div class="text-center mb-4">
        <div class="section-subtitle">OINSA AMI AJUDA ITA</div>
        <h2 class="section-title"><?= __('platform_advantages') ?></h2>
    </div>

<div class="row">

    <div class="col-lg-4 col-md-6 mb-3">
        <div class="feature-box">
            <div class="feature-icon">
                <i class="fas fa-map"></i>
            </div>
            <h4><?= __('feat_1_title') ?></h4>
            <p>
                <?= __('feat_1_desc') ?>
            </p>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <div class="feature-box">
            <div class="feature-icon">
                <i class="fas fa-location-crosshairs"></i>
            </div>
            <h4><?= __('feat_2_title') ?></h4>
            <p>
                <?= __('feat_2_desc') ?>
            </p>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <div class="feature-box">
            <div class="feature-icon">
                <i class="fas fa-mobile-screen-button"></i>
            </div>
            <h4><?= __('feat_3_title') ?></h4>
            <p>
                <?= __('feat_3_desc') ?>
            </p>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <div class="feature-box">
            <div class="feature-icon">
                <i class="fas fa-motorcycle"></i>
            </div>
            <h4><?= __('feat_4_title') ?></h4>
            <p>
                <?= __('feat_4_desc') ?>
            </p>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <div class="feature-box">
            <div class="feature-icon">
                <i class="fas fa-magnifying-glass-location"></i>
            </div>
            <h4><?= __('feat_5_title') ?></h4>
            <p>
                <?= __('feat_5_desc') ?>
            </p>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <div class="feature-box">
            <div class="feature-icon">
                <i class="fas fa-route"></i>
            </div>
            <h4><?= __('feat_6_title') ?></h4>
            <p>
                <?= __('feat_6_desc') ?>
            </p>
        </div>
    </div>

</div>

</div>

</section>

<!-- ───────────────── PROCESS SECTION ───────────────── -->

<section class="section-padding bg-light position-relative overflow-hidden">
    <i class="fas fa-circle parallax-icon parallax-icon-anim" style="top: -100px; left: -100px; font-size: 350px; filter: blur(130px); color: rgba(0, 200, 150, 0.04); position: absolute; pointer-events: none; z-index: 0; animation-delay: -4s;"></i>

<div class="container-fluid px-lg-5 position-relative" style="z-index: 1;">

    <div class="text-center mb-4">
        <div class="section-subtitle">PASSU BA PASSU</div>
        <h2 class="section-title"><?= __('how_to_find') ?></h2>
    </div>

    <div class="row text-center">

        <div class="col-md-3 mb-3">
            <div class="process-step">
                <div class="step-number">01</div>
                <h5><?= __('step_1_title') ?></h5>
                <p class="small text-muted"><?= __('step_1_desc') ?></p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="process-step">
                <div class="step-number">02</div>
                <h5><?= __('step_2_title') ?></h5>
                <p class="small text-muted"><?= __('step_2_desc') ?></p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="process-step">
                <div class="step-number">03</div>
                <h5><?= __('step_3_title') ?></h5>
                <p class="small text-muted"><?= __('step_3_desc') ?></p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="process-step">
                <div class="step-number">04</div>
                <h5><?= __('step_4_title') ?></h5>
                <p class="small text-muted"><?= __('step_4_desc') ?></p>
            </div>
        </div>

    </div>

</div>

</section>

<style>
.process-step {
    padding:50px 35px;
    position: relative;
    background: white;
    border-radius: 25px;
    height: 100%;
    transition: all 0.4s ease;
    border: 1px solid rgba(0,0,0,0.03);
    box-shadow: 0 10px 30px rgba(0,0,0,0.02);
}

.process-step:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 200, 150, 0.1);
    border-color: rgba(0, 200, 150, 0.2);
}

.step-number {
    font-size: 4rem;
    font-weight: 900;
    color: rgba(0, 200, 150, 0.08);
    position: absolute;
    top: -5px;
    right: 20px;
    z-index: 0;
    line-height: 1;
}

.process-step h5 {
    position: relative;
    z-index: 1;
    font-weight: 800;
    margin-top: 10px;
    color: #0f172a;
}

.process-step p {
    position: relative;
    z-index: 1;
    color: #64748b;
    font-size: 0.9rem;
}
</style>

<!-- ───────────────── DEALER LIST ───────────────── -->

<section class="section-padding position-relative overflow-hidden" id="dealer-list">
    <i class="fas fa-square parallax-icon parallax-icon-anim" style="bottom: -100px; left: 10%; font-size: 250px; filter: blur(110px); color: rgba(0, 140, 255, 0.03); position: absolute; pointer-events: none; z-index: 0; animation-delay: -2s;"></i>

<div class="container-fluid px-lg-5 position-relative" style="z-index: 1;">

<div class="text-center mb-4">
    <div class="section-subtitle">DEALER LIST</div>
    <h2 class="section-title">
        Lista Dealer Motor
    </h2>
</div>

<div class="row">

<?php
$stmt = $pdo->query("SELECT * FROM dealer_motor ORDER BY nama_dealer");

while($dealer = $stmt->fetch()):
?>

<div class="col-lg-4 col-md-6 mb-4">

<div class="dealer-card">

<?php
$img_src = '';
if (!empty($dealer['foto']) && file_exists('assets/images/dealers/' . $dealer['foto'])) {
    $img_src = 'assets/images/dealers/' . $dealer['foto'];
} else {
    $brand = strtolower(trim($dealer['marka']));
    $img_src = 'assets/images/genio.jfif'; // fallback / general
    if($brand == 'honda') $img_src = 'assets/images/beat.jfif';
    if($brand == 'yamaha') $img_src = 'assets/images/mio.jfif';
    if($brand == 'kawasaki') $img_src = 'assets/images/kawa.jfif';
}
?>
<div class="dealer-img-wrapper">
    <img src="<?= $img_src ?>" class="dealer-img" alt="<?= htmlspecialchars($dealer['nama_dealer']) ?>">
    <div class="position-absolute top-0 end-0 m-3">
        <span class="badge bg-primary px-3 py-2 shadow-sm rounded-pill fw-bold" style="font-size: 0.9rem;">
            $ <?= number_format($dealer['presu'], 0) ?>
        </span>
    </div>
</div>

<div class="dealer-info">

    <div class="marka-badge">
        <i class="fas fa-motorcycle me-1"></i>
        <?= htmlspecialchars($dealer['marka']) ?>
    </div>

    <h4 class="dealer-title">
        <?= htmlspecialchars($dealer['nama_dealer']) ?>
    </h4>

    <p class="dealer-text">
        <i class="fas fa-location-dot me-2"></i>
        <?= htmlspecialchars($dealer['alamat']) ?>
    </p>

    <p class="dealer-text">
        <i class="fas fa-clock me-2"></i>
        <?= htmlspecialchars($dealer['jam_buka']) ?>
    </p>

    <?php if($dealer['telepon']): ?>
    <p class="dealer-text">
        <i class="fas fa-phone me-2"></i>
        <?= htmlspecialchars($dealer['telepon']) ?>
    </p>
    <?php endif; ?>

    <button class="btn-modern mt-3 view-on-map"
        data-lat="<?= $dealer['latitude'] ?>"
        data-lng="<?= $dealer['longitude'] ?>">

        <i class="fas fa-map-pin me-2"></i>
        <?= __('view_on_map') ?>

    </button>

</div>

</div>

</div>

<?php endwhile; ?>

</div>

</div>

</section>

<!-- ───────────────── CTA ───────────────── -->

<section class="container-fluid px-lg-5 mb-5">

<div class="cta-section text-center text-white py-5 px-4 rounded-5" style="background: linear-gradient(135deg, #0f172a 0%, #00C896 150%); position: relative; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
    <i class="fas fa-motorcycle fa-10x" style="position: absolute; top: -50px; right: -50px; opacity: 0.05; transform: rotate(-20deg);"></i>
    <i class="fas fa-map-marked-alt fa-10x" style="position: absolute; bottom: -50px; left: -50px; opacity: 0.05; transform: rotate(20deg);"></i>
    
    <div style="position: relative; z-index: 1;">
        <h2 class="fw-extrabold mb-3" style="font-size: 2.5rem; letter-spacing: -1px;">
            <?= __('cta_title') ?>
        </h2>

        <p class="mb-4 opacity-75 mx-auto" style="max-width: 600px;">
            <?= __('cta_desc') ?>
        </p>

        <a href="contact.php"
           class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg"
           style="transition: 0.3s;">

            <i class="fas fa-headset me-2 text-primary"></i>
            <?= __('cta_btn') ?>

        </a>
    </div>
</div>

</section>

<!-- LEAFLET JS -->

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>

// MAP INIT
var map = L.map('map').setView([-8.5569,125.5603],13);

// LIGHT MAP
var lightMap = L.tileLayer(
'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
{
    attribution:'&copy; OpenStreetMap & CARTO',
    subdomains:'abcd',
    maxZoom:20
}).addTo(map);

// DARK MAP
var darkMap = L.tileLayer(
'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',
{
    attribution:'&copy; OpenStreetMap & CARTO',
    subdomains:'abcd',
    maxZoom:20
});

// SATELLITE
var satellite = L.tileLayer(
'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
{
    attribution:'Tiles &copy; Esri'
});

// CONTROL
L.control.layers({
    "Light Mode":lightMap,
    "Dark Mode":darkMap,
    "Satellite":satellite
}).addTo(map);

// SEARCH
L.Control.geocoder().addTo(map);

// USER GPS
map.locate({setView:false,maxZoom:15});

map.on('locationfound', function(e){

    L.circleMarker(e.latlng,{
        radius:10,
        fillColor:"#00C896",
        color:"#fff",
        weight:3,
        opacity:1,
        fillOpacity:1
    })
    .addTo(map)
    .bindPopup("Ita nia lokasaun agora");

});

// ICON
var motoIcon = L.divIcon({
    className:'custom-marker',
    html:`<div class="map-marker">
            <i class="fas fa-motorcycle"></i>
          </div>`,
    iconSize:[55,55],
    popupAnchor:[0,-20]
});

// STORE MARKERS & DATA FOR SEARCH
var allMarkers = [];
var dealerData = [];

// FETCH DEALERS
fetch('api/get_dealers.php?v=' + new Date().getTime())

.then(r => r.json())

.then(data => {

    dealerData = data;
    var bounds = [];

    data.forEach(d => {

        // Get image based on DB or brand
        let brand = (d.marka || '').toLowerCase().trim();
        let imgSrc = 'assets/images/deller.png';

        if(d.foto) {
            imgSrc = 'assets/images/dealers/' + d.foto;
        } else {
            if(brand === 'honda') imgSrc = 'assets/images/honda_motorcycle_1778566690777.png';
            else if(brand === 'yamaha') imgSrc = 'assets/images/yamaha_motorcycle_1778566896989.png';
            else if(brand === 'suzuki') imgSrc = 'assets/images/suzuki_motorcycle_1778566930123.png';
            else if(brand === 'kawasaki') imgSrc = 'assets/images/kawasaki_motorcycle_1778567013613.png';
            else if(brand === 'tvs') imgSrc = 'assets/images/tvs_motorcycle_1778567095794.png';
        }

        var marker = L.marker(
            [d.latitude, d.longitude],
            {icon:motoIcon}
        ).addTo(map);

        // Store marker with dealer ID for easy lookup
        marker.dealerId = d.id;
        allMarkers.push(marker);

        bounds.push([d.latitude,d.longitude]);

        marker.bindPopup(`
            <div class="popup-container">
                <img src="${imgSrc}" class="popup-img" alt="${d.nama_dealer}">
                
                <div class="marka-badge-popup">
                    <i class="fas fa-motorcycle me-1"></i>
                    ${d.marka.toUpperCase()}
                </div>

                <div class="popup-body">
                    <div class="popup-title">
                        ${d.nama_dealer}
                    </div>

                    <p class="popup-address">
                        <i class="fas fa-location-dot"></i>
                        ${d.alamat}
                    </p>

                    <p class="popup-hours">
                        <i class="fas fa-clock"></i>
                        ${d.jam_buka}
                    </p>

                    ${d.telepon ? `
                    <p class="popup-phone">
                        <i class="fas fa-phone"></i>
                        ${d.telepon}
                    </p>` : ''}
                    
                    <p class="popup-hours mt-2 mb-1">
                        <span class="badge bg-light text-primary border px-3 py-2 w-100 fs-6 fw-bold shadow-sm">
                            $ ${new Intl.NumberFormat().format(d.presu)}
                        </span>
                    </p>

                    <a href="https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(d.nama_dealer + ' Dili')}"
                       target="_blank"
                       class="btn-modern d-block text-center mt-3 text-decoration-none py-2"
                       style="font-size: 0.85rem;">
                       <i class="fas fa-route me-1"></i>
                       Direksaun
                    </a>
                </div>
            </div>
        `);

    });

    if(bounds.length > 0){
        map.fitBounds(bounds,{padding:[50,50]});
    }

});

// SEARCH FUNCTIONALITY
function performSearch() {
    const query = document.getElementById('heroSearchInput').value.toLowerCase().trim();
    if (!query) {
        // If empty query, reset all
        allMarkers.forEach(m => m.setOpacity(1));
        document.querySelectorAll('.col-lg-4').forEach(c => c.classList.remove('d-none'));
        map.setView([-8.556856, 125.560594], 13);
        return;
    }

    let found = false;
    let matchBounds = [];

    dealerData.forEach(d => {
        const name = d.nama_dealer.toLowerCase();
        const brand = d.marka.toLowerCase();
        const address = d.alamat.toLowerCase();

        // Check if query matches name, brand or address
        const isMatch = name.includes(query) || brand.includes(query) || address.includes(query);
        
        // Find corresponding card in the list
        const cards = document.querySelectorAll('.dealer-card');
        cards.forEach(card => {
            const cardTitle = card.querySelector('.dealer-title').innerText.toLowerCase();
            if (cardTitle === name) {
                if (isMatch) {
                    card.closest('.col-lg-4').classList.remove('d-none');
                } else {
                    card.closest('.col-lg-4').classList.add('d-none');
                }
            }
        });

        if (isMatch) {
            found = true;
            matchBounds.push([d.latitude, d.longitude]);
            
            // Find and highlight marker
            const marker = allMarkers.find(m => m.dealerId === d.id);
            if (marker) {
                marker.setOpacity(1);
                if (matchBounds.length === 1) {
                    map.setView([d.latitude, d.longitude], 16);
                    marker.openPopup();
                }
            }
        } else {
            const marker = allMarkers.find(m => m.dealerId === d.id);
            if (marker) marker.setOpacity(0.3); // Dim non-matches
        }
    });

    if (found) {
        if (matchBounds.length > 1) {
            map.fitBounds(matchBounds, { padding: [100, 100] });
        }
        
        // Scroll to map or list
        document.querySelector('#map-section').scrollIntoView({ behavior: 'smooth' });
    } else {
        alert('Lokalidade ka Dealer ne\'ebé ita buka la hetan.');
        // Reset view
        allMarkers.forEach(m => m.setOpacity(1));
        document.querySelectorAll('.col-lg-4').forEach(c => c.classList.remove('d-none'));
    }
}

// Event Listeners for Search
document.getElementById('heroSearchBtn').addEventListener('click', performSearch);
document.getElementById('heroSearchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') performSearch();
});

// VIEW MAP BUTTON
document.querySelectorAll('.view-on-map').forEach(btn => {

    btn.addEventListener('click', function(){

        map.setView(
            [this.dataset.lat, this.dataset.lng],
            17
        );

        document.querySelector('#map-section')
        .scrollIntoView({behavior:'smooth'});

    });

});

</script>

<?php include 'includes/footer.php'; ?>