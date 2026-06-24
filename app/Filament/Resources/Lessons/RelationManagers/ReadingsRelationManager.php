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
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Toggle;

class ReadingsRelationManager extends RelationManager
{
    protected static string $relationship = 'readings';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required(),
            
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                
                // 🟢 إضافة disk('public') للصورة الرئيسية للقراءة
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('reading-images'),

                Repeater::make('terms')
                    ->relationship('terms')
                    ->schema([
                        TextInput::make('term')->required(),
                        TextInput::make('meaning')->required(),
                        // 🟢 إضافة disk('public') للصوت الخاص بكل كلمة
                        FileUpload::make('audio')
                            ->disk('public')
                            ->directory('reading-audio')
                            ->nullable(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('content')->columnSpanFull(),
                ImageEntry::make('image'),
                RepeatableEntry::make('terms')
                    ->schema([
                        TextEntry::make('term'),
                        TextEntry::make('meaning'),
                        TextEntry::make('audio'),
                    ])
                    ->columns(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')->searchable(),
                ImageColumn::make('image'),
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
            ->bulkActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}