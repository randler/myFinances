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
        Schema::create('rooms', function(Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')
                ->comment('The user who created the room')
                ->references('id')
                ->on('users');
            $table->foreignId('receiver_id')
                ->comment('The user who received the room')
                ->references('id')
                ->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
