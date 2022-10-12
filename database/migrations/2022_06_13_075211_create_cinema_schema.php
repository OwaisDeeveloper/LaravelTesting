<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */


    /*
     * Task 4 completed
     */
    public function up()
    {

        /*
         * Movies Schema
         */
        Schema::create('movies', function(Blueprint $table)
        {
            $table->id();
            $table->string('name');
        });


        /*
        * ShowRoom Schema
        */
        Schema::create('show_rooms', function(Blueprint $table)
        {
            $table->id();
            $table->string('name');
        });

        /*
         * Shows Schema
         * Show status refers to that weather a show is booked or running or close e.tc
         */
        Schema::create('shows', function(Blueprint $table)
        {
            $table->id();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->string('show_status');
            $table->bigInteger('show_room_id')->unsigned()->index()->nullable();;
            $table->foreign('show_room_id')
                ->references('id')
                ->on('show_rooms');
            $table->string('standard_price');
            $table->bigInteger('movie_id')->unsigned()->index()->nullable();;
            $table->foreign('movie_id')
                ->references('id')
                ->on('movies');
            $table->timestamps();

        });

        /*
         * Seating Schema
         * Seat Type refers to as seat/couple seat/super vip/whatever
         * Seat Status refers to as occupied or empty
         * Assigned user id will be null once the seat is empty
         * Unique seat number can be referred to as ticket number
        */

        Schema::create('seating', function(Blueprint $table)
        {
            $table->id();
            $table->string('unique_seat_number');
            $table->string('seat_type');
            $table->float('percentage_premium');
            $table->string('status');
            $table->bigInteger('show_room_id')->unsigned()->index()->nullable();;
            $table->foreign('show_room_id')
                ->references('id')
                ->on('show_rooms');
            $table->integer('assigned_user_id');

        });


        // throw new \Exception('implement in coding task 4, you can ignore this exception if you are just running the initial migrations.');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
