<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-lg-3 col-xl-2"><?= $this->include('layout/sidebar_admin') ?></div>

            <div class="col-lg-9 col-xl-10">
                <a href="<?= base_url('admin/users') ?>" class="small d-inline-block mb-3"><i class="bi bi-arrow-left"></i> Back to Users</a>

                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card card-custom p-4 text-center">
                            <span class="avatar-circle mx-auto mb-2" style="width:72px;height:72px;font-size:1.8rem;"><?= esc(strtoupper(substr($user['full_name'], 0, 1))) ?></span>
                            <h5 class="mb-0"><?= esc($user['full_name']) ?></h5>
                            <small class="text-muted"><?= esc($user['email']) ?></small>
                            <hr>
                            <div class="text-start small">
                                <p><strong>Phone:</strong> <?= esc($user['phone']) ?></p>
                                <p><strong>Address:</strong> <?= esc($user['address'] ?: '—') ?></p>
                                <p><strong>Status:</strong> <span class="badge <?= $user['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>"><?= esc(ucfirst($user['status'])) ?></span></p>
                                <p class="mb-0"><strong>Joined:</strong> <?= date('d M Y', strtotime($user['created_at'])) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card card-custom p-4">
                            <h6 class="mb-3">Loan Applications (<?= count($applications) ?>)</h6>
                            <?php if (empty($applications)) : ?>
                                <p class="text-muted small mb-0">This user has not applied for any loans yet.</p>
                            <?php else : ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light"><tr><th>App No.</th><th>Amount</th><th>Status</th><th></th></tr></thead>
                                        <tbody>
                                        <?php foreach ($applications as $app) : ?>
                                            <tr>
                                                <td>#<?= esc($app['application_no']) ?></td>
                                                <td>₹<?= number_format($app['loan_amount']) ?></td>
                                                <td><span class="badge badge-<?= esc($app['current_status']) ?>"><?= esc(ucfirst(str_replace('_', ' ', $app['current_status']))) ?></span></td>
                                                <td><a href="<?= base_url('admin/loans/view/' . $app['id']) ?>" class="btn btn-sm btn-outline-primary-custom border">View</a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('layout/footer') ?>
