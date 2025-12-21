<?php

use Mvcomp\Posapp\Models\Product;

return function () {
    $jsonPath = __DIR__ . '/data/products.json';

    if (!file_exists($jsonPath)) {
        echo "products.json not found\n";
        return;
    }

    $products = json_decode(file_get_contents($jsonPath), true);

    foreach ($products as $product) {
        Product::updateOrCreate(
            ['id' => $product['id']], // supaya tidak dobel
            [
                'name'        => $product['name'],
                'description' => $product['description'],
                'price'       => $product['price'],
                'category'    => $product['category'],
                'stock'       => 1,
                'image'       => $product['image']
            ]
        );
    }

    echo "✔ Products seeded successfully\n";
};
