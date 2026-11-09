#!/bin/sh
set -e

echo "Menyiapkan database..."
php scripts/db-init.php

echo "Menyiapkan admin awal..."
php scripts/create-admin.php || true

echo "Menyiapkan produk contoh..."
php scripts/seed-products.php || true

echo "Menjalankan aplikasi di port ${PORT:-8000}..."
exec php -S "0.0.0.0:${PORT:-8000}" -t public public/router.php
