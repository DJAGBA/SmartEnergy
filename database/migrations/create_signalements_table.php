<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('signalements')) {
            Schema::create('signalements', function (Blueprint $table) {
                $table->id();

                $table->foreignId('coupure_id')->constrained()->onDelete('cascade');
                $table->foreignId('poste_id')->constrained()->onDelete('cascade');
                $table->foreignId('gestionnaire_id')->constrained('users')->onDelete('cascade');

                $table->text('message')->nullable();
                $table->string('etat')->default('non traité');

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('signalements');
    }
};