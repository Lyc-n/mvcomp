<div class="flex flex-col overflow-hidden rounded-lg bg-v5 px-4 py-6">
    <span class="text-lg font-bold">Products</span>
    <?php if (!empty($_SESSION['cart']['items'])): ?>
        <ul>
            <hr class="my-4 border-0 h-px bg-v3/60">
            <?php foreach ($_SESSION['cart']['items'] as $item): ?>
                <li class="flex justify-between items-start">
                    <span class="text-sm font-medium text-v3/80"><?= $item['nameProduct'] ?></span>
                    <div class="flex flex-col gap-1">
                        <span class="text-sm text-right font-medium text-v3/80">x<?= $item['qty'] ?></span>
                        <span class="text-xs text-right font-light text-v3/65"><?= number_format($item['priceProduct']) ?></span>
                    </div>
                </li>
            <?php endforeach ?>
            <hr class="my-4 border-0 h-px bg-v3/60">
        </ul>

        <strong>Total: <?= number_format($_SESSION['cart']['total']) ?></strong>
    <?php endif ?>
</div>