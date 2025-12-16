<div class="flex flex-col overflow-hidden rounded-lg">
    <div class="">
        <img
            src="/mvcomp/public/img/menu/<?= htmlspecialchars($detailMenu['image']) ?>"
            alt="Mie Ayam"
            class="w-sm aspect-square object-center object-cover hover:scale-105 transition-all duration-300 ease-in-out" />
    </div>
    <div class="text-base font-semibold px-4 py-2.5">
        <h4 class="line-clamp-1"><?= htmlspecialchars($detailMenu['name']) ?></h4>
        <h4 class="text-sm font-medium text-v3/70"><?= htmlspecialchars($detailMenu['description']) ?></h4>
        <p class="text-sm font-medium">Rp. <?= number_format($detailMenu['price'], 0, ',', '.') ?></p>
        <button
            class="p-2 w-full rounded-md mt-1.5
                        bg-v1 hover:bg-v2
                        shadow-sm/60
                        text-v5 font-semibold
                        flex items-center justify-center
                        active:scale-95 transition">
            Pesan Sekarang
        </button>
    </div>
</div>