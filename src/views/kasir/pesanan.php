<div class="w-full h-dvh flex flex-col bg-linear-to-br from-v5 to-v6 p-3">
    <h1 class="text-3xl font-bold">Pesanan</h1>
    <?php if (empty($orderHistory)): ?>
        <div class="text-center text-v3/70 mt-5">
            Belum ada pesanan
        </div>
    <?php else: ?>
        <div class="flex flex-wrap gap-5 mt-5">
            <?php foreach ($orderHistory as $order): ?>
                <div class="bg-v5 rounded-xl shadow-md/40 p-5 w-md hover:scale-105 transition transform">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-3">
                        <p class="text-sm font-bold text-v3">Order ID: <?= $order['order_id'] ?></p>

                        <form hx-post="/mvcomp/kasir/upStatus" hx-target="closest div.bg-v5" hx-swap="outerHTML">
                            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                            <select name="status" class="px-3 py-1 rounded-full text-xs font-semibold cursor-pointer"
                                onchange="this.form.submit()">
                                <?php
                                $statuses = ['antri', 'dibuat', 'diantar', 'selesai'];
                                foreach ($statuses as $status): ?>
                                    <option value="<?= $status ?>" <?= $status === $order['status'] ? 'selected' : '' ?>>
                                        <?= ucfirst($status) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>


                    </div>


                    <!-- Waktu Order -->
                    <p class="text-xs text-v3/60 mb-3">Waktu: <?= $order['created_at'] ?></p>

                    <hr class="mb-3 border-v3/30">

                    <!-- Items -->
                    <div class="flex flex-col gap-2 mb-3">
                        <?php foreach ($order['items'] as $item): ?>
                            <div class="flex justify-between text-xs">
                                <span><?= $item['qty'] ?> x <?= $item['nameProduct'] ?></span>
                                <span>Rp <?= number_format($item['priceProduct']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <hr class="mb-2 border-v3/30">

                    <!-- Total -->
                    <div class="flex justify-between mt-2">
                        <span class="text-sm font-medium">Total</span>
                        <span class="text-sm font-bold">Rp <?= number_format($order['total']) ?></span>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>