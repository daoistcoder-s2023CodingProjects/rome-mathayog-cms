<?php

namespace App\Filament\Resources\ActQuestionResource\Pages;

use App\Filament\Resources\ActQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditActQuestion extends EditRecord
{
    protected static string $resource = ActQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->requiresConfirmation()
            ->modalHeading('Delete Activity')
            ->modalDescription('Are you sure you\'d like to delete this Activity? This cannot be undone.')
            ->modalSubmitActionLabel('Yes, delete it'),
        ];
    }
}
