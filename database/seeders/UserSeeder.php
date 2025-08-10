<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username'   => 'admin',
            'email'      => 'adminExample.com',
            'password'   => Hash::make('pasword'),
            'first_name' => 'admin',
            'last_name'  => 'admin',
            'avatar'  => 'Image',
        ]);
        User::create([
            'username'   => 'superAdmin',
            'email'      => 'superAdminExample.com',
            'password'   => Hash::make('pasword'),
            'first_name' => 'superAdmin',
            'last_name'  => 'superAdmin',
            'avatar'  => 'Image',
        ]);
        User::create([
            'username'   => 'customer',
            'email'      => 'customerExample.com',
            'password'   => Hash::make('pasword'),
            'first_name' => 'customer',
            'last_name'  => 'customer',
            'avatar'  => 'Image',
        ]);
    }
}
