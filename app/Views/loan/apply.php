<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <span class="section-badge">Apply Online</span>
            <h2 class="mt-3">Apply for a Loan</h2>
            <div class="divider-accent mx-auto mt-2"></div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 fade-in-up">
                <?php if (! session()->get('isLoggedIn')) : ?>
                    <div class="alert alert-warning d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle-fill fs-4"></i>
                        <div>You need to <a href="<?= base_url('login') ?>" class="fw-semibold">login</a> or <a href="<?= base_url('register') ?>" class="fw-semibold">create an account</a> before submitting a loan application.</div>
                    </div>
                <?php endif; ?>

                <div class="card card-custom p-4">
                    <form action="<?= base_url('apply-loan') ?>" method="post" class="row g-3 needs-validation" novalidate>
                        <?= csrf_field() ?>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Loan Type</label>
                            <select name="loan_type_id" class="form-select" required>
                                <option value="">Select loan type</option>
                                <?php foreach ($loanTypes as $type) : ?>
                                    <option value="<?= $type['id'] ?>"><?= esc($type['name']) ?> (from <?= number_format($type['base_interest_rate'], 2) ?>%)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Preferred Bank</label>
                            <select name="bank_id" class="form-select" required>
                                <option value="">Select bank</option>
                                <?php foreach ($banks as $bank) : ?>
                                    <option value="<?= $bank['id'] ?>"><?= esc($bank['bank_name']) ?> (<?= number_format($bank['interest_rate_min'], 2) ?>%)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Loan Amount (₹)</label>
                            <input type="number" name="loan_amount" class="form-control" min="10000" step="1000" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tenure (Months)</label>
                            <input type="number" name="tenure_months" class="form-control" min="6" max="360" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Monthly Income (₹)</label>
                            <input type="number" name="monthly_income" class="form-control" min="1" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Employment Type</label>
                            <select name="employment_type" class="form-select" required>
                                <option value="salaried">Salaried</option>
                                <option value="self_employed">Self-Employed</option>
                                <option value="business">Business Owner</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Purpose of Loan</label>
                            <textarea name="purpose" class="form-control" rows="3" placeholder="E.g. Home renovation, business expansion..."></textarea>
                        </div>

                        <div class="col-12 form-check mt-2">
                            <input type="checkbox" class="form-check-input" id="agreeTerms" required>
                            <label class="form-check-label small" for="agreeTerms">I agree to the terms & conditions and consent to LoanCalc processing my information for this application.</label>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary-custom w-100 rounded-pill py-2" <?= session()->get('isLoggedIn') ? '' : 'disabled' ?>>
                                <i class="bi bi-send-check me-2"></i>Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('layout/footer') ?>
