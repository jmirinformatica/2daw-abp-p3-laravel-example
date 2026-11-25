<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('labels.section.account'))
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email'),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),                        
                    ])->columns(2),
                Section::make(__('labels.section.avatar'))
                    ->schema([
                        ImageEntry::make('avatar')
                            ->label(__("labels.avatar_img"))
                            ->disk('public')
                            ->circular()
                            ->size(120),
                        TextEntry::make('avatar')
                            ->label(__("labels.avatar_url"))
                            ->copyable(),
                    ])->columns(2),
                Section::make(__('labels.section.security'))
                    ->schema([
                        TextEntry::make('email_verified_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('two_factor_secret')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('two_factor_recovery_codes')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('two_factor_confirmed_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])->columns(2),
            ]);
    }
}
