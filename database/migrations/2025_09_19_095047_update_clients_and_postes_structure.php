<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Modifier la table clients
        Schema::table('clients', function (Blueprint $table) {
            // Supprimer la contrainte existante
            $table->dropForeign(['poste_id']);
        });

        Schema::table('clients', function (Blueprint $table) {
            // Modifier la colonne pour la rendre nullable
            $table->unsignedBigInteger('poste_id')->nullable()->change();

            // Réappliquer la contrainte avec onDelete('set null')
            $table->foreign('poste_id')
                  ->references('id')->on('postes')
                  ->onDelete('set null');
        });

        // Ajouter le champ etat dans la table postes
        Schema::table('postes', function (Blueprint $table) {
            $table->enum('etat', ['actif', 'inactif', 'hors_service'])->default('actif')->after('created_by');
        });
    }

    public function down(): void
    {
        // Revenir à la version précédente
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['poste_id']);
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->unsignedBigInteger('poste_id')->nullable(false)->change();

            $table->foreign('poste_id')
                  ->references('id')->on('postes')
                  ->onDelete('cascade');
        });

        Schema::table('postes', function (Blueprint $table) {
            $table->dropColumn('etat');
        });
    }
};