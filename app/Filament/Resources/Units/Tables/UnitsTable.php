<?php

namespace App\Filament\Resources\Units\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class UnitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // اسم الوحدة
                TextColumn::make('name')
                    ->label('اسم الوحدة')
                    ->searchable()
                    ->sortable(),

                // اسم الترم (التابع له الوحدة)
                TextColumn::make('term.name')
                    ->label('الترم الدراسي')
                    ->searchable()
                    ->sortable(),

                // اسم الصف (عن طريق الترم)
                TextColumn::make('term.grade.name')
                    ->label('الصف الدراسي')
                    ->searchable()
                    ->sortable(),

                // حالة التفعيل
                IconColumn::make('is_active')
                    ->label('مُفعلة')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                // فلتر سريع لاختيار الوحدات حسب الترم
                SelectFilter::make('term')
                    ->relationship('term', 'name')
                    ->label('الفلترة بالترم'),
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