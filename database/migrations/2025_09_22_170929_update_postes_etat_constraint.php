<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Supprimer l'ancienne contrainte si elle existe
        DB::statement("ALTER TABLE postes DROP CONSTRAINT IF EXISTS postes_etat_check");

        // Ajouter la nouvelle contrainte avec 'en_attente'
        DB::statement("ALTER TABLE postes ADD CONSTRAINT postes_etat_check CHECK (etat IN ('actif', 'hors_service', 'en_attente'))");

        // Définir la valeur par défaut
        DB::statement("ALTER TABLE postes ALTER COLUMN etat SET DEFAULT 'en_attente'");
    }

    public function down(): void
    {
        // Revenir à la contrainte d'origine
        DB::statement("ALTER TABLE postes DROP CONSTRAINT IF EXISTS postes_etat_check");
        DB::statement("ALTER TABLE postes ADD CONSTRAINT postes_etat_check CHECK (etat IN ('actif', 'hors_service'))");
        DB::statement("ALTER TABLE postes ALTER COLUMN etat SET DEFAULT 'actif'");
    }
};