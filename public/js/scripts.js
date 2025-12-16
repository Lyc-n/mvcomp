//ganti bg saat button click
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.menu-btn');
    if (!btn) return;

    localStorage.setItem('activeMenu', btn.dataset.menu);

    document.querySelectorAll('.menu-btn').forEach(b => {
        b.classList.remove('bg-v7', 'text-v2');
    });

    btn.classList.add('bg-v7', 'text-v2');
});

//loader
document.addEventListener('DOMContentLoaded', function () {
    const lastMenu = localStorage.getItem('activeMenu');

    // jika belum pernah klik apa pun → default dashboard
    const menuToLoad = lastMenu ?? 'dashboard';

    const btn = document.querySelector(
        `.menu-btn[data-menu="${menuToLoad}"]`
    );

    if (btn) btn.click();
});

//sidebar
const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    toggleBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        sidebar.classList.add('open');
        overlay.classList.remove('hidden');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.add('hidden');
    });