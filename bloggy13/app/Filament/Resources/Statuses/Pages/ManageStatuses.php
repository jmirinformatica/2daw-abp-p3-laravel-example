<?php

namespace App\Filament\Resources\Statuses\Pages;

use App\Filament\Resources\Statuses\StatusResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

use LaraZeus\SpatieTranslatable\Resources\Pages\ManageRecords\Concerns\Translatable;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;

class ManageStatuses extends ManageRecords
{
    use Translatable;
    
    protected static string $resource = StatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
            CreateAction::make(),
        ];
    }
}
