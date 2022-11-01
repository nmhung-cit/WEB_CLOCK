<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->increments('id_productDetail');
            $table->integer('id_product')->unsigned();
            $table->string('batery');
            $table->string('material');
            $table->string('material_glass');
            $table->string('glass_shape');
            $table->string('glass_size');
            $table->string('waterproof_lever');
            $table->string('color');
            $table->string('origin');
            $table->timestamps();

            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_details');
    }
}
