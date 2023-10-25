<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExeQuestionResource\Pages;
use App\Filament\Resources\ExeQuestionResource\RelationManagers;
use App\Models\ExeQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExeQuestionResource extends Resource
{
    protected static ?string $model = ExeQuestion::class;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Contents';

    protected static ?string $navigationLabel = 'Exercises';

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
        ->groups([
            Group::make('exercise.lesson.courseSkillTitle.course_title')
                ->label('Course Title')
                ->collapsible()
                ->titlePrefixedWithLabel(false),
            Group::make('exercise.lesson.lesson_title')
                ->label('Lesson Title')
                ->collapsible()
                ->titlePrefixedWithLabel(false),
            Group::make('exercise.exercise_title')
                ->label('Exercise Title')
                ->collapsible()
                ->titlePrefixedWithLabel(false),
        ])->defaultGroup('exercise.lesson.courseSkillTitle.course_title')
        ->columns([
            Tables\Columns\TextColumn::make('exercise.lesson.courseSkillTitle.course_title')
                ->label('Course Title')
                ->numeric()
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable(),
            Tables\Columns\TextColumn::make('exercise.lesson.lesson_title')
                ->label('Lesson Title')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('exercise.exercise_title')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('exercise.objective')
                ->label('Objective')
                ->searchable(),
            Tables\Columns\TextColumn::make('exercise_question')
                ->searchable(),
            Tables\Columns\TextColumn::make('question_type')
                ->searchable(),
            Tables\Columns\TextColumn::make('learning_tools')
                ->searchable(),
            Tables\Columns\TextColumn::make('exeChoices.choice_text')
                ->label('Choices')
                ->searchable(),
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListExeQuestions::route('/'),
            'create' => Pages\CreateExeQuestion::route('/create'),
            'edit' => Pages\EditExeQuestion::route('/{record}/edit'),
        ];
    }    
}
