<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEtatToCoupuresTable extends Migration
{
    public function up()
    {
        Schema::table('coupures', function (Blueprint $table) {
            $table->string('etat')->default('planifiee')->after('type');
        });
    }

    public function down()
    {
        Schema::table('coupures', function (Blueprint $table) {
            $table->dropColumn('etat');
        });
    }
}