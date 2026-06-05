// Sidebar functionality

const toggleButton = document.querySelector('.toggle-sidebar');
const sidebar = document.querySelector('.sidebar');
const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

// Toggle sidebar on mobile
if (toggleButton) {
    toggleButton.addEventListener('click', function() {
        sidebar.classList.toggle('show');
    });
}

// Toggle dropdown menus
dropdownToggles.forEach(toggle => {
    toggle.addEventListener('click', function(e) {
        e.preventDefault();
        const parent = this.parentElement;
        const dropdown = parent.querySelector('.dropdown-menu');
        
        if (dropdown) {
            // Close other open dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu !== dropdown) {
                    menu.style.maxHeight = '0';
                }
            });
            
            // Toggle current dropdown
            if (dropdown.style.maxHeight === '0px' || !dropdown.style.maxHeight) {
                dropdown.style.maxHeight = dropdown.scrollHeight + 'px';
            } else {
                dropdown.style.maxHeight = '0';
            }
        }
    });
});

// Close sidebar when clicking on a link
const navLinks = document.querySelectorAll('.nav-link');
navLinks.forEach(link => {
    link.addEventListener('click', function() {
        if (window.innerWidth < 768) {
            sidebar.classList.remove('show');
        }
    });
});

// Close sidebar when clicking outside
document.addEventListener('click', function(e) {
    if (!sidebar.contains(e.target) && !toggleButton.contains(e.target)) {
        if (window.innerWidth < 768) {
            sidebar.classList.remove('show');
        }
    }
});