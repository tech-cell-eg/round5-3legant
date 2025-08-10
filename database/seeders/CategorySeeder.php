<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Category::create([
            'name'   => 'tables',
            'parent_id'=> null,
        ]);
         Category::create([
            'name'   => 'doors',
            'parent_id'=> null,
        ]);
    }
}
