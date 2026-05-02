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
        Schema::rename('availabilities', 'unavailabilities');

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['availability_id']);
            $table->dropColumn('availability_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('availability_id')->nullable()->constrained('availabilities')->cascadeOnDelete();
        });

        Schema::rename('unavailabilities', 'availabilities');
    }
};
