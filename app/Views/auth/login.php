<?= $this->include('layout/header') ?>

<div class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card auth-card border-0">
                    <div class="row g-0">
                        <div class="col-md-5 auth-side d-none d-md-flex flex-column justify-content-center">
                            <i class="bi bi-shield-lock display-3 mb-3"></i>
                            <h3>Welcome Back</h3>
                            <p class="text-white-50">Login to track your applications, manage your profile, and get personalized loan offers.</p>
                        </div>
                        <div class="col-md-7 bg-white p-5">
                            <h4 class="mb-1">Login to LoanCalc</h4>
                            <p class="text-muted small mb-4">Demo: admin@loancalc.test / rahul.sharma@example.com — password: Password@123</p>

                            <form action="<?= base_url('login') ?>" method="post" class="needs-validation" novalidate>
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="passwordField" class="form-control" required minlength="6">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#passwordField"><i class="bi bi-eye"></i></button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember">
                                        <label class="form-check-label small" for="remember">Remember me</label>
                                    </div>
                                    <a href="<?= base_url('forgot-password') ?>" class="small">Forgot Password?</a>
                                </div>
                                <button type="submit" class="btn btn-primary-custom w-100 rounded-pill py-2">Login <i class="bi bi-box-arrow-in-right ms-1"></i></button>
                            </form>

                            <p class="text-center mt-4 mb-0 small">Don't have an account? <a href="<?= base_url('register') ?>" class="fw-semibold">Register here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>
