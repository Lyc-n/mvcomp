<?php

require_once __DIR__ . '/bootstrap/database.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$last = Capsule::table('migrations')->orderByDesc('id')->first();

if (!$last) {
    echo "No migration to rollback.\n";
    exit;
}

echo "Rolling back: {$last->migration}\n";

require __DIR__ . '/database/rollback/' . $last->migration;

Capsule::table('migrations')->where('id', $last->id)->delete();

echo "Rollback complete.\n";
