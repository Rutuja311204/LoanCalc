<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-lg-3 col-xl-2"><?= $this->include('layout/sidebar_admin') ?></div>

            <div class="col-lg-9 col-xl-10">
                <h4 class="mb-4"><i class="bi bi-tags"></i> Loan Types</h4>
                <div class="row g-4">
                    <?php foreach ($loanTypes as $type) : ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-custom p-4">
                                <div class="loan-type-icon mb-3"><i class="bi <?= esc($type['icon']) ?>"></i></div>
                                <h6><?= esc($type['name']) ?></h6>
                                <p class="text-muted small"><?= esc($type['description']) ?></p>
                                <ul class="list-unstyled small text-muted mb-0">
                                    <li>Amount: ₹<?= number_format($type['min_amount']) ?> - ₹<?= number_format($type['max_amount']) ?></li>
                                    <li>Tenure: <?= $type['min_tenure_months'] ?> - <?= $type['max_tenure_months'] ?> months</li>
                                    <li>Base Rate: <?= number_format($type['base_interest_rate'], 2) ?>%</li>
                                    <li>Status: <span class="badge <?= $type['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>"><?= esc(ucfirst($type['status'])) ?></span></li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('layout/footer') ?>
