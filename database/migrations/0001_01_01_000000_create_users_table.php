<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // جدول المستخدمين الجديد
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // الـ phone والـ identity هما اللي بنسجل بيهم
            $table->string('phone')->unique(); 
            $table->string('identity')->unique();
            // الـ email اختياري عشان الـ Filament والـ Auth يشتغلوا بسلاسة
            $table->string('email')->unique()->nullable(); 
            $table->string('password');
            $table->enum('role', ['admin', 'student'])->default('student');
            $table->rememberToken();
            $table->timestamps();
        });

        // جدول الجلسات (سيبه زي ما هو عشان الـ Auth)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};