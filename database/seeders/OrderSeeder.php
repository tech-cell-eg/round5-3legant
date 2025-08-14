<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //id	address_id	user_id	final_price	status	created_at	updated_at
        $order=new Order();
        $order->address_id=1;
        $order->user_id=3;
        $order->final_price=1000;
        $order->status="cancelled";
        $order->save();

        $order=new Order();
        $order->address_id=1;
        $order->user_id=3;
        $order->final_price=2000;
        $order->status="pending";
        $order->save();


        $order=new Order();
        $order->address_id=1;
        $order->user_id=3;
        $order->final_price=4000;
        $order->status="shipped";
        $order->save();


        $order=new Order();
        $order->address_id=1;
        $order->user_id=3;
        $order->final_price=140;
        $order->status="pending";
        $order->save();


        $order=new Order();
        $order->address_id=1;
        $order->user_id=3;
        $order->final_price=1300;
        $order->status="pending";
        $order->save();


        $order=new Order();
        $order->address_id=1;
        $order->user_id=3;
        $order->final_price=400;
        $order->status="shipped";
        $order->save();
    }
}
