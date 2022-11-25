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
        Schema::create('barang', function (Blueprint $table) {
            $table->id('barang_id');
            $table->bigInteger('kategori_id')->unsigned();
            $table->string('nama');
            $table->integer('harga');
            $table->bigInteger('suplier_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('barang', function (Blueprint $table) {
            $table->foreign('kategori_id')->references('kategori_id')->on('kategori')
	    ->onDelete('cascade')->onUpdate('cascade');
        $table->foreign('suplier_id')->references('suplier_id')->on('suplier')
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
        Schema::dropIfExists('barang');
    }
};
