<?php

namespace App\Filament\Resources\InvestmentsResource\Pages;

use App\Filament\Resources\InvestmentsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvestments extends ListRecords
{
    protected static string $resource = InvestmentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
