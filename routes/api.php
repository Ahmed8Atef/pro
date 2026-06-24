<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\UnitController;
use Illuminate\Http\Request;

// مسارات عامة (لا تحتاج تسجيل دخول)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/grades', [GradeController::class, 'index']);

// مسارات محمية (تحتاج توكين)
Route::middleware('auth:sanctum')->group(function () {
    
    // 🌟 تم إضافة مسار تسجيل الخروج هنا
    Route::post('/logout', [AuthController::class, 'logout']);

    // مسار البروفايل (النسخة الشاملة اللي فيها الـ grade)
    Route::get('/user', function (Request $request) {
        return $request->user()->load('grade');
    });

    // مسارات المنهج
    Route::get('/lessons', [LessonController::class, 'index']);
    Route::get('/lessons/{id}', [LessonController::class, 'show']);
    
    // مسار الوحدات
    Route::get('/units', [UnitController::class, 'index']);
});