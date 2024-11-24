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
        Schema::table('package_confirms', function (Blueprint $table) {
            $table->date('end_date')->after('due_date');
            $table->integer('no_of_guests')->nullable()->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_confirms', function (Blueprint $table) {
            $table->dropColumn('end_date');
            $table->dropColumn('no_of_guests');
        });
    }
};
