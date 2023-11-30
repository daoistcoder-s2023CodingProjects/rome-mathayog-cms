<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExerciseResource\Pages;
use App\Filament\Resources\ExerciseResource\RelationManagers;
use App\Models\Exercise;

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

class ExerciseResource extends Resource
{
    protected static ?string $model = Exercise::class;

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationGroup = 'Contents';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('lesson_id')
                    ->relationship('lesson', 'lesson_id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->courseSkillTitle->course_title} => {$record->lesson_title} =>")
                    ->columnSpan(1),
                Forms\Components\TextInput::make('exercise_title')
                    ->maxLength(255)
                    ->columnSpan(1),
                Forms\Components\Textarea::make('objective')
                    ->rows(3)
                    ->columnSpan(2),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('lesson.lesson_title')
                    ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('id', $direction))
                    ->getTitleFromRecordUsing(fn (Exercise $record): string => 'Course Title: ' . $record->lesson->courseSkillTitle->course_title)
                    ->getDescriptionFromRecordUsing(fn (Exercise $record): string => 'Lesson Title: ' . $record->lesson->lesson_title)
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
            ])->defaultGroup('lesson.lesson_title')
            ->columns([
                Stack::make([
                    Tables\Columns\TextColumn::make('exercise_title')
                        ->description(fn (Exercise $record): ?string => 'Objective: ' . $record->objective ?? 'Objective-skill: Add Obective')
                        ->weight(FontWeight::Bold)
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExercises::route('/'),
            'create' => Pages\CreateExercise::route('/create'),
            'edit' => Pages\EditExercise::route('/{record}/edit'),
        ];
    }
}
