<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Видаляємо full_name, якщо воно існує
            if (Schema::hasColumn('users', 'full_name')) {
                $table->dropColumn('full_name');
            }

            // Додаємо нові поля, якщо вони ще не існують
            if (!Schema::hasColumn('users', 'surname')) {
                $table->string('surname')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name')->nullable()->after('surname');
            }
            if (!Schema::hasColumn('users', 'patronymic')) {
                $table->string('patronymic')->nullable()->after('first_name');
            }
            if (!Schema::hasColumn('users', 'city_ref')) {
                $table->string('city_ref')->nullable()->after('city');
            }
            if (!Schema::hasColumn('users', 'delivery_point')) {
                $table->string('delivery_point')->nullable()->after('city_ref');
            }
            if (!Schema::hasColumn('users', 'delivery_point_ref')) {
                $table->string('delivery_point_ref')->nullable()->after('delivery_point');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Відновлюємо full_name, якщо потрібно
            if (!Schema::hasColumn('users', 'full_name')) {
                $table->string('full_name')->nullable()->after('phone');
            }

            // Видаляємо додані поля, якщо вони існують
            $columns = ['surname', 'first_name', 'patronymic', 'city_ref', 'delivery_point', 'delivery_point_ref'];
            $table->dropColumn(array_filter($columns, fn($column) => Schema::hasColumn('users', $column)));
        });
    }
};
