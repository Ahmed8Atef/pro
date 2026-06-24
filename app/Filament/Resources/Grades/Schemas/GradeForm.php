<?php

namespace App\Filament\Resources\Grades\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class GradeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            // حقل الاسم مع المثال
            Forms\Components\TextInput::make('name')
                ->required()
                ->unique(table: 'grades', column: 'name')
                ->label('اسم الصف الدراسي')
                ->placeholder('مثال: الصف الأول الإبتدائى') // ده المثال اللي بيظهر باهت جوه الخانة
                ->maxLength(255), // نصيحة: حدد طول أقصى للاسم

            // حقل التفعيل (Active)
            Forms\Components\Toggle::make('is_active')
                ->label('حالة التفعيل')
                ->default(true) // عشان يكون مفعل تلقائياً عند الإنشاء
                ->helperText('إذا تم إلغاء التفعيل، الصف لن يظهر للطلاب.'),
        ]);
    }
}