<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up()
    {
        Capsule::schema()->create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('qr_token', 64)->unique();
            $table->enum('status', ['available', 'occupied', 'reserved'])->default('available');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('tables');
    }
};
