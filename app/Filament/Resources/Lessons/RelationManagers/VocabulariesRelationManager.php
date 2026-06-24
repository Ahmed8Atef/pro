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
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VocabulariesRelationManager extends RelationManager
{
    protected static string $relationship = 'vocabularies';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('word')
                    ->required()
                    ->maxLength(255),
                TextInput::make('meaning')
                    ->required()
                    ->maxLength(255),
                
                // 🟢 تعديل حقل الصورة لإجبار التخزين في المجلد العام
                FileUpload::make('image')
                    ->image()
                    ->disk('public') // <--- هنا السر!
                    ->directory('vocabulary-images'),
                
                // 🟢 تعديل حقل الصوت أيضاً
                FileUpload::make('audio')
                    ->disk('public') // <--- هنا كمان عشان الصوت يشتغل!
                    ->directory('vocabulary-audio'),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('word'),
                TextEntry::make('meaning'),
                ImageEntry::make('image'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('word')
            ->columns([
                TextColumn::make('word')->searchable(),
                TextColumn::make('meaning'),
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
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}