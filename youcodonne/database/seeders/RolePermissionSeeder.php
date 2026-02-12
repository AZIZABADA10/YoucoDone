<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les permissions
        $permissions = [
            'view-restaurants',
            'create-restaurant',
            'edit-restaurant',
            'delete-restaurant',
            'manage-reservations',
            'make-reservation',
            'manage-users',
            'view-dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Créer les rôles et assigner les permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $restaurateurRole = Role::create(['name' => 'restaurateur']);
        $restaurateurRole->givePermissionTo([
            'view-restaurants',
            'create-restaurant',
            'edit-restaurant',
            'delete-restaurant',
            'manage-reservations',
        ]);

        $clientRole = Role::create(['name' => 'client']);
        $clientRole->givePermissionTo([
            'view-restaurants',
            'make-reservation',
        ]);

        // Créer un admin par défaut
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@youcodone.com',
            'password' => bcrypt('password'),
            'type' => 'admin',
        ]);
        $admin->assignRole('admin');
    }
}