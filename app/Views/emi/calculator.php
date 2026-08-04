<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <span class="section-badge">EMI Calculator</span>
            <h2 class="mt-3">Calculate Your Loan EMI Instantly</h2>
            <div class="divider-accent mx-auto mt-2"></div>
        </div>

        <div class="row g-4">
            <!-- Calculator Form -->
            <div class="col-lg-6 fade-in-up">
                <div class="card card-custom p-4">
                    <form id="emiForm">
                        <div class="mb-4">
                            <label class="form-label fw-semibold d-flex justify-content-between">Loan Amount <span class="text-primary-custom">₹<span id="principalDisplay">5,00,000</span></span></label>
                            <input type="number" class="form-control mb-2" id="principal" value="500000" min="10000" max="10000000" step="1000">
                            <input type="range" class="form-range" id="principalRange" min="10000" max="10000000" step="1000" value="500000">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold d-flex justify-content-between">Interest Rate (% p.a.) <span class="text-primary-custom"><span id="rateDisplay">10.5</span>%</span></label>
                            <input type="number" class="form-control mb-2" id="interestRate" value="10.5" min="1" max="30" step="0.05">
                            <input type="range" class="form-range" id="interestRateRange" min="1" max="30" step="0.05" value="10.5">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold d-flex justify-content-between">Tenure (Months) <span class="text-primary-custom"><span id="tenureDisplay">60</span> mo</span></label>
                            <input type="number" class="form-control mb-2" id="tenureMonths" value="60" min="6" max="360" step="1">
                            <input type="range" class="form-range" id="tenureRange" min="6" max="360" step="1" value="60">
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100 rounded-pill py-2"><i class="bi bi-calculator me-2"></i>Calculate EMI</button>
                    </form>
                </div>
            </div>

            <!-- Results -->
            <div class="col-lg-6 fade-in-up">
                <div class="card card-custom p-4 h-100">
                    <div class="row text-center g-3 mb-4">
                        <div class="col-4">
                            <small class="text-muted d-block">Principal</small>
                            <h5 id="principalResult">₹0</h5>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">Total Interest</small>
                            <h5 id="totalInterestResult" class="text-danger">₹0</h5>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">Total Payment</small>
                            <h5 id="totalPaymentResult">₹0</h5>
                        </div>
                    </div>
                    <canvas id="emiChart" height="220"></canvas>
                    <div class="emi-result-card p-3 text-center mt-4">
                        <small>Your Monthly EMI</small>
                        <h2 class="mb-0" id="emiResult">₹0</h2>
                    </div>
                    <a href="<?= base_url('apply-loan') ?>" class="btn btn-accent w-100 mt-3 rounded-pill">Apply for this Loan <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Amortization Schedule -->
        <div class="card card-custom p-4 mt-5 fade-in-up">
            <h5 class="mb-3"><i class="bi bi-table"></i> Amortization Schedule</h5>
            <div class="table-responsive" style="max-height:420px; overflow-y:auto;">
                <table class="table table-hover table-schedule align-middle mb-0">
                    <thead>
                        <tr><th>Month</th><th>EMI</th><th>Principal</th><th>Interest</th><th>Balance</th></tr>
                    </thead>
                    <tbody id="scheduleBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php $extraJs = '<script src="' . base_url('assets/js/emi-calculator.js') . '"></script>
<script>
    ["principal","interestRate","tenureMonths"].forEach(function(id){
        const el = document.getElementById(id);
        const displayMap = {principal:"principalDisplay", interestRate:"rateDisplay", tenureMonths:"tenureDisplay"};
        el.addEventListener("input", function(){
            document.getElementById(displayMap[id]).textContent = id === "principal" ? Number(el.value).toLocaleString("en-IN") : el.value;
        });
    });
</script>' ?>
<?= $this->include('layout/footer') ?>
