<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show($id)
    {
        // 1. جلب الدرس مع العلاقات الضرورية فقط (بدون منطق داخل الـ with)
        $lesson = Lesson::with([
            'vocabularies', 
            'readings.terms', 
            'grammars',
            'quizzes'
        ])->findOrFail($id);

        return response()->json([
            'id' => $lesson->id,
            'title' => $lesson->title,
            
            // 2. الديناميكية تعتمد الآن على حقول الـ Flags في جدول الدرس
            'available_tabs' => [
                'vocab' => (bool)$lesson->has_vocabulary,
                'reading' => (bool)$lesson->has_reading,
                'grammar' => (bool)$lesson->has_grammar,
                'quiz' => $lesson->quizzes->isNotEmpty(), // المنطق الصحيح هنا
                'sentences' => (bool)$lesson->has_conversation,
            ],
            
            // 3. المحتوى
            'content' => [
                'vocab' => $lesson->vocabularies,
                'reading' => $lesson->readings, 
                'grammar' => $lesson->grammars,
                'quiz' => $lesson->quizzes,
                'sentences' => [] 
            ]
        ]);
    }
}