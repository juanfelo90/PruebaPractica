<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sku', 50)->nullable();
            $table->string('nombre', 100)->unique();
            $table->string('descripcion', 256)->nullable();
            $table->integer('valor')->unsigned();
            $table->integer('tienda_id')->unsigned();
            $table->string('imagen', 256)->nullable();
            $table->boolean('condicion')->default(1);      
            $table->timestamps();
            $table->foreign('tienda_id')->references('id')->on('tienda');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
