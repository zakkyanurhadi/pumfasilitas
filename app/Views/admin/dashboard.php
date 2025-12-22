<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  /* ================= ROOT THEME ================= */
  :root {
    --bg: #f6f8fc;
    --card: #ffffff;
    --muted: #64748b;
    --text: #0f172a;
    --line: #e5e7eb;

    --blue: #1d4ed8;
    --green: #15803d;
    --orange: #d97706;
    --red: #b91c1c;

    --shadow-xs: 0 4px 10px rgba(15, 23, 42, .05);
    --shadow-sm: 0 10px 26px rgba(15, 23, 42, .07);
    --shadow-lg: 0 22px 50px rgba(15, 23, 42, .12);
  }

  /* ================= RESET ================= */
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  body {
    font-family: 'Inter', sans-serif;
    background: radial-gradient(circle at top, #f8fafc, #eef2ff);
    color: var(--text);
  }

  /* ================= KPI ================= */
  .kpis {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-bottom: 20px;
  }

  .kpi {
    background: linear-gradient(180deg, #ffffff, #fdfefe);
    border-radius: 18px;
    padding: 16px 16px 24px;
    box-shadow: var(--shadow-xs);
    position: relative;
    transition: .25s ease;
  }

  .kpi:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
  }

  .kpi::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 22px;
    border: 1px solid rgba(226, 232, 240, .8);
    pointer-events: none;
  }

  .kpi small {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .35px;
    color: var(--muted);
    font-weight: 600;
  }

  .kpi h2 {
    margin-top: 10px;
    font-size: 28px;
    font-weight: 800;
    letter-spacing: -.5px;
  }

  .kpi .unit {
    font-size: 14px;
    font-weight: 600;
    color: var(--muted);
    margin-left: 4px;
  }

  /* ===== ALERT KPI ===== */
  .kpi.alert {
    background: linear-gradient(180deg, #fff1f2, #ffffff);
    border: 1px solid #fecaca;
  }

  .kpi.alert h2 {
    color: var(--red);
  }

  /* ================= BADGE ================= */
  .badge {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 11px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 999px;
  }

  .badge.up {
    background: #dcfce7;
    color: var(--green);
  }

  .badge.down {
    background: #fee2e2;
    color: var(--red);
  }

  /* ================= GRID ================= */
  .grid {
    display: grid;
    grid-template-columns: 2.4fr 1.4fr;
    gap: 15px;
    margin-bottom: 15px;
  }

  .card {
    background: var(--card);
    border-radius: 18px;
    padding: 20px;
    box-shadow: var(--shadow-xs);
    position: relative;
  }

  .card::after {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 22px;
    border: 1px solid rgba(226, 232, 240, .9);
    pointer-events: none;
  }

  .card h3 {
    font-size: 17px;
    font-weight: 700;
    margin-bottom: 24px;
    letter-spacing: .2px;
  }

  /* ================= CHART ================= */
  canvas {
    width: 100% !important;
    height: 340px !important;
  }

  /* ================= BOTTOM ================= */
  .bottom {
    margin-top: 20px;
    display: grid;
    grid-template-columns: 2.4fr 1fr;
    gap: 20px;
  }

  /* ================= TABLE ================= */
  table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
    font-size: 14px;
  }

  thead th {
    text-align: left;
    font-weight: 700;
    color: #334155;
    padding-bottom: 10px;
  }

  tbody tr {
    background: #ffffff;
    box-shadow: var(--shadow-xs);
    border-radius: 14px;
  }

  tbody td {
    padding: 14px 16px;
  }

  tbody tr td:first-child {
    border-top-left-radius: 14px;
    border-bottom-left-radius: 14px;
  }

  tbody tr td:last-child {
    border-top-right-radius: 14px;
    border-bottom-right-radius: 14px;
  }

  /* ================= STATUS ================= */
  .status {
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
  }

  .status.pending {
    background: #fef3c7;
    color: #92400e;
  }

  .status.diproses {
    background: #dbeafe;
    color: #1e40af;
  }

  .status.selesai {
    background: #dcfce7;
    color: #14532d;
  }

  .priority.high {
    color: var(--red);
    font-weight: 900;
  }

  /* ================= ADMIN PERFORMANCE ================= */
  .card p {
    font-size: 14px;
    margin-bottom: 12px;
    color: #334155;
  }

  .card p strong {
    font-weight: 700;
    color: #0f172a;
  }

  .card hr {
    border: none;
    border-top: 1px dashed var(--line);
    margin: 22px 0;
  }

  /* ================= ALERT BOX ================= */
  .alert {
    background: linear-gradient(135deg, #fee2e2, #fff5f5);
    padding: 22px;
    border-radius: 18px;
    font-size: 16px;
    font-weight: 800;
    color: var(--red);
    box-shadow: 0 16px 40px rgba(185, 28, 28, .18);
  }

  /* ================= RESPONSIVE CONTENT ================= */

  /* TABLET (≤ 992px) */
  @media (max-width: 992px) {

    .wrapper {
      padding: 0 12px;
    }

    /* KPI jadi 2 kolom */
    .kpis {
      grid-template-columns: repeat(2, 1fr);
    }

    .kpi h2 {
      font-size: 28px;
    }

    /* Chart & card jadi satu kolom */
    .grid,
    .bottom {
      grid-template-columns: 1fr;
    }

    .card {
      padding: 24px;
    }

    canvas {
      height: 300px !important;
    }

    /* Table font diperkecil */
    table {
      font-size: 13px;
    }
  }

  /* MOBILE (≤ 576px) */
  @media (max-width: 576px) {

    .wrapper {
      padding: 0 8px;
    }

    /* KPI 1 kolom */
    .kpis {
      grid-template-columns: 1fr;
      gap: 14px;
    }

    .kpi {
      padding: 18px 18px 24px;
    }

    .kpi h2 {
      font-size: 26px;
    }

    .badge {
      top: 14px;
      right: 14px;
      font-size: 10px;
      padding: 4px 10px;
    }

    /* Card spacing */
    .card {
      padding: 20px;
      border-radius: 18px;
    }

    .card h3 {
      font-size: 16px;
      margin-bottom: 18px;
    }

    canvas {
      height: 260px !important;
    }

    /* TABLE RESPONSIVE (scroll horizontal) */
    .card table {
      display: block;
      overflow-x: auto;
      white-space: nowrap;
    }

    thead th {
      font-size: 12px;
    }

    tbody td {
      font-size: 12px;
      padding: 12px;
    }

    /* Status & priority lebih kecil */
    .status {
      font-size: 10px;
      padding: 4px 10px;
    }

    .priority {
      font-size: 11px;
    }

    /* Kinerja Admin */
    .card p {
      font-size: 13px;
    }
  }
</style>


<div class="wrapper">

  <!-- ================= KPI ================= -->
  <div class="kpis">
    <div class="kpi">
      <small>Total Laporan</small>
      <h2><?= esc($total) ?></h2>
    </div>

    <div class="kpi">
      <small>Penyelesaian</small>
      <h2><?= esc($completionRate) ?>%</h2>
    </div>

    <div class="kpi">
      <small>Rata-rata Selesai</small>
      <h2><?= esc($avgSelesai) ?> <span class="unit">jam</span></h2>
    </div>

    <div class="kpi alert">
      <span class="badge down">⚠ Risiko</span>
      <small>High Priority Aktif</small>
      <h2><?= esc($highRisk) ?></h2>
    </div>

    <div class="kpi">
      <small>Laporan Bulan Ini</small>
      <h2><?= esc($bulanIni) ?></h2>
    </div>
  </div>

  <!-- ================= GRAFIK ================= -->
  <div class="grid">
    <div class="card">
      <h3>Tren Laporan per Bulan</h3>
      <canvas id="trend"></canvas>
    </div>

    <div class="card">
      <h3>Distribusi Prioritas</h3>
      <canvas id="prioritas"></canvas>
    </div>
  </div>

  <div class="card">
    <h3>Top 5 Gedung Bermasalah</h3>
    <canvas id="gedung"></canvas>
  </div>

  <!-- ================= OPERASIONAL ================= -->
  <div class="bottom">

    <div class="card">
      <h3>Laporan Terbaru</h3>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Gedung</th>
            <th>Status</th>
            <th>Prioritas</th>
            <th>Umur</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($laporanTerbaru as $l): ?>
            <tr>
              <td><?= esc($l['id']) ?></td>
              <td><?= esc($l['gedung']) ?></td>
              <td><span class="status <?= esc($l['status']) ?>"><?= ucfirst($l['status']) ?></span></td>
              <td class="priority <?= esc($l['prioritas']) ?>"><?= ucfirst($l['prioritas']) ?></td>
              <td><?= esc($l['umur_jam']) ?> jam</td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

    <div class="card">
      <h3>Kinerja Admin</h3>
      <?php foreach ($adminPerformance as $a): ?>
        <p><strong><?= esc($a['nama']) ?></strong> — <?= esc($a['total']) ?> aktivitas</p>
      <?php endforeach ?>
      <hr>
      <p><strong>Notifikasi Aktif:</strong> <?= esc($notifikasi) ?></p>
    </div>

  </div>
</div>

<script>
  new Chart(document.getElementById('trend'), {
    type: 'line',
    data: {
      labels: [<?= implode(',', array_map(fn($t) => "'" . $t['bulan'] . "'", $trendBulanan)) ?>],
      datasets: [{
        data: [<?= implode(',', array_column($trendBulanan, 'total')) ?>],
        borderColor: '#1d4ed8',
        tension: .4
      }]
    },
    options: { plugins: { legend: { display: false } } }
  });

  new Chart(document.getElementById('prioritas'), {
    type: 'doughnut',
    data: {
      labels: [<?= implode(',', array_map(fn($p) => "'" . $p['prioritas'] . "'", $prioritas)) ?>],
      datasets: [{
        data: [<?= implode(',', array_column($prioritas, 'total')) ?>]
      }]
    }
  });

  new Chart(document.getElementById('gedung'), {
    type: 'bar',
    data: {
      labels: [<?= implode(',', array_map(fn($g) => "'" . $g['nama'] . "'", $gedung)) ?>],
      datasets: [{
        data: [<?= implode(',', array_column($gedung, 'total')) ?>],
        backgroundColor: '#2563eb'
      }]
    },
    options: { plugins: { legend: { display: false } } }
  });
</script>

<?= $this->endSection() ?>