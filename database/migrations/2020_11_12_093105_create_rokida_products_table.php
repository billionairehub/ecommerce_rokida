<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Backend\Product;

class CreateRokidaProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rokida_products', function (Blueprint $table) {
            $table->id();
            $table->integer('author');
            $table->string('sku', 255);
            $table->string('name', 255);
            $table->string('product_code', 255)->nullable();
            $table->integer('shop_id');
            $table->integer('price');
            $table->integer('promotion_price')->nullable();
            $table->string('long_desc', 510)->nullable();
            $table->string('short_desc', 255)->nullable();
            $table->string('thumb', 510);
            $table->string('image', 510);
            $table->integer('categories');
            $table->integer('amount');
            $table->string('location', 255)->nullable();
            $table->string('promotion_code', 255);
            $table->string('trade_mark', 255);
            $table->string('made', 255);
            $table->string('user_manual', 255);
            $table->string('img_user_manual', 255);
            $table->integer('consumed');
            $table->tinyInteger('status');
            $table->tinyInteger('book');
            $table->tinyInteger('hidden');
            $table->string('slug', 255);
            $table->tinyInteger('infringe');
            $table->bigInteger('add_to_card');
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rokida_products');
    }
}
