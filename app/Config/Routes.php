<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// ------------------------------------------------------------------
// Public pages
// ------------------------------------------------------------------
$routes->get('/', 'Home::index');
$routes->get('about', 'Pages::about');
$routes->get('contact', 'Pages::contact');
$routes->post('contact', 'Pages::submitContact');

// EMI Calculator (public)
$routes->get('emi-calculator', 'EmiController::index');
$routes->post('api/calculate-emi', 'Api\EmiApi::calculate');

// Loan Comparison (public)
$routes->get('loan-comparison', 'LoanController::compare');
$routes->post('api/compare-loans', 'Api\EmiApi::compare');

// ------------------------------------------------------------------
// Authentication
// ------------------------------------------------------------------
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::attemptRegister');
$routes->get('logout', 'Auth::logout');
$routes->get('forgot-password', 'Auth::forgotPassword');
$routes->post('forgot-password', 'Auth::attemptForgotPassword');
$routes->get('reset-password/(:any)', 'Auth::resetPassword/$1');
$routes->post('reset-password', 'Auth::attemptResetPassword');

// ------------------------------------------------------------------
// Authenticated user routes
// ------------------------------------------------------------------
$routes->group('', ['filter' => 'authFilter'], static function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');

    $routes->get('apply-loan', 'LoanController::apply');
    $routes->post('apply-loan', 'LoanController::submitApplication');
    $routes->get('loan-status', 'LoanController::status');
    $routes->get('loan-status/(:num)', 'LoanController::viewApplication/$1');

    $routes->get('profile', 'ProfileController::index');
    $routes->post('profile/update', 'ProfileController::update');
    $routes->post('profile/change-password', 'ProfileController::changePassword');

    $routes->get('notifications', 'DashboardController::notifications');
    $routes->get('notifications/read/(:num)', 'DashboardController::markNotificationRead/$1');
});

// ------------------------------------------------------------------
// Admin routes
// ------------------------------------------------------------------
$routes->group('admin', ['filter' => 'adminFilter'], static function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');

    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/view/(:num)', 'Admin\Users::view/$1');
    $routes->post('users/toggle-status/(:num)', 'Admin\Users::toggleStatus/$1');
    $routes->post('users/delete/(:num)', 'Admin\Users::delete/$1');

    $routes->get('loans', 'Admin\Loans::index');
    $routes->get('loans/view/(:num)', 'Admin\Loans::view/$1');
    $routes->post('loans/update-status/(:num)', 'Admin\Loans::updateStatus/$1');

    $routes->get('loan-types', 'Admin\Loans::loanTypes');
    $routes->get('banks', 'Admin\Loans::banks');

    $routes->get('reports', 'Admin\Reports::index');
    $routes->get('reports/export', 'Admin\Reports::export');

    $routes->get('messages', 'Admin\Reports::messages');
    $routes->post('messages/mark-read/(:num)', 'Admin\Reports::markMessageRead/$1');
});
