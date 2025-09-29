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
        // Permissions de base
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'view own posts',
            'manage notifications',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Création des rôles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $gestionnaireRole = Role::firstOrCreate(['name' => 'gestionnaire', 'guard_name' => 'web']);
        $technicienRole = Role::firstOrCreate(['name' => 'technicien', 'guard_name' => 'web']);
        $clientRole = Role::firstOrCreate(['name' => 'client', 'guard_name' => 'web']);

        // Attribution des permissions
        $adminRole->syncPermissions(Permission::all());

        $gestionnaireRole->syncPermissions([
            'view posts',
            'create posts',
            'edit posts',
        ]);

        $technicienRole->syncPermissions([
            'view posts',
            'manage notifications',
        ]);

        $clientRole->syncPermissions([
            'view own posts',
            'manage notifications',
        ]);

        // Création des utilisateurs de test
        $admin = User::firstOrCreate(
            ['email' => 'admin@ceet.tg'],
            ['name' => 'Admin', 'password' => bcrypt('password')]
        );
        $admin->assignRole('admin');

        $gestionnaire = User::firstOrCreate(
            ['email' => 'gestionnaire@ceet.tg'],
            ['name' => 'Gestionnaire', 'password' => bcrypt('password')]
        );
        $gestionnaire->assignRole('gestionnaire');

        $technicien = User::firstOrCreate(
            ['email' => 'technicien@ceet.tg'],
            [
                'name' => 'Technicien',
                'password' => bcrypt('password'),
                // 'zone_id' => 1, // Assure-toi que la zone avec ID 1 existe
            ]
        );
        $technicien->assignRole('technicien');

        $client = User::firstOrCreate(
            ['email' => 'client@ceet.tg'],
            ['name' => 'Client Test', 'password' => bcrypt('password')]
        );
        $client->assignRole('client');

        // Message terminal
        $this->command->info('✅ Rôles, permissions et utilisateurs de test créés avec succès.');
    }
}