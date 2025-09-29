<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Poste;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Appeler d'abord le seeder des rôles et permissions
        $this->call([
            RolePermissionSeeder::class,
            AgenceSeeder::class,
            ZoneSeeder::class,
           PosteSeeder::class,
            ClientSeeder::class,
        ]);

        // Créer des utilisateurs de test supplémentaires
        User::factory(5)->create();

        // Créer un utilisateur de test spécifique
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Assigner un rôle à l'utilisateur de test
        $testUser->assignRole('user');

        // Créer un éditeur de test
        $editor = User::factory()->create([
            'name' => 'Editor User',
            'email' => 'editor@example.com',
        ]);
        $editor->assignRole('editor');
    }
}