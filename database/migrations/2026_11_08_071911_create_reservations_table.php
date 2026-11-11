<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('lesson_id');
            $table->string('lesson_name');
            $table->date('date');
            $table->string('starts_at', 5);
            $table->string('ends_at', 5);
            $table->string('location');
            $table->string('name');
            $table->string('email');
            $table->timestamps();

            $table->unique(['lesson_id', 'date', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
