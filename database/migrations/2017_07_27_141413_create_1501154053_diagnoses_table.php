<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1501154053DiagnosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('diagnoses')) {
            Schema::create('diagnoses', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('patient_id')->unsigned()->nullable();
                $table->foreign('patient_id', '57034_5979cb05355bd')->references('id')->on('patients')->onDelete('cascade');
                $table->integer('diagnose_type_id')->unsigned()->nullable();
                $table->foreign('diagnose_type_id', '57034_5979cb053e447')->references('id')->on('diagnoses_types')->onDelete('cascade');
                $table->date('diagnose_date')->nullable();
                $table->text('notes')->nullable();
                
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
        Schema::dropIfExists('diagnoses');
    }
}
