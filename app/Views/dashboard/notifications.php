<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="dash-sidebar">
                    <h6 class="fw-bold px-2 mb-3">My Account</h6>
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('dashboard') ?>"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('loan-status') ?>"><i class="bi bi-file-earmark-text me-2"></i>My Applications</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('apply-loan') ?>"><i class="bi bi-plus-circle me-2"></i>Apply for Loan</a></li>
                        <li class="nav-item"><a class="nav-link active" href="<?= base_url('notifications') ?>"><i class="bi bi-bell me-2"></i>Notifications</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('profile') ?>"><i class="bi bi-person-circle me-2"></i>My Profile</a></li>
                        <li class="nav-item"><a class="nav-link text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-9">
                <h4 class="mb-4"><i class="bi bi-bell"></i> Notifications</h4>

                <div class="card card-custom p-4">
                    <?php if (empty($notifications)) : ?>
                        <p class="text-muted small mb-0">You have no notifications.</p>
                    <?php else : ?>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($notifications as $n) : ?>
                                <li class="d-flex gap-3 mb-3 pb-3 border-bottom">
                                    <span class="badge badge-<?= $n['type'] === 'success' ? 'approved' : ($n['type'] === 'danger' ? 'rejected' : 'pending') ?> rounded-circle p-2">&nbsp;</span>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <strong><?= esc($n['title']) ?></strong>
                                            <small class="text-muted"><?= date('d M Y, h:i A', strtotime($n['created_at'])) ?></small>
                                        </div>
                                        <div class="small text-muted"><?= esc($n['message']) ?></div>
                                        <?php if (! $n['is_read']) : ?>
                                            <a href="<?= base_url('notifications/read/' . $n['id']) ?>" class="small">Mark as read</a>
                                        <?php endif; ?>
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
