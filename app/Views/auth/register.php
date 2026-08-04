<?= $this->include('layout/header') ?>

<div class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card auth-card border-0">
                    <div class="row g-0">
                        <div class="col-md-5 auth-side d-none d-md-flex flex-column justify-content-center order-md-2">
                            <i class="bi bi-person-check display-3 mb-3"></i>
                            <h3>Join LoanCalc</h3>
                            <p class="text-white-50">Create your free account to apply for loans and track their status in real time.</p>
                        </div>
                        <div class="col-md-7 bg-white p-5 order-md-1">
                            <h4 class="mb-1">Create an Account</h4>
                            <p class="text-muted small mb-4">It only takes a minute.</p>

                            <form action="<?= base_url('register') ?>" method="post" class="row g-3 needs-validation" novalidate>
                                <?= csrf_field() ?>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <input type="text" name="full_name" class="form-control" value="<?= old('full_name') ?>" required minlength="3">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="<?= old('phone') ?>" required minlength="10" maxlength="15">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Password</label>
                                    <input type="password" name="password" class="form-control" required minlength="6">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" required minlength="6">
                                </div>
                                <div class="col-12 form-check">
                                    <input type="checkbox" class="form-check-input" id="agreeReg" required>
                                    <label class="form-check-label small" for="agreeReg">I agree to the Terms of Service and Privacy Policy.</label>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary-custom w-100 rounded-pill py-2">Create Account <i class="bi bi-person-plus ms-1"></i></button>
                                </div>
                            </form>

                            <p class="text-center mt-4 mb-0 small">Already have an account? <a href="<?= base_url('login') ?>" class="fw-semibold">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>
