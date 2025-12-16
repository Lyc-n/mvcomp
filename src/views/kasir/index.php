<div class="flex w-full h-screen bg-linear-to-b from-v6 from-5% to-95% to-v5">
    <div id="sidebarOverlay" class="fixed inset-0 bg-v3/40 z-50 hidden">
        <aside
            id="sidebar"
            class="
            sidebar
            fixed lg:static
            top-0 left-0
            w-[72%] max-w-[300px] h-full
            bg-linear-to-bl from-v1 from-20% to-v2
            z-90 p-[18px]
            shadow-[8px_0_20px_rgba(0,0,0,0.2)]">

            <!-- TOP -->
            <div class="pt-2.5 px-1 pb-[18px]">
                <div class="text-white font-semibold text-base">
                    kasir
                </div>
            </div>

            <!-- NAV -->
            <nav class="mt-1.5">
                <!-- LOGIN -->
                <a
                    id="navLogin"
                    href=""
                    class="w-full text-left bg-transparent border-0 text-white py-3 px-1.5 text-sm cursor-pointer flex items-center gap-2.5 mt-3 <?= isset($_SESSION['user']) ? 'hidden' : '' ?>">
                    <span>Pesanan</span>
                </a>

                <div class="h-px w-full bg-white/60 mb-1.5 <?= isset($_SESSION['user']) ? 'hidden' : '' ?>"></div>

                <!-- REGISTER -->
                <a
                    id="navRegister"
                    href=""
                    class="w-full text-left bg-transparent border-0 text-white py-3 px-1.5 text-sm cursor-pointer flex items-center gap-2.5 mt-3 <?= isset($_SESSION['user']) ? 'hidden' : '' ?>">
                    <span>Riwayat</span>
                </a>

                <div class="h-px w-full bg-white/60 mb-1.5 <?= isset($_SESSION['user']) ? 'hidden' : '' ?>"></div>

                <!-- Logout -->
                <a
                    id="navLogout"
                    href="/mvcomp/auth/logout"
                    class="w-full text-left bg-transparent border-0 text-white py-3 px-1.5 text-sm cursor-pointer flex items-center gap-2.5 mt-3 <?= isset($_SESSION['user']) ? '' : 'hidden' ?>">
                    <i class="ph-bold ph-sign-in text-lg"></i>
                    <span>Logout</span>
                </a>

                <div class="h-px w-full bg-white/60 mb-1.5 <?= isset($_SESSION['user']) ? '' : 'hidden' ?>"></div>

            </nav>
        </aside>
    </div>

    <div class="flex flex-col w-full max-h-dvh overflow-hidden overflow-y-auto no-scrollbar mx-2 md:mx-7 lg:mx-14 pt-7 relative">
        <header class="flex flex-col items-center gap-5 relative">
            <button id="sidebarToggle" class="absolute -top-3 left-0 p-2 cursor-pointer hover:scale-105 transform transition-all duration-150 active:scale-95 active:shadow-inner"><i class="ph-bold ph-list text-[1.8rem]"></i></button>
            <span class="font-semibold text-sm md:text-base">Meja 6</span>
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

        <div id="category" class="flex flex-nowrap gap-4 md:gap-7 items-center mb-2">
            <button hx-post="/mvcomp/" hx-target="#menu" hx-vals='{"id": ""}' name="category" type="button" class="bg-v1 text-xs md:text-sm  hover:bg-orange-500 shadow-sm/40 rounded-xl text-v5 md:px-8 px-6 py-1.5 md:py-2 transform transition-all duration-250 active:scale-95 active:shadow-inner">Semua</button>
            <button hx-post="/mvcomp/" hx-target="#menu" hx-vals='{"id": "makanan"}' name="category" type="button" class=" text-xs md:text-sm bg-v1 hover:bg-orange-500 shadow-sm/40 rounded-xl text-v5 md:px-8 px-6 py-1.5 md:py-2 transform transition-all duration-250 active:scale-95 active:shadow-inner">Makanan</button>
            <button hx-post="/mvcomp/" hx-target="#menu" hx-vals='{"id": "minuman"}' name="category" type="button" class=" text-xs md:text-sm bg-v1 hover:bg-orange-500 shadow-sm/40 rounded-xl text-v5 md:px-8 px-6 py-1.5 md:py-2 transform transition-all duration-250 active:scale-95 active:shadow-inner">Minuman</button>
            <button hx-post="/mvcomp/" hx-target="#menu" hx-vals='{"id": "kudapan"}' name="category" type="button" class=" text-xs md:text-sm bg-v1 hover:bg-orange-500 shadow-sm/40 rounded-xl text-v5 md:px-8 px-6 py-1.5 md:py-2 transform transition-all duration-250 active:scale-95 active:shadow-inner">Kudapan</button>
        </div>

        <main class="flex w-full justify-center pb-5">
            <div
                id="menu"
                class="mt-2.5 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-10">
                <?php include __DIR__ . '/listMenu.php';
                ?>
            </div>
            <div
                id="detailMenu"
                onclick=" this.classList.add('hidden'); this.classList.remove('flex'); "
                class="fixed inset-0 z-50 w-full h-full hidden bg-v3/40">
                <div class="flex flex-col w-sm rounded-xl overflow-hidden shadow-sm/65 shadow-v3 border-v3/40 bg-v5 pb-5 absolute left-14 top-20">
                    <div id="notif" class="overflow-hidden"></div>
                </div>
            </div>
        </main>
        <div id="action" class="pb-7 pt-4 gap-7 bg-v5 sticky bottom-0 hidden">
            <button hx-post="/mvcomp/" hx-target="#menu" hx-vals='{"id": "keranjang"}' name="actionMenu" type="button" class="border-2 border-v1 bg-v5 text-v1 text-base w-full hover:bg-v1 hover:text-v5 shadow-sm/40 rounded-xl px-8 py-2 transform transition-all duration-250 active:scale-95 active:shadow-inner">keranjang</button>
            <button hx-post="/mvcomp/" hx-target="#menu" hx-vals='{"id": "bayar"}' name="actionMenu" type="button" class="w-full text-base bg-v1 hover:bg-orange-500 shadow-sm/40 rounded-xl text-v5 px-8 py-2 transform transition-all duration-250 active:scale-95 active:shadow-inner">bayar</button>
        </div>
    </div>
    <aside
        id="sidebar"
        class="
            hidden lg:block
            top-0 left-0
            w-[72%] max-w-[300px] h-full
            bg-v5 
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
                id="pesanan"
                type="button"
                class="w-full text-left bg-transparent border-0 text-v3 py-3 px-1.5 text-xl font-bold cursor-pointer">
                Pesanan
            </button>

            <button
                id="total"
                type="button"
                class="w-full text-left bg-transparent border-0 text-v3 py-3 px-1.5 text-sm cursor-pointer">
                Total
            </button>
            <button hx-post="/mvcomp/" hx-target="#menu" hx-vals='{"id": "bayar"}' name="actionMenu" type="button" class="w-full text-base bg-v1 hover:bg-orange-500 shadow-sm/40 rounded-xl text-v5 px-8 py-2 transform transition-all duration-250 active:scale-95 active:shadow-inner">bayar</button>
        </nav>
    </aside>
</div>