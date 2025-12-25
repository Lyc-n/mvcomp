<?php

use Mvcomp\Posapp\Models\Table;

return function () {

    $statuses = ['available', 'occupied', 'reserved'];

    for ($i = 1; $i <= 12; $i++) {
        Table::updateOrCreate(
            ['id' => $i],
            [
                'name'     => null, 
                'qr_token' => 'TABLE_' . $i . '_' . strtoupper(bin2hex(random_bytes(3))),
                'status'   => $statuses[array_rand($statuses)],
            ]
        );
    }

    echo "✔ 12 tables seeded successfully\n";
};
