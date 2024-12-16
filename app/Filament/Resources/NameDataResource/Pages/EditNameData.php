<?php

namespace App\Filament\Resources\NameDataResource\Pages;

use App\Filament\Resources\NameDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNameData extends EditRecord
{
    protected static string $resource = NameDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
