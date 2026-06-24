<?php

namespace App\Filament\Resources\Lessons\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // أولاً: اختيار الوحدة (بكل تفاصيلها)
                Select::make('unit_id')
                    ->label('المرحلة | الترم | الوحدة')
                    ->relationship('unit', 'name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => 
                        ($record->term?->grade?->name ?? 'بدون مرحلة') . 
                        ' | ' . ($record->term?->name ?? 'بدون ترم') . 
                        ' | ' . $record->name
                    )
                    ->required()
                    ->searchable()
                    ->preload(),

                // ثانياً: كتابة اسم الدرس بعد اختيار الوحدة
                TextInput::make('title')
                    ->label('عنوان الدرس')
                    ->placeholder('مثال: الدرس الأول:نطق الاعداد')
                    ->required(),
                
                // ثالثاً: تفعيل الأجزاء
                Toggle::make('has_vocabulary')->label('يحتوي على مفردات'),
                Toggle::make('has_reading')->label('يحتوي على قراءة'),
                Toggle::make('has_grammar')->label('يحتوي على قواعد'),
                Toggle::make('has_conversation')->label('يحتوي على محادثة'),
            ]);
    }
}