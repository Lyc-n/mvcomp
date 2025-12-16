<div
    class="min-h-screen flex items-center justify-center bg-cover bg-center"
    style="
    background-image:
    linear-gradient(rgba(0,0,0,.4), rgba(0,0,0,.4)),
    url('https://images.unsplash.com/photo-1504674900247-0877df9cc836');">

    <form
        class="w-[420px] max-w-[90%] flex flex-col gap-10 bg-linear-to-br from-v5 to-v6 rounded-xl px-7 py-8 shadow-sm/90 animate-slideFade"
        method="post"
        action="/mvcomp/auth/crud">

        <!-- Header -->
        <div class="mb-7">
            <h1 class="text-5xl text-left font-abhaya-black">Login</h1>
        </div>

        <!-- Username -->
        <div class="flex flex-col gap-4">
            <input
                name="username"
                type="text"
                placeholder="Username or Email"
                class="w-full border bg-v5 border-v3/40 py-2 pr-4 pl-4 rounded-xl text-sm focus:ring focus:ring-v3/40 focus:outline-0">
            <input
                name="password"
                type="password"
                placeholder="Password"
                class="w-full border bg-v5 border-v3/40 py-2 pr-4 pl-4 rounded-xl text-sm focus:ring focus:ring-v3/40 focus:outline-0">
        </div>

        <!-- Button -->
        <div class="flex flex-col gap-4">
            <button
                type="submit" name="login"
                class=" text-base bg-linear-to-br from-v1 to-v2 bg-size-[200%_200%] bg-left hover:bg-right shadow-sm/40 rounded-xl text-v5 px-8 py-2.5 transform transition-all duration-250 active:scale-95 active:shadow-inner">
                Log in
            </button>
            <label for="daftar" class="text-xs text-center text-v3/50 font-semibold">Belum punya akun? <a id="daftar" href="/mvcomp/auth/register" class="italic text-v2/65">Daftar di sini</a></label>
        </div>

    </form>

    <!-- JS -->
    <script>
        function login(e) {
            const btn = e.currentTarget;
            const rect = btn.getBoundingClientRect();
            const ripple = document.createElement("span");

            ripple.className = "ripple";
            ripple.style.left = (e.clientX - rect.left) + "px";
            ripple.style.top = (e.clientY - rect.top) + "px";
            ripple.style.width = ripple.style.height = "20px";

            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);

            const user = username.value;
            const pass = password.value;

            if (!user || !pass) {
                alert("Username dan Password wajib diisi!");
                return;
            }

            localStorage.setItem("login", "true");
            alert("Login berhasil (contoh)");
            window.location.href = "daftarmenu.html";
        }
    </script>

</div>