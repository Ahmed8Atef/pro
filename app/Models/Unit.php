<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    protected $fillable = [
        'name', 
        'term_id', 
        'is_active'
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    // الخطوة الجريئة: بنربط الـ Unit بالـ Term والـ Grade أوتوماتيك
    // عشان لما ننده على اسم الوحدة، البيانات تكون جاهزة في الذاكرة
    protected $with = ['term']; 

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

}