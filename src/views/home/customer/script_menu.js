
const tabs = document.querySelectorAll(".tab");
const categories = document.querySelectorAll(".category");


tabs.forEach(tab => {
  tab.addEventListener("click", () => {
    
    tabs.forEach(t => t.classList.remove("active"));
    tab.classList.add("active");

    
    const target = tab.getAttribute("data-target");

    
    categories.forEach(cat => cat.classList.add("hidden"));

   
    document.getElementById(target).classList.remove("hidden");
  });
});


const cards = document.querySelectorAll(".card");
const modal = document.getElementById("menuDetail");
const detailImage = document.getElementById("detailImage");
const detailTitle = document.getElementById("detailTitle");
const detailDesc = document.getElementById("detailDesc");
const detailPrice = document.getElementById("detailPrice");
const closeBtn = document.querySelector(".btn-close");


const menuDescriptions = {
  "Mie Ayam": "Hidangan mie kuning yang diberi potongan ayam berbumbu gurih dan biasanya ditambah sayuran serta kuah ringan.",
  "Soto Banjar": "Sup khas Banjar dengan ayam suwir, telur rebus, dan bumbu rempah harum.",
  "Rawon": "Masakan daging sapi dengan kuah hitam khas Jawa Timur dari kluwek.",
  "Nasi Tongseng Daging": "Tongseng daging sapi dengan kuah gurih manis dan aroma khas rempah.",
  "Nasi Ayam Bakar Rica": "Ayam bakar pedas manis dengan cita rasa khas Manado.",
  "Nasi Pecel": "Nasi dengan aneka sayuran dan sambal kacang khas Jawa Timur.",
  "Es Teh": "Minuman teh dingin manis segar untuk menghilangkan dahaga.",
  "Thai Tea Ice": "Minuman teh Thailand dengan susu kental manis dan aroma rempah.",
  "Klepon": "Kue tradisional berisi gula merah, dilapisi kelapa parut lembut.",
  "Onde-Onde": "Kue bola wijen berisi kacang hijau manis khas Indonesia."
};


cards.forEach(card => {
  const img = card.querySelector("img");
  const title = card.querySelector("h4");
  const price = card.querySelector("p");

  img.addEventListener("click", () => {
    const menuName = title.textContent.trim();
    detailImage.src = img.src;
    detailTitle.textContent = menuName;
    detailDesc.textContent = menuDescriptions[menuName] || "Deskripsi belum tersedia.";
    detailPrice.textContent = price.textContent;
    modal.classList.remove("hidden");
  });
});


closeBtn.addEventListener("click", () => {
  modal.classList.add("hidden");
});


modal.addEventListener("click", (e) => {
  if (e.target === modal) modal.classList.add("hidden");
});
// === KERANJANG ===
const cart = [];
const cartModal = document.getElementById("cartModal");
const cartItemsContainer = document.getElementById("cartItems");
const subtotalElem = document.getElementById("subtotal");
const totalElem = document.getElementById("total");
const closeCartBtn = cartModal.querySelector(".btn-close");

// Tambah item ke keranjang
function addToCart(name, price, img) {
  const existingItem = cart.find(item => item.name === name);
  if (existingItem) {
    existingItem.qty++;
  } else {
    cart.push({ name, price, img, qty: 1 });
  }
  updateCartUI();
}

// Update tampilan keranjang
function updateCartUI() {
  cartItemsContainer.innerHTML = "";

  let subtotal = 0;

  cart.forEach((item, index) => {
    subtotal += item.price * item.qty;

    const cartItem = document.createElement("div");
    cartItem.classList.add("cart-item");
    cartItem.innerHTML = `
  <img src="${item.img}" alt="${item.name}">
  <div class="cart-item-info">
    <h4>${item.name}</h4>
    <p>Rp.${item.price.toLocaleString()}</p>
  </div>
  <div class="qty-control">
    <button class="qty-btn minus">-</button>
    <span class="qty-value">${item.qty}</span>
    <button class="qty-btn plus">+</button>
  </div>
  <button class="qty-btn remove">✕</button>
`;
cartItemsContainer.appendChild(cartItem);
subtotalElem.textContent = `Rp.${subtotal.toLocaleString()}`;
totalElem.textContent = `Rp.${subtotal.toLocaleString()}`;

updatePayButtons(); // <--- TAMBAH INI


    // Event tambah / kurang / hapus
    cartItem.querySelector(".plus").addEventListener("click", () => {
      item.qty++;
      updateCartUI();
    });

    cartItem.querySelector(".minus").addEventListener("click", () => {
      if (item.qty > 1) item.qty--;
      else cart.splice(index, 1);
      updateCartUI();
    });

    cartItem.querySelector(".remove").addEventListener("click", () => {
      cart.splice(index, 1);
      updateCartUI();
    });

    cartItemsContainer.appendChild(cartItem);
  });

  subtotalElem.textContent = `Rp.${subtotal.toLocaleString()}`;
  totalElem.textContent = `Rp.${subtotal.toLocaleString()}`;
}

// Tutup keranjang
closeCartBtn.addEventListener("click", () => {
  cartModal.classList.add("hidden");
});

// Tombol footer “Keranjang”
document.querySelector(".btn-cart").addEventListener("click", () => {
  cartModal.classList.remove("hidden");
});
// === TOMBOL + DI SETIAP MENU ===
const addButtons = document.querySelectorAll(".add-btn");

addButtons.forEach(btn => {
  btn.addEventListener("click", (e) => {
    const card = e.target.closest(".card");
    const name = card.querySelector("h4").textContent;
    const priceText = card.querySelector("p").textContent.replace(/[^\d]/g, "");
    const price = parseInt(priceText);
    const img = card.querySelector("img").src;

    addToCart(name, price, img);
  });
});
document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("searchInput");

  function filterMenu() {
    const keyword = searchInput.value.trim().toLowerCase();

    // cari kategori yang sedang aktif (tidak hidden)
    const activeCategory = document.querySelector(".category:not(.hidden)");
    if (!activeCategory) return;

    const cards = activeCategory.querySelectorAll(".card");

    cards.forEach(card => {
      const nama = card.querySelector("h4")?.textContent.trim().toLowerCase() || "";
      card.style.display = nama.includes(keyword) ? "" : "none";
    });
  }

  // jalan saat ngetik
  searchInput.addEventListener("input", filterMenu);

  // kalau pindah tab, search tetap diterapkan ke tab baru
  document.querySelectorAll(".tab").forEach(tab => {
    tab.addEventListener("click", () => {
      setTimeout(filterMenu, 0);
    });
  });
});
// ===== BAYAR + STATUS ORDER (PAKAI CART YANG SUDAH ADA) =====
const btnPayFooter = document.querySelector(".btn-pay");
const btnPayModal  = document.getElementById("btnBayar");
const orderStatusList = document.getElementById("orderStatusList");

function cartCount() {
  return cart.reduce((sum, it) => sum + it.qty, 0);
}

function updatePayButtons() {
  const hasItem = cartCount() > 0;

  if (btnPayFooter) {
    btnPayFooter.disabled = !hasItem;
    btnPayFooter.classList.toggle("opacity-50", !hasItem);
  }

  if (btnPayModal) {
    btnPayModal.disabled = !hasItem;
    btnPayModal.classList.toggle("opacity-50", !hasItem);
  }
}

function rupiah(n) {
  return new Intl.NumberFormat("id-ID").format(n);
}

function loadOrders() {
  return JSON.parse(localStorage.getItem("orders") || "[]");
}
function saveOrders(orders) {
  localStorage.setItem("orders", JSON.stringify(orders));
}

function renderOrders() {
  if (!orderStatusList) return;

  const orders = loadOrders();
  orderStatusList.innerHTML = "";

  orders.slice().reverse().forEach(order => {
    const div = document.createElement("div");
    div.className = "order-card";
    div.innerHTML = `
      <div class="flex justify-between items-center gap-2">
        <div>
          <div class="text-sm">id pesanan <b>#${order.id}</b></div>
          <div class="text-xs">${order.itemsCount} items</div>
        </div>
        <div class="text-right">
          <span class="text-xs px-2 py-1 rounded bg-red-100 text-red-600">${order.status}</span>
          <div class="font-semibold">Rp.${rupiah(order.total)}</div>
          <div class="text-[11px] text-gray-500">Baru saja</div>
        </div>
      </div>
    `;
    orderStatusList.appendChild(div);
  });
}

function checkout() {
  if (cartCount() === 0) return;

  const total = cart.reduce((sum, it) => sum + it.price * it.qty, 0);
  const itemsCount = cartCount();

  const order = {
    id: Math.floor(1000 + Math.random() * 9000),
    status: "Dikerjakan",
    total,
    itemsCount,
    createdAt: new Date().toISOString()
  };

  const orders = loadOrders();
  orders.push(order);
  saveOrders(orders);

  // kosongkan keranjang (PAKAI CART YANG SAMA)
  cart.length = 0;
  updateCartUI();      // <- ini punyamu, biar UI keranjang kosong
  updatePayButtons();

  // tutup modal
  cartModal.classList.add("hidden");

  // tampilkan status order
  renderOrders();
}

// klik bayar modal
if (btnPayModal) btnPayModal.addEventListener("click", checkout);

// init saat awal
updatePayButtons();
renderOrders();
