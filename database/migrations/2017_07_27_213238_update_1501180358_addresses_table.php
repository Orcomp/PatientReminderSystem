<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1501180358AddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->integer('address_type_id')->unsigned()->nullable();
                $table->foreign('address_type_id', '57025_597a31c5a6247')->references('id')->on('address_types')->onDelete('cascade');
                
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
            $table->dropForeign('57025_597a31c5a6247');
            $table->dropIndex('57025_597a31c5a6247');
            $table->dropColumn('address_type_id');
            
        });

    }
}
