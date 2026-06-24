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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('unit_id')->constrained()->onDelete('cascade');
    // هنا المرونة: الأدمن يختار إيه اللي يظهر في الدرس
            $table->boolean('has_vocabulary')->default(false);
            $table->boolean('has_reading')->default(false);
            $table->boolean('has_grammar')->default(false);
            $table->boolean('has_conversation')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
