<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('departureTimeZone')->nullable();
            $table->string('arrivalTimeZone')->nullable();
            $table->string('estimatedTime')->nullable();
            $table->string('departureAirport')->nullable();
            $table->string('arrivalAirport')->nullable();
            $table->string('flightDate')->nullable();
            $table->string('status')->nullable();
            $table->string('airline')->nullable();
            $table->string('flightNo')->nullable();
            $table->string('departureTime')->nullable();
            $table->string('arrivalTime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flights');
    }
};
