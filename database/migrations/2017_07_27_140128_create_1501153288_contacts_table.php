<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1501153288ContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('contacts')) {
            Schema::create('contacts', function (Blueprint $table) {
                $table->increments('id');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('mobile_number')->nullable();
                $table->string('phone_number')->nullable();
                $table->string('email')->nullable();
                $table->integer('contact_type_id')->unsigned()->nullable();
                $table->foreign('contact_type_id', '57021_5979c80903808')->references('id')->on('contact_types')->onDelete('cascade');
                $table->integer('designation_type_id')->unsigned()->nullable();
                $table->foreign('designation_type_id', '57021_5979c8090b548')->references('id')->on('designation_types')->onDelete('cascade');
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', '57021_5979c809221e7')->references('id')->on('users')->onDelete('cascade');
                $table->tinyInteger('is_primary')->nullable()->default(0);
                
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
        Schema::dropIfExists('contacts');
    }
}
