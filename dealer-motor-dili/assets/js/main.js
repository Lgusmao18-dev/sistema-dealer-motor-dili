// Admin JS — Dealer Motor Dili

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const main    = document.getElementById('mainContent');
    if (window.innerWidth <= 992) {
        sidebar.classList.toggle('open');
    } else {
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('expanded');
    }
}

// Navbar scroll shadow
window.addEventListener('scroll', () => {
    const nav = document.querySelector('.top-navbar');
    if (nav) nav.style.boxShadow = window.scrollY > 10 ? '0 2px 12px rgba(0,0,0,.12)' : '0 1px 4px rgba(0,0,0,.08)';
});

// Auto close alert after 4s
document.querySelectorAll('.alert-dismissible').forEach(el => {
    setTimeout(() => {
        const btn = el.querySelector('.btn-close');
        if (btn) btn.click();
    }, 4000);
});