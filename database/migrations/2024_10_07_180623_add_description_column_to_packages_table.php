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
        Schema::table('packages', function (Blueprint $table) {
            $table->unsignedBigInteger('from_city')->change();
            $table->unsignedBigInteger('to_city')->change();
            $table->string('hotel_name', 150)->after('price_per_person');
            $table->string('hotel_name_ar', 150)->after('hotel_name');
            $table->text('description')->nullable()->after('hotel_name_ar');
            $table->smallInteger('reservation_type')->after('description')->default(1);
            $table->boolean('is_cruise')->after('reservation_type')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('from_city')->change();
            $table->string('to_city')->change();
            $table->dropColumn('hotel_name');
            $table->dropColumn('hotel_name_ar');
            $table->dropColumn('description');
            $table->dropColumn('reservation_type');
            $table->dropColumn('is_cruise');
        });
    }
};
