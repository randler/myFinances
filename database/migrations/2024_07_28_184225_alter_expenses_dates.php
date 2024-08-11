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
        Schema::table('expenses', function(Blueprint $table) {
            $table->dropColumn('expiration_date');
            $table->integer('expiration_day');
            $table->dropColumn('recurrence');
            $table->integer('recurrence_month')->default(1);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function(Blueprint $table) {
            $table->dropColumn('expiration_day');
            $table->date('expiration_date')->nullable();
            $table->dropColumn('recurrence_month');
            $table->enum('recurrence', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
        });
    }
};
