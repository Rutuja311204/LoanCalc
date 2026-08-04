<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-lg-3 col-xl-2"><?= $this->include('layout/sidebar_admin') ?></div>

            <div class="col-lg-9 col-xl-10">
                <h4 class="mb-1">Admin Dashboard</h4>
                <p class="text-muted mb-4">Overview of loan applications, users, and portal activity.</p>

                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3"><div class="stat-card bg-1"><h3 class="mb-0"><?= $stats['total_users'] ?></h3><small>Total Users</small></div></div>
                    <div class="col-6 col-md-3"><div class="stat-card bg-2"><h3 class="mb-0"><?= $stats['total_applications'] ?></h3><small>Applications</small></div></div>
                    <div class="col-6 col-md-3"><div class="stat-card bg-4"><h3 class="mb-0"><?= $stats['pending'] + $stats['under_review'] ?></h3><small>Pending Review</small></div></div>
                    <div class="col-6 col-md-3"><div class="stat-card bg-3"><h3 class="mb-0">₹<?= number_format($stats['total_loan_amount'] / 100000, 1) ?>L</h3><small>Total Loan Volume</small></div></div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-4"><div class="card card-custom p-3 text-center"><i class="bi bi-check-circle-fill text-success fs-3"></i><h4 class="mt-2 mb-0"><?= $stats['approved'] ?></h4><small class="text-muted">Approved</small></div></div>
                    <div class="col-md-4"><div class="card card-custom p-3 text-center"><i class="bi bi-x-circle-fill text-danger fs-3"></i><h4 class="mt-2 mb-0"><?= $stats['rejected'] ?></h4><small class="text-muted">Rejected</small></div></div>
                    <div class="col-md-4"><div class="card card-custom p-3 text-center"><i class="bi bi-envelope-fill text-primary-custom fs-3"></i><h4 class="mt-2 mb-0"><?= $stats['unread_messages'] ?></h4><small class="text-muted">Unread Messages</small></div></div>
                </div>

                <div class="card card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Recent Loan Applications</h6>
                        <a href="<?= base_url('admin/loans') ?>" class="small">View all <i class="bi bi-arrow-right"></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light"><tr><th>App No.</th><th>Applicant</th><th>Loan Type</th><th>Amount</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                            <?php foreach ($applications as $app) : ?>
                                <tr>
                                    <td>#<?= esc($app['application_no']) ?></td>
                                    <td><?= esc($app['full_name']) ?></td>
                                    <td><?= esc($app['loan_type_name']) ?></td>
                                    <td>₹<?= number_format($app['loan_amount']) ?></td>
                                    <td><span class="badge badge-<?= esc($app['current_status']) ?>"><?= esc(ucfirst(str_replace('_', ' ', $app['current_status']))) ?></span></td>
                                    <td><a href="<?= base_url('admin/loans/view/' . $app['id']) ?>" class="btn btn-sm btn-outline-primary-custom border">View</a></td>
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
