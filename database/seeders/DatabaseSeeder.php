<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        // $this->call(AddressSeeder::class);
        // $this->call(BlogSeeder::class);
        // $this->call(CartSeeder::class);
        // $this->call(CartDetailsSeeder::class);
        $this->call(CategorySeeder::class);
        // $this->call(OrderSeeder::class);
        // $this->call(ProductImagesSeeder::class);
        $this->call(ProductSeeder::class);
        // $this->call(ProductVariationsSeeder::class);
        // $this->call(ReviewSeeder::class);
        $this->call(UserSeeder::class);
        // $this->call(WishListSeeder::class);
        // $this->call(OrderItemsSeeder::class);
        $this->call(PermissionSeeder::class);
    }
}
