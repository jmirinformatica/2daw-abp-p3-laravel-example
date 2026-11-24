<?php

namespace App\Filament\Resources\Comments\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('comment')
                    ->required()
                    ->columnSpanFull(),
                // Admin
                Select::make('author_id')
                    ->required()
                    ->relationship('author', 'name')
                    ->hidden(! auth()->user()->isAdmin())
                    ->default(auth()->user()->id),
                // NOT admin
                Hidden::make('author_id')
                    ->required()
                    ->hidden(auth()->user()->isAdmin())
                    ->default(auth()->user()->id),
                Select::make('post_id')
                    ->relationship('post', 'title')
                    ->required(),
            ]);
    }
}
