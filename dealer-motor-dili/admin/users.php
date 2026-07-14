<?php
require_once '../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');

$currentAdmin = $_SESSION['admin_username'] ?? '';
$stmt = $pdo->prepare("
    SELECT * FROM users 
    ORDER BY 
        CASE WHEN username = ? THEN 0 ELSE 1 END,
        id DESC
");
$stmt->execute([$currentAdmin]);
$users = $stmt->fetchAll();
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid p-4">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate-up">
        <div class="card-body p-4">
            
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 animate-up" style="background: rgba(29, 158, 117, 0.1); color: #1D9E75;">
                    <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 animate-up">
                    <i class="fas fa-exclamation-triangle me-2"></i> <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-users fs-3 text-dark"></i>
                    <h4 class="fw-bold mb-0">Lista Utilizador</h4>
                </div>
                <a href="add_user.php" class="btn btn-purple-gradient rounded-3 px-4 py-2 fw-bold pulse-action">
                    <i class="fas fa-user-plus me-2"></i>Utilizador Foun
                </a>
            </div>

            <div class="search-container-card mb-4">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <!-- Simplified search, could add JS logic later -->
                    </div>
                    <div class="col-md-5 text-end">
                        <span class="badge rounded-pill px-4 py-2" style="background: #6f42c1; font-size: 0.9rem;">
                            <?= count($users) ?> utilizador
                        </span>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">No</th>
                            <th>Username</th>
                            <th>Data Kria</th>
                            <th class="text-center" width="150">Aksaun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($users as $u): ?>
                        <tr>
                            <td class="text-center fw-medium"><?= $no++ ?></td>
                            <td>
                                <div class="fw-bold text-dark fs-6">
                                    <?= e($u['username']) ?>
                                    <?php if($u['username'] === $_SESSION['admin_username']): ?>
                                        <span class="badge bg-success ms-2" style="font-size: 0.7rem;">(Ativu)</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="small text-muted"><?= date('d M Y, H:i', strtotime($u['created_at'])) ?></div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="edit_user.php?id=<?= $u['id'] ?>" class="btn-action-edit" title="Edita">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if($u['username'] !== $_SESSION['admin_username']): ?>
                                    <button class="btn-action-delete" title="Hamoos" onclick='deleteUser(<?= $u["id"] ?>, <?= json_encode($u["username"]) ?>)'>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <?php else: ?>
                                    <button class="btn-action-delete" style="opacity: 0.5; cursor: not-allowed;" title="Labele hamoos konta rasik" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if(empty($users)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                Laiha dadus utilizador.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<script>
function deleteUser(id, username) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Ita-boot serteza?',
            text: "Atu apaga utilizador: " + username,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#D32F2F',
            cancelButtonColor: '#333',
            confirmButtonText: 'Sim, Apaga!',
            cancelButtonText: 'Kansela'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'delete_user.php?id=' + id;
            }
        });
    } else {
        if (confirm("Ita-boot serteza atu apaga utilizador: " + username + "?")) {
            window.location.href = 'delete_user.php?id=' + id;
        }
    }
}
</script>

<?php include 'includes/footer.php'; ?>
