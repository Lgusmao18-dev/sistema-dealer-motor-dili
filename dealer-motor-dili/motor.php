<?php
require_once 'config/database.php';

// Get all models
$models = $pdo->query("
    SELECT m.*, d.nama_dealer, d.alamat as dealer_address
    FROM motor_models m 
    LEFT JOIN dealer_motor d ON m.dealer_id = d.id 
    ORDER BY m.nama_model ASC
")->fetchAll();

include 'includes/header.php';
?>

<section class="hero-section py-5 mb-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); position: relative; overflow: hidden;">
    <div class="container py-5 text-center position-relative" style="z-index: 2;">
        <h1 class="display-3 fw-bold text-white mb-3">Kátalogu <span class="text-primary-mid">Motor</span></h1>
        <p class="lead text-white-50 mb-0">Haree modelu motor foun no kualidade ne'ebé disponível iha Dili.</p>
    </div>
    <div style="position: absolute; top: 0; right: 0; opacity: 0.1; width: 40%;">
        <i class="fas fa-motorcycle" style="font-size: 30rem; color: white;"></i>
    </div>
</section>

<div class="container pb-5">
    
    <!-- Filter Section -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-0 pe-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" id="motorSearch" class="form-control border-0 shadow-none" placeholder="Buka modelu ka marka...">
                        </div>
                    </div>
                    <div class="col-md-8 text-md-end mt-3 mt-md-0">
                        <div class="d-flex justify-content-md-end gap-2">
                            <button class="btn btn-primary-mid rounded-pill px-4 filter-btn active" data-filter="all">Hotu-hotu</button>
                            <button class="btn btn-outline-secondary rounded-pill px-4 filter-btn" data-filter="honda">Honda</button>
                            <button class="btn btn-outline-secondary rounded-pill px-4 filter-btn" data-filter="yamaha">Yamaha</button>
                            <button class="btn btn-outline-secondary rounded-pill px-4 filter-btn" data-filter="suzuki">Suzuki</button>
                            <button class="btn btn-outline-secondary rounded-pill px-4 filter-btn" data-filter="kawasaki">Kawasaki</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid Models -->
    <div class="row g-4" id="motorGrid">
        <?php if (empty($models)): ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-box-open fs-1 text-muted mb-3 d-block"></i>
                <h4 class="text-muted">Seidauk iha dadus motor.</h4>
            </div>
        <?php else: ?>
            <?php foreach ($models as $m): ?>
            <div class="col-md-4 col-lg-3 motor-card" data-marka="<?= strtolower($m['marka']) ?>">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-hover">
                    <div class="position-relative">
                        <?php
                        $img_path = 'assets/images/genio.jfif';
                        if (!empty($m['foto']) && file_exists('assets/images/motors/' . $m['foto'])) {
                            $img_path = 'assets/images/motors/' . $m['foto'];
                        } else {
                            $brand = strtolower(trim($m['marka']));
                            if($brand == 'honda') $img_path = 'assets/images/beat.jfif';
                            if($brand == 'yamaha') $img_path = 'assets/images/mio.jfif';
                            if($brand == 'kawasaki') $img_path = 'assets/images/kawa.jfif';
                        }
                        ?>
                        <img src="<?= $img_path ?>" class="card-img-top" alt="<?= e($m['nama_model']) ?>" style="height: 200px; object-fit: cover;">
                        <span class="badge bg-primary-mid position-absolute top-0 end-0 m-3 rounded-pill px-3 shadow-sm">$ <?= number_format($m['presu'], 0) ?></span>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold mb-0"><?= e($m['nama_model']) ?></h5>
                            <small class="text-uppercase fw-bold text-muted" style="font-size: 0.7rem;"><?= e($m['marka']) ?></small>
                        </div>
                        <p class="text-muted small mb-4 line-clamp-2"><?= e($m['deskrisaun'] ?: 'Iha ne\'e ita bele haree spesifikasaun no kualidade husi motor foun ne\'e.') ?></p>
                        
                        <div class="mt-auto border-top pt-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-light rounded-circle p-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-store text-primary-mid" style="font-size: 0.8rem;"></i>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="small fw-bold mb-0 text-truncate"><?= e($m['nama_dealer'] ?: 'La iha Dealer') ?></p>
                                    <p class="text-muted" style="font-size: 0.65rem; margin: 0;"><?= e($m['dealer_address'] ?: 'Dili, Timor-Leste') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-4 pt-0">
                        <button class="btn btn-outline-primary-mid w-100 rounded-pill fw-bold" onclick="showMotorDetail(<?= $m['id'] ?>)">
                            Haree Detallu
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('motorSearch');
    const cards = document.querySelectorAll('.motor-card');
    const filterBtns = document.querySelectorAll('.filter-btn');

    // Search Filter
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        cards.forEach(card => {
            const name = card.querySelector('h5').innerText.toLowerCase();
            const brand = card.getAttribute('data-marka').toLowerCase();
            if (name.includes(query) || brand.includes(query)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Category Filter
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active', 'btn-primary-mid'));
            filterBtns.forEach(b => b.classList.add('btn-outline-secondary'));
            
            this.classList.remove('btn-outline-secondary');
            this.classList.add('active', 'btn-primary-mid');
            
            const filter = this.getAttribute('data-filter');
            cards.forEach(card => {
                if (filter === 'all' || card.getAttribute('data-marka') === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});

function showMotorDetail(id) {
    Swal.fire({
        title: 'Informasaun Adisionál',
        text: 'Servisu ne\'e sei dezenvolve hela. Ita-boot bele kontaktu dealer direitamente atu husu kona-ba motor ne\'e.',
        icon: 'info',
        confirmButtonText: 'Entende',
        confirmButtonColor: '#25285d'
    });
}
</script>

<style>
.card-hover { transition: all 0.3s ease; }
.card-hover:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important; }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.btn-primary-mid { background-color: #25285d; color: white; }
.btn-primary-mid:hover { background-color: #181b40; color: white; }
.btn-outline-primary-mid { border-color: #25285d; color: #25285d; }
.btn-outline-primary-mid:hover { background-color: #25285d; color: white; }
.text-primary-mid { color: #25285d; }
</style>

<?php include 'includes/footer.php'; ?>
