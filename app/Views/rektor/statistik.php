<?= $this->extend('rektor/layouts/main') ?>

<?= $this->section('content') ?>
<div class="stats-grid mb-3">
    <!-- CHART 1: PER GEDUNG -->
    <div class="dashboard-card">
        <h3 class="card-header-title">Laporan Per Gedung</h3>
        <div style="height: 350px;">
            <canvas id="chartGedung"></canvas>
        </div>
    </div>

    <!-- CHART 2: PER KATEGORI -->
    <div class="dashboard-card">
        <h3 class="card-header-title">Laporan Per Kategori</h3>
        <div style="height: 350px;">
            <canvas id="chartKategori"></canvas>
        </div>
    </div>
</div>

<div class="dashboard-card mb-3">
    <h3 class="card-header-title">Tren Kerusakan (Bulanan)</h3>
    <div style="height: 350px;">
        <canvas id="chartTrend"></canvas>
    </div>
</div>

<script>
    // Helper to format currency/number if needed
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        }
    };

    // 1. Gedung (Bar Chart)
    new Chart(document.getElementById('chartGedung'), {
        type: 'bar',
        data: {
            labels: [<?= implode(',', array_map(fn($x) => "'" . esc($x['nama']) . "'", $chartGedung)) ?>],
            datasets: [{
                label: 'Jumlah Laporan',
                data: [<?= implode(',', array_column($chartGedung, 'total')) ?>],
                backgroundColor: '#3b82f6',
                borderRadius: 8
            }]
        },
        options: chartOptions
    });

    // 2. Kategori (Doughnut Chart)
    new Chart(document.getElementById('chartKategori'), {
        type: 'doughnut',
        data: {
            labels: [<?= implode(',', array_map(fn($x) => "'" . esc($x['kategori'] ?: 'Lainnya') . "'", $chartKategori)) ?>],
            datasets: [{
                data: [<?= implode(',', array_column($chartKategori, 'total')) ?>],
                backgroundColor: ['#6366f1', '#ec4899', '#8b5cf6', '#14b8a6', '#f59e0b', '#3b82f6'],
                hoverOffset: 4
            }]
        },
        options: chartOptions
    });

    // 3. Trend (Line Chart)
    new Chart(document.getElementById('chartTrend'), {
        type: 'line',
        data: {
            labels: [<?= implode(',', array_map(fn($x) => "'Bulan " . $x['bulan'] . "'", $trendTahunan)) ?>],
            datasets: [{
                label: 'Tren Laporan',
                data: [<?= implode(',', array_column($trendTahunan, 'total')) ?>],
                borderColor: '#f43f5e',
                backgroundColor: 'rgba(244, 63, 94, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        },
        options: chartOptions
    });
</script>

<?= $this->endSection() ?>