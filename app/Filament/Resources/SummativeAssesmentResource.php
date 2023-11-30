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
use Filament\Tables\Grouping\Group;
use Filament\Tables\Columns\Layout\Stack;

use Filament\Support\Enums\FontWeight;

use Illuminate\Database\Eloquent\Model;
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
                Forms\Components\Select::make('lesson_id')
                    ->relationship('lesson', 'lesson_id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->courseSkillTitle->course_title} => {$record->lesson_title} =>")
                    ->columnSpan(3),
                Forms\Components\TextInput::make('summative_assesment_title')
                    ->maxLength(255)
                    ->columnSpan(2),
                Forms\Components\TextInput::make('level_id')
                    ->default('2')
                    ->maxLength(255)
                    ->columnSpan(1),
                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->columnSpan(6),
            ])
            ->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('lesson.lesson_title')
                    ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('id', $direction))
                    ->getTitleFromRecordUsing(fn (SummativeAssesment $record): string => 'Course Title: ' . $record->lesson->courseSkillTitle->course_title)
                    ->getDescriptionFromRecordUsing(fn (SummativeAssesment $record): string => 'Lesson Title: ' . $record->lesson->lesson_title)
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
            ])->defaultGroup('lesson.lesson_title')
            ->columns([
                Stack::make([
                    Tables\Columns\TextColumn::make('summative_assesment_title')
                        ->description(fn (SummativeAssesment $record): ?string => 'Description: ' . $record->description ?? 'Description: Add Description')
                        ->weight(FontWeight::Bold)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('level_id')
                        ->formatStateUsing(fn (string $state): string => __("level {$state}"))
                        ->badge()
                        ->searchable(),
                ]),
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
            RelationManagers\SumQuestionsRelationManager::class,
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
