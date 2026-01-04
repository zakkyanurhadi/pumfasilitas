<?= $this->extend('rektor/layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .filter-year {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .filter-year label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }

    .filter-year select {
        padding: 8px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        background: white;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .filter-year select:hover {
        border-color: #6366f1;
    }

    .filter-year select:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
</style>

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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 class="card-header-title" style="margin-bottom: 0;">Tren Laporan Bulanan</h3>
            <div class="filter-year">
                <label for="yearFilter">Tahun:</label>
                <select id="yearFilter" onchange="updateTrendChart()">
                    <option value="<?= $currentYear - 1 ?>"><?= $currentYear - 1 ?></option>
                    <option value="<?= $currentYear ?>" selected><?= $currentYear ?></option>
                </select>
            </div>
        </div>
        <canvas id="chartBulanan" height="300"></canvas>
    </div>

    <div class="dashboard-card">
        <h3 class="card-header-title">Distribusi Prioritas</h3>
        <canvas id="chartPrioritas" height="250"></canvas>
    </div>
</div>

<?php
// Helper function untuk mengkonversi data trend ke format chart
function formatTrendDataRektor($data)
{
    $result = array_fill(0, 12, 0); // Initialize with 0 for all 12 months

    foreach ($data as $item) {
        $monthIndex = (int) $item['bulan'] - 1;
        if ($monthIndex >= 0 && $monthIndex < 12) {
            $result[$monthIndex] = (int) $item['total'];
        }
    }

    return $result;
}
?>

<script>
    // Nama bulan dalam Bahasa Indonesia
    const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const currentYear = <?= $currentYear ?>;

    // Data dari PHP untuk tahun ini dan tahun sebelumnya
    const trendData = {
        <?= $currentYear - 1 ?>: {
            labels: monthLabels,
            data: [<?= implode(',', formatTrendDataRektor($chartBulanan[$currentYear - 1])) ?>]
        },
        <?= $currentYear ?>: {
            labels: monthLabels,
            data: [<?= implode(',', formatTrendDataRektor($chartBulanan[$currentYear])) ?>]
        }
    };

    // Chart Bulanan
    const ctxBulanan = document.getElementById('chartBulanan').getContext('2d');
    let trendChart = new Chart(ctxBulanan, {
        type: 'line',
        data: {
            labels: trendData[currentYear].labels,
            datasets: [{
                label: 'Jumlah Laporan',
                data: trendData[currentYear].data,
                borderColor: '#3b82f6',
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    function updateTrendChart() {
        const year = document.getElementById('yearFilter').value;
        const data = trendData[year];

        trendChart.data.labels = data.labels;
        trendChart.data.datasets[0].data = data.data;
        trendChart.update();
    }

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