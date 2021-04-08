<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopifyOriginalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopify_originals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('financial_status');
            $table->string('paid_at');
            $table->string('fulfillment_status');
            $table->string('fulfillment_at');
            $table->string('accepts_marketing');
            $table->string('currency');
            $table->string('subtotal');
            $table->string('shipping');
            $table->string('taxes');
            $table->string('total');
            $table->string('discount_code');
            $table->string('discount_amount');
            $table->string('shipping_method');
            $table->string('created_at');
            $table->string('lineitem_quantity');
            $table->string('limeitem_name');
            $table->string('lineitem_price');
            $table->string('lienitem_compare_at_price');
            $table->string('lineitem_sku');
            $table->string('lineitem_requires_shipping');
            $table->string('lineitem_taxable');
            $table->string('lineitem_fulfillment_status');
            $table->string('billing_name');
            $table->string('billing_street');
            $table->string('billing_address1');
            $table->string('billing_address2');
            $table->string('billing_company');
            $table->string('billing_city');
            $table->string('billing_zip');
            $table->string('billing_province');
            $table->string('billing_country');
            $table->string('billing_phone');
            $table->string('shipping_name');
            $table->string('shipping_street');
            $table->string('shipping_address1');
            $table->string('shipping_address2');
            $table->string('shipping_company');
            $table->string('shipping_city');
            $table->string('shipping_zip');
            $table->string('shipping_province');
            $table->string('shipping_country');
            $table->string('shipping_phone');
            $table->string('notes');
            $table->string('note_attributes');
            $table->string('cancelled_at');
            $table->string('payment_method');
            $table->string('payment_preference');
            $table->string('refunded_amount');
            $table->string('vendor');
            $table->string('id2');
            $table->string('tags');
            $table->string('risk_level');
            $table->string('source');
            $table->string('lineitem_discount');
            $table->string('tax1_name');
            $table->string('tax1_value');
            $table->string('tax2_name');
            $table->string('tax2_value');
            $table->string('tax3_name');
            $table->string('tax3_value');
            $table->string('tax4_name');
            $table->string('tax4_value');
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
        Schema::dropIfExists('shopify_originals');
    }
}
