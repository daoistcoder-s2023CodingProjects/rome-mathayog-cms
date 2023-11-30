<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SummativeAssesmentResource\Pages;
use App\Filament\Resources\SummativeAssesmentResource\RelationManagers;
use App\Models\SummativeAssesment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SummativeAssesmentResource extends Resource
{
    protected static ?string $model = SummativeAssesment::class;

    protected static ?int $navigationSort = 8;

    protected static ?string $navigationGroup = 'Contents';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListSummativeAssesments::route('/'),
            'create' => Pages\CreateSummativeAssesment::route('/create'),
            'edit' => Pages\EditSummativeAssesment::route('/{record}/edit'),
        ];
    }    
}
