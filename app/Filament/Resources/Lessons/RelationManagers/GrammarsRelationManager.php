<?php

namespace App\Filament\Resources\Lessons\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload; // استدعاء المكون الجديد
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup; // التعديل الصحيح للمسار

class GrammarsRelationManager extends RelationManager
{
    protected static string $relationship = 'grammars';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('عنوان القاعدة')
                    ->required()
                    ->maxLength(255),

                RichEditor::make('explanation')
                    ->label('شرح القاعدة')
                    ->columnSpanFull()
                    ->required(),

                Repeater::make('examples')
                    ->label('الأمثلة (الجملة والترجمة والنطق)')
                    ->schema([
                        TextInput::make('sentence')->label('الجملة (English)')->required(),
                        TextInput::make('translation')->label('الترجمة (عربي)')->required(),
                        
                        // هنا التعديل: استخدام FileUpload بدلاً من TextInput للنطق
                        FileUpload::make('audio_file')
                            ->label('ملف النطق (Audio)')
                            ->disk('public') // تأكد أن لديك الرابط: php artisan storage:link
                            ->directory('grammar-audio')
                            ->acceptedFileTypes(['audio/mpeg', 'audio/wav', 'audio/ogg']),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')->label('عنوان القاعدة')->searchable(),
                TextColumn::make('order')->label('الترتيب'),
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