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
        Schema::create('shelters', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->text('area');
            $table->string('floor_no');
            $table->string('nb_of_rooms');
            $table->string('capacity');
            $table->boolean('rent')->nullable();
            $table->boolean('furnished')->nullable();
            $table->boolean('elevator')->nullable();
            $table->string('price')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelters');
    }
};
