<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBsOrderWongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bs_order_wongs', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('full_name');
            $table->string('address1');
            $table->string('address2');
            $table->string('city');
            $table->string('post_code');
            $table->string('state_code');
            $table->string('country_code');
            $table->string('phone');
            $table->string('product_variation');
            $table->string('item_sku');
            $table->string('quantity');
            $table->string('base_cost');
            $table->string('total_price');
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
        Schema::dropIfExists('bs_order_wongs');
    }
}
