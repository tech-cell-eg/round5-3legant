<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::create([
                'title' => 'Furniture ',
                'image' => 'Furniture.jpg',
                'content' => 'hi from article furniture',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}

