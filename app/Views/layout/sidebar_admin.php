<?php $seg = service('uri')->getSegment(2) ?? 'dashboard'; ?>
<div class="dash-sidebar">
    <h6 class="fw-bold px-2 mb-3"><i class="bi bi-speedometer2"></i> Admin Panel</h6>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link <?= $seg === 'dashboard' ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>"><i class="bi bi-grid me-2"></i>Dashboard</a></li>
        <li class="nav-item"><a class="nav-link <?= $seg === 'users' ? 'active' : '' ?>" href="<?= base_url('admin/users') ?>"><i class="bi bi-people me-2"></i>Users</a></li>
        <li class="nav-item"><a class="nav-link <?= $seg === 'loans' ? 'active' : '' ?>" href="<?= base_url('admin/loans') ?>"><i class="bi bi-file-earmark-text me-2"></i>Loan Applications</a></li>
        <li class="nav-item"><a class="nav-link <?= $seg === 'loan-types' ? 'active' : '' ?>" href="<?= base_url('admin/loan-types') ?>"><i class="bi bi-tags me-2"></i>Loan Types</a></li>
        <li class="nav-item"><a class="nav-link <?= $seg === 'banks' ? 'active' : '' ?>" href="<?= base_url('admin/banks') ?>"><i class="bi bi-bank me-2"></i>Banks</a></li>
        <li class="nav-item"><a class="nav-link <?= $seg === 'reports' ? 'active' : '' ?>" href="<?= base_url('admin/reports') ?>"><i class="bi bi-bar-chart me-2"></i>Reports</a></li>
        <li class="nav-item"><a class="nav-link <?= $seg === 'messages' ? 'active' : '' ?>" href="<?= base_url('admin/messages') ?>"><i class="bi bi-envelope me-2"></i>Messages</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>"><i class="bi bi-box-arrow-up-right me-2"></i>View Site</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
    </ul>
</div>
