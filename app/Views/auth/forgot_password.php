<?= $this->include('layout/header') ?>

<div class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card auth-card border-0 p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-key display-4 text-primary-custom"></i>
                        <h4 class="mt-2">Forgot Password?</h4>
                        <p class="text-muted small">Enter your registered email and we'll send you a reset link.</p>
                    </div>
                    <form action="<?= base_url('forgot-password') ?>" method="post" class="needs-validation" novalidate>
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100 rounded-pill py-2">Send Reset Link</button>
                    </form>
                    <p class="text-center mt-4 mb-0 small"><a href="<?= base_url('login') ?>"><i class="bi bi-arrow-left"></i> Back to Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>
