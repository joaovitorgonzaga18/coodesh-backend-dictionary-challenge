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
        Schema::create('user_access_history', function (Blueprint $table) {
            $table->string('user_id', false, true);            
            $table->foreign('user_id')->references('uuid')->on('users')->onDelete('cascade');
            $table->string('word');
            $table->dateTime('added');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_access_history');
    }
};
