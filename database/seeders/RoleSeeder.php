<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Create Permissions (Optional)
        $createProductPermission = Permission::create(['name' => 'create product']);
        $editProductPermission = Permission::create(['name' => 'edit product']);
        $deleteProductPermission = Permission::create(['name' => 'delete product']);
        $viewProductPermission = Permission::create(['name' => 'view product']);

        // Assign Permissions to Roles (Example)
        $adminRole->givePermissionTo(['create product', 'edit product', 'delete product', 'view product']);
        $userRole->givePermissionTo('view product');

        // Seed Users and Assign Roles
        $admin = User::first(); // Ensure you have at least one user in the database
        if ($admin) {
            $admin->assignRole('admin');
        }

        $user = User::skip(1)->first(); // Take the second user as 'user'
        if ($user) {
            $user->assignRole('user');
        }

        // Optional: Create a new Admin or User if no users exist
        if (!User::count()) {
            $adminUser = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
            $adminUser->assignRole('admin');
        }

        if (User::count() < 2) {
            $user = User::create([
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
            ]);
            $user->assignRole('user');
        }
    }
}
