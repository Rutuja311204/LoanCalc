<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'LoanCalc') ?></title>
    <meta name="description" content="LoanCalc - Smart Bank Loan EMI Calculator and Loan Application Portal">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- App CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <?php if (function_exists('csrf_token')) : ?>
        <meta name="csrf-name" content="<?= csrf_token() ?>">
        <meta name="csrf-hash" content="<?= csrf_hash() ?>">
    <?php endif; ?>
    <script>const BASE_URL = "<?= base_url('/') ?>";</script>
</head>
<body>

<!-- Page Loader -->
<div id="pageLoader" class="page-loader">
    <div class="spinner-ring"><div></div><div></div><div></div><div></div></div>
</div>

<!-- Toast container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:1080">
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="toast align-items-center text-bg-success border-0 show" role="alert" data-bs-delay="4000">
            <div class="d-flex">
                <div class="toast-body"><i class="bi bi-check-circle-fill me-2"></i><?= esc(session()->getFlashdata('success')) ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert" data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body"><i class="bi bi-exclamation-triangle-fill me-2"></i><?= esc(session()->getFlashdata('error')) ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="toast align-items-center text-bg-warning border-0 show" role="alert" data-bs-delay="6000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <?= implode('<br>', array_map('esc', session()->getFlashdata('errors'))) ?>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-brand-custom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>">
            <i class="bi bi-bank2"></i> Loan<span>Calc</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('emi-calculator') ?>">EMI Calculator</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('loan-comparison') ?>">Compare Loans</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('apply-loan') ?>">Apply Loan</a></li>
                <?php if (session()->get('isLoggedIn')) : ?>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('loan-status') ?>">Loan Status</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('about') ?>">About</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('contact') ?>">Contact</a></li>
            </ul>
            <ul class="navbar-nav">
                <?php if (session()->get('isLoggedIn')) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                            <span class="avatar-circle"><?= esc(strtoupper(substr(session()->get('fullName'), 0, 1))) ?></span>
                            <?= esc(session()->get('fullName')) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <?php if (session()->get('role') === 'admin') : ?>
                                <li><a class="dropdown-item" href="<?= base_url('admin/dashboard') ?>"><i class="bi bi-speedometer2 me-2"></i>Admin Panel</a></li>
                            <?php else : ?>
                                <li><a class="dropdown-item" href="<?= base_url('dashboard') ?>"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="bi bi-person-circle me-2"></i>My Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('login') ?>">Login</a></li>
                    <li class="nav-item"><a class="btn btn-primary-custom rounded-pill px-4 ms-2" href="<?= base_url('register') ?>">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
