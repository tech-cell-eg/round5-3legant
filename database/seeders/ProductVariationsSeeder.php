<?php

namespace Database\Seeders;

use App\Models\ProductVariation;
use Database\Factories\VariationsFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductVariationsSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
        
    public function run(): void
    {
        $productVariation=new ProductVariation();
        $productVariation->product_id=1;
        $productVariation->color="black";
        $productVariation->measurements="100cm * 150cm";
        $productVariation->quantity=12;
        $productVariation->price=30;
        $productVariation->size="small";
        $productVariation->save();

        $productVariation=new ProductVariation();
        $productVariation->product_id=2;
        $productVariation->color="black";
        $productVariation->measurements="100cm * 150cm";
        $productVariation->quantity=12;
        $productVariation->price=40;
        $productVariation->size="small";
        $productVariation->save();


        $productVariation=new ProductVariation();
        $productVariation->product_id=3;
        $productVariation->color="red";
        $productVariation->measurements="100cm * 150cm";
        $productVariation->quantity=12;
        $productVariation->price=200;
        $productVariation->size="large";
        $productVariation->save();


        $productVariation=new ProductVariation();
        $productVariation->product_id=4;
        $productVariation->color="white";
        $productVariation->measurements="100cm * 150cm";
        $productVariation->quantity=12;
        $productVariation->price=30;
        $productVariation->size="small";
        $productVariation->save();


        $productVariation=new ProductVariation();
        $productVariation->product_id=5;
        $productVariation->color="red";
        $productVariation->measurements="100cm * 150cm";
        $productVariation->quantity=12;
        $productVariation->price=30;
        $productVariation->size="large";
        $productVariation->save();
    }
}
