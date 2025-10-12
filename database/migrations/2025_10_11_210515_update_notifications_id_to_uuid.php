<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Supprimer la colonne id actuelle (probablement un bigint)
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        // Recréer la colonne id avec le type UUID (string)
        Schema::table('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary()->first();
        });
    }

    public function down(): void
    {
        // Permet de revenir en arrière si besoin
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->bigIncrements('id')->first();
        });
    }
};
