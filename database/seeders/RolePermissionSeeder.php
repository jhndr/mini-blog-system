<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'moderate posts',
            'view admin dashboard',
            'manage categories',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        
        $userRole->givePermissionTo([
            'view posts',
            'create posts',
            'edit posts',
            'delete posts'
        ]);

        // Create admin user if it doesn't exist
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@miniblog.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password')
            ]
        );
        $adminUser->assignRole('admin');

        // Create regular user if it doesn't exist
        $regularUser = User::firstOrCreate(
            ['email' => 'user@miniblog.com'],
            [
                'name' => 'Regular User',
                'password' => bcrypt('password')
            ]
        );
        $regularUser->assignRole('user');
    }
}
