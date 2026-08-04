<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-lg-3 col-xl-2"><?= $this->include('layout/sidebar_admin') ?></div>

            <div class="col-lg-9 col-xl-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0"><i class="bi bi-file-earmark-text"></i> Loan Applications</h4>
                    <a href="<?= base_url('admin/reports/export') ?>" class="btn btn-outline-primary-custom border rounded-pill btn-sm"><i class="bi bi-download"></i> Export CSV</a>
                </div>

                <div class="card card-custom p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr><th>App No.</th><th>Applicant</th><th>Type</th><th>Bank</th><th>Amount</th><th>EMI</th><th>Status</th><th>Applied</th><th></th></tr>
                            </thead>
                            <tbody>
                            <?php foreach ($applications as $app) : ?>
                                <tr>
                                    <td>#<?= esc($app['application_no']) ?></td>
                                    <td><?= esc($app['full_name']) ?></td>
                                    <td><?= esc($app['loan_type_name']) ?></td>
                                    <td><?= esc($app['bank_name']) ?></td>
                                    <td>₹<?= number_format($app['loan_amount']) ?></td>
                                    <td>₹<?= number_format($app['emi_amount']) ?></td>
                                    <td><span class="badge badge-<?= esc($app['current_status']) ?>"><?= esc(ucfirst(str_replace('_', ' ', $app['current_status']))) ?></span></td>
                                    <td><?= date('d M Y', strtotime($app['created_at'])) ?></td>
                                    <td><a href="<?= base_url('admin/loans/view/' . $app['id']) ?>" class="btn btn-sm btn-outline-primary-custom border">Review</a></td>
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
