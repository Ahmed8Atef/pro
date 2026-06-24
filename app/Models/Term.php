<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Term extends Model
{
    protected $fillable = [
        'name',
        'grade_id',
        'is_active',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    // إضافة الخاصية دي عشان لما ننده على الترم، يجيب بيانات الصف معاه أوتوماتيك
    protected $with = ['grade'];

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}