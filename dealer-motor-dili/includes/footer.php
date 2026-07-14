    </main>

   </div><!-- end main-content -->

<!-- FOOTER START -->
<footer class="footer-modern py-4 bg-dark text-white">
    <div class="container">
        <div class="row g-4">
            <!-- About Column -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-info">
                    <h4 class="fw-bold mb-3">Dealer<span class="text-primary-mid"> Motor</span></h4>
                    <p class="text-secondary mb-4">
                        <?= __('footer_desc') ?>
                    </p>
                    <div class="social-links d-flex gap-3">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6">
                <h5 class="fw-bold mb-3"><?= __('navigation') ?></h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="index.php"><i class="fas fa-chevron-right me-2"></i><?= __('start') ?></a></li>
                    <li><a href="motor.php"><i class="fas fa-chevron-right me-2"></i><?= __('motor_list') ?></a></li>
                    <li><a href="about.php"><i class="fas fa-chevron-right me-2"></i><?= __('about_us') ?></a></li>
                    <li><a href="contact.php"><i class="fas fa-chevron-right me-2"></i><?= __('contact') ?></a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6">
                <h5 class="fw-bold mb-3"><?= __('contact') ?></h5>
                <div class="contact-item d-flex mb-3">
                    <div class="contact-icon me-3">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-secondary">Dili, Timor-Leste</p>
                    </div>
                </div>
                <div class="contact-item d-flex mb-3">
                    <div class="contact-icon me-3">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-secondary">+670 7XX XXXX</p>
                    </div>
                </div>
                <div class="contact-item d-flex mb-3">
                    <div class="contact-icon me-3">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <p class="mb-0 text-secondary">info@motordili.tl</p>
                    </div>
                </div>
            </div>

            <!-- Newsletter/Business Hours -->
            <div class="col-lg-3 col-md-6">
                <h5 class="fw-bold mb-3"><?= __('working_hours_title') ?></h5>
                <ul class="list-unstyled text-secondary">
                    <li class="d-flex justify-content-between mb-2">
                        <span><?= __('monday_saturday') ?>:</span>
                        <span>08:00 - 17:00</span>
                    </li>
                    <li class="d-flex justify-content-between mb-2">
                        <span><?= __('sunday') ?>:</span>
                        <span class="text-danger"><?= __('closed') ?></span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4 border-secondary opacity-25">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 text-secondary small">
                    © 2026 <strong>Dealer Motor Dili</strong>. <?= __('all_rights_reserved') ?>
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <p class="mb-0 text-secondary small">
                    <?= __('developed_by') ?> <a href="#" class="text-white text-decoration-none fw-bold">L.Gusmão</a>
                </p>
            </div>
        </div>
    </div>
</footer>
<!-- FOOTER END -->
    <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

    <!-- CHATBOT WIDGET -->
    <?php include_once __DIR__ . '/chatbot.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 1000, once: true });</script>
    <script src="assets/js/main.js"></script>
</body>
</html>
