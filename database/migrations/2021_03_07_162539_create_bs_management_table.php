<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBsManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bs_management', function (Blueprint $table) {
            $table->id();
            $table->string('order_date');
            $table->string('tracking_number');
            $table->string('order_number');
            $table->string('order_date2');
            $table->string('customer_note');
            $table->string('email_billing');
            $table->string('order_status');
            $table->string('paid_date');
            $table->string('shipping_method');
            $table->string('shipping_method2');
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
            $table->string('image_url');
            $table->string('order_refund_amount');
            $table->string('customer_note2');
            $table->string('item_sku');
            $table->string('quantity2');
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
        Schema::dropIfExists('bs_management');
    }
}
