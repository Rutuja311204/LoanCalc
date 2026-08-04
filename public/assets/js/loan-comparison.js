/* ==========================================================
   LoanCalc - loan-comparison.js
   Fetches bank-wise EMI comparison via API and renders
   a bar chart + comparison table.
   ========================================================== */

(function () {
    const form = document.getElementById('compareForm');
    if (!form) return;

    const resultsBody = document.getElementById('compareResultsBody');
    const chartCanvas  = document.getElementById('compareChart');
    let compareChart   = null;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const principal = document.getElementById('cmpPrincipal').value;
        const tenure     = document.getElementById('cmpTenure').value;

        const csrfName = document.querySelector('meta[name="csrf-name"]')?.content;
        const csrfHash = document.querySelector('meta[name="csrf-hash"]')?.content;

        const formData = new FormData();
        formData.append('principal', principal);
        formData.append('tenure_months', tenure);
        if (csrfName && csrfHash) formData.append(csrfName, csrfHash);

        fetch(BASE_URL + 'api/compare-loans', {
            method: 'POST',
            body: formData,
        })
            .then((res) => res.json())
            .then((res) => {
                if (!res.success) {
                    showToast('Please check your inputs and try again.', 'danger');
                    return;
                }
                renderTable(res.data);
                renderChart(res.data);
                document.getElementById('compareResultsWrap').classList.remove('d-none');
            })
            .catch(() => showToast('Something went wrong. Please try again.', 'danger'));
    });

    function renderTable(data) {
        resultsBody.innerHTML = '';
        data.forEach((row, idx) => {
            const tr = document.createElement('tr');
            if (idx === 0) tr.classList.add('table-success');
            tr.innerHTML = `
                <td>${idx === 0 ? '<span class="badge bg-success mb-1 d-block">Best Offer</span>' : ''} <strong>${row.bank_name}</strong></td>
                <td>${row.interest_rate}%</td>
                <td>${formatCurrency(row.emi)}</td>
                <td>${formatCurrency(row.total_interest)}</td>
                <td>${formatCurrency(row.total_payment)}</td>
                <td>${formatCurrency(row.processing_fee)}</td>`;
            resultsBody.appendChild(tr);
        });
    }

    function renderChart(data) {
        if (compareChart) compareChart.destroy();
        compareChart = new Chart(chartCanvas, {
            type: 'bar',
            data: {
                labels: data.map((d) => d.bank_name),
                datasets: [{
                    label: 'Monthly EMI (₹)',
                    data: data.map((d) => d.emi),
                    backgroundColor: '#0d3b66',
                    borderRadius: 6,
                }],
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } },
            },
        });
    }
})();
