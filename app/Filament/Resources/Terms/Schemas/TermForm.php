<?php

namespace App\Filament\Resources\Terms\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class TermForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // اختيار الصف الدراسي
                Forms\Components\Select::make('grade_id')
                    ->label('الصف الدراسي')
                    ->relationship('grade', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                // اختيار الترم من قائمة محددة
                Forms\Components\Select::make('name')
                    ->label('اسم الترم')
                    ->options([
                        'الترم الأول' => 'الترم الأول',
                        'الترم الثاني' => 'الترم الثاني',
                    ])
                    ->required(),

                // التفعيل
                Forms\Components\Toggle::make('is_active')
                    ->label('مُفعل')
                    ->default(true),
            ]);
    }
}