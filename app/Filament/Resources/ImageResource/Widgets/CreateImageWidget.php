<?php

namespace App\Filament\Resources\ImageResource\Widgets;

use App\Models\Image;
use Filament\Widgets\Widget;

use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;


use Filament\Forms\Set;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CreateImageWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.resources.image-resource.widgets.create-image-widget';

    protected int | string | array $columnSpan = 'full';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('preview_url')
                    ->label('Image url')
                    ->placeholder('images/sample.jpg')
                    ->disabled()
                    ->columnSpan(2),
                FileUpload::make('image_url')
                    ->live()
                    ->afterStateUpdated(function (Set $set, ?UploadedFile $state) {
                        if ($state !== null) {
                            $fileName = $state->getClientOriginalName();
                            $filePath = 'images/' . $fileName;
                            $set('preview_url', $filePath);
                        }
                    })
                    ->label('Image Upload')
                    ->image()
                    ->preserveFilenames()
                    ->imagePreviewHeight('250')
                    ->imageEditor()
                    ->disk('s3')
                    ->directory('images')
                    ->visibility('public')
                    ->columnSpan(2)
                    ->required(),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        Image::create($this->form->getState());
        $this->form->fill();
        $this->dispatch('image-created');
    }
}
