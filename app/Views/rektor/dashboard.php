<?= $this->extend('rektor/layouts/main') ?>

<?= $this->section('content') ?>

<div class="dashboard-kpi-grid">
    <div class="kpi-card">
        <small class="kpi-label">TOTAL LAPORAN</small>
        <h2 class="kpi-value"><?= $stats['total_laporan'] ?></h2>
    </div>
    <div class="kpi-card">
        <small class="kpi-label">SELESAI</small>
        <h2 class="kpi-value" style="color: #15803d;"><?= $stats['laporan_selesai'] ?></h2>
    </div>
    <div class="kpi-card">
        <small class="kpi-label">RATA-RATA RESPON</small>
        <h2 class="kpi-value"><?= $stats['rata_rata_respon'] ?></h2>
    </div>
    <!-- KPI Kosong atau Tambahan -->
    <div class="kpi-card">
        <small class="kpi-label">AVG HOURS</small>
        <h2 class="kpi-value"><?= round($stats['avg_hours'] ?? 0) ?>h</h2>
    </div>
</div>

<div class="dashboard-charts-grid">
    <div class="dashboard-card">
        <h3 class="card-header-title">Tren Laporan Bulanan</h3>
        <canvas id="chartBulanan" height="300"></canvas>
    </div>

    <div class="dashboard-card">
        <h3 class="card-header-title">Distribusi Prioritas</h3>
        <canvas id="chartPrioritas" height="250"></canvas>
    </div>
</div>

<script>
    // Chart Bulanan
    const ctxBulanan = document.getElementById('chartBulanan').getContext('2d');
    new Chart(ctxBulanan, {
        type: 'line',
        data: {
            labels: [<?= implode(',', array_map(fn($x) => "'Bulan " . $x['bulan'] . "'", $chartBulanan)) ?>],
            datasets: [{
                label: 'Jumlah Laporan',
                data: [<?= implode(',', array_column($chartBulanan, 'total')) ?>],
                borderColor: '#3b82f6',
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(59, 130, 246, 0.1)'
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // Chart Prioritas
    const ctxPrioritas = document.getElementById('chartPrioritas').getContext('2d');
    new Chart(ctxPrioritas, {
        type: 'doughnut',
        data: {
            labels: [<?= implode(',', array_map(fn($x) => "'" . ucfirst($x['prioritas']) . "'", $chartPrioritas)) ?>],
            datasets: [{
                data: [<?= implode(',', array_column($chartPrioritas, 'total')) ?>],
                backgroundColor: ['#ef4444', '#f59e0b', '#10b981'] // High=Red, Medium=Orange, Low=Green logic might vary order
            }]
        }
    });
</script>

<?= $this->endSection() ?>