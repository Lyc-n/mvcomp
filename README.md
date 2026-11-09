# 🛒 Sistem Kasir Digital (mvcomp)

Aplikasi Point of Sale (POS) sederhana berbasis PHP dengan pola MVC. Mendukung manajemen produk, transaksi kasir, laporan dasar, autentikasi, dan pembayaran Midtrans Snap (sandbox).

## Persyaratan

- PHP >= 8.0 dengan ekstensi `pdo_mysql`
- Composer
- MySQL (lokal atau Aiven free)
- Node.js (opsional, hanya jika mengubah style Tailwind)

## Menjalankan lokal dengan `php -S`

```bash
composer install
cp .env.example .env
```

Isi `.env` untuk lokal:

```dotenv
APP_URL=http://localhost:8000
APP_BASE_PATH=
BASE_ASSETS=http://localhost:8000/
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=mvcomp
DB_USER=root
DB_PASSWORD=
DB_SSL=false
ADMIN_USERNAME=admin
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=admin123
```

Siapkan database kosong bernama `mvcomp`, lalu jalankan:

```bash
php scripts/db-init.php
php scripts/create-admin.php
php scripts/seed-products.php
php -S localhost:8000 -t public public/router.php
```

Buka `http://localhost:8000`.

CSS sudah tersedia di `public/css/styles.css`. Jika mengubah `src/app.css`:

```bash
npm install
npm run build
```

## Menjalankan dengan Docker

```bash
docker compose up --build
```

Buka `http://localhost:8000`. Compose akan menjalankan MySQL lokal dan inisialisasi schema + seed otomatis.

## Deploy ke Render (free tier)

1. Push repository ke GitHub.
2. Render Dashboard → **New → Web Service** → pilih repo → runtime **Docker** → plan **Free**.
3. Health check path: `/`.
4. Isi environment variables:

| Variable | Nilai |
|---|---|
| `APP_ENV` | `production` |
| `APP_URL` | `https://<service>.onrender.com` (opsional, fallback otomatis ke `RENDER_EXTERNAL_URL`) |
| `APP_BASE_PATH` | kosong |
| `BASE_ASSETS` | `https://<service>.onrender.com/` (opsional) |
| `DB_HOST` | host MySQL Aiven |
| `DB_PORT` | port MySQL Aiven |
| `DB_NAME` | `mvcomp` |
| `DB_USER` | user MySQL |
| `DB_PASSWORD` | password MySQL |
| `DB_SSL` | `true` |
| `DB_SSL_CA` | `/var/www/config/ca.pem` |
| `DB_SSL_VERIFY` | `true` |
| `ADMIN_USERNAME` | username admin awal |
| `ADMIN_EMAIL` | email admin awal |
| `ADMIN_PASSWORD` | password admin awal |
| `MIDTRANS_SERVER_KEY` | server key Midtrans |
| `MIDTRANS_CLIENT_KEY` | client key Midtrans |
| `MIDTRANS_IS_PRODUCTION` | `false` untuk sandbox |

5. Siapkan MySQL Aiven free:
   - Buat database `mvcomp`.
   - Izinkan koneksi dari mana saja (Render free memakai IP keluar dinamis).
   - Unduh CA certificate dan simpan sebagai `config/ca.pem` jika berbeda.
6. Deploy. Container otomatis membuat tabel, admin awal, dan seed produk saat start.

### Keterbatasan free tier

- Service spin down setelah 15 menit tanpa traffic; request berikutnya butuh ±1 menit.
- Filesystem ephemeral: gambar produk yang diupload **hilang** saat redeploy/restart/spin-down. Gambar seed tetap ada karena masuk image.
- Session berbasis file: user logout setelah instance restart.
- Render free tidak menyediakan MySQL; gunakan MySQL eksternal.

## Struktur singkat

```
public/          front controller, asset, router php -S
src/Controllers/ controller aplikasi
src/Models/      model + auto-create table
src/App/         config, database, route, helper
scripts/         init schema, seed, start container
deploy/php.ini   konfigurasi PHP container
```

## Keamanan

- Jangan commit `.env`, `env/`, atau `env.zip`.
- Rotasi kredensial database dan Midtrans yang pernah terekspos.
- Set secret hanya lewat environment variables Render.
