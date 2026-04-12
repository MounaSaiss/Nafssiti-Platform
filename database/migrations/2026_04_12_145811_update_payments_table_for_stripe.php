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
        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('amount', 'totalPrice');
            $table->foreignId('user_id')->after('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->string('stripe_id')->after('user_id')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'stripe_id']);
            $table->renameColumn('totalPrice', 'amount');
        });
    }
};
