<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('image')->nullable()->after('desc');
        });
        Schema::table('capitals', function (Blueprint $table) {
            $table->string('image')->nullable()->after('desc');
        });
        Schema::table('expenditures', function (Blueprint $table) {
            $table->string('image')->nullable()->after('desc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('capitals', function (Blueprint $table) {
            $table->dropColumn('image');
        });
        Schema::table('expenditures', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
