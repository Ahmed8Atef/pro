<?php

namespace App\Models;

// استيراد الواجهات الضرورية لـ Filament
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * الحقول المسموح بتعديلها
     */
    protected $fillable = [
        'name',
        'phone',
        'identity',
        'email',
        'password',
        'role',
        'grade_id', // أضفنا grade_id للربط بالصف
    ];

    /**
     * الحقول المخفية عند التحويل لـ JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * إعدادات تحويل أنواع البيانات (Cast)
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * حماية لوحة تحكم Filament: لا يدخل إلا الأدمن
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // يسمح فقط للمستخدمين اللي الـ role بتاعهم 'admin' بالدخول للوحة التحكم
        return $this->role === 'admin';
    }

    /**
     * العلاقة مع الصف الدراسي
     */
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
}