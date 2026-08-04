<?= $this->include('layout/header') ?>

<!-- ================= HERO ================= -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-7 fade-in-up">
                <span class="badge bg-white text-primary-custom mb-3 px-3 py-2 rounded-pill fw-semibold">
                    <i class="bi bi-shield-check"></i> RBI-style transparent lending, simulated
                </span>
                <h1 class="fw-bold mb-3">Smart Loans. Simple EMIs.<br>Real Peace of Mind.</h1>
                <p class="fs-5 text-white-50 mb-4">Calculate your EMI in seconds, compare offers from top banks, and apply for your loan online — all in one place.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= base_url('emi-calculator') ?>" class="btn btn-accent btn-lg rounded-pill px-4"><i class="bi bi-calculator me-2"></i>Calculate EMI</a>
                    <a href="<?= base_url('apply-loan') ?>" class="btn btn-outline-light btn-lg rounded-pill px-4">Apply for a Loan</a>
                </div>
                <div class="row hero-stats mt-5 g-3">
                    <div class="col-4"><div class="stat-box text-center"><h3 class="mb-0">50K+</h3><small>Loans Disbursed</small></div></div>
                    <div class="col-4"><div class="stat-box text-center"><h3 class="mb-0">5</h3><small>Partner Banks</small></div></div>
                    <div class="col-4"><div class="stat-box text-center"><h3 class="mb-0">8.4%</h3><small>Starting Rate</small></div></div>
                </div>
            </div>
            <div class="col-lg-5 fade-in-up">
                <div class="card card-custom p-4">
                    <h5 class="mb-3"><i class="bi bi-lightning-charge-fill text-warning"></i> Quick EMI Estimate</h5>
                    <p class="text-muted small">Try it now — full calculator with charts awaits on the EMI Calculator page.</p>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Loan Amount</label>
                        <input type="range" class="form-range" min="10000" max="5000000" step="10000" id="quickPrincipal" value="500000">
                        <div class="text-primary-custom fw-bold" id="quickPrincipalVal">₹5,00,000</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Tenure (Months)</label>
                        <input type="range" class="form-range" min="6" max="360" step="6" id="quickTenure" value="60">
                        <div class="text-primary-custom fw-bold" id="quickTenureVal">60 months</div>
                    </div>
                    <div class="emi-result-card p-3 text-center mt-2">
                        <small>Estimated Monthly EMI</small>
                        <h2 class="mb-0" id="quickEmiVal">₹0</h2>
                    </div>
                    <a href="<?= base_url('emi-calculator') ?>" class="btn btn-primary-custom w-100 mt-3 rounded-pill">Get Full Breakdown</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= LOAN TYPES ================= -->
<section class="py-5 mt-4">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <span class="section-badge">Our Loan Products</span>
            <h2 class="mt-3">Choose the Right Loan for You</h2>
            <div class="divider-accent mx-auto mt-2"></div>
        </div>
        <div class="row g-4">
            <?php foreach ($loanTypes as $type) : ?>
                <div class="col-md-6 col-lg-4 fade-in-up">
                    <div class="card card-custom h-100 p-4">
                        <div class="loan-type-icon mb-3"><i class="bi <?= esc($type['icon']) ?>"></i></div>
                        <h5><?= esc($type['name']) ?></h5>
                        <p class="text-muted small"><?= esc($type['description']) ?></p>
                        <div class="d-flex justify-content-between small text-muted mb-3">
                            <span>From <?= number_format($type['base_interest_rate'], 2) ?>%</span>
                            <span>Up to ₹<?= number_format($type['max_amount'] / 100000, 1) ?>L</span>
                        </div>
                        <a href="<?= base_url('apply-loan') ?>" class="btn btn-outline-primary-custom border rounded-pill mt-auto">Apply Now <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ================= HOW IT WORKS ================= -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <span class="section-badge">Simple Process</span>
            <h2 class="mt-3">How LoanCalc Works</h2>
            <div class="divider-accent mx-auto mt-2"></div>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-3 fade-in-up">
                <div class="step-circle mx-auto mb-3">1</div>
                <h6>Calculate EMI</h6>
                <p class="text-muted small">Use our smart calculator to estimate your monthly payments.</p>
            </div>
            <div class="col-md-3 fade-in-up">
                <div class="step-circle mx-auto mb-3">2</div>
                <h6>Compare Banks</h6>
                <p class="text-muted small">See offers side-by-side from 5 leading banks.</p>
            </div>
            <div class="col-md-3 fade-in-up">
                <div class="step-circle mx-auto mb-3">3</div>
                <h6>Apply Online</h6>
                <p class="text-muted small">Submit your application in minutes, fully online.</p>
            </div>
            <div class="col-md-3 fade-in-up">
                <div class="step-circle mx-auto mb-3">4</div>
                <h6>Track Status</h6>
                <p class="text-muted small">Real-time updates from application to disbursement.</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= PARTNER BANKS ================= -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-4 fade-in-up">
            <span class="section-badge">Trusted Partners</span>
            <h2 class="mt-3">Our Partner Banks</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ($banks as $bank) : ?>
                <div class="col-6 col-md-2 text-center fade-in-up">
                    <div class="card card-custom p-3">
                        <i class="bi bi-bank display-6 text-primary-custom"></i>
                        <div class="fw-semibold small mt-2"><?= esc($bank['bank_name']) ?></div>
                        <div class="text-muted small"><?= number_format($bank['interest_rate_min'], 2) ?>%+</div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php $extraJs = '<script>
    const qp = document.getElementById("quickPrincipal");
    const qt = document.getElementById("quickTenure");
    const qpVal = document.getElementById("quickPrincipalVal");
    const qtVal = document.getElementById("quickTenureVal");
    const qEmi = document.getElementById("quickEmiVal");

    function quickCalc() {
        const principal = parseFloat(qp.value);
        const months = parseInt(qt.value, 10);
        const rate = 10.5;
        const monthlyRate = (rate/12)/100;
        const factor = Math.pow(1+monthlyRate, months);
        const emi = (principal * monthlyRate * factor) / (factor - 1);
        qpVal.textContent = formatCurrency(principal);
        qtVal.textContent = months + " months";
        qEmi.textContent = formatCurrency(emi);
    }
    qp.addEventListener("input", quickCalc);
    qt.addEventListener("input", quickCalc);
    quickCalc();
</script>' ?>
<?= $this->include('layout/footer') ?>
