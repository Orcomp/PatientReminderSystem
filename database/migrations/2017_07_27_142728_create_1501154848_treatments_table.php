<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1501154848TreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('treatments')) {
            Schema::create('treatments', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('patient_id')->unsigned()->nullable();
                $table->foreign('patient_id', '57042_5979ce2057763')->references('id')->on('patients')->onDelete('cascade');
                $table->integer('treatment_type_id')->unsigned()->nullable();
                $table->foreign('treatment_type_id', '57042_5979ce2060438')->references('id')->on('treatment_types')->onDelete('cascade');
                $table->integer('treatment_stage_id')->unsigned()->nullable();
                $table->foreign('treatment_stage_id', '57042_5979ce2068477')->references('id')->on('treatment_stages')->onDelete('cascade');
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
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
        Schema::dropIfExists('treatments');
    }
}
