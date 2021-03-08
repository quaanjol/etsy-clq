<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBigcomOriginalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bigcom_originals', function (Blueprint $table) {
            $table->id();
            $table->string('site');
            $table->string('order_id');
            $table->string('order_status');
            $table->date('order_date');
            $table->string('order_time');
            $table->string('shipping_cost_tax');
            $table->string('shipping_cost_no_tax');
            $table->string('customer_id');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('ship_method');
            $table->string('payment_method');
            $table->string('total_quantity');
            $table->string('total_shipped');
            $table->string('order_notes');
            $table->string('customer_message');
            $table->string('shipping_name');
            $table->string('shipping_first_name');
            $table->string('shipping_last_name');
            $table->string('shipping_company');
            $table->string('shipping_street1');
            $table->string('shipping_street2');
            $table->string('shipping_suburb');
            $table->string('shipping_state');
            $table->string('shipping_state_abbreviation');
            $table->string('shipping_zip');
            $table->string('shipping_country');
            $table->string('shipping_suburb_state_zip');
            $table->string('shipping_phone');
            $table->string('shipping_email');
            $table->string('product_details');
            $table->string('transaction_id');
            $table->date('deleted_at')->nullable();
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
        Schema::dropIfExists('bigcom_originals');
    }
}
