<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-lg-3 col-xl-2"><?= $this->include('layout/sidebar_admin') ?></div>

            <div class="col-lg-9 col-xl-10">
                <h4 class="mb-4"><i class="bi bi-bank"></i> Partner Banks</h4>
                <div class="card card-custom p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr><th>Bank</th><th>Code</th><th>Interest Rate Range</th><th>Processing Fee</th><th>Status</th></tr>
                            </thead>
                            <tbody>
                            <?php foreach ($banks as $bank) : ?>
                                <tr>
                                    <td><?= esc($bank['bank_name']) ?></td>
                                    <td><span class="badge bg-secondary"><?= esc($bank['bank_code']) ?></span></td>
                                    <td><?= number_format($bank['interest_rate_min'], 2) ?>% - <?= number_format($bank['interest_rate_max'], 2) ?>%</td>
                                    <td><?= number_format($bank['processing_fee_percent'], 2) ?>%</td>
                                    <td><span class="badge <?= $bank['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>"><?= esc(ucfirst($bank['status'])) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('layout/footer') ?>
