<?php
require_once '../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');

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
} catch (PDOException $e) {}

// Queries
$totalDealers = $pdo->query("SELECT COUNT(*) as t FROM dealer_motor")->fetch()['t'];
$recentDealers = $pdo->query("SELECT * FROM dealer_motor ORDER BY created_at DESC LIMIT 5")->fetchAll();
$brandsCount = $pdo->query("SELECT COUNT(DISTINCT marka) as t FROM dealer_motor")->fetch()['t'];
$totalMessages = $pdo->query("SELECT COUNT(*) as t FROM messages")->fetch()['t'];
?>

<?php include 'includes/header.php'; ?>

<div class="page-header">
    <h2 class="page-title">Dashboard!</h2>
    <p class="page-subtitle">Favor jere Data sira ho professionalizmu.</p>
</div>

<div class="container-fluid px-3 pb-5">

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon-box bg-purple-soft">
                    <i class="fas fa-motorcycle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?= $totalDealers ?></div>
                    <div class="stat-label">Total Dealer</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon-box bg-green-soft">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?= $totalMessages ?></div>
                    <div class="stat-label">Mensajen Kliente</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon-box bg-yellow-soft">
                    <i class="fas fa-award"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?= $brandsCount ?></div>
                    <div class="stat-label">Marka Motor</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Quick Actions -->
        <div class="col-lg-4">
            <h5 class="section-title-dash">Operasaun Lalais</h5>
            <div class="section-card h-100">
                <p class="text-muted small mb-4">Ezekuta tarefa administrativu sira ho klik ida deit.</p>
                <div class="d-grid gap-3">
                    <a href="add_dealer.php" class="btn-dash-action btn-dash-green">
                        <i class="fas fa-plus-circle"></i> Rejista Dellear Foun
                    </a>
                    <a href="dealers.php" class="btn-dash-action btn-dash-black">
                        <i class="fas fa-motorcycle"></i> Jere Dealer
                    </a>
                    <a href="messages.php" class="btn-dash-action btn-purple-gradient">
                        <i class="fas fa-envelope"></i> Mensajen Kliente
                    </a>
                </div>
                
                <div class="mt-5 p-4 rounded-4 bg-light border border-dashed text-center">
                    <i class="fas fa-info-circle text-primary mb-2 d-block fs-4"></i>
                    <span class="small text-muted d-block">Status Sistema: <strong>Ótimu</strong></span>
                </div>
            </div>
        </div>

        <!-- Latest Table -->
        <div class="col-lg-8">
            <h5 class="section-title-dash">Atividade Rezentu</h5>
            <div class="section-card">
                <div class="table-responsive">
                    <table id="recentDealersTable" class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID Unidade</th>
                                <th>Pre-vizaun</th>
                                <th>Naran Dellear</th>
                                <th>Oráriu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($recentDealers as $d): ?>
                            <tr>
                                <td class="text-muted small">#D-<?= 100 + $no++ ?></td>
                                <td>
                                    <?php
                                    $img_path = '';
                                    if (!empty($d['foto']) && file_exists('../assets/images/dealers/' . $d['foto'])) {
                                        $img_path = '/dealer-motor-dili/assets/images/dealers/' . $d['foto'];
                                    } else {
                                        $brand = strtolower(trim($d['marka']));
                                        $img_path = '/dealer-motor-dili/assets/images/genio.jfif';
                                        if($brand == 'honda') $img_path = '/dealer-motor-dili/assets/images/beat.jfif';
                                        if($brand == 'yamaha') $img_path = '/dealer-motor-dili/assets/images/mio.jfif';
                                        if($brand == 'kawasaki') $img_path = '/dealer-motor-dili/assets/images/kawa.jfif';
                                    }
                                    ?>
                                    <div style="width: 50px; height: 50px; border-radius: 12px; overflow: hidden; border: 2px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                        <img src="<?= $img_path ?>" alt="Dealer" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-dealer-name"><?= e($d['nama_dealer']) ?></span>
                                        <small class="text-muted small"><?= e($d['alamat']) ?></small>
                                    </div>
                                </td>
                                <td><span class="badge-hours"><?= e($d['jam_buka']) ?></span></td>
                                <td>
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill small">
                                        <i class="fas fa-check-circle me-1"></i> Ativu
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'includes/footer.php'; ?>