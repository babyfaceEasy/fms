<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('ticket_id')->unique();
            $table->string('title');
            $table->string('priority');
            $table->text('message');
            $table->string('status');
            $table->timestamps();
            $table->string('nodeA', 100);
            $table->string('nodeB', 100);
            $table->string('vendor', 100);
            $table->string('site_id', 100);
            $table->string('bsc');
            $table->string('location');
            $table->string('region');
            $table->string('time_occurence');
            $table->string('cause_of_failure');
            $table->text('impact');
            $table->text('resolution');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tickets');
    }
}
