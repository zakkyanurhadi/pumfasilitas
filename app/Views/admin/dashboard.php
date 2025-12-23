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
    overflow-x: hidden;
  }

  .wrapper {
    max-width: 100%;
    overflow-x: hidden;
    width: 100%;
    padding: 0;
    /* Remove padding - main-content already handles it */
  }

  /* ================= KPI ================= */
  .kpis {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    /* 5 card sejajar */
    gap: 16px;
    margin-bottom: 28px;
  }

  .kpi {
    background: linear-gradient(180deg, #ffffff, #fdfefe);
    border-radius: 22px;

    /* 🔑 hanya memendekkan kiri–kanan */
    padding: 20px 30px 22px;

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

  /* Text */
  .kpi small {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .35px;
    color: var(--muted);
    font-weight: 600;
  }

  .kpi h2 {
    margin-top: 8px;
    font-size: 26px;
    font-weight: 800;
    letter-spacing: -.4px;
  }

  .kpi .unit {
    font-size: 13px;
    font-weight: 600;
    color: var(--muted);
    margin-left: 3px;
  }

  /* Alert */
  .kpi.alert {
    background: linear-gradient(180deg, #fff7ed, #ffedd5);
  }

  .kpi .badge {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 999px;
    font-weight: 600;
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
    border-radius: 25px;
  }

  .card {
    background: var(--card);
    border-radius: 25px;
    padding: 20px;
    box-shadow: var(--shadow-xs);
    position: relative;
    max-width: 100%;
    overflow: hidden;
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
  .chart-container {
    width: 100%;
    max-width: 100%;
    overflow-x: auto;
  }

  canvas {
    width: 100% !important;
    height: 340px !important;
    max-width: 100%;
  }

  /* ================= BOTTOM ================= */
  .bottom {
    margin-top: 20px;
    display: grid;
    grid-template-columns: 1fr;
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

  thead th:first-child,
  thead th:last-child {
    text-align: center;
  }

  tbody tr {
    background: #ffffff;
    box-shadow: var(--shadow-xs);
    border-radius: 14px;
  }

  tbody td {
    padding: 14px 16px;
    vertical-align: middle;
  }

  tbody td:first-child,
  tbody td:last-child {
    text-align: center;
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
  .alert-box {
    background: linear-gradient(135deg, #fee2e2, #fff5f5);
    padding: 22px;
    border-radius: 18px;
    font-size: 16px;
    font-weight: 800;
    color: var(--red);
    box-shadow: 0 16px 40px rgba(185, 28, 28, .18);
  }

  /* ================= ADMIN PERFORMANCE MODERN ================= */
  .admin-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .admin-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    background: #f8fafc;
    border-radius: 12px;
    border-left: 4px solid #6366f1;
    transition: all 0.3s ease;
    max-width: 100%;
    overflow: hidden;
  }

  .admin-item:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
  }

  .admin-item:nth-child(2) {
    border-left-color: #06b6d4;
  }

  .admin-item:nth-child(3) {
    border-left-color: #f59e0b;
  }

  .admin-item:nth-child(4) {
    border-left-color: #10b981;
  }

  .admin-item .admin-info {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .admin-item .admin-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: #6366f1;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 14px;
  }

  .admin-item:nth-child(2) .admin-avatar {
    background: #06b6d4;
  }

  .admin-item:nth-child(3) .admin-avatar {
    background: #f59e0b;
  }

  .admin-item:nth-child(4) .admin-avatar {
    background: #10b981;
  }

  .admin-item .admin-name {
    font-weight: 600;
    color: #1e293b;
    font-size: 14px;
  }

  .admin-item .admin-count {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: white;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    color: #6366f1;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
  }

  .admin-item .admin-count i {
    font-size: 12px;
  }

  /* Notifikasi Aktif Card */
  .notifikasi-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    background: #6366f1;
    border-radius: 12px;
    color: white;
    margin-top: 16px;
  }

  .notifikasi-card .notif-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    font-size: 14px;
  }

  .notifikasi-card .notif-label i {
    font-size: 18px;
  }

  .notifikasi-card .notif-count {
    font-size: 24px;
    font-weight: 800;
  }

  /* ================= TABLE WRAPPER ================= */
  .table-wrapper {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  /* ================= RESPONSIVE CONTENT ================= */

  /* TABLET (≤ 992px) */
  @media (max-width: 992px) {

    .wrapper {
      padding: 0;
      /* No padding - alignment handled by main-content */
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
      border-radius: 25px;
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
      padding: 0;
      /* No padding - alignment handled by main-content */
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
      padding: 16px;
      border-radius: 25px;
      max-width: 100%;
      overflow: hidden;
    }

    /* Chart container scroll horizontal */
    .chart-container {
      width: 100%;
      max-width: 100%;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    canvas {
      height: 220px !important;
      min-width: 300px;
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

    /* Kinerja Admin Mobile */
    .admin-item {
      padding: 12px 14px;
    }

    .admin-item .admin-avatar {
      width: 36px;
      height: 36px;
      font-size: 12px;
    }

    .admin-item .admin-name {
      font-size: 13px;
    }

    .admin-item .admin-count {
      padding: 4px 10px;
      font-size: 12px;
    }

    .notifikasi-card {
      flex-direction: column;
      gap: 10px;
      text-align: center;
    }

    .notifikasi-card .notif-count {
      font-size: 28px;
    }

    /* Admin item flex wrap */
    .admin-item {
      flex-wrap: wrap;
      gap: 10px;
    }

    .admin-item .admin-info {
      flex: 1;
      min-width: 150px;
    }
  }

  /* SMALL MOBILE (≤ 480px) */
  @media (max-width: 480px) {
    .wrapper {
      padding: 0;
      /* No padding - alignment handled by main-content */
    }

    .card {
      padding: 14px;
      border-radius: 12px;
    }

    .card h3 {
      font-size: 14px;
      margin-bottom: 14px;
    }

    /* Table wrapper with better scroll */
    .table-wrapper {
      margin: 0 -14px;
      padding: 0 14px;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    .table-wrapper table {
      min-width: 500px;
    }

    thead th {
      font-size: 11px;
      padding: 8px 10px;
    }

    tbody td {
      font-size: 11px;
      padding: 10px;
    }

    .status {
      font-size: 9px;
      padding: 3px 8px;
    }

    /* Kinerja Admin Small Mobile */
    .admin-list {
      gap: 8px;
    }

    .admin-item {
      padding: 10px 12px;
      flex-direction: row;
      align-items: center;
    }

    .admin-item .admin-avatar {
      width: 32px;
      height: 32px;
      font-size: 10px;
      border-radius: 8px;
    }

    .admin-item .admin-info {
      gap: 8px;
    }

    .admin-item .admin-name {
      font-size: 12px;
    }

    .admin-item .admin-count {
      padding: 3px 8px;
      font-size: 10px;
      gap: 4px;
    }

    .admin-item .admin-count i {
      font-size: 10px;
    }

    .notifikasi-card {
      padding: 12px 16px;
      margin-top: 12px;
    }

    .notifikasi-card .notif-label {
      font-size: 12px;
      gap: 6px;
    }

    .notifikasi-card .notif-label i {
      font-size: 14px;
    }

    .notifikasi-card .notif-count {
      font-size: 24px;
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
      <div class="chart-container">
        <canvas id="trend"></canvas>
      </div>
    </div>

    <div class="card">
      <h3>Distribusi Prioritas</h3>
      <div class="chart-container">
        <canvas id="prioritas"></canvas>
      </div>
    </div>
  </div>

  <div class="card">
    <h3>Top 5 Gedung Bermasalah</h3>
    <div class="chart-container">
      <canvas id="gedung"></canvas>
    </div>
  </div>

  <!-- ================= OPERASIONAL ================= -->
  <div class="bottom">

    <div class="card">
      <h3>Laporan Terbaru</h3>
      <div class="table-wrapper">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Gedung</th>
              <th>Status</th>
              <th>Prioritas</th>
              <th>Waktu Berlalu</th>
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
    </div>

    <div class="card">
      <h3><i class="fas fa-users" style="margin-right: 8px; color: #6366f1;"></i>Kinerja Admin</h3>
      <div class="admin-list">
        <?php foreach ($adminPerformance as $index => $a): ?>
          <div class="admin-item">
            <div class="admin-info">
              <div class="admin-avatar">
                <?= strtoupper(substr($a['nama'], 0, 2)) ?>
              </div>
              <span class="admin-name"><?= esc($a['nama']) ?></span>
            </div>
            <div class="admin-count">
              <i class="fas fa-check-circle"></i>
              <?= esc($a['total']) ?> aktivitas
            </div>
          </div>
        <?php endforeach ?>
      </div>

      <div class="notifikasi-card">
        <div class="notif-label">
          <i class="fas fa-bell"></i>
          Notifikasi Aktif
        </div>
        <div class="notif-count"><?= esc($notifikasi) ?></div>
      </div>
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