<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageResource\Pages;
use App\Filament\Resources\ImageResource\RelationManagers;

use App\Models\Image;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;

use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageResource extends Resource
{
    protected static ?string $model = Image::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Image Link Generator';

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function getWidgets(): array
    {
        return [
            ImageResource\Widgets\CreateImageWidget::class,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('preview_url')
                    ->label('Image url')
                    ->placeholder('bulk_upload_images/')
                    ->disabled()
                    ->columnSpan(2),
                FileUpload::make('image_url')
                    ->label('Image Upload')
                    ->image()
                    ->preserveFilenames()
                    ->imagePreviewHeight('250')
                    ->imageEditor()
                    ->disk('s3')
                    ->directory('images')
                    ->visibility('public')
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('preview_url')
                    ->label('Preview')
                    ->width('100px')
                    ->height('auto')
                    ->disk('s3'),
                Tables\Columns\TextColumn::make('image_url')
                    ->label('Image URL')
                    ->size(TextColumnSize::Medium)
                    ->weight(FontWeight::Bold)
                    ->icon('heroicon-m-folder')
                    ->copyable(true)
                    ->copyMessage('Image URL copied')
                    ->copyMessageDuration(1500),
                Tables\Columns\TextColumn::make('uploader')
                    ->numeric()
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->since()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListImages::route('/'),
        ];
    }
}
