<?php

namespace App\Filament\Resources\FinanceAssetsResource\Pages;

use App\Filament\Resources\FinanceAssetsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFinanceAssets extends CreateRecord
{
    protected static string $resource = FinanceAssetsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
