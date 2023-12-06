<?php

namespace App\Filament\Resources\SummativeAssesmentResource\Pages;

use App\Filament\Resources\SummativeAssesmentResource;
use Filament\Actions;
use Filament\Support\Enums\IconPosition;
use Filament\Resources\Pages\EditRecord;

class EditSummativeAssesment extends EditRecord
{
    protected static string $resource = SummativeAssesmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('returnBtn')
            ->label('Return to Lesson Content')
            ->url(fn ($record): string => $record ? url()->previous() : '#')
            ->color('success')
            ->icon('heroicon-m-arrow-uturn-left')
            ->iconPosition(IconPosition::After)
        ];
    }
}
