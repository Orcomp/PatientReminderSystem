<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1501153920ContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->integer('patient_id')->unsigned()->nullable();
                $table->foreign('patient_id', '57021_5979ca7fb9435')->references('id')->on('patients')->after('email')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign('57021_5979ca7fb9435');
            $table->dropIndex('57021_5979ca7fb9435');
            $table->dropColumn('patient_id');

        });

    }
}
