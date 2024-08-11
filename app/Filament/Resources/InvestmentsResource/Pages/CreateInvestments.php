<?php

namespace App\Filament\Resources\InvestmentsResource\Pages;

use App\Filament\Resources\InvestmentsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInvestments extends CreateRecord
{
    protected static string $resource = InvestmentsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
