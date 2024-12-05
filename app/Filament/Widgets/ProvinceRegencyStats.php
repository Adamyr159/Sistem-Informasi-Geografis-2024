<?php

namespace App\Filament\Widgets;

use App\Models\Province;
use App\Models\Regency;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ProvinceRegencyStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Provinsi', Province::count()),
            Stat::make('Total Kabupaten/Kota', Regency::count()),
            Stat::make('Total Kabupaten/Kota', Regency::count()),
        ];
    }
}
