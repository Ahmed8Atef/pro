<?php

namespace App\Filament\Resources\Terms\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class TermsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // اسم الترم
                TextColumn::make('name')
                    ->label('اسم الترم')
                    ->searchable()
                    ->sortable(),

                // اسم الصف (استخدام العلاقة)
                TextColumn::make('grade.name')
                    ->label('الصف الدراسي')
                    ->searchable()
                    ->sortable(),

                // حالة التفعيل
                IconColumn::make('is_active')
                    ->label('مُفعل')
                    ->boolean(),
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