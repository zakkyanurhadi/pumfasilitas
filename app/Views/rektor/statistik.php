<?= $this->extend('rektor/layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .filter-year-inline {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .filter-year-inline label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }

    .filter-year-inline select {
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

    .filter-year-inline select:hover {
        border-color: #6366f1;
    }

    .filter-year-inline select:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .stat-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-summary-card {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        padding: 24px;
        border-radius: 16px;
        text-align: center;
    }

    .stat-summary-card.green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stat-summary-card.blue {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .stat-summary-card .stat-value {
        font-size: 36px;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .stat-summary-card .stat-label {
        font-size: 13px;
        opacity: 0.9;
        font-weight: 500;
    }
</style>



<div class="stats-grid mb-3">
    <!-- CHART 1: PER GEDUNG -->
    <div class="dashboard-card">
        <h3 class="card-header-title">
            <i class="fas fa-building" style="margin-right: 8px; color: #3b82f6;"></i>
            Laporan Per Gedung
        </h3>
        <div style="height: 350px;">
            <canvas id="chartGedung"></canvas>
        </div>
    </div>

    <!-- CHART 2: PER KATEGORI -->
    <div class="dashboard-card">
        <h3 class="card-header-title">
            <i class="fas fa-tags" style="margin-right: 8px; color: #ec4899;"></i>
            Laporan Per Kategori
        </h3>
        <div style="height: 350px;">
            <canvas id="chartKategori"></canvas>
        </div>
    </div>
</div>

<div class="dashboard-card mb-3">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 class="card-header-title" style="margin-bottom: 0;">
            <i class="fas fa-chart-line" style="margin-right: 8px; color: #f43f5e;"></i>
            Tren Kerusakan (Bulanan)
        </h3>
        <div class="filter-year-inline">
            <label for="yearFilterTrend">Tahun:</label>
            <select id="yearFilterTrend" onchange="updateTrendChart()">
                <option value="<?= $currentYear - 1 ?>"><?= $currentYear - 1 ?></option>
                <option value="<?= $currentYear ?>" selected><?= $currentYear ?></option>
            </select>
        </div>
    </div>
    <div style="height: 350px;">
        <canvas id="chartTrend"></canvas>
    </div>
</div>

<?php
// Helper function untuk mengkonversi data trend ke format chart
function formatTrendDataStatistik($data)
{
    $result = array_fill(0, 12, 0);

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
                backgroundColor: ['#6366f1', '#3b82f6', '#06b6d4', '#10b981', '#8b5cf6'],
                borderRadius: 8
            }]
        },
        options: {
            ...chartOptions,
            plugins: {
                legend: { display: false }
            }
        }
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

    // 3. Trend (Line Chart) dengan dukungan filter tahun
    const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const currentYear = <?= $currentYear ?>;

    const trendData = {
        <?= $currentYear - 1 ?>: {
            labels: monthLabels,
            data: [<?= implode(',', formatTrendDataStatistik($trendTahunan[$currentYear - 1])) ?>]
        },
        <?= $currentYear ?>: {
            labels: monthLabels,
            data: [<?= implode(',', formatTrendDataStatistik($trendTahunan[$currentYear])) ?>]
        }
    };

    let trendChart = new Chart(document.getElementById('chartTrend'), {
        type: 'line',
        data: {
            labels: trendData[currentYear].labels,
            datasets: [{
                label: 'Tren Laporan',
                data: trendData[currentYear].data,
                borderColor: '#f43f5e',
                backgroundColor: 'rgba(244, 63, 94, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        },
        options: {
            ...chartOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    function updateTrendChart() {
        const year = document.getElementById('yearFilterTrend').value;
        const data = trendData[year];

        trendChart.data.labels = data.labels;
        trendChart.data.datasets[0].data = data.data;
        trendChart.update();
    }
</script>

<?= $this->endSection() ?>