<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->integer('patient_id')->unsigned()->nullable()->after('contact_id');
            $table->foreign('patient_id', '57025_597a31c6a6248')->references('id')->on('patients')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign('57025_597a31c6a6248');
            $table->dropIndex('57025_597a31c6a6248');
            $table->dropColumn('patient_id');
        });

    }
}
