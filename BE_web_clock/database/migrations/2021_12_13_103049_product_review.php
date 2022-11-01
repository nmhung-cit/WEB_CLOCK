<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductReview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->increments('id_reviews');
            $table->integer('id_product')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->integer('id_order')->unsigned();
            $table->integer('star');
            $table->text('comment')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_order')->references('id_order')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_reviews');
    }
}
// <?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// class CreateProductReviewsTable extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         Schema::create('product_reviews', function (Blueprint $table) {
//             $table->increments('id_reviews');
//             $table->integer('id_product')->unsigned();
//             $table->integer('id_user')->unsigned();
//             $table->integer('id_order')->unsigned();
//             $table->integer('star');
//             $table->text('comment')->nullable();
//             $table->text('feedback')->nullable();
//             $table->timestamps();

//             $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
//             $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
//             // $table->foreign('id_order')->references('id_order')->on('orders')->onDelete('cascade');
//         });
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down()
//     {
//         Schema::dropIfExists('product_reviews');
//     }
// }
