<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                RichEditor::make('body')
                    ->required(),
                // Admin
                Select::make('author_id')
                    ->required()
                    ->hidden(! auth()->user()->isAdmin())
                    ->default(auth()->user()->id)
                    ->label('Author')
                    ->relationship(name: 'author', titleAttribute: 'name'),
                // NOT admin
                Hidden::make('author_id')
                    ->required()
                    ->hidden(auth()->user()->isAdmin())
                    ->default(auth()->user()->id),
            ])->columns(1);
    }
}
