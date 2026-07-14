<?php
require_once 'config/database.php';
include 'includes/header.php';

$message = '';
$alert_class = '';

// Auto-create messages table if it does not exist
try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(200) NOT NULL,
            email VARCHAR(200) NOT NULL,
            subject VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
} catch (PDOException $e) {
    // Fail silently in production, or log the error
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email   = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $msg     = htmlspecialchars(trim($_POST['message'] ?? ''));

    if ($name && $email && $subject && $msg) {
        try {
            $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $subject, $msg]);
            
            $message = __('msg_sent_success');
            $alert_class = 'alert-success';
        } catch (PDOException $e) {
            $message = __('msg_sent_error') . " (Database error)";
            $alert_class = 'alert-danger';
        }
    } else {
        $message = __('msg_sent_error');
        $alert_class = 'alert-danger';
    }
}
?>

<style>
    :root {
        --primary: #181b40;
        --primary-mid: #25285d;
        --primary-lt: #454a9c;
        --primary-pale: #eaebf4;
        --dark: #0f172a;
        --light: #f8fafc;
    }

    body {
        background: #f8fafc;
    }

    .contact-container {
        padding: 60px 0 100px;
    }

    .contact-header {
        text-align: center;
        margin-bottom: 50px;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .contact-title {
        animation: fadeInUp 0.8s ease-out both;
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .contact-title::after {
        content: '';
        display: block;
        width: 60px;
        height: 4px;
        background: var(--primary-mid);
        margin: 15px auto 0;
        border-radius: 2px;
    }

    .contact-subtitle {
        animation: fadeInUp 0.8s ease-out both;
        animation-delay: 0.2s;
        color: #6b7280;
        font-size: 0.95rem;
        max-width: 600px;
        margin: 0 auto 50px;
    }

    .contact-card {
        animation: fadeInUp 0.8s ease-out both;
        animation-delay: 0.4s;
        background: #ffffff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        height: 100%;
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        z-index: 1;
        overflow: hidden;
    }

    .contact-card::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(37, 40, 93, 0.05) 0%, transparent 70%);
        opacity: 0;
        transition: 0.5s;
        z-index: -1;
    }
    
    .contact-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 20px 40px rgba(37, 40, 93, 0.12);
        border-color: rgba(37, 40, 93, 0.3);
    }

    .contact-card:hover::after {
        opacity: 1;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 25px;
        padding: 15px;
        border-radius: 12px;
        transition: background 0.3s ease;
    }

    .info-item:hover {
        background: var(--light);
    }

    .info-icon {
        width: 50px;
        height: 50px;
        background: var(--primary-pale);
        color: var(--primary-mid);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-right: 20px;
        flex-shrink: 0;
        transition: 0.5s;
        box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
    }

    .info-item:hover .info-icon {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        transform: rotateY(180deg);
        box-shadow: 0 10px 20px rgba(37, 40, 93, 0.4);
    }

    .info-details h6 {
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 5px;
        font-size: 1.05rem;
    }

    .info-details p {
        color: #6b7280;
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    .map-container {
        border-radius: 16px;
        overflow: hidden;
        margin-top: 30px;
        height: 250px;
        width: 100%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .map-container:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 25px rgba(37, 40, 93, 0.15);
    }

    .form-control-modern {
        background: #f8fafc;
        border: 2px solid transparent;
        border-radius: 12px;
        padding: 14px 20px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        margin-bottom: 20px;
        color: var(--dark);
        font-family: inherit;
    }

    .form-control-modern::placeholder {
        color: #9ca3af;
    }

    .form-control-modern:focus {
        background: #ffffff;
        border-color: var(--primary-lt);
        box-shadow: 0 0 0 4px rgba(69, 74, 156, 0.15);
        outline: none;
    }
    
    .form-control-modern:hover:not(:focus) {
        background: #f1f5f9;
    }

    .btn-submit {
        background: var(--primary-mid);
        color: white;
        border: none;
        padding: 14px 40px;
        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 0.5px;
        font-size: 1.05rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin: 0 auto;
        box-shadow: 0 5px 15px rgba(37, 40, 93, 0.2);
    }

    .btn-submit:hover {
        background: var(--primary);
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(24, 27, 64, 0.3);
        color: white;
    }

    /* ── RESPONSIVE ── */
    @media(max-width: 768px) {
        .contact-container {
            padding: 30px 0 60px;
        }
        .contact-header {
            margin-bottom: 30px;
        }
        .contact-title {
            font-size: 1.8rem;
        }
        .contact-subtitle {
            font-size: 0.9rem;
            margin-bottom: 30px;
        }
        .contact-card {
            padding: 25px 20px;
            border-radius: 16px;
        }
        .info-item {
            padding: 10px;
            margin-bottom: 15px;
        }
        .info-icon {
            width: 44px;
            height: 44px;
            font-size: 16px;
            margin-right: 15px;
        }
        .info-details h6 {
            font-size: 0.95rem;
        }
        .info-details p {
            font-size: 0.85rem;
        }
        .map-container {
            height: 200px;
            margin-top: 20px;
        }
        .form-control-modern {
            padding: 12px 16px;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        .btn-submit {
            padding: 12px 30px;
            font-size: 0.95rem;
        }
    }
</style>

<div class="contact-container container">
    
    <header class="contact-header">
        <h1 class="contact-title"><?= __('contact_details') ?></h1>
        <p class="contact-subtitle">
            <?= __('contact_header_desc') ?>
        </p>
    </header>

    <div class="row g-4 justify-content-center">
        <!-- LEFT COLUMN: INFO & MAP -->
        <div class="col-lg-5">
            <div class="contact-card">
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-details">
                        <h6><?= __('address') ?></h6>
                        <p>Rua de Dili, Timor-Leste</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="info-details">
                        <h6><?= __('phone') ?></h6>
                        <p>+670 7700 0000</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-details">
                        <h6>Email</h6>
                        <p>info@dealermotor.tl</p>
                    </div>
                </div>

                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125206.51610427387!2d125.498421!3d-8.558362!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2a0459c5d0134449%3A0xc3b4c106b0d1e3d3!2sDili%2C%20Timor-Leste!5e0!3m2!1sen!2s!4v1680000000000!5m2!1sen!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

            </div>
        </div>

        <!-- RIGHT COLUMN: FORM -->
        <div class="col-lg-7">
            <div class="contact-card">
                
                <?php if ($message): ?>
                <div class="alert <?= $alert_class ?> alert-dismissible fade show rounded-2 p-3 mb-4">
                    <?= $message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control-modern w-100" name="name" required placeholder="<?= __('full_name') ?>">
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control-modern w-100" name="email" required placeholder="<?= __('current_email') ?>">
                        </div>
                    </div>

                    <input type="text" class="form-control-modern w-100" name="subject" required placeholder="Assuntu">

                    <textarea class="form-control-modern w-100" name="message" rows="6" required placeholder="<?= __('your_message') ?>"></textarea>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane me-2"></i>
                            <?= __('send_message_now') ?>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
