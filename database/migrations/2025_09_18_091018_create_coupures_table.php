<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupures', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_debut'); // Date et heure de début
            $table->dateTime('date_fin');   // Date et heure de fin
            $table->string('duree_prevue')->nullable(); // Calculée automatiquement
            $table->text('motif');
            $table->enum('priorite', ['faible', 'moyenne', 'élevée'])->default('moyenne');
            $table->foreignId('gestionnaire_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupures');
    }
};
