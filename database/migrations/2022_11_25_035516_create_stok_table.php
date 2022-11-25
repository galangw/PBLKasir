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
        Schema::create('stok', function (Blueprint $table) {
            $table->id('stok_id');
            $table->integer('jumlah');
            $table->bigInteger('barang_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('stok', function (Blueprint $table) {
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
        Schema::dropIfExists('stok');
    }
};
