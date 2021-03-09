<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCvDsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cv_ds', function (Blueprint $table) {
            $table->id();
            $table->string('reference_id');
            $string->string('quantity');
            $string->string('item_variant_id');
            $string->string('first_name');
            $string->string('last_name');
            $string->string('street1');
            $string->string('street2');
            $string->string('city');
            $string->string('state');
            $string->string('country');
            $string->string('zip');
            $string->string('phone');
            $string->string('force_verified_delivery');
            $string->string('print_area_key1');
            $string->string('artwork_url1');
            $string->string('resize1');
            $string->string('position1');
            $string->string('print_area_key2');
            $string->string('artwork_url2');
            $string->string('resize2');
            $string->string('position2');
            $string->string('print_area_key3');
            $string->string('artwork_url3');
            $string->string('resize3');
            $string->string('position3');
            $string->string('print_area_key4');
            $string->string('artwork_url4');
            $string->string('resize4');
            $string->string('position4');
            $string->string('print_area_key5');
            $string->string('artwork_url5');
            $string->string('resize5');
            $string->string('position5');
            $string->string('test_order');
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
        Schema::dropIfExists('cv_ds');
    }
}
