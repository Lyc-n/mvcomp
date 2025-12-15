<?php if (empty($products)): ?>
    <div class="p-6 text-center text-gray-500">
        Data tidak ditemukan
    </div>
<?php else: ?>
    <table class="table-auto border-collapse">
        <thead>
            <tr class="border-b border-gray-400 bg-v6">
                <th class="text-sm font-medium text-left px-4 py-2">Full Name</th>
                <th class="text-sm font-medium text-left px-4 py-2">Description</th>
                <th class="text-sm font-medium text-left px-4 py-2">Price</th>
                <th class="text-sm font-medium text-left px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td class="text-sm px-4 py-2 flex">
                        <?= htmlspecialchars($product['name']) ?>
                    </td>
                    <td class="text-sm px-4 py-2"><?= htmlspecialchars($product['description']) ?></td>
                    <td class="text-sm px-4 py-2">Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                    <td class="px-4 py-2 text-right">
                        <div class="">
                            <button
                                hx-post="/mvcomp/admin/add/product"
                                hx-target="#table"
                                hx-confirm="Yakin ingin menghapus product ini?"
                                type="button"
                                name="deleteProduct"
                                value="<?= $product['id'] ?>"
                                class="transform transition-all duration-150 active:scale-95 active:shadow-inner">
                                <i class="mr-1 ph-bold ph-x text-v5 bg-v2 py-1.5 px-2.5 rounded-md"></i>
                            </button>
                            <button
                                hx-post="/mvcomp/admin/add/product"
                                hx-target="#notif"
                                hx-swap="outerHTML"
                                hx-vals='{"id": <?= $product["id"] ?>}'
                                type="button"
                                name="loadEditProduct"
                                class="transform transition-all duration-150 active:scale-95 active:shadow-inner">
                                <i class="ml-1 ph-bold ph-pencil-simple-line bg-v7 px-2.5 py-1.5 rounded"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>