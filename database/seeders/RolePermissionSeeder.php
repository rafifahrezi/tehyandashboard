<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role 'admin' jika belum ada
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Buat akun admin pertama
        $admin = User::firstOrCreate(
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
            ]
        );

        // Berikan role 'admin' ke user admin
        $admin->assignRole($adminRole);

        // Buat role 'owner' jika belum ada
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);

        // Buat akun owner pertama
        $owner = User::firstOrCreate(
            [
                'name' => 'Owner User',
                'email' => 'owner@gmail.com',
                'password' => Hash::make('owner123'),
            ]
        );

        // Berikan role 'owner' ke user admin
        $owner->assignRole($ownerRole);
    }
}
