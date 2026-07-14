<?php
require_once '../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');

$id = $_GET['id'] ?? null;
if (!$id) redirect('/dealer-motor-dili/admin/users.php');

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) redirect('/dealer-motor-dili/admin/users.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username)) {
        $error = "Username labele mamuk!";
    } else {
        // Check if username already exists for OTHER users
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND id != ?");
        $stmt->execute([$username, $id]);
        if ($stmt->fetchColumn() > 0) {
            $error = "Username ne'e uza ona husi ema seluk, favor hili seluk!";
        } else {
            if (!empty($password)) {
                // Update username and password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
                $success = $stmt->execute([$username, $hashedPassword, $id]);
            } else {
                // Update username only
                $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
                $success = $stmt->execute([$username, $id]);
            }
            
            if ($success) {
                // If the edited user is the currently logged-in admin, update session
                if ($user['username'] === $_SESSION['admin_username']) {
                    $_SESSION['admin_username'] = $username;
                }
                redirect('/dealer-motor-dili/admin/users.php?success=Dadus utilizador atualiza ona ho susesu!');
            } else {
                $error = "Falha atu atualiza dadus ba database.";
            }
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid p-4">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate-up" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header bg-white p-4 border-bottom d-flex align-items-center gap-3">
            <i class="fas fa-user-edit fs-3 text-primary"></i>
            <h4 class="fw-bold mb-0">Edita Utilizador</h4>
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
                        <input type="text" name="username" class="form-control border-start-0" required placeholder="Hakerek username" value="<?= htmlspecialchars($_POST['username'] ?? $user['username']) ?>">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Password Foun <span class="text-muted fw-normal" style="font-size: 0.85rem;">(Husik mamuk se lakohi troka)</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control border-start-0" placeholder="Hakerek password foun">
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-5">
                    <a href="users.php" class="btn btn-light px-4 border">Kansela</a>
                    <button type="submit" class="btn btn-purple-gradient px-4">
                        <i class="fas fa-save me-2"></i>Atualiza
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<?php include 'includes/footer.php'; ?>
