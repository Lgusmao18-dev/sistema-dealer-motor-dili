<?php
require_once 'config/database.php';
include 'includes/header.php';
?>

<style>
    :root {
        --primary: #181b40;
        --secondary: #25285d;
        --dark: #0f172a;
        --accent: #f59e0b;
        --light: #f8fafc;
        --glass: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(255, 255, 255, 0.3);
    }

    body {
        background: #f8fafc;
        background-image: 
            radial-gradient(at 0% 0%, rgba(37, 40, 93, 0.1) 0, transparent 50%),
            radial-gradient(at 100% 0%, rgba(245, 158, 11, 0.08) 0, transparent 50%),
            radial-gradient(at 50% 100%, rgba(37, 40, 93, 0.05) 0, transparent 50%);
        min-height: 100vh;
        color: #334155;
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

    .animate-up {
        animation: fadeInUp 0.8s ease-out both;
    }

    .about-header {
        text-align: center;
        padding: 80px 0 50px;
        position: relative;
    }

    .about-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 25px;
        background: white;
        color: var(--primary);
        border-radius: 50px;
        font-weight: 800;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 25px;
        box-shadow: 
            0 10px 25px rgba(0, 200, 150, 0.15),
            inset 0 0 0 2px rgba(0, 200, 150, 0.05);
        animation: floatBadge 3s ease-in-out infinite;
        border: 1px solid rgba(0, 200, 150, 0.1);
    }

    @keyframes floatBadge {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .about-badge i {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 1.1rem;
    }

    .about-title {
        font-size: 3.5rem;
        font-weight: 900;
        color: var(--dark);
        margin-bottom: 20px;
        letter-spacing: -1px;
        text-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .about-title span, .highlight {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 900;
    }

    .about-card {
        background: var(--glass);
        backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 30px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 40px;
    }

    .about-section-title {
        font-weight: 800;
        font-size: 1.5rem;
        color: var(--dark);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .about-section-title::before {
        content: '';
        height: 8px;
        width: 8px;
        background: var(--primary);
        border-radius: 50%;
        box-shadow: 0 0 10px var(--primary);
    }

    .feature-card-modern {
        background: white;
        padding: 35px 25px;
        border-radius: 30px;
        height: 100%;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0, 0, 0, 0.03);
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        position: relative;
        z-index: 1;
        overflow: hidden;
    }

    .feature-card-modern::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(0, 200, 150, 0.05) 0%, transparent 70%);
        opacity: 0;
        transition: 0.5s;
        z-index: -1;
    }

    .feature-card-modern:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 200, 150, 0.12);
        border-color: rgba(0, 200, 150, 0.3);
    }

    .feature-card-modern:hover::after {
        opacity: 1;
    }

    .feature-icon-circle {
        width: 70px;
        height: 70px;
        border-radius: 22px;
        background: linear-gradient(135deg, var(--light), #fff);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 25px;
        transition: 0.5s;
        box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
    }

    .feature-card-modern:hover .feature-icon-circle {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        transform: rotateY(180deg);
        box-shadow: 0 10px 20px rgba(0, 200, 150, 0.4);
    }

    .feature-card-modern h6 {
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 12px;
        font-size: 1.1rem;
    }

    .feature-card-modern p {
        font-size: 0.9rem;
        line-height: 1.6;
        color: #64748b;
    }

    .objective-item {
        background: white;
        padding: 18px 25px;
        border-radius: 20px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 18px;
        border: 1px solid rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.01);
    }

    .objective-item:hover {
        transform: translateX(10px);
        box-shadow: 0 10px 20px rgba(0, 200, 150, 0.08);
        background: linear-gradient(to right, white, var(--light));
        border-color: var(--primary);
    }

    .objective-item i {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 22px;
    }

    .objective-text {
        font-weight: 600;
        color: #475569;
    }

    .about-footer-info {
        background: linear-gradient(135deg, var(--dark), #0a2e28);
        padding: 40px;
        border-radius: 25px;
        color: white;
        text-align: center;
    }

    .btn-aesthetic {
        background: white;
        color: var(--dark);
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: 0.3s;
        margin-top: 20px;
    }

    .btn-aesthetic:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        color: var(--primary);
    }

    .parallax-icon {
        position: fixed;
        opacity: 0.03;
        z-index: -1;
    }

    /* ── RESPONSIVE ── */
    @media(max-width: 768px) {
        .about-header {
            padding: 40px 0 30px;
        }
        .about-badge {
            font-size: 0.7rem;
            padding: 8px 18px;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }
        .about-title {
            font-size: 2.2rem;
            margin-bottom: 15px;
        }
        .about-card {
            padding: 25px 15px !important;
            border-radius: 20px;
            margin-bottom: 25px;
        }
        .about-section-title {
            font-size: 1.3rem;
            margin-bottom: 20px;
        }
        .feature-card-modern {
            padding: 25px 20px;
            border-radius: 20px;
        }
        .objective-item {
            padding: 14px 20px;
            gap: 12px;
        }
        .objective-text {
            font-size: 0.9rem;
        }
        .about-footer-info {
            padding: 30px 20px;
            border-radius: 20px;
        }
        .about-footer-info h5 {
            font-size: 1.2rem;
        }
        .about-footer-info p {
            font-size: 0.9rem;
        }
    }

    @media(max-width: 480px) {
        .about-title {
            font-size: 1.8rem;
        }
    }
</style>

<!-- Floating Background Elements -->
<i class="fas fa-motorcycle fa-10x parallax-icon" style="top: 10%; left: -5%; transform: rotate(15deg);"></i>
<i class="fas fa-map-marked-alt fa-10x parallax-icon" style="bottom: 10%; right: -5%; transform: rotate(-15deg);"></i>
<i class="fas fa-circle parallax-icon" style="top: 20%; right: 10%; font-size: 100px; filter: blur(60px); color: rgba(0, 200, 150, 0.15);"></i>
<i class="fas fa-square parallax-icon" style="bottom: 30%; left: 5%; font-size: 80px; filter: blur(50px); color: rgba(245, 158, 11, 0.1);"></i>

<div class="container-fluid px-3 px-md-4 pb-5">
    
    <header class="about-header">
        <div class="about-badge animate-up" style="animation-delay: 0.1s;">
            <i class="fas fa-info-circle"></i>
            <?= __('about_website') ?>
        </div>
        <h1 class="about-title animate-up" style="animation-delay: 0.3s;">
            <?= __('gis_info_system') ?>
        </h1>
        <p class="lead text-muted mx-auto animate-up" style="max-width: 1200px; animation-delay: 0.5s;">
            <?= __('about_desc') ?>
        </p>
    </header>

    <div class="row m-0">
        <div class="col-12">
            
            <!-- MAIN CONTENT CARD -->
            <div class="about-card p-4 p-lg-5 animate-up" style="animation-delay: 0.7s;">
                
                <div class="row mb-5">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <h4 class="about-section-title"><?= __('website_objective') ?></h4>
                        <div class="objective-item">
                            <i class="fas fa-search-location"></i>
                            <span class="objective-text"><?= __('obj_1') ?></span>
                        </div>
                        <div class="objective-item">
                            <i class="fas fa-info-circle"></i>
                            <span class="objective-text"><?= __('obj_2') ?></span>
                        </div>
                        <div class="objective-item">
                            <i class="fas fa-shield-alt"></i>
                            <span class="objective-text"><?= __('obj_3') ?></span>
                        </div>
                        <div class="objective-item">
                            <i class="fas fa-chart-line"></i>
                            <span class="objective-text"><?= __('obj_4') ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="h-100 rounded-4 overflow-hidden shadow-sm" style="min-height: 250px; background: url('assets/images/map.png') center/cover;">
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0, 200, 150, 0.05); backdrop-filter: blur(2px);">
                                <i class="fas fa-map-marker-alt text-white fa-4x drop-shadow"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="about-section-title mt-5"><?= __('main_features') ?></h4>
                <div class="row g-4">
                    <div class="col-md-6 col-xl-3">
                        <div class="feature-card-modern">
                            <div class="feature-icon-circle">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <h6><?= __('feature_1_title') ?></h6>
                            <p class="text-muted small mb-0"><?= __('feature_1_desc') ?></p>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="feature-card-modern">
                            <div class="feature-icon-circle">
                                <i class="fas fa-list-ul"></i>
                            </div>
                            <h6><?= __('feature_2_title') ?></h6>
                            <p class="text-muted small mb-0"><?= __('feature_2_desc') ?></p>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="feature-card-modern">
                            <div class="feature-icon-circle">
                                <i class="fas fa-mobile-screen"></i>
                            </div>
                            <h6><?= __('feature_3_title') ?></h6>
                            <p class="text-muted small mb-0"><?= __('feature_3_desc') ?></p>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="feature-card-modern">
                            <div class="feature-icon-circle">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <h6><?= __('feature_4_title') ?></h6>
                            <p class="text-muted small mb-0"><?= __('feature_4_desc') ?></p>
                        </div>
                    </div>
                </div>

                <div class="about-footer-info mt-5">
                    <h5 class="fw-bold mb-3"><?= __('about_footer_title') ?></h5>
                    <p class="opacity-75"><?= __('about_footer_desc') ?></p>
                    <a href="index.php" class="btn-aesthetic">
                        <i class="fas fa-map-marker-alt"></i>
                        <?= __('view_map_now') ?>
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
