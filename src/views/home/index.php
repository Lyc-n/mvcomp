<div class="flex w-full h-screen bg-linear-to-b from-v6 from-5% to-95% to-v5">
    <aside
        id="sidebar"
        class="
            hidden lg:block
            top-0 left-0
            w-[72%] max-w-[300px] h-full
            bg-linear-to-bl from-v1 from-20% to-v2
            z-90 p-[18px]
            shadow-[8px_0_20px_rgba(0,0,0,0.2)]">

        <!-- TOP -->
        <div class="pt-2.5 px-1 pb-[18px]">
            <div class="text-white font-semibold text-base">
                Meja 6
            </div>
        </div>

        <!-- NAV -->
        <nav class="mt-1.5">

            <!-- ITEM -->
            <button
                id="navKeranjang"
                type="button"
                class="
                w-full text-left
                bg-transparent border-0
                text-white
                py-3 px-1.5
                text-sm
                cursor-pointer">
                Keranjang
            </button>

            <div class="h-px w-full bg-white/60 mb-1.5"></div>

            <button
                id="navRiwayat"
                type="button"
                class="
                w-full text-left
                bg-transparent border-0
                text-white
                py-3 px-1.5
                text-sm
                cursor-pointer">
                Riwayat
            </button>

            <div class="h-px w-full bg-white/60 mb-1.5"></div>

            <!-- LOGIN -->
            <button
                id="navLogin"
                type="button"
                class="
                w-full text-left
                bg-transparent border-0
                text-white
                py-3 px-1.5
                text-sm
                cursor-pointer
                flex items-center gap-2.5
                mt-3">
                <i class="ph-bold ph-sign-in text-lg"></i>
                <span>Login</span>
            </button>

            <div class="h-px w-full bg-white/60 mb-1.5"></div>

            <!-- REGISTER -->
            <button
                id="navRegister"
                type="button"
                class="
                w-full text-left
                bg-transparent border-0
                text-white
                py-3 px-1.5
                text-sm
                cursor-pointer
                flex items-center gap-2.5
                mt-3">
                <i class="ph-bold ph-sign-in text-lg"></i>
                <span>Register</span>
            </button>

            <div class="h-px w-full bg-white/60 mb-1.5"></div>

        </nav>
    </aside>
    <div class="flex flex-col w-full max-h-ful overflow-hidden overflow-y-auto no-scrollbar mx-2 md:mx-7 lg:mx-14 pt-7 relative">
        <header class="flex flex-col items-center gap-5">
            <span class="font-semibold text-sm md:text-base md:hidden">Meja 6</span>
            <form
                hx-post="/mvcomp/"
                hx-target="#menu"
                class="relative w-full">
                <input name="search" type="text" placeholder="search" class="w-full border bg-v5 border-v3/40 py-2 pr-4 pl-10 rounded-xl text-sm focus:ring focus:ring-v3/40 focus:outline-0">
                <button type="submit" name="searchButton" class="h-fit cursor-pointer">
                    <i class="ph ph-magnifying-glass absolute left-3.5 top-2.5 opacity-40"></i>
                </button>
            </form>
        </header>

        <div id="category" class="flex gap-7 items-center mb-2">
            <button hx-post="/mvcomp/" hx-target="#menu" hx-vals='{"id": ""}' name="category" type="button" class="bg-v1 text-sm  hover:bg-orange-500 shadow-sm/40 rounded-xl text-v5 px-8 py-2 transform transition-all duration-250 active:scale-95 active:shadow-inner">Semua</button>
            <button hx-post="/mvcomp/" hx-target="#menu" hx-vals='{"id": "makanan"}' name="category" type="button" class=" text-sm bg-v1 hover:bg-orange-500 shadow-sm/40 rounded-xl text-v5 px-8 py-2 transform transition-all duration-250 active:scale-95 active:shadow-inner">Makanan</button>
            <button hx-post="/mvcomp/" hx-target="#menu" hx-vals='{"id": "minuman"}' name="category" type="button" class=" text-sm bg-v1 hover:bg-orange-500 shadow-sm/40 rounded-xl text-v5 px-8 py-2 transform transition-all duration-250 active:scale-95 active:shadow-inner">Minuman</button>
            <button hx-post="/mvcomp/" hx-target="#menu" hx-vals='{"id": "kudapan"}' name="category" type="button" class=" text-sm bg-v1 hover:bg-orange-500 shadow-sm/40 rounded-xl text-v5 px-8 py-2 transform transition-all duration-250 active:scale-95 active:shadow-inner">Kudapan</button>
        </div>

        <main class="flex w-full justify-center pb-5">
            <div
                id="menu"
                class="mt-2.5 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-10">
                <?php include __DIR__ . '/listMenu.php';
                var_dump($_SESSION)
                ?>
            </div>
        </main>
        <div id="action" class="flex pb-7 pt-4 gap-7 bg-v5 sticky bottom-0 ">
            <button hx-post="/mvcomp/" hx-target="#menu" hx-vals='{"id": "keranjang"}' name="actionMenu" type="button" class="border-2 border-v1 bg-v5 text-v1 text-base w-full hover:bg-v1 hover:text-v5 shadow-sm/40 rounded-xl px-8 py-2 transform transition-all duration-250 active:scale-95 active:shadow-inner">keranjang</button>
            <button hx-post="/mvcomp/" hx-target="#menu" hx-vals='{"id": "bayar"}' name="actionMenu" type="button" class="w-full text-base bg-v1 hover:bg-orange-500 shadow-sm/40 rounded-xl text-v5 px-8 py-2 transform transition-all duration-250 active:scale-95 active:shadow-inner">bayar</button>
        </div>
    </div>
</div>