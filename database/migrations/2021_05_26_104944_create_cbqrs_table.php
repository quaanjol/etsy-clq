<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCbqrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cbqrs', function (Blueprint $table) {
            $table->id();
            $table->string('order_date');
            $table->string('order_number');
            $table->string('customer_note');
            $table->string('email_billing');
            $table->string('quantity');
            $table->string('item_name');
            $table->string('sku');
            $table->string('full_name');
            $table->string('address1');
            $table->string('address2');
            $table->string('city');
            $table->string('state_code');
            $table->string('zip_code');
            $table->string('country_code');
            $table->string('phone');
            $table->string('transaction_id');
            $table->string('product_variation');
            $table->string('customer_note2');
            $table->string('item_sku');
            // $table->string('base_cost');
            // $table->string('total_price');
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
        Schema::dropIfExists('cbqrs');
    }
}
