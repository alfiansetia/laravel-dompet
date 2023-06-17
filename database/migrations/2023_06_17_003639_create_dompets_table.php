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
        Schema::create('dompets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['cash', 'ewallet'])->default('ewallet');
            $table->string('acc_name');
            $table->string('acc_number');
            $table->integer('saldo')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dompets');
    }
};
