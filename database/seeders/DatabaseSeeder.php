<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Order;
use App\Models\CustomDesign;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Користувач
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@stylehub.com',
            'password' => bcrypt('password'),
        ]);

        // Категорії
        $category1 = Category::create([
            'name' => 'Футболки',
            'description' => 'Стильні футболки для всіх',
            'is_active' => true,
        ]);
        $category2 = Category::create([
            'name' => 'Джинси',
            'description' => 'Зручні джинси',
            'is_active' => true,
        ]);

        // Товари
        $product1 = Product::create([
            'name' => 'Футболка базова',
            'category_id' => $category1->id,
            'price' => 299.99,
            'stock' => 50,
            'image_path' => 'storage/products/tshirt1.jpg',
            'description' => 'Базова футболка для кастомізації',
        ]);
        $product2 = Product::create([
            'name' => 'Джинси класичні',
            'category_id' => $category2->id,
            'price' => 799.99,
            'stock' => 30,
            'image_path' => 'storage/products/jeans1.jpg',
            'description' => 'Класичні джинси синього кольору',
        ]);
        $product3 = Product::create([
            'name' => 'Футболка з принтом',
            'category_id' => $category1->id,
            'price' => 399.99,
            'stock' => 20,
            'image_path' => 'storage/products/tshirt2.jpg',
            'description' => 'Футболка з унікальним принтом',
        ]);

        // Атрибути
        Attribute::create([
            'product_id' => $product1->id,
            'color' => 'Чорний',
            'size' => 'M',
        ]);
        Attribute::create([
            'product_id' => $product1->id,
            'color' => 'Білий',
            'size' => 'L',
        ]);
        Attribute::create([
            'product_id' => $product2->id,
            'color' => 'Синій',
            'size' => '32',
        ]);
        Attribute::create([
            'product_id' => $product3->id,
            'color' => 'Червоний',
            'size' => 'S',
        ]);

        // Замовлення
        $order = Order::create([
            'user_id' => $user->id,
            'customer' => 'Іван Іванов',
            'phone' => '+380671234567',
            'city' => 'Київ',
            'delivery_point' => 'Відділення №1',
            'total' => 699.98,
            'status' => 'pending',
            'date' => now(),
            'shipment_description' => 'Стандартна доставка',
            'weight' => 1.0,
            'length' => 30.0,
            'width' => 20.0,
            'height' => 5.0,
        ]);

        // Товари в замовленні
        $order->products()->attach([
            $product1->id => ['quantity' => 1, 'price' => 299.99],
            $product3->id => ['quantity' => 1, 'price' => 399.99],
        ]);

        // Кастомний дизайн
        CustomDesign::create([
            'product_id' => $product3->id,
            'order_id' => $order->id,
            'image_path' => 'storage/custom_designs/print1.png',
        ]);
    }
}
