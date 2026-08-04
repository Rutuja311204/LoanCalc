<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5 fade-in-up">
            <span class="section-badge">Track Progress</span>
            <h2 class="mt-3">Your Loan Application Status</h2>
            <div class="divider-accent mx-auto mt-2"></div>
        </div>

        <?php if (! empty($singleView) && ! empty($application)) : ?>
            <div class="row justify-content-center fade-in-up">
                <div class="col-lg-8">
                    <div class="card card-custom p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div>
                                <h5 class="mb-1">Application #<?= esc($application['application_no']) ?></h5>
                                <small class="text-muted"><?= esc($application['loan_type_name']) ?> · <?= esc($application['bank_name']) ?></small>
                            </div>
                            <span class="badge badge-<?= esc($application['current_status']) ?> px-3 py-2"><?= esc(ucfirst(str_replace('_', ' ', $application['current_status']))) ?></span>
                        </div>
                        <hr>
                        <div class="row text-center g-3">
                            <div class="col-4"><small class="text-muted d-block">Loan Amount</small><strong>₹<?= number_format($application['loan_amount']) ?></strong></div>
                            <div class="col-4"><small class="text-muted d-block">EMI</small><strong>₹<?= number_format($application['emi_amount']) ?></strong></div>
                            <div class="col-4"><small class="text-muted d-block">Tenure</small><strong><?= $application['tenure_months'] ?> mo</strong></div>
                        </div>
                    </div>

                    <div class="card card-custom p-4">
                        <h6 class="mb-3"><i class="bi bi-clock-history"></i> Status Timeline</h6>
                        <ul class="list-unstyled">
                            <?php foreach ($history as $h) : ?>
                                <li class="mb-3 d-flex gap-3">
                                    <span class="badge badge-<?= esc($h['status']) ?> rounded-circle p-2">&nbsp;</span>
                                    <div>
                                        <strong><?= esc(ucfirst(str_replace('_', ' ', $h['status']))) ?></strong>
                                        <div class="small text-muted"><?= esc($h['remarks']) ?> — <?= date('d M Y, h:i A', strtotime($h['created_at'])) ?></div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <a href="<?= base_url('loan-status') ?>" class="btn btn-outline-primary-custom border rounded-pill mt-3"><i class="bi bi-arrow-left"></i> Back to all applications</a>
                </div>
            </div>
        <?php else : ?>
            <?php if (empty($applications)) : ?>
                <div class="text-center py-5 fade-in-up">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <p class="text-muted mt-3">You have not submitted any loan applications yet.</p>
                    <a href="<?= base_url('apply-loan') ?>" class="btn btn-primary-custom rounded-pill px-4">Apply for a Loan</a>
                </div>
            <?php else : ?>
                <div class="row g-4">
                    <?php foreach ($applications as $app) : ?>
                        <div class="col-lg-6 fade-in-up">
                            <div class="card card-custom p-4">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">#<?= esc($app['application_no']) ?></h6>
                                        <small class="text-muted"><?= esc($app['loan_type_name']) ?> · <?= esc($app['bank_name']) ?></small>
                                    </div>
                                    <span class="badge badge-<?= esc($app['current_status']) ?> px-3 py-2"><?= esc(ucfirst(str_replace('_', ' ', $app['current_status']))) ?></span>
                                </div>
                                <div class="row text-center g-2 mt-3">
                                    <div class="col-4"><small class="text-muted d-block">Amount</small><strong>₹<?= number_format($app['loan_amount']) ?></strong></div>
                                    <div class="col-4"><small class="text-muted d-block">EMI</small><strong>₹<?= number_format($app['emi_amount']) ?></strong></div>
                                    <div class="col-4"><small class="text-muted d-block">Applied</small><strong><?= date('d M Y', strtotime($app['created_at'])) ?></strong></div>
                                </div>
                                <a href="<?= base_url('loan-status/' . $app['id']) ?>" class="btn btn-outline-primary-custom border rounded-pill mt-3">View Timeline <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?= $this->include('layout/footer') ?>
