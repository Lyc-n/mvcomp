<div
    id="editProductModal"
    onclick="this.remove()"
    class="fixed inset-0 z-50 w-full h-full justify-center items-center bg-v3/40 flex">
    <div id="notif"></div>
    <form
        hx-post="/mvcomp/admin/add/product"
        hx-target="#notif"
        onclick="event.stopPropagation()"
        class="flex w-1/5 shadow-xl/20 h-fit flex-col gap-1.5 px-7 py-6 bg-v5 rounded-lg">
        <input type="hidden" name="id" value="<?= $defaultValue['id'] ?>">
        <input type="hidden" name="updateProduct" value="1">
        <label class="text-sm font-semibold" for="name">Product Edit<span class="text-rose-600">*</span></label>
        <input
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 focus:ring focus:ring-v3/40 focus:outline-0"
            type="text"
            name="name"
            id="name"
            value="<?= htmlspecialchars($defaultValue['name']) ?>"
            require>
        <label class="text-sm font-semibold" for="price">Price <span class="text-rose-600">*</span></label>
        <input
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 focus:ring focus:ring-v3/40 focus:outline-0"
            type="number"
            name="price"
            id="price"
            value="<?= htmlspecialchars($defaultValue['price']) ?>"
            require>
        <label class="text-sm font-semibold" for="description">Description <span class="text-rose-600">*</span></label>
        <textarea
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 focus:ring focus:ring-v3/40 focus:outline-0 leading-relaxed resize-y min-h-28"
            type="text"
            name="description"
            id="description"
            require></textarea>
        <label class="text-sm font-semibold" for="category">Category <span class="text-rose-600">*</span></label>
        <select
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 transitio focus:outline-0 focus:ring focus:ring-v3/40"
            name="category"
            required>
            <option value="">-- Pilih Role --</option>
            <option value="makanan" <?= $defaultValue['category'] === 'makanan' ? 'selected' : '' ?>>Makanan</option>
            <option value="minuman" <?= $defaultValue['category'] === 'minuman' ? 'selected' : '' ?>>Minuman</option>
            <option value="kudapan" <?= $defaultValue['category'] === 'kudapan' ? 'selected' : '' ?>>Kudapan</option>
        </select>
        <button
            class="text-v5 bg-v1 rounded-md p-2 cursor-pointer hover:bg-amber-500 transform transition-all duration-150 active:scale-95 active:shadow-inner"
            name="editProduct"
            type="submit">Submit
        </button>
    </form>
</div>