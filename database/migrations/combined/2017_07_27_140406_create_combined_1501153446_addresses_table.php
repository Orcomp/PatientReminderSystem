<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCombined1501153446AddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('addresses')) {
            Schema::create('addresses', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('contact_id')->unsigned()->nullable();
                $table->foreign('contact_id', '57025_5979c8a65ee2e')->references('id')->on('contacts')->onDelete('cascade');
                $table->string('street')->nullable();
                $table->integer('city_id')->unsigned()->nullable();
                $table->foreign('city_id', '57025_5979c8a6701b5')->references('id')->on('cities')->onDelete('cascade');
                $table->integer('state_id')->unsigned()->nullable();
                $table->foreign('state_id', '57025_5979c8a67f2b6')->references('id')->on('states')->onDelete('cascade');
                $table->integer('country_id')->unsigned()->nullable();
                $table->foreign('country_id', '57025_5979c8a68a82a')->references('id')->on('countries')->onDelete('cascade');
                $table->text('note')->nullable();
                $table->integer('address_type_id')->unsigned()->nullable();
                $table->foreign('address_type_id', '57025_597a31c5a6247')->references('id')->on('address_types')->onDelete('cascade');
                
                $table->timestamps();
                $table->softDeletes();

                $table->index(['deleted_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
