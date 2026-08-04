<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-lg-3 col-xl-2"><?= $this->include('layout/sidebar_admin') ?></div>

            <div class="col-lg-9 col-xl-10">
                <a href="<?= base_url('admin/loans') ?>" class="small d-inline-block mb-3"><i class="bi bi-arrow-left"></i> Back to Applications</a>

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card card-custom p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                                <div>
                                    <h5 class="mb-1">Application #<?= esc($application['application_no']) ?></h5>
                                    <small class="text-muted"><?= esc($application['loan_type_name']) ?> · <?= esc($application['bank_name']) ?></small>
                                </div>
                                <span class="badge badge-<?= esc($application['current_status']) ?> px-3 py-2"><?= esc(ucfirst(str_replace('_', ' ', $application['current_status']))) ?></span>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4"><small class="text-muted d-block">Applicant</small><strong><?= esc($application['full_name']) ?></strong></div>
                                <div class="col-md-4"><small class="text-muted d-block">Email</small><strong><?= esc($application['email']) ?></strong></div>
                                <div class="col-md-4"><small class="text-muted d-block">Employment</small><strong><?= esc(ucfirst(str_replace('_', ' ', $application['employment_type']))) ?></strong></div>
                                <div class="col-md-4"><small class="text-muted d-block">Loan Amount</small><strong>₹<?= number_format($application['loan_amount']) ?></strong></div>
                                <div class="col-md-4"><small class="text-muted d-block">Tenure</small><strong><?= $application['tenure_months'] ?> months</strong></div>
                                <div class="col-md-4"><small class="text-muted d-block">Interest Rate</small><strong><?= number_format($application['interest_rate'], 2) ?>%</strong></div>
                                <div class="col-md-4"><small class="text-muted d-block">Monthly EMI</small><strong>₹<?= number_format($application['emi_amount']) ?></strong></div>
                                <div class="col-md-4"><small class="text-muted d-block">Total Interest</small><strong>₹<?= number_format($application['total_interest']) ?></strong></div>
                                <div class="col-md-4"><small class="text-muted d-block">Total Payable</small><strong>₹<?= number_format($application['total_payable']) ?></strong></div>
                                <div class="col-md-4"><small class="text-muted d-block">Monthly Income</small><strong>₹<?= number_format($application['monthly_income']) ?></strong></div>
                                <div class="col-12"><small class="text-muted d-block">Purpose</small><span><?= esc($application['purpose'] ?: '—') ?></span></div>
                            </div>
                        </div>

                        <div class="card card-custom p-4">
                            <h6 class="mb-3"><i class="bi bi-clock-history"></i> Status Timeline</h6>
                            <ul class="list-unstyled mb-0">
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
                    </div>

                    <div class="col-lg-4">
                        <div class="card card-custom p-4">
                            <h6 class="mb-3"><i class="bi bi-pencil-square"></i> Update Status</h6>
                            <form action="<?= base_url('admin/loans/update-status/' . $application['id']) ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">New Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="pending" <?= $application['current_status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="under_review" <?= $application['current_status'] === 'under_review' ? 'selected' : '' ?>>Under Review</option>
                                        <option value="approved" <?= $application['current_status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                                        <option value="rejected" <?= $application['current_status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                        <option value="disbursed" <?= $application['current_status'] === 'disbursed' ? 'selected' : '' ?>>Disbursed</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Remarks</label>
                                    <textarea name="remarks" class="form-control" rows="3" placeholder="Add a note about this status change..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary-custom w-100 rounded-pill">Update & Notify Applicant</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('layout/footer') ?>
