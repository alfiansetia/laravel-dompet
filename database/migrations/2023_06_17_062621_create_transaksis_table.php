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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dompet_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['in', 'out'])->default('out');
            $table->integer('amount')->default(0);
            $table->integer('cost')->default(0);
            $table->integer('revenue')->default(0);
            $table->enum('status', ['success', 'pending', 'cancel'])->default('success');
            $table->string('desc')->nullable();
            $table->timestamps();
            $table->foreign('dompet_id')->references('id')->on('dompets')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
};
