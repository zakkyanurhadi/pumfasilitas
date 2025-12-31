<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<style>
  /* Modern Form Styling */
  .form-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
    background: #fff;
    overflow: hidden;
  }

  .form-header-line {
    height: 6px;
    background: #f1f5f9;
    width: 100%;
    position: relative;
  }

  .form-header-progress {
    background: var(--primary-blue);
    height: 100%;
    width: 33%;
    border-radius: 0 4px 4px 0;
  }

  .section-icon {
    width: 40px;
    height: 40px;
    background: rgba(44, 94, 243, 0.1);
    color: var(--primary-blue);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
  }

  .form-label {
    font-weight: 500;
    color: #4a5568;
    margin-bottom: 0.5rem;
  }

  .form-control,
  .form-select {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.2s;
  }

  .form-control:focus,
  .form-select:focus {
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 3px rgba(44, 94, 243, 0.15);
  }

  /* File Upload Styling */
  .drop-zone {
    border: 2px dashed #cbd5e0;
    border-radius: 10px;
    padding: 2rem;
    text-align: center;
    transition: all 0.2s;
    cursor: pointer;
    background: #f8fafc;
  }

  .drop-zone:hover {
    border-color: var(--primary-blue);
    background: #ebf8ff;
  }

  .drop-zone.dragover {
    border-color: var(--primary-blue);
    background: #e6fffa;
  }

  .upload-icon {
    font-size: 2.5rem;
    color: #a0aec0;
    margin-bottom: 0.5rem;
    transition: color 0.2s;
  }

  .drop-zone:hover .upload-icon {
    color: var(--primary-blue);
  }

  /* Button Styling */
  .btn-submit {
    background: var(--primary-blue);
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s;
    box-shadow: 0 4px 12px rgba(44, 94, 243, 0.2);
    color: white;
  }

  .btn-submit:hover {
    background: var(--dark-blue);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(44, 94, 243, 0.3);
    color: white;
  }

  .btn-cancel {
    background: #fff;
    border: 1px solid #e2e8f0;
    color: #4a5568;
    padding: 0.8rem 2rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s;
  }

  .btn-cancel:hover {
    background: #f7fafc;
    color: #2d3748;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-5">
  <!-- Header Section -->
  <div class="row justify-content-center mb-5">
    <div class="col-lg-8 text-center">
      <h1 class="fw-bold mb-3">
        <span class="text-primary">Form Pelaporan</span> Kerusakan
      </h1>
      <p class="text-secondary">
        Isi formulir di bawah dengan keterangan kerusakan fasilitas kampus
        secara jelas agar laporan Anda dapat segera diproses.
      </p>
    </div>
  </div>

  <!-- Form Container -->
  <div class="row justify-content-center">
    <div class="col-lg-9">
      <div class="form-card">
        <!-- Progress Indicator -->
        <div class="form-header-line">
          <div class="form-header-progress"></div>
        </div>

        <div class="p-4 p-md-5">
          <form id="damageForm" action="<?= base_url('laporan/store') ?>" method="POST" enctype="multipart/form-data"
            novalidate>

            <!-- Section 1: Identitas -->
            <div class="mb-5">
              <div class="d-flex align-items-center gap-3 mb-4 pb-2 border-bottom">
                <div class="section-icon">
                  <i class="bi bi-person-badge"></i>
                </div>
                <h4 class="mb-0 fw-bold">Identitas Pelapor</h4>
              </div>

              <div class="row">
                <div class="col-md-12 mb-3">
                  <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="name" name="nama_pelapor"
                    placeholder="Masukkan nama lengkap Anda" required>
                  <div class="invalid-feedback">Nama wajib diisi.</div>
                </div>
              </div>
            </div>

            <!-- Section 2: Lokasi & Kategori -->
            <div class="mb-5">
              <div class="d-flex align-items-center gap-3 mb-4 pb-2 border-bottom">
                <div class="section-icon">
                  <i class="bi bi-geo-alt"></i>
                </div>
                <h4 class="mb-0 fw-bold">Lokasi & Kategori Kerusakan</h4>
              </div>

              <div class="row gy-3">
                <div class="col-12">
                  <label for="gedung" class="form-label">Gedung / Area <span class="text-danger">*</span></label>
                  <select class="form-select" id="gedung" name="gedung_id" required>
                    <option value="" disabled selected>Pilih Lokasi Gedung</option>
                    <?php foreach ($gedung as $g): ?>
                      <option value="<?= esc($g['id']) ?>"><?= esc($g['nama']) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <div class="invalid-feedback">Silakan pilih gedung.</div>
                </div>

                <div class="col-12">
                  <label for="ruangan" class="form-label">Detail Ruangan <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="ruangan" name="lokasi_kerusakan"
                    placeholder="Contoh: Lab Komputer D3, R.304, Toilet Pria Lt.2, Koridor Utama" required>
                  <div class="invalid-feedback">Detail ruangan wajib diisi.</div>
                </div>

                <div class="col-12">
                  <label for="lokasi_spesifik" class="form-label">Lokasi Spesifik (Opsional)</label>
                  <textarea class="form-control" id="lokasi_spesifik" name="lokasi_spesifik" rows="2"
                    placeholder="Contoh: Di sudut kanan belakang dekat saklar, di plafon atas pintu masuk, di bawah meja dosen"></textarea>
                </div>

                <div class="col-12">
                  <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="kategori" name="kategori"
                    placeholder="Contoh: AC, Proyektor, Kursi Kuliah, Jendela, Keramik Lantai, Papan Tulis" required>
                  <div class="invalid-feedback">Kategori wajib diisi.</div>
                </div>

                <div class="col-12">
                  <label for="prioritas" class="form-label">Tingkat Prioritas <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text bg-white" id="prioritas-icon"><i
                        class="bi bi-exclamation-circle text-secondary"></i></span>
                    <select class="form-select fw-bold text-secondary" id="prioritas" name="prioritas" required
                      onchange="changePriorityColor(this)">
                      <option value="" disabled selected>Pilih Prioritas</option>
                      <option value="low" class="text-success fw-bold">&#128994; Rendah (Kerusakan Ringan)</option>
                      <option value="medium" class="text-warning fw-bold">&#128993; Sedang (Mengganggu Fungsi)
                      </option>
                      <option value="high" class="text-danger fw-bold">&#128308; Tinggi (Darurat / Bahaya)</option>
                    </select>
                  </div>
                  <div class="invalid-feedback">Silakan pilih prioritas kerusakan.</div>
                </div>
              </div>
            </div>

            <!-- Section 3: Detail Kerusakan -->
            <div class="mb-4">
              <div class="d-flex align-items-center gap-3 mb-4 pb-2 border-bottom">
                <div class="section-icon">
                  <i class="bi bi-card-text"></i>
                </div>
                <h4 class="mb-0 fw-bold">Detail Kerusakan</h4>
              </div>

              <div class="row">
                <div class="col-12 mb-4">
                  <label for="deskripsi" class="form-label">Deskripsi Masalah <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5"
                    placeholder="Jelaskan kondisi kerusakan secara rinci (minimal 20 karakter)..." required
                    minlength="20"></textarea>
                  <div class="d-flex justify-content-between mt-1">
                    <div class="invalid-feedback">Deskripsi minimal 20 karakter.</div>
                    <small class="text-muted ms-auto">Min. 20 Karakter</small>
                  </div>
                </div>

                <div class="col-12">
                  <label class="form-label d-block mb-2">Foto Bukti Kerusakan</label>
                  <input type="file" id="file-upload" name="foto" class="d-none" accept="image/*">

                  <div class="drop-zone" id="drop-zone">
                    <div class="upload-icon">
                      <i class="bi bi-cloud-arrow-up"></i>
                    </div>
                    <h6 class="fw-bold mb-1" id="file-label">Upload Foto</h6>
                    <p class="text-muted small mb-0" id="file-info">Klik atau seret file ke sini</p>
                    <p class="text-muted small mt-1">Format: JPG, PNG (Max. 5MB)</p>
                    <div id="preview-container" class="mt-3 d-none">
                      <img id="image-preview" src="#" alt="Preview" class="img-fluid rounded border"
                        style="max-height: 200px;">
                      <div class="mt-2">
                        <button type="button" class="btn btn-sm btn-outline-danger" id="remove-file">
                          <i class="bi bi-trash me-1"></i> Hapus Foto
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Actions -->
            <div class="d-flex gap-3 justify-content-end pt-4 border-top mt-4">
              <button type="button" class="btn btn-cancel" onclick="window.history.back()">Batal</button>
              <button type="submit" class="btn btn-submit" id="btn-submit">
                <i class="bi bi-send me-2"></i> Kirim Laporan
              </button>
            </div>

          </form>
        </div>
      </div>

      <!-- Call Center info -->
      <div class="text-center mt-5 mb-5">
        <p class="text-muted mb-0">Butuh bantuan mendesak?</p>
        <p class="mb-0">Hubungi Call Center di <a href="#"
            class="text-primary fw-bold text-decoration-none">0812-3456-7890</a></p>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  // === CHANGE COLOR DROPDOWN PRIORITAS ===
  function changePriorityColor(select) {
    const val = select.value;
    const icon = document.getElementById('prioritas-icon').querySelector('i');

    // Reset classes
    select.classList.remove('text-secondary', 'text-success', 'text-warning', 'text-danger', 'border-success', 'border-warning', 'border-danger');
    icon.classList.remove('text-secondary', 'text-success', 'text-warning', 'text-danger');

    if (val === 'low') {
      select.classList.add('text-success', 'border-success');
      icon.classList.add('text-success', 'bi-check-circle');
      icon.classList.remove('bi-exclamation-circle', 'bi-exclamation-triangle', 'bi-x-circle');
    } else if (val === 'medium') {
      select.classList.add('text-warning', 'border-warning');
      icon.classList.add('text-warning', 'bi-exclamation-circle');
      icon.classList.remove('bi-check-circle', 'bi-exclamation-triangle', 'bi-x-circle');
    } else if (val === 'high') {
      select.classList.add('text-danger', 'border-danger');
      icon.classList.add('text-danger', 'bi-exclamation-triangle');
      icon.classList.remove('bi-check-circle', 'bi-exclamation-circle', 'bi-x-circle');
    } else {
      select.classList.add('text-secondary');
      icon.classList.add('text-secondary', 'bi-exclamation-circle');
    }
  }

  document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("damageForm");
    const btnSubmit = document.getElementById("btn-submit");

    // File Upload Logic
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-upload');
    const previewContainer = document.getElementById('preview-container');
    const imagePreview = document.getElementById('image-preview');
    const removeFileBtn = document.getElementById('remove-file');
    const fileLabel = document.getElementById('file-label');
    const fileInfo = document.getElementById('file-info');
    const uploadIcon = dropZone.querySelector('.upload-icon');

    // Trigger file input click when dropzone is clicked
    dropZone.addEventListener('click', (e) => {
      if (e.target !== removeFileBtn && !removeFileBtn.contains(e.target)) {
        fileInput.click();
      }
    });

    // Drag and Drop events
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
      dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
      e.preventDefault();
      e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
      dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
      dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
      dropZone.classList.add('dragover');
    }

    function unhighlight(e) {
      dropZone.classList.remove('dragover');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
      const dt = e.dataTransfer;
      const files = dt.files;
      fileInput.files = files;
      handleFiles(files);
    }

    fileInput.addEventListener('change', function () {
      handleFiles(this.files);
    });

    function handleFiles(files) {
      if (files.length > 0) {
        const file = files[0];
        if (file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = function (e) {
            imagePreview.src = e.target.result;
            previewContainer.classList.remove('d-none');

            // Sembunyikan instruksi default
            uploadIcon.classList.add('d-none');
            fileLabel.textContent = file.name;
            fileInfo.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
          }
          reader.readAsDataURL(file);
        } else {
          Swal.fire('Format Salah', 'Harap upload file gambar (JPG, PNG)', 'error');
          resetFile();
        }
      }
    }

    removeFileBtn.addEventListener('click', function (e) {
      e.stopPropagation(); // Mencegah trigger klik dropzone
      resetFile();
    });

    function resetFile() {
      fileInput.value = '';
      previewContainer.classList.add('d-none');
      imagePreview.src = '#';
      uploadIcon.classList.remove('d-none');
      fileLabel.textContent = 'Upload Foto';
      fileInfo.textContent = 'Klik atau seret file ke sini';
    }

    // Form Validation & Submit
    // Form Validation & Submit
    form.addEventListener("submit", function (e) {

      if (!this.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.add('was-validated');

        // Cari elemen invalid pertama dan scroll ke sana
        const firstInvalid = this.querySelector(':invalid');
        if (firstInvalid) {
          firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
          firstInvalid.focus();
        }
        return;
      }

      // Custom Validation (Deskripsi length)
      const deskripsi = document.getElementById('deskripsi');
      if (deskripsi.value.trim().length < 20) {
        e.preventDefault();
        deskripsi.classList.add('is-invalid');
        deskripsi.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
      } else {
        deskripsi.classList.remove('is-invalid');
      }

      // Loading State (Submit will proceed natively)
      const originalBtnContent = btnSubmit.innerHTML;
      btnSubmit.disabled = true;
      btnSubmit.classList.add("opacity-75", "cursor-not-allowed");
      btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Mengirim...';
    });

    // Real-time validation removal
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
      input.addEventListener('input', function () {
        if (this.classList.contains('is-invalid')) {
          this.classList.remove('is-invalid');
        }
      });
    });
  });
</script>
<?= $this->endSection() ?>