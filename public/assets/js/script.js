// --- FUNGSI UI TETAP SAMA --- //

function toggleDropdown() {
  const dropdown = document.getElementById("profileDropdown");
  dropdown.style.display =
    dropdown.style.display === "block" ? "none" : "block";
}

function openReportModal() {
  document.getElementById("reportModal").style.display = "block";
}
function openReportModalAdmin(id) {
  const modal = document.getElementById("reportModal");
  const form = document.getElementById("reportForm");

  // Set action form ke URL verifikasi sesuai ID

  // Simpan juga ke input hidden jika diperlukan
  document.getElementById("laporan_id").value = id;

  // Tampilkan modal
  modal.style.display = "block";
}

function closeReportModal() {
  document.getElementById("reportModal").style.display = "none";
}



window.onclick = function (event) {
  const modal = document.getElementById("reportModal");
  if (event.target == modal) {
    closeReportModal();
  }

  if (!event.target.closest(".user-profile")) {
    document.getElementById("profileDropdown").style.display = "none";
  }
};

// Event listener untuk preview gambar (tetap sama)
document.getElementById("foto")?.addEventListener("change", function (e) {
  const previewContainer = document.getElementById("imagePreviewContainer");
  const fileNameSpan = document.getElementById("fileName");
  const files = e.target.files;
  previewContainer.innerHTML = "";
  fileNameSpan.textContent = "";

  if (files.length > 0) {
    fileNameSpan.textContent =
      files.length === 1 ? files[0].name : `${files.length} file dipilih`;
    for (const file of files) {
      if (file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function (event) {
          const img = document.createElement("img");
          img.src = event.target.result;
          previewContainer.appendChild(img);
        };
        reader.readAsDataURL(file);
      }
    }
  }
});

// Placeholder functions
function showReportsList() {
  window.location.href = "laporan/status";
}

function showHistory() {
  window.location.href = "laporan/riwayat";
}

// Smooth scroll
document.querySelectorAll(".nav-menu a").forEach((link) => {
  /* ... (logika smooth scroll tetap sama) ... */
});

// Animasi counter untuk statistik
function animateCounters() {
  const counters = document.querySelectorAll(".stat-card .number");
  counters.forEach((counter) => {
    const target = parseInt(counter.textContent) || 0;
    let current = 0;
    const increment = target / 50;
    const updateCounter = () => {
      if (current < target) {
        current = Math.min(current + increment, target);
        counter.textContent = Math.floor(current);
        requestAnimationFrame(updateCounter);
      } else {
        counter.textContent = target;
      }
    };
    updateCounter();
  });
}

// Panggil animasi saat DOM siap
document.addEventListener("DOMContentLoaded", animateCounters);
