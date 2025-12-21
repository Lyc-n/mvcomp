<?php require_once __DIR__ . '/components/header.php'; ?>
<?php require_once __DIR__ . '/components/table.php'; ?>

<div id="notif"></div>

<div
    id="addModal"
    onclick="
        this.classList.add('hidden');
        this.classList.remove('flex');
        "
    class="fixed inset-0 z-50 w-full h-full justify-center items-center bg-v3/40 hidden">
    <form
        hx-post="/admin/add"
        hx-encoding="multipart/form-data"
        hx-target="#notif"
        method="post"
        onclick="event.stopPropagation()"
        class="flex w-md shadow-xl/20 h-fit flex-col gap-1.5 px-7 py-6 bg-v5 rounded-lg">
        <label class="text-sm font-semibold" for="productname">Productname <span class="text-rose-600">*</span></label>
        <input
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 focus:ring focus:ring-v3/40 focus:outline-0"
            type="text"
            name="productname"
            id="productname"
            require>
        <label class="text-sm font-semibold" for="price">Price <span class="text-rose-600">*</span></label>
        <input
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 focus:ring focus:ring-v3/40 focus:outline-0"
            type="number"
            name="price"
            id="price"
            require>
        <label class="text-sm font-semibold" for="password">Description <span class="text-rose-600">*</span></label>
        <textarea
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 focus:ring focus:ring-v3/40 focus:outline-0 leading-relaxed resize-y min-h-28"
            type="text"
            name="description"
            id="description"
            require></textarea>
        <label class="text-sm font-semibold" for="image">Product Image <span class="text-rose-600">*</span></label>
        <input
            type="file"
            name="image"
            id="image"
            accept="image/*"
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 file:bg-v1 file:text-v5 file:border-0 file:px-4 file:py-2 file:rounded-md cursor-pointer"
            required>
        <label class="text-sm font-semibold" for="role">Category <span class="text-rose-600">*</span></label>
        <select
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 transitio focus:outline-0 focus:ring focus:ring-v3/40"
            name="category"
            required>
            <option value="">-- Pilih Category --</option>
            <option value="makanan">Makanan</option>
            <option value="minuman">Minuman</option>
            <option value="kudapan">Kudapan</option>
        </select>
        <button
            class="text-v5 bg-v1 rounded-md p-2 cursor-pointer hover:bg-amber-500 transform transition-all duration-150 active:scale-95 active:shadow-inner"
            name="addProduct"
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
            hx-post="/mvcomp/admin/add/product"
            hx-target="#table"
            hx-swap=""
            type="button"
            value="makanan"
            name="filterProduct"
            class="px-6 py-2 hover:bg-v1 hover:text-white transform transition-all duration-150 active:scale-95 active:shadow-inner text-sm text-left">Makanan</button>
        <button
            hx-post="/mvcomp/admin/add/product"
            hx-target="#table"
            hx-swap=""
            type="button"
            value="minuman"
            name="filterProduct"
            class="px-6 py-2 hover:bg-v1 hover:text-white transform transition-all duration-150 active:scale-95 active:shadow-inner text-sm text-left">Minuman</button>
        <button
            hx-post="/mvcomp/admin/add/product"
            hx-target="#table"
            hx-swap=""
            type="button"
            value="kudapan"
            name="filterProduct"
            class="px-6 py-2 hover:bg-v1 hover:text-white transform transition-all duration-150 active:scale-95 active:shadow-inner text-sm text-left">Kudapan</button>
    </div>
</div>