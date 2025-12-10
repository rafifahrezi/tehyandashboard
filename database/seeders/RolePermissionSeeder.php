<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);

        // Create users
        $admin = User::firstOrCreate(
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
            ]
        );
        $admin->assignRole($adminRole);

        $owner = User::firstOrCreate(
            [
                'name' => 'Owner User',
                'email' => 'owner@gmail.com',
                'password' => Hash::make('owner123'),
            ]
        );
        $owner->assignRole($ownerRole);
    }

    // add to permission after l:21
/*         $permissions = [
            'create stock moves',
            'view stock moves',
            'edit stock moves',
            'delete stock moves',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->givePermissionTo($permissions);
 */
}
