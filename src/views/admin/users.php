<!-- Header: Search, Add, Filter -->
<?php require_once __DIR__ . '/components/header.php'; ?>
<?php require_once __DIR__ . '/components/table.php'; ?>

<div id="notif"></div>

<!-- Filter Modal -->
<div
    id="filterModal"
    onclick="
        this.classList.add('hidden');
        this.classList.remove('flex');
        "
    class="fixed inset-0 z-50 w-full h-full hidden">
    <div class="flex flex-col w-48 rounded-md shadow-sm/65 shadow-v3 border-v3/40 bg-v5 py-5 absolute right-15 top-30">
        <button
            hx-post="/admin/add"
            hx-target="#table"
            hx-swap=""
            type="button"
            value="admin"
            name="filterUser"
            class="px-6 py-2 hover:bg-v1 hover:text-white transform transition-all duration-150 active:scale-95 active:shadow-inner text-sm text-left">Admin</button>
        <button
            hx-post="/admin/add"
            hx-target="#table"
            hx-swap=""
            type="button"
            value="kasir"
            name="filterUser"
            class="px-6 py-2 hover:bg-v1 hover:text-white transform transition-all duration-150 active:scale-95 active:shadow-inner text-sm text-left">Kasir</button>
        <button
            hx-post="/admin/add"
            hx-target="#table"
            hx-swap=""
            type="button"
            value="member"
            name="filterUser"
            class="px-6 py-2 hover:bg-v1 hover:text-white transform transition-all duration-150 active:scale-95 active:shadow-inner text-sm text-left">Member</button>
        <button
            hx-post="/admin/add"
            hx-target="#table"
            hx-swap=""
            type="button"
            value="guest"
            name="filterUser"
            class="px-6 py-2 hover:bg-v1 hover:text-white transform transition-all duration-150 active:scale-95 active:shadow-inner text-sm text-left">Guest</button>
    </div>
</div>

<!-- Add User -->
<div
    id="addModal"
    onclick="
        this.classList.add('hidden');
        this.classList.remove('flex');
        "
    class="fixed inset-0 z-50 w-full h-full justify-center items-center bg-v3/40 hidden">
    <form
        hx-post="/admin/add"
        hx-target="#notif"
        onclick="event.stopPropagation()"
        class="flex w-sm shadow-xl/20 h-fit flex-col gap-1.5 px-7 py-6 bg-v5 rounded-lg">
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

