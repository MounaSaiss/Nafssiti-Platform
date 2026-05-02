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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('city');
        });

        Schema::dropIfExists('private_notes');
        Schema::dropIfExists('specialities');

        Schema::table('psychologists', function (Blueprint $table) {
            $table->dropColumn('photo');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('recommendations', function (Blueprint $table) {
            $table->dropForeign(['patient_id', 'psychologist_id']);
            $table->dropColumn(['patient_id', 'psychologist_id']);
            $table->foreignId('follow_request_id')->constrained()->cascadeOnDelete();
        });

        Schema::table('therapeutic_objectives', function (Blueprint $table) {
            $table->dropForeign(['patient_id', 'psychologist_id']);
            $table->dropColumn(['patient_id', 'psychologist_id']);
            $table->foreignId('follow_request_id')->constrained()->cascadeOnDelete();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
