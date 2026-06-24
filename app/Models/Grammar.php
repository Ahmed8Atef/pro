<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grammar extends Model
{
    protected $fillable = [
        'lesson_id',
        'title',
        'explanation',
        'examples', 
        
    ];

    // ده الجزء الأهم عشان لارافيل يحول الـ JSON لأراي (Array) أوتوماتيك
    protected $casts = [
        'examples' => 'array',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}