<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReadingTerm extends Model
{
    protected $fillable = ['reading_id', 'term', 'meaning', 'audio'];

    public function reading(): BelongsTo
    {
        return $this->belongsTo(Reading::class);
    }
}