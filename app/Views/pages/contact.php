<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <span class="section-badge">Get in Touch</span>
            <h2 class="mt-3">Contact Us</h2>
            <div class="divider-accent mx-auto mt-2"></div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 fade-in-up">
                <div class="card card-custom p-4 mb-3">
                    <i class="bi bi-geo-alt fs-3 text-primary-custom mb-2"></i>
                    <h6>Head Office</h6>
                    <p class="text-muted small mb-0">LoanCalc Towers, Bandra Kurla Complex, Mumbai, India - 400051</p>
                </div>
                <div class="card card-custom p-4 mb-3">
                    <i class="bi bi-telephone fs-3 text-primary-custom mb-2"></i>
                    <h6>Call Us</h6>
                    <p class="text-muted small mb-0">+91 1800-123-4567 (Toll-Free)</p>
                </div>
                <div class="card card-custom p-4">
                    <i class="bi bi-envelope fs-3 text-primary-custom mb-2"></i>
                    <h6>Email Us</h6>
                    <p class="text-muted small mb-0">support@loancalc.test</p>
                </div>
            </div>

            <div class="col-lg-8 fade-in-up">
                <div class="card card-custom p-4">
                    <h5 class="mb-3">Send us a Message</h5>
                    <form action="<?= base_url('contact') ?>" method="post" class="row g-3 needs-validation" novalidate>
                        <?= csrf_field() ?>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control" value="<?= old('name') ?>" required minlength="3">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="<?= old('phone') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Subject</label>
                            <input type="text" name="subject" class="form-control" value="<?= old('subject') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Message</label>
                            <textarea name="message" class="form-control" rows="5" required minlength="10"><?= old('message') ?></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary-custom rounded-pill px-4"><i class="bi bi-send me-2"></i>Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('layout/footer') ?>
