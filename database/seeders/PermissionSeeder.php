<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create admin',
            'edit admin',
            'delete admin',
            'publish admin',

            'create product',
            'edit product',
            'delete product',
            'publish product',

            'create category',
            'edit category',
            'delete category',
            'publish category',

            'make order' 
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $SadminRole = Role::firstOrCreate(['name' => 'Sadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        $SadminRole->givePermissionTo(Permission::all());
        $adminRole->givePermissionTo(['create product',
                                    'edit product',
                                    'publish product']);
        $customerRole->givePermissionTo(['make order']);

        $admin = User::where('email', 'adminExample.com')->first();;
        if ($admin) {
            $admin->assignRole('admin');
        }

        $Sadmin = User::where('email', 'superAdminExample.com')->first();;
        if ($Sadmin) {
            $Sadmin->assignRole('Sadmin');
        }

        $customer = User::where('email', 'customerExample.com')->first();
        if ($customer) {
            $customer->assignRole('customer');
        }

    }
}
