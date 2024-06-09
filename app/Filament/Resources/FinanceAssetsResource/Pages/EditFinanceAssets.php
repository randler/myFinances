<?php

namespace App\Filament\Resources\FinanceAssetsResource\Pages;

use App\Filament\Resources\FinanceAssetsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinanceAssets extends EditRecord
{
    protected static string $resource = FinanceAssetsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
