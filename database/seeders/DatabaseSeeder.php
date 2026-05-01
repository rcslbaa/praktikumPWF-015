<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);

        // Create regular users
        $user1 = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'user',
        ]);

        $user2 = User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'role' => 'user',
        ]);

        // Create categories
        $category1 = Category::create(['name' => 'Perangkat Keras']);
        $category2 = Category::create(['name' => 'Perangkat Lunak']);
        $category3 = Category::create(['name' => 'Aksesoris']);

        // Create products
        Product::create([
            'name' => 'Laptop Dell XPS 13',
            'qty' => 5,
            'price' => 12000000,
            'user_id' => $user1->id,
            'category_id' => $category1->id,
        ]);

        Product::create([
            'name' => 'Monitor LG 24 inch',
            'qty' => 10,
            'price' => 2500000,
            'user_id' => $user1->id,
            'category_id' => $category1->id,
        ]);

        Product::create([
            'name' => 'Microsoft Office 365',
            'qty' => 20,
            'price' => 1500000,
            'user_id' => $user2->id,
            'category_id' => $category2->id,
        ]);

        Product::create([
            'name' => 'Mouse Logitech MX Master',
            'qty' => 15,
            'price' => 800000,
            'user_id' => $user2->id,
            'category_id' => $category3->id,
        ]);

        Product::create([
            'name' => 'Keyboard Mechanical RGB',
            'qty' => 8,
            'price' => 1200000,
            'user_id' => $user1->id,
            'category_id' => $category3->id,
        ]);
    }
}

