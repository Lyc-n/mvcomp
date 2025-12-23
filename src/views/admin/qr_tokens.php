<?php require_once __DIR__ . '/components/header.php'; ?>
<?php require_once __DIR__ . '/components/table.php'; ?>

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
        <label class="text-sm font-semibold" for="name">Name <span class="text-rose-600">*</span></label>
        <input
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 focus:ring focus:ring-v3/40 focus:outline-0"
            type="text"
            name="name"
            id="name"
            require>
        <label class="text-sm font-semibold" for="qr_token">QR Token <span class="text-rose-600">*</span></label>
        <input
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 focus:ring focus:ring-v3/40 focus:outline-0"
            type="text"
            name="qr_token"
            id="qr_token"
            require>
        <label class="text-sm font-semibold" for="status">Status <span class="text-rose-600">*</span></label>
        <select
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 transitio focus:outline-0 focus:ring focus:ring-v3/40"
            name="status"
            required>
            <option value="">-- Pilih Status --</option>
            <option value="available">Available</option>
            <option value="occupied">Occupied</option>
            <option value="reserved">Reserved</option>
        </select>
        <button
            class="text-v5 bg-v1 rounded-md p-2 cursor-pointer hover:bg-amber-500 transform transition-all duration-150 active:scale-95 active:shadow-inner"
            name="addTable"
            type="submit">Submit
        </button>
    </form>
</div>

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
            value="available"
            name="filterTable"
            class="px-6 py-2 hover:bg-v1 hover:text-white transform transition-all duration-150 active:scale-95 active:shadow-inner text-sm text-left">Available</button>
        <button
            hx-post="/admin/add"
            hx-target="#table"
            hx-swap=""
            type="button"
            value="occupied"
            name="filterTable"
            class="px-6 py-2 hover:bg-v1 hover:text-white transform transition-all duration-150 active:scale-95 active:shadow-inner text-sm text-left">Occupied</button>
        <button
            hx-post="/admin/add"
            hx-target="#table"
            hx-swap=""
            type="button"
            value="reserved"
            name="filterTable"
            class="px-6 py-2 hover:bg-v1 hover:text-white transform transition-all duration-150 active:scale-95 active:shadow-inner text-sm text-left">Reserved</button>
    </div>
</div>