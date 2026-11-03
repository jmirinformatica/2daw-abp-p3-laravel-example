<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function getNavigationGroup(): string
    {
        return __('Content');
    }
    
    public static function getNavigationLabel(): string
    {
        return __('navigation.comments');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('comment')
                    ->required()
                    ->rows(6),
                Forms\Components\Select::make('post_id')
                    ->required()
                    ->label('Post')
                    ->relationship(name: 'post', titleAttribute: 'title')
                    ->searchable(),
                // Admin
                Forms\Components\Select::make('author_id')
                    ->required()
                    ->hidden(! auth()->user()->isAdmin())
                    ->default(auth()->user()->id)
                    ->label('Author')
                    ->relationship(name: 'author', titleAttribute: 'name'),
                // NOT admin
                Forms\Components\Hidden::make('author_id')
                    ->required()
                    ->hidden(auth()->user()->isAdmin())
                    ->default(auth()->user()->id),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();
        
        // L'administrador pot veure-ho tot
        // La resta només el seu propi contingut
        return $user->isAdmin() ? $query : $query->where('author_id', $user->id);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('comment')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('post.title')
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->sortable()
                    ->hidden(! auth()->user()->isAdmin()),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageComments::route('/'),
        ];
    }
}
