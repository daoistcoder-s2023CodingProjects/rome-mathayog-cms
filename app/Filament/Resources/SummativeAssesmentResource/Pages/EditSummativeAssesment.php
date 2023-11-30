<?php

namespace App\Filament\Resources\SummativeAssesmentResource\Pages;

use App\Filament\Resources\SummativeAssesmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSummativeAssesment extends EditRecord
{
    protected static string $resource = SummativeAssesmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
