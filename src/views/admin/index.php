<div class="flex w-full h-screen bg-v5">
    <aside class="min-w-fit max-w-12 h-full bg-linear-to-b/oklch from-v6 from-25% to-v1 py-3 flex flex-col gap-5">
        <div class="w-fit flex items-center gap-3 justify-center px-8">
            <img src="/img/mainLogo.svg" alt="mainLogo" class="w-9">
            <div class="flex flex-col gap-0 items-center pt-1">
                <h1 class="text-[1.3rem] leading-3">YUMMY</h1>
                <p class="text-[0.6rem] text-amber-900">Nusantara Food</p>
            </div>
        </div>
        <div class="">
            <ul class="flex flex-col gap-3 overflow-hidden">
                <li><button
                        hx-post="/admin/panel"
                        hx-target="#menuInti"
                        hx-vals='{"id": "dashboard"}'
                        data-menu="dashboard"
                        type="button"
                        class="menu-btn flex w-full gap-3 justify-between items-center hover:scale-105 transition-all duration-300 ease-in-out px-8 py-3 bg-v7 text-v2 transform active:scale-95 active:shadow-inner">
                        <i class="ph-fill ph-squares-four text-xl"></i>
                        <p class="w-full text-left text-sm">Dashboard</p>
                    </button></li>
                <li><button
                        type="button"
                        hx-target="#menuInti"
                        data-menu="users"
                        hx-post="/admin/panel"
                        hx-vals='{"id": "users"}'
                        class="menu-btn flex w-full gap-3 justify-between items-center hover:scale-105 transition-all duration-300 ease-in-out px-8 py-3 transform active:scale-95 active:shadow-inner">
                        <i class="ph-fill ph-users text-xl"></i>
                        <p class="w-full text-left text-sm">Manage Users</p>
                    </button></li>
                <li><button
                        type="button"
                        hx-target="#menuInti"
                        data-menu="products"
                        hx-post="/admin/panel"
                        hx-vals='{"id": "products"}'
                        class="menu-btn flex w-full gap-3 justify-between items-center hover:scale-105 transition-all duration-300 ease-in-out px-8 py-3 transform active:scale-95 active:shadow-inner">
                        <i class="ph-fill ph-bowl-steam text-xl"></i>
                        <p class="w-full text-left text-sm">Manage Products</p>
                    </button></li>
                <li><button
                        type="button"
                        hx-target="#menuInti"
                        data-menu="reports"
                        hx-post="/admin/panel"
                        hx-vals='{"id": "reports"}'
                        class="menu-btn flex w-full gap-3 justify-between items-center hover:scale-105 transition-all duration-300 ease-in-out px-8 py-3 transform active:scale-95 active:shadow-inner">
                        <i class="ph-fill ph-qr-code text-xl"></i>
                        <p class="w-full text-left text-sm">QR</p>
                    </button></li>
            </ul>
        </div>
    </aside>
    <main class="flex w-full flex-col">
        <nav class="w-full min-h-12 h-fit px-8 py-2 flex flex-row-reverse gap-3 items-center bg-v6">
            <div class="flex flex-col justify-center cursor-pointer">
                <h2 class="font-semibold text-md leading-3.5">Guest</h2>
                <p class="font-light text-xs opacity-75 ml-0.5">admin</p>
            </div>
            <div id="profile" class="aspect-square cursor-pointer h-full bg-[url(../img/samplePP.jpg)] bg-cover bg-center bg-no-repeat rounded-full shadow-md"></div>
        </nav>
        <div id="menuInti" class="flex w-full h-full bg-linear-to-br/oklch from-v5 from-60% to-v6 flex-col overflow-hidden">

        </div>
    </main>
</div>