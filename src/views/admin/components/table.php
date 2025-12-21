<div id="<?= $id ?? 'table' ?>">
    <div
        class="flex flex-col mx-7 border rounded-lg shadow-sm/20 border-gray-400 overflow-hidden overflow-y-auto no-scrollbar bg-v5">
        <?php if (empty($rows)): ?>
            <div class="p-6 text-center text-gray-500">
                Data tidak ditemukan
            </div>
        <?php else: ?>
            <table class="table-auto border-collapse w-full relative">
                <thead class="sticky top-0">
                    <tr class="border-b border-gray-400 bg-v6">
                        <?php foreach ($headers as $header): ?>
                            <th class="text-xs md:text-sm font-medium text-left px-4 py-2">
                                <?= htmlspecialchars($header['label']) ?>
                            </th>
                        <?php endforeach; ?>

                        <?php if (!empty($actions)): ?>
                            <th class="text-xs md:text-sm font-medium px-4 py-2"></th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr class="border-0 last:border-0">
                            <?php foreach ($headers as $header): ?>
                                <td class="text-xs md:text-sm px-4 py-2 <?= $header['class'] ?? '' ?>">
                                    <?php
                                    $value = $row[$header['key']] ?? null;

                                    if (isset($header['formatter']) && is_callable($header['formatter'])) {
                                        echo $header['formatter']($value, $row);
                                    } else {
                                        echo htmlspecialchars($value ?? 'N/A');
                                    }
                                    ?>
                                </td>
                            <?php endforeach; ?>
                            <td class="md:px-4 md:py-2 px-1.5 py-0.5 text-right">
                                <div class="inline-flex gap-2">
                                    <button
                                        hx-post="/admin/add"
                                        hx-target="#notif"
                                        hx-confirm="Yakin ingin menghapus <?= isset($row['username']) ? $row['username'] : $row['name'] ?>"
                                        name="deleteItems"
                                        value="<?= isset($row['username']) ? $row['username'] : $row['name'] ?>"
                                        type="button"
                                        class="transform transition-all duration-150 active:scale-95">
                                        <i class="mr-1 ph-bold ph-x text-v5 bg-v2 md:py-1.5 md:px-2.5 py-0.5 px-1.5 text-xs rounded-sm md:rounded-md"></i>
                                    </button>

                                    <button
                                        hx-post="/admin/add"
                                        hx-target="#notif"
                                        hx-swap="outerHTML"
                                        hx-vals='{"id": <?= $user["id"] ?>}'
                                        name="loadEditItems"
                                        type="button"
                                        class="transform transition-all duration-150 active:scale-95">
                                        <i class="ml-1 ph-bold ph-pencil-simple-line bg-v7 md:py-1.5 md:px-2.5 py-0.5 px-1.5 text-xs rounded-sm md:rounded-md"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>