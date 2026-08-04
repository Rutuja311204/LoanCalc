/* ==========================================================
   LoanCalc - main.js
   Global UI behaviors: page loader, toasts, animations, validation helpers
   ========================================================== */

document.addEventListener('DOMContentLoaded', function () {
    // Hide page loader once everything is ready
    const loader = document.getElementById('pageLoader');
    if (loader) {
        setTimeout(() => loader.classList.add('hide'), 350);
    }

    // Initialize all toasts on the page
    document.querySelectorAll('.toast').forEach((toastEl) => {
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    });

    // Fade-in animation for elements with .fade-in-up
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.fade-in-up').forEach((el) => observer.observe(el));

    // Bootstrap client-side validation
    document.querySelectorAll('.needs-validation').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Password show/hide toggle
    document.querySelectorAll('.toggle-password').forEach((btn) => {
        btn.addEventListener('click', function () {
            const input = document.querySelector(this.dataset.target);
            if (!input) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    });
});

/**
 * Utility: format a number as Indian Rupee currency.
 */
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR',
        maximumFractionDigits: 0,
    }).format(amount);
}

/**
 * Simple front-end toast trigger, usable from any inline script.
 */
function showToast(message, type = 'success') {
    const container = document.querySelector('.toast-container');
    if (!container) return;

    const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';
    const wrapper = document.createElement('div');
    wrapper.className = `toast align-items-center text-bg-${type} border-0`;
    wrapper.setAttribute('role', 'alert');
    wrapper.innerHTML = `
        <div class="d-flex">
            <div class="toast-body"><i class="bi ${icon} me-2"></i>${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>`;
    container.appendChild(wrapper);
    new bootstrap.Toast(wrapper, { delay: 4000 }).show();
}
