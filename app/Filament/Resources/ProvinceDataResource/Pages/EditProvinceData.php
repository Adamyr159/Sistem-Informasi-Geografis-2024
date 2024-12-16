<?php

namespace App\Filament\Resources\ProvinceDataResource\Pages;

use App\Filament\Resources\ProvinceDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProvinceData extends EditRecord
{
    protected static string $resource = ProvinceDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
