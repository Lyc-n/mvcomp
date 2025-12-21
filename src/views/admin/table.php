<?php if (empty($users)): ?>
    <div class="p-6 text-center text-gray-500">
        Data tidak ditemukan
    </div>
<?php else: ?>
    <table class="table-auto border-collapse">
        <thead>
            <tr class="border-b border-gray-400 bg-v6">
                <th class="text-sm font-medium text-left px-4 py-2">Full Name</th>
                <th class="text-sm font-medium text-left px-4 py-2">Email</th>
                <th class="text-sm font-medium text-left px-4 py-2">Role</th>
                <th class="text-sm font-medium text-left px-4 py-2">Joined Date</th>
                <th class="text-sm font-medium text-left px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td class="text-sm px-4 py-2"><?= htmlspecialchars($user['username']) ?></td>
                    <td class="text-sm px-4 py-2"><?= htmlspecialchars($user['email']) ?></td>
                    <td class="text-sm px-4 py-2"><?= htmlspecialchars($user['role']) ?></td>
                    <td class="text-sm px-4 py-2"><?= htmlspecialchars($user['created_at']) ?></td>
                    <td class="px-4 py-2 text-right">
                        <div>
                            <button
                                hx-post="/admin/add/user"
                                hx-target="#table"
                                hx-confirm="Yakin ingin menghapus user ini?"
                                type="button"
                                name="deleteUser"
                                value="<?= $user['id'] ?>"
                                class="transform transition-all duration-150 active:scale-95 active:shadow-inner">
                                <i class="mr-1 ph-bold ph-x text-v5 bg-v2 py-1.5 px-2.5 rounded-md"></i>
                            </button>
                            <button
                                hx-confirm="Yakin ingin edit ini?"
                                type="submit"
                                name="updateUser"
                                value="<?= $user['id'] ?>"
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