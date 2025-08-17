<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // id	user_id	address	phone	created_at	updated_at	

        $address=new Address();
        $address->user_id=3;
        $address->address="alexandria albitach";
        $address->phone="01212121244";
        $address->save();
    }
}
