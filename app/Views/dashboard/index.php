<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="dash-sidebar">
                    <h6 class="fw-bold px-2 mb-3">My Account</h6>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link active" href="<?= base_url('dashboard') ?>"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('loan-status') ?>"><i class="bi bi-file-earmark-text me-2"></i>My Applications</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('apply-loan') ?>"><i class="bi bi-plus-circle me-2"></i>Apply for Loan</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('notifications') ?>"><i class="bi bi-bell me-2"></i>Notifications</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('profile') ?>"><i class="bi bi-person-circle me-2"></i>My Profile</a></li>
                        <li class="nav-item"><a class="nav-link text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-9">
                <h4 class="mb-1">Welcome back, <?= esc(session()->get('fullName')) ?> 👋</h4>
                <p class="text-muted mb-4">Here's a quick overview of your loan journey.</p>

                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="stat-card bg-1"><h3 class="mb-0"><?= $stats['total'] ?></h3><small>Total Applications</small></div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card bg-2"><h3 class="mb-0"><?= $stats['approved'] ?></h3><small>Approved</small></div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card bg-4"><h3 class="mb-0"><?= $stats['pending'] ?></h3><small>Pending / Review</small></div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-card bg-3"><h3 class="mb-0"><?= $stats['rejected'] ?></h3><small>Rejected</small></div>
                    </div>
                </div>

                <div class="card card-custom p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0"><i class="bi bi-file-earmark-text"></i> Recent Applications</h6>
                        <a href="<?= base_url('loan-status') ?>" class="small">View all <i class="bi bi-arrow-right"></i></a>
                    </div>
                    <?php if (empty($applications)) : ?>
                        <p class="text-muted small mb-0">No applications yet. <a href="<?= base_url('apply-loan') ?>">Apply now</a>.</p>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light"><tr><th>App No.</th><th>Amount</th><th>EMI</th><th>Status</th></tr></thead>
                                <tbody>
                                <?php foreach ($applications as $app) : ?>
                                    <tr>
                                        <td><a href="<?= base_url('loan-status/' . $app['id']) ?>">#<?= esc($app['application_no']) ?></a></td>
                                        <td>₹<?= number_format($app['loan_amount']) ?></td>
                                        <td>₹<?= number_format($app['emi_amount']) ?></td>
                                        <td><span class="badge badge-<?= esc($app['current_status']) ?>"><?= esc(ucfirst(str_replace('_', ' ', $app['current_status']))) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card card-custom p-4">
                    <h6 class="mb-3"><i class="bi bi-bell"></i> Recent Notifications</h6>
                    <?php if (empty($notifications)) : ?>
                        <p class="text-muted small mb-0">No notifications yet.</p>
                    <?php else : ?>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($notifications as $n) : ?>
                                <li class="d-flex gap-3 mb-3">
                                    <span class="badge badge-<?= $n['type'] === 'success' ? 'approved' : ($n['type'] === 'danger' ? 'rejected' : 'pending') ?> rounded-circle p-2">&nbsp;</span>
                                    <div>
                                        <strong><?= esc($n['title']) ?></strong>
                                        <div class="small text-muted"><?= esc($n['message']) ?></div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('layout/footer') ?>
