<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1501155407AppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('appointments')) {
            Schema::create('appointments', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('patient_id')->unsigned()->nullable();
                $table->foreign('patient_id', '57043_5979d04f67512')->references('id')->on('patients')->onDelete('cascade');
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', '57043_5979d04f7b49f')->references('id')->on('users')->onDelete('cascade');
                $table->datetime('appointment_time')->nullable();
                $table->datetime('confirmed_at')->nullable();
                $table->integer('contacted_contact_id')->unsigned()->nullable();
                $table->foreign('contacted_contact_id', '57043_5979d04fa6316')->references('id')->on('contacts')->onDelete('cascade');
                $table->text('notes')->nullable();
                $table->integer('created_by_id')->unsigned()->nullable();
                $table->foreign('created_by_id', '57043_5979d04fb743a')->references('id')->on('users')->onDelete('cascade');
                
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
        Schema::dropIfExists('appointments');
    }
}
