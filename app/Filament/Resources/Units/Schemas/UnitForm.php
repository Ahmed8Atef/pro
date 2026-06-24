<?php

namespace App\Filament\Resources\Units\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;
use App\Models\Term; // استدعاء الموديل

class UnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // اختيار الترم الدراسي مع اسم الصف
                Forms\Components\Select::make('term_id')
                    ->label('الترم الدراسي (الصف - الترم)')
                    ->relationship('term', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Term $record) => "{$record->grade->name} - {$record->name}")
                    ->required()
                    ->searchable()
                    ->preload(),

                // اسم الوحدة
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('اسم الوحدة')
                    ->placeholder('مثال: الوحدة الأولى: الأعداد')
                    ->maxLength(255),

                // التفعيل
                Forms\Components\Toggle::make('is_active')
                    ->label('مُفعلة')
                    ->default(true),
            ]);
    }
}