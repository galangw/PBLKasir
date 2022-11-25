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
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id('barang_masuk_id');
            $table->bigInteger('barang_id')->unsigned();
            $table->integer('jumlah');
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::table('barang_masuk', function (Blueprint $table) {
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
        Schema::dropIfExists('barang_masuk');
    }
};
