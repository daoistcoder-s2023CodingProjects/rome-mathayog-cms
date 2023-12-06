<?php

namespace App\Filament\Resources\ExerciseResource\Pages;

use App\Filament\Resources\ExerciseResource;
use Filament\Actions;
use Filament\Support\Enums\IconPosition;
use Filament\Resources\Pages\EditRecord;

class EditExercise extends EditRecord
{
    protected static string $resource = ExerciseResource::class;

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
