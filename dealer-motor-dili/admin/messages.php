<?php
require_once '../config/database.php';
if (!isLoggedIn()) redirect('/dealer-motor-dili/admin/login.php');

// Fetch all messages ordered by newest first
$stmt = $pdo->query("SELECT * FROM messages ORDER BY id DESC");
$messages = $stmt->fetchAll();
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
                    <div class="p-2 bg-light rounded-3 text-primary">
                        <i class="fas fa-envelope fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-dark">Komentariu / Mensajen</h4>
                        <p class="text-muted small mb-0">Jere komentáriu no sujestaun sira ne'ebé submete husi kliente.</p>
                    </div>
                </div>
                <div>
                    <span class="badge rounded-pill px-4 py-2 bg-purple-gradient" style="font-size: 0.9rem;">
                        <?= count($messages) ?> Mensajen
                    </span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">No</th>
                            <th>Kliente (Naran & Email)</th>
                            <th>Assuntu</th>
                            <th>Mensajen</th>
                            <th>Data Submete</th>
                            <th class="text-center" width="150">Aksaun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($messages as $m): ?>
                        <tr>
                            <td class="text-center fw-medium"><?= $no++ ?></td>
                            <td>
                                <div class="fw-bold text-dark mb-0"><?= e($m['name']) ?></div>
                                <a href="mailto:<?= e($m['email']) ?>" class="small text-decoration-none text-muted">
                                    <i class="far fa-envelope me-1"></i><?= e($m['email']) ?>
                                </a>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark"><?= e($m['subject']) ?></div>
                            </td>
                            <td class="text-muted small" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?= e($m['message']) ?>
                            </td>
                            <td>
                                <div class="small text-muted">
                                    <i class="far fa-clock me-1"></i><?= date('d M Y, H:i', strtotime($m['created_at'])) ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn-action-view" style="background: #0d6efd;" title="Haree Detalhe" onclick='viewMessage(<?= json_encode($m) ?>)'>
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="javascript:void(0)" class="btn-action-reply" title="Reply via Gmail" onclick='replyViaGmail(<?= json_encode($m["email"]) ?>, <?= json_encode($m["subject"]) ?>, <?= json_encode($m["name"]) ?>, <?= json_encode($m["message"]) ?>)'>
                                        <i class="fas fa-reply"></i>
                                    </a>
                                    <button class="btn-action-delete" style="background: #dc3545;" title="Hamoos" onclick='deleteMessage(<?= $m["id"] ?>, <?= json_encode($m["name"]) ?>)'>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if(empty($messages)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-envelope-open fs-1 d-block mb-3 text-secondary"></i>
                                Laiha mensajen ka komentáriu husi kliente.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<!-- Message Detail Modal -->
<div class="modal fade" id="messageDetailModal" tabindex="-1" aria-labelledby="messageDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-purple-gradient text-white border-0 py-3 px-4 rounded-top-4">
                <h5 class="modal-title fw-bold" id="messageDetailModalLabel">
                    <i class="fas fa-envelope-open me-2"></i> Detalhe Mensajen
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-6 border-end">
                        <small class="text-uppercase text-muted fw-bold d-block" style="font-size: 0.75rem;">Husi / Sender</small>
                        <h5 class="fw-bold text-dark mb-1" id="modalSenderName"></h5>
                        <a href="" id="modalSenderEmailLink" class="text-decoration-none text-primary">
                            <i class="far fa-envelope me-1"></i><span id="modalSenderEmail"></span>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <small class="text-uppercase text-muted fw-bold d-block" style="font-size: 0.75rem;">Data / Time Received</small>
                        <h6 class="text-dark fw-semibold" id="modalDate"></h6>
                        <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Submete husi formuláriu kontaktu</small>
                    </div>
                </div>

                <div class="mb-4">
                    <small class="text-uppercase text-muted fw-bold d-block mb-2" style="font-size: 0.75rem;">Assuntu / Subject</small>
                    <div class="p-3 bg-light rounded-3 fw-bold text-dark border-start border-4 border-primary" id="modalSubject"></div>
                </div>

                <div>
                    <small class="text-uppercase text-muted fw-bold d-block mb-2" style="font-size: 0.75rem;">Konteúdu Mensajen / Message</small>
                    <div class="p-4 bg-light rounded-3 text-dark style-message-body" style="white-space: pre-wrap; font-size: 1rem; line-height: 1.6;" id="modalContent"></div>
                </div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4">
                <a href="" id="replyBtn" target="_blank" class="btn btn-purple-gradient rounded-3 px-4 fw-semibold me-auto">
                    <i class="fab fa-google me-2"></i>Responde via Gmail
                </a>
                <button type="button" class="btn btn-secondary rounded-3 px-4 fw-semibold" data-bs-dismiss="modal">Taka</button>
            </div>
        </div>
    </div>
</div>

<style>
.style-message-body {
    border: 1px solid #e9ecef;
    min-height: 150px;
    background: #f8fafc !important;
}
.rounded-top-4 {
    border-top-left-radius: 16px !important;
    border-top-right-radius: 16px !important;
}
.btn-action-reply {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    border: none;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.85rem;
    text-decoration: none;
    background: linear-gradient(135deg, #34a853, #0f9d58);
    box-shadow: 0 3px 10px rgba(52, 168, 83, 0.3);
}
.btn-action-reply:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(52, 168, 83, 0.4);
    color: #fff;
}
</style>

<script>
function buildGmailUrl(email, subject, name, message) {
    const replySubject = 'Re: ' + subject;
    const replyBody = 'Olá ' + name + ',\n\nObrigadu ba ita-boot nia mensajen.\n\n---\nMensajen Orijnál:\n' + message;
    return 'https://mail.google.com/mail/?view=cm&fs=1'
        + '&to=' + encodeURIComponent(email)
        + '&su=' + encodeURIComponent(replySubject)
        + '&body=' + encodeURIComponent(replyBody);
}

function replyViaGmail(email, subject, name, message) {
    window.open(buildGmailUrl(email, subject, name, message), '_blank');
}

function viewMessage(data) {
    document.getElementById('modalSenderName').innerText = data.name;
    document.getElementById('modalSenderEmail').innerText = data.email;
    document.getElementById('modalSenderEmailLink').href = 'mailto:' + data.email;
    document.getElementById('modalSubject').innerText = data.subject;
    document.getElementById('modalContent').innerText = data.message;
    document.getElementById('replyBtn').href = buildGmailUrl(data.email, data.subject, data.name, data.message);
    
    // Formatting date
    const date = new Date(data.created_at);
    const options = { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' };
    document.getElementById('modalDate').innerText = date.toLocaleString('pt-PT', options);
    
    // Show modal
    var myModal = new bootstrap.Modal(document.getElementById('messageDetailModal'));
    myModal.show();
}

function deleteMessage(id, name) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Ita-boot serteza?',
            text: "Atu apaga mensajen husi: " + name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sim, Apaga!',
            cancelButtonText: 'Kansela'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'delete_message.php?id=' + id;
            }
        });
    } else {
        if (confirm("Ita-boot serteza atu apaga mensajen husi: " + name + "?")) {
            window.location.href = 'delete_message.php?id=' + id;
        }
    }
}
</script>

<?php include 'includes/footer.php'; ?>
