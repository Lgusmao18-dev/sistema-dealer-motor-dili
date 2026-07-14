<?php
require_once '../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');

$dealers = $pdo->query("SELECT id, nama_dealer FROM dealer_motor ORDER BY nama_dealer")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $foto = '';
    if (!empty($_FILES['foto']['name'])) {
        $foto = time() . '_' . $_FILES['foto']['name'];
        if (!is_dir('../assets/images/motors')) {
            mkdir('../assets/images/motors', 0777, true);
        }
        move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/images/motors/' . $foto);
    }

    $stmt = $pdo->prepare("INSERT INTO motor_models (nama_model, marka, presu, deskrisaun, foto, dealer_id) VALUES (?,?,?,?,?,?)");
    $stmt->execute([
        $_POST['nama_model'], $_POST['marka'], $_POST['presu'],
        $_POST['deskrisaun'], $foto, $_POST['dealer_id']
    ]);
    redirect('/dealer-motor-dili/admin/models.php?success=Modelu motor aumenta ho susesu!');
}
?>

<?php include 'includes/header.php'; ?>

<div class="page-header animate-up">
    <div class="d-flex align-items-center gap-3">
        <a href="models.php" class="btn btn-light rounded-circle p-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="page-title">Aumenta Modelu Motor</h2>
            <p class="page-subtitle">Hatama unidade foun ba kátalogu motor.</p>
        </div>
    </div>
</div>

<div class="container-fluid px-3 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="section-card animate-up delay-1">
                <form method="POST" id="modelForm" enctype="multipart/form-data">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label text-dark fw-bold">Naran Modelu</label>
                                <div class="input-group-custom">
                                    <i class="fas fa-motorcycle"></i>
                                    <input type="text" name="nama_model" class="form-control-custom" placeholder="Ex: Honda Vario 160" required>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-bold">Marka</label>
                                        <div class="input-group-custom">
                                            <i class="fas fa-tag"></i>
                                            <select name="marka" class="form-control-custom" required>
                                                <option value="">— Hili marka —</option>
                                                <?php foreach (['Honda','Yamaha','Suzuki','Kawasaki','TVS','Lainseluk'] as $m): ?>
                                                    <option value="<?= $m ?>"><?= $m ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-bold">Presu ($)</label>
                                        <div class="input-group-custom">
                                            <i class="fas fa-dollar-sign"></i>
                                            <input type="number" step="0.01" name="presu" class="form-control-custom" placeholder="Ex: 2500.00" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-dark fw-bold">Dealer Disponível</label>
                                <div class="input-group-custom">
                                    <i class="fas fa-store"></i>
                                    <select name="dealer_id" class="form-control-custom" required>
                                        <option value="">— Hili Dealer —</option>
                                        <?php foreach ($dealers as $d): ?>
                                            <option value="<?= $d['id'] ?>"><?= e($d['nama_dealer']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-dark fw-bold">Foto Motor</label>
                                <div class="input-group-custom">
                                    <i class="fas fa-image"></i>
                                    <input type="file" name="foto" class="form-control-custom" accept="image/*">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-dark fw-bold">Deskrisaun / Spesifikasaun</label>
                                <div class="input-group-custom">
                                    <i class="fas fa-info-circle" style="top: 25px;"></i>
                                    <textarea name="deskrisaun" class="form-control-custom" rows="4" placeholder="Informasaun kona-ba motor..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4 pt-4 border-top">
                        <a href="models.php" class="btn btn-light rounded-pill px-4">Kansela</a>
                        <button type="submit" class="btn btn-primary-custom rounded-pill px-5">
                            <i class="fas fa-save me-2"></i>Salva Modelu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('modelForm').addEventListener('submit', function(e) {
    const btn = this.querySelector('button[type="submit"]');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Salva hela...';
    btn.style.opacity = '0.8';
    btn.style.pointerEvents = 'none';
});
</script>

<?php include 'includes/footer.php'; ?>
