<?php
require_once '../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $foto = '';
    if (!empty($_FILES['foto']['name'])) {
        $foto = time() . '_' . $_FILES['foto']['name'];
        if (!is_dir('../assets/images/dealers')) {
            mkdir('../assets/images/dealers', 0777, true);
        }
        move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/images/dealers/' . $foto);
    }

    $stmt = $pdo->prepare("INSERT INTO dealer_motor (nama_dealer, marka, presu, alamat, latitude, longitude, jam_buka, telepon, email, facebook, instagram, deskripsi, foto) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute([
        $_POST['nama_dealer'], $_POST['marka'], $_POST['presu'], $_POST['alamat'],
        $_POST['latitude'], $_POST['longitude'], $_POST['jam_buka'],
        $_POST['telepon'], $_POST['email'], $_POST['facebook'], $_POST['instagram'],
        $_POST['deskripsi'], $foto
    ]);
    redirect('/dealer-motor-dili/admin/dealers.php?success=Dealer motor aumenta ho susesu!');
}
?>

<?php include 'includes/header.php'; ?>

<div class="page-header animate-up">
    <div class="d-flex align-items-center gap-3">
        <a href="dealers.php" class="btn btn-light rounded-circle p-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="page-title">Rejista Dellear Foun</h2>
            <p class="page-subtitle">Aumenta unidade foun ba rede dellear motor iha Dili.</p>
        </div>
    </div>
</div>

<div class="container-fluid px-3 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="section-card animate-up delay-1">
                <form method="POST" id="dealerForm" enctype="multipart/form-data">
                    <div class="row g-4">
                        <!-- Left Column: Form Fields -->
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-bold">Naran Dellear</label>
                                        <div class="input-group-custom">
                                            <i class="fas fa-motorcycle"></i>
                                            <input type="text" name="nama_dealer" class="form-control-custom" placeholder="Ex: Honda Motor Dili" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-bold">Marka Motor</label>
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
                                        <label class="form-label text-dark fw-bold">Oráriu Loke</label>
                                        <div class="input-group-custom">
                                            <i class="fas fa-clock"></i>
                                            <input type="text" name="jam_buka" class="form-control-custom" placeholder="Ex: 08:00 - 17:00" required value="08:00 - 17:00">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-bold">Atributu Presu (SAW)</label>
                                        <div class="input-group-custom">
                                            <i class="fas fa-dollar-sign"></i>
                                            <input type="number" step="any" name="presu" class="form-control-custom" placeholder="Ex: 2500" required>
                                        </div>
                                        <small class="text-muted">Valor hodi kalkula iha sistema SAW.</small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-bold">Enderesu Kompletu</label>
                                        <div class="input-group-custom">
                                            <i class="fas fa-map-marker-alt" style="top: 25px;"></i>
                                            <textarea name="alamat" class="form-control-custom" rows="2" placeholder="Ex: Rua Formosa, Dili" required style="padding-top: 12px;"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-bold">
                                            <i class="fas fa-map-location-dot me-1 text-primary"></i> Hili Lokasaun iha Mapa
                                        </label>
                                        <p class="text-muted small mb-2">Klik iha mapa atu hili lokasaun dealer nian. Kordenadas sei preenxe automatikamente.</p>
                                        <div id="mapPicker" style="height: 320px; border-radius: 16px; border: 3px solid #e0e7ff; box-shadow: 0 4px 24px rgba(99,102,241,0.10); z-index: 1;"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-bold">Latitude</label>
                                        <div class="input-group-custom">
                                            <i class="fas fa-location-crosshairs"></i>
                                            <input type="number" step="any" name="latitude" id="inputLatitude" class="form-control-custom" placeholder="Klik iha mapa..." required readonly style="background: #f0f4ff; cursor: pointer;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-bold">Longitude</label>
                                        <div class="input-group-custom">
                                            <i class="fas fa-location-dot"></i>
                                            <input type="number" step="any" name="longitude" id="inputLongitude" class="form-control-custom" placeholder="Klik iha mapa..." required readonly style="background: #f0f4ff; cursor: pointer;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-bold">Telefone</label>
                                        <div class="input-group-custom">
                                            <i class="fas fa-phone"></i>
                                            <input type="tel" name="telepon" class="form-control-custom" placeholder="Ex: +670 7700 0000">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-bold">Email</label>
                                        <div class="input-group-custom">
                                            <i class="fas fa-envelope"></i>
                                            <input type="email" name="email" class="form-control-custom" placeholder="Ex: info@dealer.com">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-bold">Facebook</label>
                                        <div class="input-group-custom">
                                            <i class="fab fa-facebook"></i>
                                            <input type="text" name="facebook" class="form-control-custom" placeholder="Ex: fb.com/dealer">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-bold">Instagram</label>
                                        <div class="input-group-custom">
                                            <i class="fab fa-instagram"></i>
                                            <input type="text" name="instagram" class="form-control-custom" placeholder="Ex: @dealer_motor">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label text-dark fw-bold">Deskrisaun / Deskrisaun Favoritu</label>
                                        <div class="input-group-custom">
                                            <i class="fas fa-info-circle" style="top: 25px;"></i>
                                            <textarea name="deskripsi" class="form-control-custom" rows="2" placeholder="Hatama informasaun adisionál..." style="padding-top: 12px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Info & Media -->
                        <div class="col-lg-4">
                            <div class="p-4 rounded-4 bg-light h-100 border border-white shadow-sm">
                                <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                                    <i class="fas fa-image text-primary"></i> Media & Info
                                </h5>
                                
                                <div class="mb-4">
                                    <label class="form-label text-dark fw-bold">Foto Dellear</label>
                                    <div class="input-group-custom">
                                        <i class="fas fa-camera"></i>
                                        <input type="file" name="foto" class="form-control-custom" accept="image/*">
                                    </div>
                                    <small class="text-muted d-block mt-2">Upload foto ne'ebé kualidade aas atu dada kliente nia atensaun.</small>
                                </div>

                                <hr class="my-4 opacity-5">

                                <div class="info-box p-3 rounded-3 bg-white border border-light mb-3">
                                    <h6 class="fw-bold text-primary mb-2"><i class="fas fa-lightbulb me-2"></i>Dika Utíl</h6>
                                    <p class="small text-muted mb-0">Uza koordinadas ne'ebé precizu husi Google Maps atu kliente bele buka dalan ho lójiku no lalais liu.</p>
                                </div>

                                <div class="info-box p-3 rounded-3 bg-white border border-light">
                                    <h6 class="fw-bold text-primary mb-2"><i class="fas fa-shield-halved me-2"></i>Seguransa Dadus</h6>
                                    <p class="small text-muted mb-0">Dadus ne'ebé ita-boot hatama sei salva ho seguru no mosu kedas iha kátalogu site kabeer nian.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4 pt-4 border-top">
                        <a href="dealers.php" class="btn btn-light rounded-pill px-4">Kansela</a>
                        <button type="submit" class="btn btn-purple-gradient rounded-pill px-5">
                            <i class="fas fa-save me-2"></i>Salva Dellear
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>
    #mapPicker { transition: box-shadow 0.3s ease; }
    #mapPicker:hover { box-shadow: 0 6px 32px rgba(99,102,241,0.18) !important; }
    .map-coord-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff; padding: 4px 12px; border-radius: 20px;
        font-size: 0.78rem; font-weight: 600;
        animation: coordPulse 0.4s ease;
    }
    @keyframes coordPulse {
        0% { transform: scale(0.9); opacity: 0.5; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// Form submit handler
document.getElementById('dealerForm').addEventListener('submit', function(e) {
    // Validate that coordinates are selected
    const lat = document.getElementById('inputLatitude').value;
    const lng = document.getElementById('inputLongitude').value;
    if (!lat || !lng) {
        e.preventDefault();
        alert('Favór klik iha mapa atu hili lokasaun dealer nian!');
        document.getElementById('mapPicker').scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    }
    const btn = this.querySelector('button[type="submit"]');
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Salva hela...';
    btn.style.opacity = '0.8';
    btn.style.pointerEvents = 'none';
});

// Initialize Leaflet Map Picker
document.addEventListener('DOMContentLoaded', function() {
    // Default center: Dili, Timor-Leste
    const defaultLat = -8.5569;
    const defaultLng = 125.5603;
    const defaultZoom = 14;

    const map = L.map('mapPicker', {
        center: [defaultLat, defaultLng],
        zoom: defaultZoom,
        scrollWheelZoom: true
    });

    // Tile layers
    const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap',
        maxZoom: 19
    });

    const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '&copy; Esri',
        maxZoom: 19
    });

    streetLayer.addTo(map);

    // Layer control
    L.control.layers({
        '🗺️ Estrada': streetLayer,
        '🛰️ Satélite': satelliteLayer
    }, null, { position: 'topright' }).addTo(map);

    // Custom marker icon
    const dealerIcon = L.divIcon({
        className: 'custom-map-pin',
        html: '<div style="background: linear-gradient(135deg, #6366f1, #ec4899); width: 36px; height: 36px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(99,102,241,0.4); border: 3px solid #fff;"><i class="fas fa-motorcycle" style="transform: rotate(45deg); color: #fff; font-size: 14px;"></i></div>',
        iconSize: [36, 36],
        iconAnchor: [18, 36],
        popupAnchor: [0, -36]
    });

    let marker = null;

    function setMarker(lat, lng) {
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], {
                icon: dealerIcon,
                draggable: true
            }).addTo(map);

            // Update coords when marker is dragged
            marker.on('dragend', function(e) {
                const pos = e.target.getLatLng();
                updateCoords(pos.lat, pos.lng);
            });
        }

        marker.bindPopup(
            '<div style="text-align:center; font-family: Outfit, sans-serif;">' +
            '<strong style="color: #6366f1;">📍 Lokasaun Hili ona</strong><br>' +
            '<small style="color: #666;">Lat: ' + lat.toFixed(8) + '<br>Lng: ' + lng.toFixed(8) + '</small><br>' +
            '<small style="color: #999;">Ita bele rasta marker atu ajusta</small>' +
            '</div>'
        ).openPopup();
    }

    function updateCoords(lat, lng) {
        document.getElementById('inputLatitude').value = lat.toFixed(8);
        document.getElementById('inputLongitude').value = lng.toFixed(8);

        // Visual feedback
        const latInput = document.getElementById('inputLatitude');
        const lngInput = document.getElementById('inputLongitude');
        latInput.style.background = '#e8f5e9';
        lngInput.style.background = '#e8f5e9';
        latInput.style.borderColor = '#4caf50';
        lngInput.style.borderColor = '#4caf50';
        setTimeout(() => {
            latInput.style.background = '#f0f4ff';
            lngInput.style.background = '#f0f4ff';
            latInput.style.borderColor = '';
            lngInput.style.borderColor = '';
        }, 1500);

        setMarker(lat, lng);
    }

    // Click on map to set coordinates
    map.on('click', function(e) {
        updateCoords(e.latlng.lat, e.latlng.lng);
    });

    // Fix map rendering inside hidden/collapsed containers
    setTimeout(() => { map.invalidateSize(); }, 300);
});
</script>

<?php include 'includes/footer.php'; ?>