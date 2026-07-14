<?php
require_once '../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Prienxe dadus hotu mak presiza!";
    } else {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            $error = "Username ne'e uza ona, favor hili seluk!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $hashedPassword])) {
                redirect('/dealer-motor-dili/admin/users.php?success=Rejistu utilizador foun ho susesu!');
            } else {
                $error = "Falha atu rai dadus ba database.";
            }
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid p-4">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate-up" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header bg-white p-4 border-bottom d-flex align-items-center gap-3">
            <i class="fas fa-user-plus fs-3 text-primary"></i>
            <h4 class="fw-bold mb-0">Rejista Utilizador Foun</h4>
        </div>
        
        <div class="card-body p-4">
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 animate-up">
                    <i class="fas fa-exclamation-triangle me-2"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Username <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                        <input type="text" name="username" class="form-control border-start-0" required placeholder="Hakerek username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control border-start-0" required placeholder="Hakerek password foun">
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-5">
                    <a href="users.php" class="btn btn-light px-4 border">Kansela</a>
                    <button type="submit" class="btn btn-purple-gradient px-4">
                        <i class="fas fa-save me-2"></i>Rai Dadus
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<?php include 'includes/footer.php'; ?>
