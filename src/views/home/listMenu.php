<?php foreach ($menus as $menu): ?>
    <div
        class="bg-white rounded-xl shadow-sm/40 relative overflow-hidden w-fit h-fit">
        <div class="">
            <img
                src="/mvcomp/public/img/menu/<?= htmlspecialchars($menu['image']) ?>"
                alt="Mie Ayam"
                class="w-[200px] aspect-square object-center object-cover hover:scale-105 transition-all duration-300 ease-in-out" />
        </div>
        <div class="text-base font-semibold px-4 py-2.5">
            <h4 class="line-clamp-1"><?= htmlspecialchars($menu['name']) ?></h4>
            <p class="text-sm font-medium">Rp. <?= number_format($menu['price'], 0, ',', '.') ?></p>
            <button
                class="absolute bottom-3 right-3
                        w-8 h-8 rounded-full
                        bg-white
                        shadow-sm/60
                        text-xl font-bold
                        flex items-center justify-center
                        active:scale-95 transition">
                +
            </button>
        </div>
    </div>
<?php endforeach; ?>