<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = [
        'title', 
        'unit_id', 
        'has_vocabulary', 
        'has_reading', 
        'has_grammar', 
        'has_conversation',
        
    ];

    // علاقة الدرس بالوحدة
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    // علاقات المحتوى (لسه هنبني الجداول دي، بس الموديل كدة جاهز)
    public function grammars(): HasMany
    {
        return $this->hasMany(Grammar::class);
    }

    public function vocabularies(): HasMany
    {
        return $this->hasMany(Vocabulary::class);
    }

    public function readings(): HasMany
    {
        return $this->hasMany(Reading::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }
    
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
}