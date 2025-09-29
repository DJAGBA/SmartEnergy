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
    Schema::table('coupures', function (Blueprint $table) {
        $table->foreignId('zone_id')->constrained()->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('coupures', function (Blueprint $table) {
        $table->dropForeign(['zone_id']);
        $table->dropColumn('zone_id');
    });
}
};
