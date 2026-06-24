<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    // أضفنا questions_data للقائمة المسموح بحفظها
    protected $fillable = ['title', 'lesson_id', 'questions_data'];

    // هذا هو السحر! لارافيل سيحول الـ JSON لمصفوفة أوتوماتيكياً
    protected $casts = [
        'questions_data' => 'array',
    ];

    // الاختبار يتبع درساً واحداً
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}