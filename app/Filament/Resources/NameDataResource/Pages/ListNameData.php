<?php

namespace App\Filament\Resources\NameDataResource\Pages;

use App\Filament\Resources\NameDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNameData extends ListRecords
{
    protected static string $resource = NameDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
