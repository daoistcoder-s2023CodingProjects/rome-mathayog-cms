<?php

namespace App\Filament\Resources\ImageResource\Pages;

use App\Filament\Resources\ImageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Livewire\Attributes\On;

class ListImages extends ListRecords
{
    protected static string $resource = ImageResource::class;


    // This is a livewire Attribute that will refresh the page when the event is dispatched
    #[On('image-created')]
    public function refresh() {}

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ImageResource\Widgets\CreateImageWidget::class,
        ];
    }
}
