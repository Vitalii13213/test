<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('customer')->nullable();
            $table->string('phone');
            $table->string('shipment_description')->nullable();
            $table->decimal('declared_value', 10, 2);
            $table->decimal('weight', 10, 2);
            $table->decimal('length', 10, 2);
            $table->decimal('width', 10, 2);
            $table->decimal('height', 10, 2);
            $table->string('city');
            $table->string('delivery_point');
            $table->decimal('total', 10, 2);
            $table->string('status')->default('pending');
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
