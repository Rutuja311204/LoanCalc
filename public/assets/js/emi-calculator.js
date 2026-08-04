/* ==========================================================
   LoanCalc - emi-calculator.js
   Handles the EMI calculator form, sliders, live calculation,
   and the principal-vs-interest doughnut chart.
   ========================================================== */

(function () {
    const form           = document.getElementById('emiForm');
    if (!form) return;

    const principalInput = document.getElementById('principal');
    const principalRange  = document.getElementById('principalRange');
    const rateInput       = document.getElementById('interestRate');
    const rateRange       = document.getElementById('interestRateRange');
    const tenureInput     = document.getElementById('tenureMonths');
    const tenureRange     = document.getElementById('tenureRange');

    const emiResultEl       = document.getElementById('emiResult');
    const totalInterestEl   = document.getElementById('totalInterestResult');
    const totalPaymentEl    = document.getElementById('totalPaymentResult');
    const principalResultEl = document.getElementById('principalResult');
    const scheduleBody      = document.getElementById('scheduleBody');

    let emiChart = null;

    function syncPair(input, range) {
        input.addEventListener('input', () => { range.value = input.value; calculateAndRender(); });
        range.addEventListener('input', () => { input.value = range.value; calculateAndRender(); });
    }

    syncPair(principalInput, principalRange);
    syncPair(rateInput, rateRange);
    syncPair(tenureInput, tenureRange);

    function calculateEmiLocal(principal, annualRate, months) {
        const monthlyRate = (annualRate / 12) / 100;
        let emi;
        if (monthlyRate === 0) {
            emi = principal / months;
        } else {
            const factor = Math.pow(1 + monthlyRate, months);
            emi = (principal * monthlyRate * factor) / (factor - 1);
        }
        const totalPayment = emi * months;
        const totalInterest = totalPayment - principal;
        return { emi, totalPayment, totalInterest };
    }

    function renderChart(principal, totalInterest) {
        const ctx = document.getElementById('emiChart');
        if (!ctx) return;

        if (emiChart) emiChart.destroy();

        emiChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Principal Amount', 'Total Interest'],
                datasets: [{
                    data: [principal, totalInterest],
                    backgroundColor: ['#0d3b66', '#e6342b'],
                    borderWidth: 0,
                }],
            },
            options: {
                responsive: true,
                cutout: '70%',
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 16, usePointStyle: true } },
                },
            },
        });
    }

    function renderSchedule(principal, rate, months) {
        if (!scheduleBody) return;
        scheduleBody.innerHTML = '';

        const monthlyRate = (rate / 12) / 100;
        const { emi } = calculateEmiLocal(principal, rate, months);
        let balance = principal;

        for (let m = 1; m <= months; m++) {
            const interestPart = balance * monthlyRate;
            const principalPart = emi - interestPart;
            balance = Math.max(balance - principalPart, 0);

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${m}</td>
                <td>${formatCurrency(emi)}</td>
                <td>${formatCurrency(principalPart)}</td>
                <td>${formatCurrency(interestPart)}</td>
                <td>${formatCurrency(balance)}</td>`;
            scheduleBody.appendChild(row);
        }
    }

    function calculateAndRender() {
        const principal = parseFloat(principalInput.value) || 0;
        const rate      = parseFloat(rateInput.value) || 0;
        const months    = parseInt(tenureInput.value, 10) || 0;

        if (principal <= 0 || rate <= 0 || months <= 0) return;

        const { emi, totalInterest, totalPayment } = calculateEmiLocal(principal, rate, months);

        emiResultEl.textContent       = formatCurrency(emi);
        totalInterestEl.textContent   = formatCurrency(totalInterest);
        totalPaymentEl.textContent    = formatCurrency(totalPayment);
        principalResultEl.textContent = formatCurrency(principal);

        renderChart(principal, totalInterest);
        renderSchedule(principal, rate, months);
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        calculateAndRender();
        showToast('EMI calculated successfully!', 'success');
    });

    // Initial render on page load
    calculateAndRender();
})();
