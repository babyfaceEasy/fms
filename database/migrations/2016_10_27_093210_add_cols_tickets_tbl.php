<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsTicketsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            //transmission
            $table->string('nodeA', 100);
            $table->string('nodeB', 100);
            $table->string('vendor', 100);
            
            //base station
            $table->string('site_id', 100);
            $table->string('bsc');

            //ip network
            $table->string('location');

            //general
            $table->string('region');
            $table->time('time_occurence');
            $table->string('cause_of_failure');
            $table->text('impact');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('nodeA');
            $table->dropColumn('nodeB');
            $table->dropColumn('vendor');
            $table->dropColumn('site_id');
            $table->dropColumn('bsc');
            $table->dropColumn('location');
            $table->dropColumn('region');
            $table->dropColumn('time_occurence');
            $table->dropColumn('cause_of_failure');
            $table->dropColumn('impact');
        });
    }
}
