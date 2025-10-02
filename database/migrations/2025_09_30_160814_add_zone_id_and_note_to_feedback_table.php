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
    Schema::table('feedback', function (Blueprint $table) {
        $table->foreignId('zone_id')->nullable()->constrained()->onDelete('set null');
        $table->tinyInteger('note')->nullable(); // note de satisfaction (1 à 5)
    });
}

public function down(): void
{
    Schema::table('feedback', function (Blueprint $table) {
        $table->dropForeign(['zone_id']);
        $table->dropColumn(['zone_id', 'note']);
    });
}

};
