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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('customer');
            $table->string('phone_number');
            $table->string('shipment_description')->nullable();
            $table->decimal('declared_value', 10, 2)->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->string('city')->nullable();
            $table->string('delivery_point')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('new');
            $table->timestamp('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
