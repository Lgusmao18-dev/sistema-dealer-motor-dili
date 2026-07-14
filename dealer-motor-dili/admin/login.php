<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/database.php';

$error = '';
$success = '';

if (isLoggedIn()) {
    redirect('/dealer-motor-dili/admin/dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' && $password === '') {
        // Both fields empty
        $error = 'Favor prenxe username ho password!';
    } elseif ($username === '') {
        // Username empty
        $error = 'Favor prenxe username!';
    } elseif ($password === '') {
        // Password empty
        $error = 'Favor prenxe password!';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
            // Username is correct! Now check password
            if (password_verify($password, $user['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username']  = $user['username'];
                session_regenerate_id(true);
                $success = 'Login ho susesu!';
            } else {
                // Username is correct, but password is wrong
                $error = 'Password sala, favor prenxe repete!';
            }
        } else {
            // Username is incorrect!
            // Check if the entered password matches any user's password in DB
            $allUsersStmt = $pdo->query("SELECT * FROM users");
            $allUsers = $allUsersStmt->fetchAll();
            
            $isPasswordCorrectForAny = false;
            foreach ($allUsers as $u) {
                if (password_verify($password, $u['password'])) {
                    $isPasswordCorrectForAny = true;
                    break;
                }
            }
            
            if ($isPasswordCorrectForAny) {
                // Password matches a user, but username is wrong
                $error = 'Username sala, favor prenxe repete!';
            } else {
                // Username is wrong AND password is also wrong
                $error = 'Username ho password sala, favor prenxe repete!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login Admin — Dealer Motor Dili</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        :root {
            --primary-color: #181b40;
            --primary-dark: #121430;
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.4);
            --text-main: #2d3436;
            --text-muted: #636e72;
        }

        body {
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
            position: relative;
        }

        #map-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 28px;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transform: translateY(0);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: fadeInScale 0.6s ease-out;
        }

        .login-form-body {
            padding: 20px 25px 25px;
        }

        .card-header-banner {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            padding: 25px 20px 25px;
            text-align: center;
            border-bottom-left-radius: 90px 28px;
            border-bottom-right-radius: 90px 28px;
            position: relative;
            box-shadow: 0 10px 30px rgba(18, 20, 48, 0.3);
            border-bottom: 2px solid rgba(255, 255, 255, 0.05);
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.9) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .login-icon-wrapper {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #FFD700, #FF9F00);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            box-shadow: 0 12px 25px rgba(255, 215, 0, 0.25);
            border: 2px solid rgba(255, 255, 255, 0.2);
            transform: rotate(-10deg);
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(-10deg); }
            50% { transform: translateY(-8px) rotate(-5deg); }
        }

        .login-icon-wrapper i {
            font-size: 24px;
            color: #121430;
        }

        .brand-title {
            font-weight: 800;
            font-size: 1.4rem;
            color: #ffffff;
            margin-bottom: 2px;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.85rem;
            font-weight: 400;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-main);
            margin-left: 4px;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group-custom i:first-child {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            z-index: 10;
            transition: all 0.3s ease;
        }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #b2bec3;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
            padding: 5px;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .form-control-custom {
            width: 100%;
            padding: 10px 15px 10px 42px;
            background: rgba(255, 255, 255, 0.6);
            border: 2px solid transparent;
            border-radius: 12px;
            font-size: 0.95rem;
            color: var(--text-main);
            transition: all 0.3s ease;
        }

        .form-control-custom.has-toggle {
            padding-right: 45px;
        }

        .form-control-custom:focus {
            background: #fff;
            border-color: var(--primary-color);
            box-shadow: 0 10px 20px rgba(24, 27, 64, 0.1);
            outline: none;
        }

        .form-control-custom::placeholder {
            color: #b2bec3;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 700;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(24, 27, 64, 0.3);
            margin-top: 5px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(24, 27, 64, 0.4);
            opacity: 0.95;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin-top: 15px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-link i {
            margin-right: 8px;
            transition: transform 0.3s ease;
        }

        .back-link:hover {
            color: var(--primary-color);
        }

        .back-link:hover i {
            transform: translateX(-4px);
        }

        .alert {
            border-radius: 16px;
            padding: 12px 16px;
            font-size: 0.85rem;
            border: none;
            margin-bottom: 18px;
            background: rgba(255, 121, 121, 0.12);
            color: #d63031;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shakeAlert 0.5s ease-in-out;
            box-shadow: 0 4px 15px rgba(214, 48, 49, 0.1);
        }

        @keyframes shakeAlert {
            0%, 100% { transform: translateX(0); }
            15% { transform: translateX(-8px); }
            30% { transform: translateX(8px); }
            45% { transform: translateX(-6px); }
            60% { transform: translateX(6px); }
            75% { transform: translateX(-3px); }
            90% { transform: translateX(3px); }
        }

        .alert-success {
            animation: fadeInUp 0.4s ease-out !important;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .input-error .form-control-custom {
            border-color: #d63031 !important;
            background: rgba(255, 121, 121, 0.05) !important;
        }

        .input-error i:first-child {
            color: #d63031 !important;
        }

        /* Custom motorbike map marker */
        .moto-marker {
            width: 36px;
            height: 36px;
            background: #25074e;
            border: 3px solid #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.4);
            color: white;
            font-size: 16px;
        }
        
        .moto-marker i {
            color: #ffffff;
            font-size: 14px;
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .login-card {
                padding: 0;
                border-radius: 24px;
            }
            .login-form-body {
                padding: 20px 15px 20px;
            }
            .card-header-banner {
                padding: 20px 15px 20px;
                border-bottom-left-radius: 80px 24px;
                border-bottom-right-radius: 80px 24px;
            }
            .brand-title {
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body>

<div id="map-bg"></div>

<div class="login-container">
    <div class="login-card">
        <!-- TOP CURVED BANNER -->
        <div class="card-header-banner">
            <div class="login-icon-wrapper">
                <i class="fas fa-motorcycle"></i>
            </div>
            <h1 class="brand-title">Login Admin</h1>
            <p class="brand-subtitle">Sistema Dealer Motor Dili</p>
        </div>

        <!-- BOTTOM FORM CONTAINER -->
        <div class="login-form-body">
            <!-- ERROR MESSAGE -->
            <?php if (!empty($error)): ?>
                <div class="alert">
                    <i class="fas fa-circle-exclamation"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <!-- SUCCESS MESSAGE -->
            <?php if (!empty($success)): ?>
                <div class="alert alert-success animate-up" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; border: none; margin-bottom: 24px; border-radius: 16px; padding: 12px 16px; font-size: 0.85rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-check-circle"></i>
                    <span><?= htmlspecialchars($success) ?></span>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const btn = document.querySelector('.btn-login');
                        if (btn) {
                            btn.style.background = 'linear-gradient(135deg, #2ecc71, #27ae60)';
                            btn.style.boxShadow = '0 10px 25px rgba(46, 204, 113, 0.3)';
                            btn.querySelector('span').textContent = 'Login ho susesu!';
                            btn.querySelector('i').className = 'fas fa-check-circle';
                            btn.style.pointerEvents = 'none';
                        }
                        // Disable all inputs
                        document.querySelectorAll('.form-control-custom').forEach(input => input.disabled = true);
                    });
                    
                    setTimeout(function() {
                        window.location.href = '/dealer-motor-dili/admin/dashboard.php';
                    }, 1500);
                </script>
            <?php endif; ?>

            <!-- LOGIN FORM -->
            <form method="POST" id="loginForm">
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-group-custom">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" class="form-control-custom" 
                               placeholder="Hakerek username" autocomplete="username">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="passwordInput" class="form-control-custom has-toggle" 
                               placeholder="••••••••" autocomplete="current-password">
                        <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <span>Login</span>
                    <i class="fas fa-arrow-right"></i>
                </button>

                <a href="../index.php" class="back-link">
                    <i class="fas fa-chevron-left"></i>
                    Fila ba Website
                </a>
            </form>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Determine initial zoom based on screen size (more zoomed out on mobile)
    const initialZoom = window.innerWidth < 768 ? 12 : 13.5;
    
    // Offset the center so Dili appears on the left side of the screen
    // Dili coordinates: [-8.5568, 125.5603]
    // To move Dili to the left, we center the map further East (increase longitude)
    const centerOffset = window.innerWidth < 768 ? 0 : 0.06;
    const centerLat = -8.5668; // Slightly south
    const centerLng = 125.5603 + centerOffset;
    
    // Initialize map in the background
    const map = L.map('map-bg', {
        zoomControl: false,
        attributionControl: false
    }).setView([centerLat, centerLng], initialZoom);

    // Use Google Hybrid (Satellite + Roads/Labels) matching the mockup exactly
    L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 19
    }).addTo(map);
    
    // Add custom motorbike markers
    const motoIcon = L.divIcon({
        className: 'custom-div-icon',
        html: `
            <div class="moto-marker">
                <i class="fas fa-motorcycle"></i>
            </div>
        `,
        iconSize: [36, 36],
        iconAnchor: [18, 18]
    });
    
    // Place markers around Dili
    const locations = [
        [-8.5520, 125.5580], // near center
        [-8.5575, 125.5620], // south of center
        [-8.5610, 125.5520], // south west
        [-8.5530, 125.5690], // east
        [-8.5590, 125.5720], // south east
        [-8.5500, 125.5760], // far east
        [-8.5620, 125.5650], // further south
        [-8.5490, 125.5630]  // north
    ];

    locations.forEach(coord => {
        L.marker(coord, { icon: motoIcon }).addTo(map);
    });

    // Make map non-interactive for the login background
    map.dragging.disable();
    map.touchZoom.disable();
    map.doubleClickZoom.disable();
    map.scrollWheelZoom.disable();
    map.boxZoom.disable();
    map.keyboard.disable();
    if (map.tap) map.tap.disable();

    // Make map fully responsive on window resize
    window.addEventListener('resize', function() {
        map.invalidateSize();
        // Recalculate center based on new window width
        const newOffset = window.innerWidth < 768 ? 0 : 0.06;
        const newZoom = window.innerWidth < 768 ? 12 : 13.5;
        map.setView([-8.5668, 125.5603 + newOffset], newZoom);
    });
</script>

<script>
    // Password visibility toggle
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#passwordInput');

    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
    });

    // Form validation and submit handler
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const usernameInput = this.querySelector('input[name="username"]');
        const passwordInput = this.querySelector('#passwordInput');
        const usernameVal = usernameInput.value.trim();
        const passwordVal = passwordInput.value.trim();
        
        // Clear previous input error highlights
        document.querySelectorAll('.input-group-custom').forEach(g => g.classList.remove('input-error'));
        
        if (usernameVal === '' || passwordVal === '') {
            e.preventDefault();
            
            // Determine specific error message
            let errorMsg = '';
            if (usernameVal === '' && passwordVal === '') {
                errorMsg = 'Favor prenxe username ho password!';
                usernameInput.closest('.input-group-custom').classList.add('input-error');
                passwordInput.closest('.input-group-custom').classList.add('input-error');
            } else if (usernameVal === '') {
                errorMsg = 'Favor prenxe username!';
                usernameInput.closest('.input-group-custom').classList.add('input-error');
            } else {
                errorMsg = 'Favor prenxe password!';
                passwordInput.closest('.input-group-custom').classList.add('input-error');
            }
            
            // Show/create the error alert
            let alertDiv = document.querySelector('.alert:not(.alert-success)');
            if (!alertDiv) {
                alertDiv = document.createElement('div');
                alertDiv.className = 'alert';
                
                const icon = document.createElement('i');
                icon.className = 'fas fa-circle-exclamation';
                alertDiv.appendChild(icon);
                
                const span = document.createElement('span');
                alertDiv.appendChild(span);
                
                // Insert before the form
                const form = document.getElementById('loginForm');
                form.parentNode.insertBefore(alertDiv, form);
            }
            
            alertDiv.querySelector('span').textContent = errorMsg;
            
            // Re-trigger shake animation
            alertDiv.style.animation = 'none';
            alertDiv.offsetHeight; // force reflow
            alertDiv.style.animation = 'shakeAlert 0.5s ease-in-out';
            
            return false;
        }

        const btn = this.querySelector('.btn-login');
        const span = btn.querySelector('span');
        const icon = btn.querySelector('i');
        
        span.textContent = 'Verifika...';
        icon.className = 'fas fa-circle-notch fa-spin';
        btn.style.opacity = '0.8';
        btn.style.pointerEvents = 'none';
    });

    // Remove error highlights when user starts typing
    document.querySelectorAll('.form-control-custom').forEach(input => {
        input.addEventListener('input', function() {
            this.closest('.input-group-custom').classList.remove('input-error');
        });
    });
</script>

</body>
</html>