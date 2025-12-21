<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        Capsule::schema()->create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('table_id')
                ->constrained('tables')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('status', [
                'unpaid',
                'paid',
                'waitlist',
                'cooking',
                'served',
                'cancelled',
                'completed'
            ])->default('unpaid');

            $table->decimal('total', 10, 2)->default(0);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('orders');
    }
};
