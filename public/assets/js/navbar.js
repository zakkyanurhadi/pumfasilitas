// Toggle Dropdown Menu
function toggleDropdown() {
    const dropdown = document.getElementById('profileDropdown');
    dropdown.classList.toggle('show');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('profileDropdown');
    const profileInfo = document.querySelector('.profile-info');
    
    if (!dropdown || !profileInfo) return;
    
    if (!profileInfo.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.remove('show');
    }
});

// Close dropdown on ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown) {
            dropdown.classList.remove('show');
        }
    }
});

// Active menu highlight
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-menu li a');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath || 
            currentPath.includes(link.getAttribute('href').split('/').pop())) {
            link.style.background = 'rgba(255, 255, 255, 0.2)';
        }
    });
});