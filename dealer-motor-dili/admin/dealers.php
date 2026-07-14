<?php
require_once '../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');

$dealers = $pdo->query("SELECT * FROM dealer_motor ORDER BY id DESC")->fetchAll();
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
                    <i class="fas fa-motorcycle fs-3 text-dark"></i>
                    <h4 class="fw-bold mb-0">Lista Dellear Motor</h4>
                </div>
                <a href="add_dealer.php" class="btn btn-purple-gradient rounded-3 px-4 py-2 fw-bold pulse-action">
                    <i class="fas fa-plus-circle me-2"></i>Dellear Foun
                </a>
            </div>

            <div class="search-container-card mb-4">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="d-flex gap-2">
                            <input type="text" id="customSearch" class="form-control border-light-subtle shadow-sm" style="border-radius: 10px; height: 45px;" placeholder="Buka: naran, marka, enderesu, koordinadas...">
                            <button id="btnSearch" class="btn btn-purple-gradient px-4" style="border-radius: 10px; min-width: 120px;">
                                <i class="fas fa-search me-2"></i>Buka
                            </button>
                            <button id="resetSearch" class="btn btn-link text-muted text-decoration-none d-flex align-items-center gap-1">
                                <i class="fas fa-times"></i> Reset
                            </button>
                        </div>
                    </div>
                    <div class="col-md-5 text-end">
                        <span class="badge rounded-pill px-4 py-2" style="background: #6f42c1; font-size: 0.9rem;">
                            <?= count($dealers) ?> rekord
                        </span>
                    </div>
                </div>
            </div>


            <div class="table-responsive">
                <table id="dealersTable" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">No</th>
                            <th width="80">Foto</th>
                            <th>Naran Dellear Motor</th>
                            <th>Enderesu</th>
                            <th class="text-center">Presu</th>
                            <th width="120">Oráriu Loke</th>
                            <th width="180">Koordinadas</th>
                            <th class="text-center" width="150">Aksaun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($dealers as $d): ?>
                        <tr>
                            <td class="text-center fw-medium"><?= $no++ ?></td>
                            <td>
                                <div style="width: 50px; height: 50px; border-radius: 8px; overflow: hidden; background: #eee;">
                                    <?php
                                    $img_path = '/dealer-motor-dili/assets/images/genio.jfif';
                                    if (!empty($d['foto']) && file_exists('../assets/images/dealers/' . $d['foto'])) {
                                        $img_path = '/dealer-motor-dili/assets/images/dealers/' . $d['foto'];
                                    }
                                    ?>
                                    <img src="<?= $img_path ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark fs-6"><?= e($d['nama_dealer']) ?></div>
                            </td>
                            <td>
                                <div class="small text-muted"><?= e($d['alamat']) ?></div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-primary border shadow-sm px-3 py-2 fw-bold" style="font-size: 0.85rem;">
                                    $ <?= number_format($d['presu'], 0) ?>
                                </span>
                            </td>
                            <td>
                                <div class="badge-hours">
                                    <?php 
                                        $h = explode('-', $d['jam_buka']);
                                        echo '<div>' . trim($h[0] ?? '') . '</div>';
                                        echo '<div>' . trim($h[1] ?? '') . '</div>';
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="small text-muted" style="font-size: 0.75rem;">
                                    Lat: <?= number_format($d['latitude'], 8) ?><br>
                                    Lng: <?= number_format($d['longitude'], 8) ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="view_dealer.php?id=<?= $d['id'] ?>" class="btn-action-view" title="Haree Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="https://www.google.com/maps?q=<?= $d['latitude'] ?>,<?= $d['longitude'] ?>" target="_blank" class="btn-action-maps" title="Mapa">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </a>
                                    <a href="edit_dealer.php?id=<?= $d['id'] ?>" class="btn-action-edit" title="Edita">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn-action-delete" title="Hamoos"
                                            onclick='deleteDealer(<?= $d["id"] ?>, <?= json_encode($d["nama_dealer"]) ?>)'>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>


<?php include 'includes/footer.php'; ?>