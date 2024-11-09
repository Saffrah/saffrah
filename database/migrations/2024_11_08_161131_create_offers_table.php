<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('from_city');
            $table->unsignedBigInteger('to_city');
            $table->integer('no_of_nights');
            $table->integer('no_of_adults');
            $table->integer('no_of_children');
            $table->integer('max_price');
            $table->boolean('including_tickets')->default(0);
            $table->boolean('including_hotels')->default(0);
            $table->boolean('including_program')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('from_city')->references('id')->on('cities');
            $table->foreign('to_city')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
