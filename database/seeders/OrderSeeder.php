<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = [
            [
                'address_id' => 1,
                'user_id' => 3,
                'final_price' => 1000,
                'status' => 'cancelled',
                'first_name' => 'Ahmed',
                'last_name' => 'Ali',
                'phone' => '0101111111',
                'email' => 'ahmed@example.com',
                'address' => 'Tahrir Street',
                'country' => 'Egypt',
                'city' => 'Cairo',
                'payment_method' => 'credit_card',
                'subtotal' => 1000,
                'discount' => 0,
                'total' => 1000,
            ],
            [
                'address_id' => 1,
                'user_id' => 3,
                'final_price' => 2000,
                'status' => 'pending',
                'first_name' => 'Mohamed',
                'last_name' => 'Abdullah',
                'phone' => '0102222222',
                'email' => 'mohamed@example.com',
                'address' => 'Faisal Street',
                'country' => 'Egypt',
                'city' => 'Giza',
                'payment_method' => 'paypal',
                'subtotal' => 2000,
                'discount' => 0,
                'total' => 2000,
            ],
            [
                'address_id' => 1,
                'user_id' => 3,
                'final_price' => 4000,
                'status' => 'shipped',
                'first_name' => 'Mahmoud',
                'last_name' => 'Ibrahim',
                'phone' => '0103333333',
                'email' => 'mahmoud@example.com',
                'address' => 'Nasr Street',
                'country' => 'Egypt',
                'city' => 'Alexandria',
                'payment_method' => 'cash',
                'subtotal' => 4000,
                'discount' => 0,
                'total' => 4000,
            ],
            [
                'address_id' => 1,
                'user_id' => 3,
                'final_price' => 140,
                'status' => 'pending',
                'first_name' => 'Khaled',
                'last_name' => 'Hassan',
                'phone' => '0104444444',
                'email' => 'khaled@example.com',
                'address' => 'Orouba Street',
                'country' => 'Egypt',
                'city' => 'Tanta',
                'payment_method' => 'cash',
                'subtotal' => 140,
                'discount' => 0,
                'total' => 140,
            ],
            [
                'address_id' => 1,
                'user_id' => 3,
                'final_price' => 1300,
                'status' => 'pending',
                'first_name' => 'Hassan',
                'last_name' => 'Mostafa',
                'phone' => '0105555555',
                'email' => 'hassan@example.com',
                'address' => 'Bahr Street',
                'country' => 'Egypt',
                'city' => 'Mansoura',
                'payment_method' => 'cash',
                'subtotal' => 1300,
                'discount' => 0,
                'total' => 1300,
            ],
            [
                'address_id' => 1,
                'user_id' => 3,
                'final_price' => 400,
                'status' => 'shipped',
                'first_name' => 'Yasser',
                'last_name' => 'Saeed',
                'phone' => '0106666666',
                'email' => 'yasser@example.com',
                'address' => 'Giza Square',
                'country' => 'Egypt',
                'city' => 'Giza',
                'payment_method' => 'cash',
                'subtotal' => 400,
                'discount' => 0,
                'total' => 400,
            ],
        ];

        foreach ($orders as $data) {
            Order::create($data);
        }
    }
}
