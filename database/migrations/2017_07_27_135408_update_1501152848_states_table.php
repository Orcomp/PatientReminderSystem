<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1501152848StatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('states', function (Blueprint $table) {
            $table->integer('country_id')->unsigned()->nullable();
                $table->foreign('country_id', '57019_5979c64fb06f6')->references('id')->on('countries')->onDelete('cascade');
                
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('states', function (Blueprint $table) {
            $table->dropForeign('57019_5979c64fb06f6');
            $table->dropIndex('57019_5979c64fb06f6');
            $table->dropColumn('country_id');
            
        });

    }
}
