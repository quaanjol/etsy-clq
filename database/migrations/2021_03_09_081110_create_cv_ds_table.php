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
            $table->string('quantity');
            $table->string('item_variant_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('street1');
            $table->string('street2');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('zip');
            $table->string('phone');
            $table->string('force_verified_delivery');
            $table->string('print_area_key1');
            $table->string('artwork_url1');
            $table->string('resize1');
            $table->string('position1');
            $table->string('print_area_key2');
            $table->string('artwork_url2');
            $table->string('resize2');
            $table->string('position2');
            $table->string('print_area_key3');
            $table->string('artwork_url3');
            $table->string('resize3');
            $table->string('position3');
            $table->string('print_area_key4');
            $table->string('artwork_url4');
            $table->string('resize4');
            $table->string('position4');
            $table->string('print_area_key5');
            $table->string('artwork_url5');
            $table->string('resize5');
            $table->string('position5');
            $table->string('test_order');
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
