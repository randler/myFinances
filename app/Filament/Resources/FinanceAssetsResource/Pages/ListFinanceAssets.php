<?php

namespace App\Filament\Resources\FinanceAssetsResource\Pages;

use App\Filament\Resources\FinanceAssetsResource;
use Filament\Actions;
use Filament\Forms\Components\Builder;
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }


}
