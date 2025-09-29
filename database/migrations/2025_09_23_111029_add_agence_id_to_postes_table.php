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
    Schema::table('postes', function (Blueprint $table) {
        $table->foreignId('agence_id')->nullable()->after('code_poste')->constrained()->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('postes', function (Blueprint $table) {
        $table->dropForeign(['agence_id']);
        $table->dropColumn('agence_id');
    });
}

};
