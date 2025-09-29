<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('technicien_notifications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('technicien_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('poste_id')->constrained()->onDelete('cascade');
        $table->string('message');
        $table->boolean('lu')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technicien_notifications');
    }
};
