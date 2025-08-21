<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $productImage = new ProductImage();
        $productImage->product_variation_id = 1;
        $productImage->image = "product_images/p1.jpg";
        $productImage->save();

        $productImage = new ProductImage();
        $productImage->product_variation_id = 2;
        $productImage->image = "product_images/p2.jpg";
        $productImage->save();

        $productImage = new ProductImage();
        $productImage->product_variation_id = 3;
        $productImage->image = "product_images/p3.jpg";
        $productImage->save();

        $productImage = new ProductImage();
        $productImage->product_variation_id = 4;
        $productImage->image = "product_images/p4.jpg";
        $productImage->save();

        $productImage = new ProductImage();
        $productImage->product_variation_id = 5;
        $productImage->image = "product_images/p5.jpg";
        $productImage->save();
    }
}
