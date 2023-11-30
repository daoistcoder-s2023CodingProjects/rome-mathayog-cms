<?php

namespace App\Filament\Resources\SummativeAssesmentResource\Pages;

use App\Filament\Resources\SummativeAssesmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSummativeAssesments extends ListRecords
{
    protected static string $resource = SummativeAssesmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
