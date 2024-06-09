<?php

namespace App\Filament\Resources\FinanceAssetsResource\Pages;

use App\Filament\Resources\FinanceAssetsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinanceAssets extends ListRecords
{
    protected static string $resource = FinanceAssetsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
