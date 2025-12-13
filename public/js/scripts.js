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