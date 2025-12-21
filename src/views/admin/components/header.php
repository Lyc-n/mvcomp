<form
    hx-post="/admin/add"
    hx-target="#<?= $id ?? 'table' ?>"
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
            const m = document.getElementById('addModal');
            m.classList.remove('hidden');
            m.classList.add('flex');"
        class="w-fit h-fit p-2 px-4 bg-v7 rounded-lg flex flex-nowrap justify-center items-center gap-1 transform transition-all duration-150 active:scale-95 active:shadow-inner">
        <i class="ph-bold ph-plus-square right-5 top-3"></i>
        <span class="w-full text-right font-bold text-sm whitespace-nowrap">Add New</span>
    </button>
</form>