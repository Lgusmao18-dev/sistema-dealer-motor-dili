<?php
require_once '../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM dealer_motor WHERE id = ?");
$stmt->execute([$id]);
$dealer = $stmt->fetch();

if (!$dealer) {
    redirect('/dealer-motor-dili/admin/dealers.php?error=Dellear la konese!');
}

include 'includes/header.php';
?>

<div class="page-header animate-up">
    <div class="d-flex align-items-center gap-3">
        <a href="dealers.php" class="btn btn-light rounded-circle p-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="page-title">Detallu Dellear Motor</h2>
            <p class="page-subtitle">Informasaun kompletu husi <?= htmlspecialchars($dealer['nama_dealer']) ?></p>
        </div>
    </div>
</div>

<div class="container-fluid px-4 pb-5">
    <div class="row g-4">
        <!-- Profile Column -->
        <div class="col-lg-4">
            <div class="section-card h-100 animate-up delay-1 text-center p-5">
                <div class="dealer-photo-container mb-4 mx-auto" style="width: 180px; height: 180px; border-radius: 30px; overflow: hidden; border: 5px solid white; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                    <?php if($dealer['foto']): ?>
                        <img src="/dealer-motor-dili/assets/images/dealers/<?= $dealer['foto'] ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-light h-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-store fa-4x text-muted opacity-25"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <h3 class="fw-bold mb-1"><?= htmlspecialchars($dealer['nama_dealer']) ?></h3>
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-4"><?= htmlspecialchars($dealer['marka']) ?> Dealer</span>
                
                <div class="d-grid gap-2 mt-2">
                    <a href="edit_dealer.php?id=<?= $dealer['id'] ?>" class="btn btn-dark rounded-3 py-2">
                        <i class="fas fa-edit me-2"></i>Edita Dadus
                    </a>
                    <a href="https://www.google.com/maps?q=<?= $dealer['latitude'] ?>,<?= $dealer['longitude'] ?>" target="_blank" class="btn btn-primary-custom rounded-3 py-2">
                        <i class="fas fa-map-marker-alt me-2"></i>Haree iha Mapa
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Column -->
        <div class="col-lg-8">
            <div class="section-card h-100 animate-up delay-2">
                <h5 class="fw-bold mb-4 border-bottom pb-3">
                    <i class="fas fa-info-circle text-primary me-2"></i>Informasaun Jerál
                </h5>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-item mb-4">
                            <label class="small text-muted text-uppercase fw-bold">Enderesu</label>
                            <p class="mb-0 fw-medium"><?= nl2br(htmlspecialchars($dealer['alamat'])) ?></p>
                        </div>
                        <div class="info-item mb-4">
                            <label class="small text-muted text-uppercase fw-bold">Oráriu Loke</label>
                            <p class="mb-0 fw-medium text-success"><?= htmlspecialchars($dealer['jam_buka']) ?></p>
                        </div>
                        <div class="info-item mb-4">
                            <label class="small text-muted text-uppercase fw-bold">Atributu Presu (SAW)</label>
                            <p class="mb-0 fw-bold text-primary">$ <?= number_format($dealer['presu'], 0) ?></p>
                        </div>
                        <div class="info-item">
                            <label class="small text-muted text-uppercase fw-bold">Koordinadas</label>
                            <p class="mb-0 fw-medium"><?= $dealer['latitude'] ?>, <?= $dealer['longitude'] ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="info-item mb-4">
                            <label class="small text-muted text-uppercase fw-bold">Kontaktu (Phone)</label>
                            <p class="mb-0 fw-medium"><?= htmlspecialchars($dealer['telepon'] ?: '-') ?></p>
                        </div>
                        <div class="info-item mb-4">
                            <label class="small text-muted text-uppercase fw-bold">Email</label>
                            <p class="mb-0 fw-medium"><?= htmlspecialchars($dealer['email'] ?: '-') ?></p>
                        </div>
                        <div class="info-item">
                            <label class="small text-muted text-uppercase fw-bold">Social Media</label>
                            <div class="d-flex gap-3 mt-1">
                                <?php if($dealer['facebook']): ?>
                                    <a href="#" class="text-primary fs-5"><i class="fab fa-facebook"></i></a>
                                <?php endif; ?>
                                <?php if($dealer['instagram']): ?>
                                    <a href="#" class="text-danger fs-5"><i class="fab fa-instagram"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-top">
                    <label class="small text-muted text-uppercase fw-bold">Deskrisaun</label>
                    <p class="mt-2 text-muted"><?= nl2br(htmlspecialchars($dealer['deskripsi'] ?: 'Seidauk iha deskrisaun ba dellear ida ne\'e.')) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
