<?php

namespace App\Filament\Resources\RegencyDataResource\Pages;

use App\Filament\Resources\RegencyDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegencyData extends ListRecords
{
    protected static string $resource = RegencyDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
