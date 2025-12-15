<!-- Header: Search, Add, Filter -->
<form
    hx-post="/mvcomp/admin/add/user"
    hx-target="#table"
    class="flex w-full h-fit p-7 gap-5">
    <div class="relative w-full">
        <input name="search" type="text" placeholder="search" class="w-full border border-v3/40 py-2 pr-4 pl-10 rounded-lg text-sm focus:ring focus:ring-v3/40 focus:outline-0">
        <button type="submit" name="searchButton" class="h-fit cursor-pointer">
            <i class="ph ph-magnifying-glass absolute left-3.5 top-2.5 opacity-40"></i>
        </button>
    </div>
    <button
        type="button"
        onclick="
            const f = document.getElementById('filterModal');
            f.classList.remove('hidden');
            f.classList.add('flex');"
        class="w-fit h-fit py-2 px-4 bg-v7 rounded-lg flex flex-nowrap justify-center items-center gap-1 transform transition-all duration-150 active:scale-95 active:shadow-inner">
        <i class="ph-bold ph-funnel left-5 top-3"></i>
        <span class="w-full text-right font-bold text-sm whitespace-nowrap">Filter</span>
    </button>
    <button
        type="button"
        onclick="
            const m = document.getElementById('addUserModal');
            m.classList.remove('hidden');
            m.classList.add('flex');"
        class="w-fit h-fit p-2 px-4 bg-v7 rounded-lg flex flex-nowrap justify-center items-center gap-1 transform transition-all duration-150 active:scale-95 active:shadow-inner">
        <i class="ph-bold ph-plus-square right-5 top-3"></i>
        <span class="w-full text-right font-bold text-sm whitespace-nowrap">Add New</span>
    </button>
</form>

<!-- add user -->
<div
    id="addUserModal"
    onclick="
        this.classList.add('hidden');
        this.classList.remove('flex');
        "
    class="fixed inset-0 z-50 w-full h-full justify-center items-center bg-v3/40 hidden">
    <form
        hx-post="/mvcomp/admin/add/user"
        hx-target="#notif"
        onclick="event.stopPropagation()"
        class="flex w-1/5 shadow-xl/20 h-fit flex-col gap-1.5 px-7 py-6 bg-v5 rounded-lg">
        <label class="text-sm font-semibold" for="username">Username <span class="text-rose-600">*</span></label>
        <input
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 focus:ring focus:ring-v3/40 focus:outline-0"
            type="text"
            name="username"
            id="username"
            require>
        <label class="text-sm font-semibold" for="email">Email <span class="text-rose-600">*</span></label>
        <input
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 focus:ring focus:ring-v3/40 focus:outline-0"
            type="email"
            name="email"
            id="email"
            require>
        <label class="text-sm font-semibold" for="password">Password <span class="text-rose-600">*</span></label>
        <input
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 focus:ring focus:ring-v3/40 focus:outline-0"
            type="password"
            name="password"
            id="password"
            require>
        <label class="text-sm font-semibold" for="role">Role <span class="text-rose-600">*</span></label>
        <select
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 transitio focus:outline-0 focus:ring focus:ring-v3/40"
            name="role"
            required>
            <option value="">-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="kasir">Kasir</option>
            <option value="guest">Guest</option>
            <option value="member">Member</option>
        </select>
        <button
            class="text-v5 bg-v1 rounded-md p-2 cursor-pointer hover:bg-amber-500 transform transition-all duration-150 active:scale-95 active:shadow-inner"
            name="addUser"
            type="submit">Submit
        </button>
    </form>
</div>

<!-- Filter -->
<div
    id="filterModal"
    onclick="
        this.classList.add('hidden');
        this.classList.remove('flex');
        "
    class="fixed inset-0 z-50 w-full h-full hidden">
    <div class="flex flex-col w-48 rounded-md shadow-sm/65 shadow-v3 border-v3/40 bg-v5 py-5 absolute right-15 top-30">
        <button
            hx-post="/mvcomp/admin/add/user"
            hx-target="#table"
            hx-swap=""
            type="button"
            value="admin"
            name="filterUser"
            class="px-6 py-2 hover:bg-v1 hover:text-white transform transition-all duration-150 active:scale-95 active:shadow-inner text-sm text-left">Admin</button>
        <button
            hx-post="/mvcomp/admin/add/user"
            hx-target="#table"
            hx-swap=""
            type="button"
            value="kasir"
            name="filterUser"
            class="px-6 py-2 hover:bg-v1 hover:text-white transform transition-all duration-150 active:scale-95 active:shadow-inner text-sm text-left">Kasir</button>
        <button
            hx-post="/mvcomp/admin/add/user"
            hx-target="#table"
            hx-swap=""
            type="button"
            value="member"
            name="filterUser"
            class="px-6 py-2 hover:bg-v1 hover:text-white transform transition-all duration-150 active:scale-95 active:shadow-inner text-sm text-left">Member</button>
        <button
            hx-post="/mvcomp/admin/add/user"
            hx-target="#table"
            hx-swap=""
            type="button"
            value="guest"
            name="filterUser"
            class="px-6 py-2 hover:bg-v1 hover:text-white transform transition-all duration-150 active:scale-95 active:shadow-inner text-sm text-left">Guest</button>
    </div>
</div>

<!-- Notification -->
<div id="notif"></div>

<!-- Table User -->
<div id="table" class="flex flex-col mx-7 border rounded-lg shadow-sm/20 border-gray-400 overflow-hidden bg-v5 overflow-y-visible">
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
                        <div class="">
                            <button
                                hx-post="/mvcomp/admin/add/user"
                                hx-target="#table"
                                hx-confirm="Yakin ingin menghapus user ini?"
                                type="button"
                                name="deleteUser"
                                value="<?= $user['id'] ?>"
                                class="transform transition-all duration-150 active:scale-95 active:shadow-inner">
                                <i class="mr-1 ph-bold ph-x text-v5 bg-v2 py-1.5 px-2.5 rounded-md"></i>
                            </button>
                            <button
                                hx-post="/mvcomp/admin/add/user"
                                hx-target="#notif"
                                hx-swap="outerHTML"
                                hx-vals='{"id": <?= $user["id"] ?>}'
                                type="button"
                                name="loadEditUser"
                                class="transform transition-all duration-150 active:scale-95 active:shadow-inner">
                                <i class="ml-1 ph-bold ph-pencil-simple-line bg-v7 px-2.5 py-1.5 rounded"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>