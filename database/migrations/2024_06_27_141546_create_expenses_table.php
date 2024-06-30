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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('description', 255)->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('amount_paid', 15, 2)->nullable();
            $table->date('expiration_date')->nullable();
            $table->date('paid_date')->nullable();
            // recurrence
            $table->enum('recurrence', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
