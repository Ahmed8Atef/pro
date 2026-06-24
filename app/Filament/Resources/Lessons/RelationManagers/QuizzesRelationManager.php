<?php

namespace App\Filament\Resources\Lessons\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;

class QuizzesRelationManager extends RelationManager
{
    protected static string $relationship = 'quizzes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required(),
                
                Repeater::make('questions_data')
                    ->schema([
                Select::make('type')
                    ->options([
                        'multiple_choice' => 'اختيار من متعدد',
                        'fill_missing'    => 'إكمال الكلمة (C...T)',
                    ])
                    ->default('multiple_choice')
                    ->reactive()
                    ->required(),

                TextInput::make('question_text')->required(),

                Repeater::make('options')
            // تعديل هنا: بدلاً من تحديد نوع الـ Get كـ argument، نستخدمه داخل الـ Closure
                    ->visible(fn ($get) => $get('type') === 'multiple_choice') 
                    ->schema([
                        TextInput::make('text')->required(),
                         Toggle::make('is_correct'),
                    ])
                    ->columns(2),

                TextInput::make('correct_answer')
            // تعديل هنا: نفس الشيء
                    ->visible(fn ($get) => $get('type') === 'fill_missing')
                    ->label('الإجابة الصحيحة'),
            ])
            ->columnSpanFull(),
        ]);
    }
    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
