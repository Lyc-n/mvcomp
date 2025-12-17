<?php foreach ($menus as $menu): ?>
    <div class="relative">
        <div
            hx-post="/mvcomp/"
            hx-trigger="click"
            hx-target="#notif"
            hx-vals='{"id": <?= htmlspecialchars($menu['id']) ?>}'
            class="bg-white rounded-xl shadow-sm/40 relative overflow-hidden w-fit h-fit"
            onclick=" const f = document.getElementById('detailMenu'); f.classList.remove('hidden'); f.classList.add('flex');">
            <div class="">
                <img
                    src="/mvcomp/public/img/menu/<?= htmlspecialchars($menu['image']) ?>"
                    alt="Mie Ayam"
                    class="w-[200px] aspect-square object-center object-cover hover:scale-105 transition-all duration-300 ease-in-out" />
            </div>
            <div class="text-base font-semibold px-4 py-2.5">
                <h4 class="line-clamp-1"><?= htmlspecialchars($menu['name']) ?></h4>
                <p class="text-sm font-medium">Rp. <?= number_format($menu['price'], 0, ',', '.') ?></p>
            </div>
        </div>
        <button
            hx-post="/mvcomp/"
            hx-trigger="click"
            hx-target="#cookie"
            hx-vals='{"addCart": 1, "idProduct": <?= htmlspecialchars($menu['id']) ?>, "idTable": <?= $param ?>, "idUser": <?= $_SESSION['user']['id'] ?>}'
            onclick="event.stopPropagation()"
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
<?php endforeach; ?>