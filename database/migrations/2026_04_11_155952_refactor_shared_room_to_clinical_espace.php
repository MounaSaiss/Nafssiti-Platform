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
        // 1. Remove old clinical space features
        Schema::dropIfExists('mood_logs');
        Schema::dropIfExists('to_do_tasks');
        Schema::dropIfExists('shared_notes');

        // 2. Enhance patient profile
        Schema::table('patients', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('user_id');
            $table->text('problematique_principale')->nullable()->after('date_of_birth');
        });

        // 3. Create Private Notes (Visible only to psychologists)
        Schema::create('private_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('psychologist_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->timestamps();
        });

        // 4. Create Therapeutic Objectives
        Schema::create('therapeutic_objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('psychologist_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->text('description');
            $table->enum('status', ['en cours', 'atteint'])->default('en cours');
            $table->timestamps();
        });

        // 5. Create Recommendations
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('psychologist_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendations');
        Schema::dropIfExists('therapeutic_objectives');
        Schema::dropIfExists('private_notes');

        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['date_of_birth', 'problematique_principale']);
        });

        // We don't necessarily recreate the dropped tables in down() 
        // because we don't have their original schema here easily, 
        // and this is a major refactor.
    }
};
