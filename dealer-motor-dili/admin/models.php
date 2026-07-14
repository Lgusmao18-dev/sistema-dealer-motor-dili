<?php
require_once '../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');

// Join with dealer to show where the model is available
$models = $pdo->query("
    SELECT m.*, d.nama_dealer 
    FROM motor_models m 
    LEFT JOIN dealer_motor d ON m.dealer_id = d.id 
    ORDER BY m.id DESC
")->fetchAll();
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid p-4">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Lista Modelu Motor</h4>
                <a href="add_model.php" class="btn btn-success rounded-2 px-3 py-2 fw-bold pulse-action">
                    <i class="fas fa-plus me-2"></i>Aumenta Modelu Foun
                </a>
            </div>

            <div class="table-responsive">
                <table id="modelsTable" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th width="80">Foto</th>
                            <th>Naran Modelu</th>
                            <th>Marka</th>
                            <th>Presu</th>
                            <th>Dealer Disponível</th>
                            <th width="120" class="text-center">Aksaun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($models as $m): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?php
                                $img_path = '/dealer-motor-dili/assets/images/genio.jfif';
                                if (!empty($m['foto']) && file_exists('../assets/images/motors/' . $m['foto'])) {
                                    $img_path = '/dealer-motor-dili/assets/images/motors/' . $m['foto'];
                                } else {
                                    // Fallback images from assets if available
                                    $brand = strtolower(trim($m['marka']));
                                    if($brand == 'honda') $img_path = '/dealer-motor-dili/assets/images/beat.jfif';
                                    if($brand == 'yamaha') $img_path = '/dealer-motor-dili/assets/images/mio.jfif';
                                    if($brand == 'kawasaki') $img_path = '/dealer-motor-dili/assets/images/kawa.jfif';
                                }
                                ?>
                                <div style="width: 50px; height: 50px; border-radius: 8px; overflow: hidden; background: #eee;">
                                    <img src="<?= $img_path ?>" 
                                         alt="Motor" 
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </td>
                            <td>
                                <span class="text-dealer-name"><?= e($m['nama_model']) ?></span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border"><?= e($m['marka']) ?></span>
                            </td>
                            <td>
                                <span class="fw-bold text-primary">$ <?= number_format($m['presu'], 2) ?></span>
                            </td>
                            <td>
                                <span class="text-muted small"><?= e($m['nama_dealer'] ?? 'La iha Dealer') ?></span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="edit_model.php?id=<?= $m['id'] ?>" class="btn-action-edit" title="Edita">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn-action-delete" title="Apaga"
                                            onclick="deleteModel(<?= $m['id'] ?>,'<?= e($m['nama_model']) ?>')">
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('modelsTable')) {
        $('#modelsTable').DataTable({
            order: [[0, 'asc']],
            pageLength: 10,
            responsive: true,
            dom: 'lrtip',
            language: {
                search: "Buka:",
                lengthMenu: "Haree _MENU_ dadus",
                info: "Haree _START_ to'o _END_ husi _TOTAL_ dadus",
                paginate: {
                    first: "Primeiru",
                    last: "Últimu",
                    next: "Oituan",
                    previous: "Atras"
                }
            },
            drawCallback: function() {
                $('#modelsTable tbody tr').each(function(i) {
                    const row = $(this);
                    setTimeout(() => {
                        row.addClass('show');
                    }, i * 50);
                });
            }
        });
    }
});

function deleteModel(id, name) {
    Swal.fire({
        title: 'Ita-boot serteza?',
        text: "Atu apaga modelu motor: " + name,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#D32F2F',
        cancelButtonColor: '#333',
        confirmButtonText: 'Sim, Apaga!',
        cancelButtonText: 'Kansela'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'delete_model.php?id=' + id;
        }
    });
}
</script>

<?php include 'includes/footer.php'; ?>
