<?php

namespace App\Filament\Resources\Grades\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn; // عشان نظهر علامة صح/غلط
use Filament\Tables\Filters\TernaryFilter; // عشان الفلتر
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class GradesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('اسم الصف')
                    ->sortable()
                    ->searchable(),

                // إضافة عمود الحالة (مفعل/معطل)
                IconColumn::make('is_active')
                    ->label('مُفعل؟')
                    ->boolean() // بيحول القيمة لعلامة صح أو غلط
                    ->sortable(),
            ])
            ->filters([
                // إضافة فلتر لعرض المفعل فقط أو المعطل فقط
                TernaryFilter::make('is_active')
                    ->label('حالة التفعيل')
                    ->placeholder('الكل')
                    ->trueLabel('مُفعل فقط')
                    ->falseLabel('معطل فقط')
                    ->queries(
                        true: fn ($query) => $query->where('is_active', true),
                        false: fn ($query) => $query->where('is_active', false),
                    ),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}