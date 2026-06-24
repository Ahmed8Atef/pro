<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    // أضفنا 'is_active' هنا عشان الموديل يسمح بتعديله
    protected $fillable = ['name', 'is_active']; 

    // عشان يخلي القيمة الافتراضية true دايماً في الكود
    protected $attributes = [
        'is_active' => true,
    ];

    public function units() 
    {
        return $this->hasMany(Unit::class);
    }
}