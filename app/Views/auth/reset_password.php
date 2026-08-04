<?= $this->include('layout/header') ?>

<div class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card auth-card border-0 p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-shield-lock display-4 text-primary-custom"></i>
                        <h4 class="mt-2">Reset Your Password</h4>
                        <p class="text-muted small">Choose a new, strong password for your account.</p>
                    </div>
                    <form action="<?= base_url('reset-password') ?>" method="post" class="needs-validation" novalidate>
                        <?= csrf_field() ?>
                        <input type="hidden" name="token" value="<?= esc($token) ?>">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Password</label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <input type="password" name="confirm_password" class="form-control" required minlength="6">
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100 rounded-pill py-2">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>
