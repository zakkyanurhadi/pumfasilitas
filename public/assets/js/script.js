// --- FUNGSI UI TETAP SAMA --- //

function toggleDropdown() {
  const dropdown = document.getElementById("profileDropdown");
  dropdown.style.display =
    dropdown.style.display === "block" ? "none" : "block";
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

function closeReportModalAdmin() {
  document.getElementById("reportModal").style.display = "none";
}


function closeReportModal() {
  document.getElementById("reportModal").style.display = "none";
}

function openReportModal(id) {
  document.getElementById("reportModal").style.display = "block";
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
  window.location.href = "lapor/status";
}

function showHistory() {
  window.location.href = "lapor/riwayat";
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

function toggleSidebar() {
    const sidebar = document.querySelector(".sidebar");
    const toggle = document.querySelector(".sidebar-toggle");
    const icon = toggle.querySelector("i");
    const isMobile = window.innerWidth <= 768;

    if (isMobile) {
        // MOBILE LOGIC: Toggle 'mobile-active' class to slide in/out
        sidebar.classList.toggle("mobile-active");
        
        // Create or toggle overlay
        let overlay = document.querySelector(".sidebar-overlay");
        if (!overlay) {
            overlay = document.createElement("div");
            overlay.className = "sidebar-overlay";
            document.body.appendChild(overlay);
            overlay.addEventListener("click", toggleSidebar); // Close on overlay click
        }
        overlay.classList.toggle("active");
        
        // Update Icon - menggunakan Font Awesome icons untuk mobile
        const isActive = sidebar.classList.contains("mobile-active");
        icon.textContent = ""; // Kosongkan text content dulu
        icon.className = isActive ? "toggle-icon fa-solid fa-times" : "toggle-icon fa-solid fa-bars";
        
    } else {
        // DESKTOP LOGIC: Toggle 'sidebar-closed' (Collapse/Expand)
        sidebar.classList.toggle("sidebar-closed");
        toggle.classList.toggle("closed");

        // Update icon - menggunakan karakter Unicode untuk desktop
        const isClosed = sidebar.classList.contains("sidebar-closed");
        icon.className = "toggle-icon"; // Remove Font Awesome classes
        icon.textContent = isClosed ? "❯" : "❮"; // Right chevron (expand) or left chevron (collapse)

        // Tambahan: atur body agar main-content ikut menyesuaikan
        if (sidebar.classList.contains("sidebar-closed")) {
            document.body.classList.add("sidebar-closed");
            document.body.classList.remove("sidebar-open");
        } else {
            document.body.classList.add("sidebar-open");
            document.body.classList.remove("sidebar-closed");
        }
    }
}

// Dropdown sidebar
document.querySelectorAll('.sidebar-dropdown > a').forEach(drop => {
    drop.addEventListener('click', function (e) {
        e.preventDefault();

        const parent = this.parentElement;
        const submenu = parent.querySelector('.sidebar-submenu');

        // Tutup yang lain
        document.querySelectorAll('.sidebar-dropdown').forEach(item => {
            if (item !== parent) {
                item.classList.remove('active');
                const sub = item.querySelector('.sidebar-submenu');
                if (sub) sub.style.maxHeight = null;
            }
        });

        // Toggle dropdown yang diklik
        parent.classList.toggle('active');
        submenu.style.maxHeight = parent.classList.contains('active') 
            ? submenu.scrollHeight + "px"
            : null;
    });
});

// ===== AUTO OPEN DROPDOWN JIKA SUBMENU AKTIF =====
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    // Pasang event listener ke tombol toggle
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }

    // Tutup sidebar mobile jika klik di luar area sidebar
    document.addEventListener('click', function(event) {
        const sidebar = document.querySelector('.sidebar');
        const isClickInsideSidebar = sidebar && sidebar.contains(event.target);
        const isClickOnToggle = sidebarToggle && sidebarToggle.contains(event.target);
        const isMobile = window.innerWidth <= 768;

        if (!isClickInsideSidebar && !isClickOnToggle && isMobile && sidebar.classList.contains('mobile-active')) {
            toggleSidebar();
        }
    });
});


// Panggil animasi saat DOM siap
document.addEventListener("DOMContentLoaded", animateCounters);

// Set icon yang benar saat page load
document.addEventListener("DOMContentLoaded", function() {
    const toggle = document.querySelector(".sidebar-toggle");
    const icon = toggle?.querySelector("i");
    const isMobile = window.innerWidth <= 768;
    
    if (icon && isMobile) {
        // Di mobile, set ke Font Awesome hamburger icon
        icon.className = "toggle-icon fa-solid fa-bars";
        icon.textContent = "";
    }
    // Di desktop, biarkan default ❮ dari HTML
});

