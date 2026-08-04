<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <span class="section-badge">Compare & Save</span>
            <h2 class="mt-3">Compare Loan Offers Across Banks</h2>
            <div class="divider-accent mx-auto mt-2"></div>
        </div>

        <div class="card card-custom p-4 mb-5 fade-in-up">
            <form id="compareForm" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Loan Amount (₹)</label>
                    <input type="number" class="form-control" id="cmpPrincipal" value="1000000" min="10000" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Tenure (Months)</label>
                    <input type="number" class="form-control" id="cmpTenure" value="120" min="6" max="360" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary-custom w-100 rounded-pill"><i class="bi bi-search"></i> Compare</button>
                </div>
            </form>
        </div>

        <div id="compareResultsWrap" class="d-none fade-in-up">
            <div class="card card-custom p-4 mb-4">
                <canvas id="compareChart" height="100"></canvas>
            </div>
            <div class="card card-custom p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Bank</th><th>Interest Rate</th><th>Monthly EMI</th>
                                <th>Total Interest</th><th>Total Payment</th><th>Processing Fee</th>
                            </tr>
                        </thead>
                        <tbody id="compareResultsBody"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Static bank list for quick reference -->
        <div class="row g-4 mt-5">
            <?php foreach ($banks as $bank) : ?>
                <div class="col-md-6 col-lg-4 fade-in-up">
                    <div class="card card-custom p-4">
                        <h6><i class="bi bi-bank2 text-primary-custom"></i> <?= esc($bank['bank_name']) ?></h6>
                        <div class="d-flex justify-content-between small text-muted mt-2">
                            <span>Rate: <?= number_format($bank['interest_rate_min'], 2) ?>% - <?= number_format($bank['interest_rate_max'], 2) ?>%</span>
                            <span>Fee: <?= number_format($bank['processing_fee_percent'], 2) ?>%</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php $extraJs = '<script src="' . base_url('assets/js/loan-comparison.js') . '"></script>' ?>
<?= $this->include('layout/footer') ?>
