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
            $table->text('description_ar')->nullable()->after('description');
        });
        Schema::table('transits', function (Blueprint $table) {
            $table->text('description_ar')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('description_ar');
        });
        Schema::table('transits', function (Blueprint $table) {
            $table->dropColumn('description_ar');
        });
    }
};
