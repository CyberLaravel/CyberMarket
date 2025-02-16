<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        // Product permissions
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'edit products']);
        Permission::create(['name' => 'delete products']);
        Permission::create(['name' => 'publish products']);
        Permission::create(['name' => 'unpublish products']);

        // Order permissions
        Permission::create(['name' => 'view orders']);
        Permission::create(['name' => 'manage orders']);
        Permission::create(['name' => 'view own orders']);

        // User permissions
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        // Seller application permissions
        Permission::create(['name' => 'view seller applications']);
        Permission::create(['name' => 'manage seller applications']);

        // Create roles and assign permissions
        // Customer role
        $customerRole = Role::create(['name' => 'customer']);
        $customerRole->givePermissionTo([
            'view products',
            'view own orders',
        ]);

        // Seller role
        $sellerRole = Role::create(['name' => 'seller']);
        $sellerRole->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view orders',
            'view own orders',
        ]);

        // Manager role
        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view products',
            'edit products',
            'publish products',
            'unpublish products',
            'view orders',
            'manage orders',
            'view users',
        ]);

        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'delete products',
            'publish products',
            'unpublish products',
            'view orders',
            'manage orders',
            'view users',
            'edit users',
            'view seller applications',
            'manage seller applications',
        ]);

        // Super Admin role
        $superAdminRole = Role::create(['name' => 'super-admin']);
        // Super Admin gets all permissions via Gate::before rule in AuthServiceProvider

        // Create demo users
        // Customer
        $user = User::factory()->withPersonalTeam()->create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
        ]);
        $user->assignRole($customerRole);

        // Seller
        $user = User::factory()->withPersonalTeam()->create([
            'name' => 'Test Seller',
            'email' => 'seller@example.com',
        ]);
        $user->assignRole($sellerRole);

        // Manager
        $user = User::factory()->withPersonalTeam()->create([
            'name' => 'Test Manager',
            'email' => 'manager@example.com',
        ]);
        $user->assignRole($managerRole);

        // Admin
        $user = User::factory()->withPersonalTeam()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
        ]);
        $user->assignRole($adminRole);

        // Super Admin
        $user = User::factory()->withPersonalTeam()->create([
            'name' => 'Test Super Admin',
            'email' => 'superadmin@example.com',
        ]);
        $user->assignRole($superAdminRole);
    }
}
