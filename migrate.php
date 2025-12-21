<?php

require __DIR__ . '/bootstrap/database.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

/**
 * -----------------------------------------
 * CONFIG
 * -----------------------------------------
 */
$migrationsPath = __DIR__ . '/database/migrations';
$command = $argv[1] ?? 'up';

/**
 * -----------------------------------------
 * 1️⃣ Pastikan tabel migrations ada
 * -----------------------------------------
 */
if (!Capsule::schema()->hasTable('migrations')) {
    Capsule::schema()->create('migrations', function (Blueprint $table) {
        $table->string('migration')->primary();
        $table->timestamp('created_at')->useCurrent();
    });

    echo "📦 Table migrations created\n";
}

/**
 * -----------------------------------------
 * 2️⃣ REFRESH (rollback all → migrate)
 * -----------------------------------------
 */
if ($command === 'refresh') {

    echo "🔄 Refreshing migrations...\n";

    // 🔥 INI WAJIB AGAR FK TIDAK ERROR
    Capsule::schema()->disableForeignKeyConstraints();

    $migrated = Capsule::table('migrations')
        ->orderByDesc('created_at')
        ->get();

    foreach ($migrated as $row) {
        $file = $migrationsPath . '/' . $row->migration;

        if (!file_exists($file)) {
            echo "⚠️ Missing migration file: {$row->migration}\n";
            continue;
        }

        $migration = require $file;

        if (!is_object($migration) || !method_exists($migration, 'down')) {
            throw new RuntimeException("Invalid migration file: {$row->migration}");
        }

        echo "↩️ Rolled back: {$row->migration}\n";
        $migration->down();

        Capsule::table('migrations')
            ->where('migration', $row->migration)
            ->delete();
    }

    Capsule::schema()->enableForeignKeyConstraints();

    echo "✅ Database cleared\n\n";

    // lanjut migrate ulang
    $command = 'up';
}

/**
 * -----------------------------------------
 * 3️⃣ ROLLBACK (1 step)
 * -----------------------------------------
 */
if ($command === 'rollback') {

    $last = Capsule::table('migrations')
        ->orderByDesc('created_at')
        ->first();

    if (!$last) {
        echo "⚠️ Nothing to rollback\n";
        exit;
    }

    $file = $migrationsPath . '/' . $last->migration;

    if (!file_exists($file)) {
        throw new RuntimeException("Missing migration file: {$last->migration}");
    }

    Capsule::schema()->disableForeignKeyConstraints();

    $migration = require $file;

    if (!is_object($migration) || !method_exists($migration, 'down')) {
        throw new RuntimeException("Invalid migration file: {$last->migration}");
    }

    $migration->down();

    Capsule::table('migrations')
        ->where('migration', $last->migration)
        ->delete();

    Capsule::schema()->enableForeignKeyConstraints();

    echo "↩️ Rolled back: {$last->migration}\n";
    exit;
}

/**
 * -----------------------------------------
 * 4️⃣ MIGRATE (UP)
 * -----------------------------------------
 */
$files = glob($migrationsPath . '/*.php');
sort($files); // PENTING: urutkan berdasarkan nama file

foreach ($files as $file) {
    $migrationName = basename($file);

    $exists = Capsule::table('migrations')
        ->where('migration', $migrationName)
        ->exists();

    if ($exists) {
        echo "⏩ Skipped: $migrationName\n";
        continue;
    }

    $migration = require $file;

    if (!is_object($migration) || !method_exists($migration, 'up')) {
        throw new RuntimeException("Invalid migration file: $migrationName");
    }

    echo "⬆️ Migrating: $migrationName\n";
    $migration->up();

    Capsule::table('migrations')->insert([
        'migration' => $migrationName,
    ]);

    echo "✅ Migrated: $migrationName\n";
}

echo "\n🎉 All migrations done\n";
