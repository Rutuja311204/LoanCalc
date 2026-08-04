<footer class="footer-custom mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="text-white mb-3"><i class="bi bi-bank2"></i> Loan<span class="text-primary-custom">Calc</span></h5>
                <p class="text-white-50">Smart, transparent and fast loan calculations & applications — inspired by India's leading banks.</p>
                <div class="d-flex gap-3 fs-5">
                    <a href="#" class="text-white-50"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white-50"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-white-50"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="text-white-50"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="text-white mb-3">Quick Links</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="<?= base_url('/') ?>">Home</a></li>
                    <li><a href="<?= base_url('emi-calculator') ?>">EMI Calculator</a></li>
                    <li><a href="<?= base_url('loan-comparison') ?>">Compare Loans</a></li>
                    <li><a href="<?= base_url('apply-loan') ?>">Apply Loan</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="text-white mb-3">Company</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="<?= base_url('about') ?>">About Us</a></li>
                    <li><a href="<?= base_url('contact') ?>">Contact</a></li>
                    <li><a href="<?= base_url('login') ?>">Login</a></li>
                    <li><a href="<?= base_url('register') ?>">Register</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h6 class="text-white mb-3">Contact Us</h6>
                <ul class="list-unstyled footer-links">
                    <li><i class="bi bi-geo-alt me-2"></i>LoanCalc Towers, BKC, Mumbai, India</li>
                    <li><i class="bi bi-telephone me-2"></i>+91 1800-123-4567</li>
                    <li><i class="bi bi-envelope me-2"></i>support@loancalc.test</li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary my-4">
        <div class="text-center text-white-50 small">
            &copy; <?= date('Y') ?> LoanCalc. All rights reserved. | Demo project built with CodeIgniter 4.
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<!-- App JS -->
<script src="<?= base_url('assets/js/main.js') ?>"></script>
<?= $extraJs ?? '' ?>

</body>
</html>
