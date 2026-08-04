<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-lg-3 col-xl-2"><?= $this->include('layout/sidebar_admin') ?></div>

            <div class="col-lg-9 col-xl-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0"><i class="bi bi-bar-chart"></i> Reports & Analytics</h4>
                    <a href="<?= base_url('admin/reports/export') ?>" class="btn btn-outline-primary-custom border rounded-pill btn-sm"><i class="bi bi-download"></i> Export CSV</a>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-lg-6">
                        <div class="card card-custom p-4">
                            <h6 class="mb-3">Applications by Loan Type</h6>
                            <canvas id="byTypeChart" height="220"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-custom p-4">
                            <h6 class="mb-3">Applications by Status</h6>
                            <canvas id="byStatusChart" height="220"></canvas>
                        </div>
                    </div>
                </div>

                <div class="card card-custom p-4">
                    <h6 class="mb-3">Monthly Application Volume</h6>
                    <canvas id="monthlyChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$extraJs = '<script>
    new Chart(document.getElementById("byTypeChart"), {
        type: "pie",
        data: {
            labels: ' . json_encode(array_keys($byType)) . ',
            datasets: [{ data: ' . json_encode(array_values($byType)) . ', backgroundColor: ["#0d3b66","#14539c","#e6342b","#f7941d","#1d9c5c"] }]
        },
        options: { plugins: { legend: { position: "bottom" } } }
    });

    new Chart(document.getElementById("byStatusChart"), {
        type: "doughnut",
        data: {
            labels: ' . json_encode(array_keys($byStatus)) . ',
            datasets: [{ data: ' . json_encode(array_values($byStatus)) . ', backgroundColor: ["#f7941d","#14539c","#1d9c5c","#e6342b","#6f42c1"] }]
        },
        options: { plugins: { legend: { position: "bottom" } } }
    });

    new Chart(document.getElementById("monthlyChart"), {
        type: "bar",
        data: {
            labels: ' . json_encode(array_keys($monthly)) . ',
            datasets: [{ label: "Applications", data: ' . json_encode(array_values($monthly)) . ', backgroundColor: "#0d3b66", borderRadius: 6 }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });
</script>';
?>
<?= $this->include('layout/footer') ?>
