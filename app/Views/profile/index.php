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
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('notifications') ?>"><i class="bi bi-bell me-2"></i>Notifications</a></li>
                        <li class="nav-item"><a class="nav-link active" href="<?= base_url('profile') ?>"><i class="bi bi-person-circle me-2"></i>My Profile</a></li>
                        <li class="nav-item"><a class="nav-link text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-9">
                <h4 class="mb-4"><i class="bi bi-person-circle"></i> My Profile</h4>

                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="card card-custom p-4">
                            <h6 class="mb-3">Personal Information</h6>
                            <form action="<?= base_url('profile/update') ?>" method="post" class="row g-3 needs-validation" novalidate>
                                <?= csrf_field() ?>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <input type="text" name="full_name" class="form-control" value="<?= esc($user['full_name']) ?>" required minlength="3">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email Address</label>
                                    <input type="email" class="form-control" value="<?= esc($user['email']) ?>" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="<?= esc($user['phone']) ?>" required minlength="10" maxlength="15">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control" value="<?= esc($user['dob']) ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Address</label>
                                    <textarea name="address" class="form-control" rows="2"><?= esc($user['address']) ?></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary-custom rounded-pill px-4">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card card-custom p-4 text-center mb-4">
                            <span class="avatar-circle mx-auto mb-2" style="width:72px;height:72px;font-size:1.8rem;"><?= esc(strtoupper(substr($user['full_name'], 0, 1))) ?></span>
                            <h6 class="mb-0"><?= esc($user['full_name']) ?></h6>
                            <small class="text-muted"><?= esc($user['email']) ?></small>
                            <span class="badge bg-secondary mt-2 mx-auto" style="width:fit-content"><?= esc(ucfirst($user['role'])) ?></span>
                        </div>

                        <div class="card card-custom p-4">
                            <h6 class="mb-3">Change Password</h6>
                            <form action="<?= base_url('profile/change-password') ?>" method="post" class="needs-validation" novalidate>
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Current Password</label>
                                    <input type="password" name="current_password" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">New Password</label>
                                    <input type="password" name="new_password" class="form-control" required minlength="6">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Confirm New Password</label>
                                    <input type="password" name="confirm_new_password" class="form-control" required minlength="6">
                                </div>
                                <button type="submit" class="btn btn-accent w-100 rounded-pill">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('layout/footer') ?>
