<!-- Edit Modal -->
<div
    id="editModal"
    onclick="this.remove()"
    class="fixed inset-0 z-50 w-full h-full justify-center items-center bg-v3/40 flex">
    <div id="notific"></div>
    <form
        hx-post="/admin/add"
        hx-target="#notific"
        onclick="event.stopPropagation()"
        class="flex w-1/5 shadow-xl/20 h-fit flex-col gap-1.5 px-7 py-6 bg-v5 rounded-lg">
        <input type="hidden" name="id" value="<?= $defaultValue['id'] ?>">
        <input type="hidden" name="updateUser" value="1">
        <label class="text-sm font-semibold" for="username">Username Edit<span class="text-rose-600">*</span></label>
        <input
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 focus:ring focus:ring-v3/40 focus:outline-0"
            type="text"
            name="username"
            id="username"
            value="<?= htmlspecialchars($defaultValue['username']) ?>"
            require>
        <label class="text-sm font-semibold" for="email">Email <span class="text-rose-600">*</span></label>
        <input
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 focus:ring focus:ring-v3/40 focus:outline-0"
            type="email"
            name="email"
            id="email"
            value="<?= htmlspecialchars($defaultValue['email']) ?>"
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
            class="text-sm bg-v5 shadow-md mb-2 border border-v3/20 rounded-md px-4 py-2 transition focus:outline-0 focus:ring focus:ring-v3/40 appearance-none"
            name="role"
            required>
            <option value="">-- Pilih Role --</option>
            <option value="admin" <?= $defaultValue['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="kasir" <?= $defaultValue['role'] === 'kasir' ? 'selected' : '' ?>>Kasir</option>
            <option value="guest" <?= $defaultValue['role'] === 'guest' ? 'selected' : '' ?>>Guest</option>
            <option value="member" <?= $defaultValue['role'] === 'member' ? 'selected' : '' ?>>Member</option>
        </select>
        <button
            class="text-v5 bg-v1 rounded-md p-2 cursor-pointer hover:bg-amber-500 transform transition-all duration-150 active:scale-95 active:shadow-inner"
            name="editUser"
            type="submit">Submit
        </button>
    </form>
</div>