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
        Schema::table('cities', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->foreign('from_city')->references('id')->on('cities');
            $table->foreign('to_city')->references('id')->on('cities');
        });

        Schema::table('transits', function (Blueprint $table) {
            $table->foreign('to_city')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->unsignedMediumInteger('id')->change();
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropForeign('from_city');
            $table->dropForeign('to_city');
        });

        Schema::table('transits', function (Blueprint $table) {
            $table->dropForeign('to_city');
        });
    }
};
