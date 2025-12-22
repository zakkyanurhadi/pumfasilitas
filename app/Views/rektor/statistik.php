<?= $this->extend('rektor/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="stats-grid">

        <!-- CHART 1: PER GEDUNG -->
        <div class="dashboard-card">
            <h3 class="card-header-title">Laporan Per Gedung</h3>
            <canvas id="chartGedung"></canvas>
        </div>

        <!-- CHART 2: PER KATEGORI -->
        <div class="dashboard-card">
            <h3 class="card-header-title">Laporan Per Kategori</h3>
            <canvas id="chartKategori"></canvas>
        </div>

    </div>

    <div class="dashboard-card" style="margin-top: 25px;">
        <h3 class="card-header-title">Tren Kerusakan (Waktu)</h3>
        <canvas id="chartTrend" height="100"></canvas>
    </div>
</div>

<script>
    // Gedung
    new Chart(document.getElementById('chartGedung'), {
        type: 'bar',
        data: {
            labels: [<?= implode(',', array_map(fn($x) => "'" . esc($x['nama']) . "'", $chartGedung)) ?>],
            datasets: [{
                label: 'Jumlah',
                data: [<?= implode(',', array_column($chartGedung, 'total')) ?>],
                backgroundColor: '#3b82f6'
            }]
        }
    });

    // Kategori
    new Chart(document.getElementById('chartKategori'), {
        type: 'pie',
        data: {
            labels: [<?= implode(',', array_map(fn($x) => "'" . esc($x['kategori']) . "'", $chartKategori)) ?>],
            datasets: [{
                data: [<?= implode(',', array_column($chartKategori, 'total')) ?>],
                backgroundColor: ['#6366f1', '#ec4899', '#8b5cf6', '#14b8a6']
            }]
        }
    });

    // Trend
    new Chart(document.getElementById('chartTrend'), {
        type: 'line',
        data: {
            labels: [<?= implode(',', array_map(fn($x) => "'Bulan " . $x['bulan'] . "'", $trendTahunan)) ?>],
            datasets: [{
                label: 'Tren Kerusakan',
                data: [<?= implode(',', array_column($trendTahunan, 'total')) ?>],
                borderColor: '#f43f5e',
                tension: 0.3
            }]
        }
    });
</script>

<?= $this->endSection() ?>