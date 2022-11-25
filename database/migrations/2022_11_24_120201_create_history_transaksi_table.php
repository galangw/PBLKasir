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
        Schema::create('history_transaksi', function (Blueprint $table) {
            $table->id('history_transaksi_id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('barang_id')->unsigned();
            $table->integer('jumlah');
            $table->integer('total');
            $table->integer('laba');
            $table->date('tgl_transaksi');
            $table->timestamps();
        });

        Schema::table('history_transaksi', function (Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')
	    ->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('barang_id')->references('barang_id')->on('barang')
	    ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_transaksi');
    }
};
