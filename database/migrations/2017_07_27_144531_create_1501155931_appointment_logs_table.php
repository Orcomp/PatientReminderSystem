<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1501155931AppointmentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('appointment_logs')) {
            Schema::create('appointment_logs', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('appointment_id')->unsigned()->nullable();
                $table->foreign('appointment_id', '57046_5979d25c466c9')->references('id')->on('appointments')->onDelete('cascade');
                $table->datetime('appointment_time')->nullable();
                $table->text('note')->nullable();
                $table->integer('reschedule_reason_id')->unsigned()->nullable();
                $table->foreign('reschedule_reason_id', '57046_5979d25c4ff7a')->references('id')->on('reschedule_reasons')->onDelete('cascade');
                $table->integer('created_by_id')->unsigned()->nullable();
                $table->foreign('created_by_id', '57046_5979d25c604c5')->references('id')->on('users')->onDelete('cascade');
                
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
        Schema::dropIfExists('appointment_logs');
    }
}
