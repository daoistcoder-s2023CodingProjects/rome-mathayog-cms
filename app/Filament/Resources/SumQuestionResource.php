<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SumQuestionResource\Pages;
use App\Filament\Resources\SumQuestionResource\RelationManagers;
use App\Models\SumQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SumQuestionResource extends Resource
{
    protected static ?string $model = SumQuestion::class;

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'Summative Assesment';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Group::make('summativeAssesment.lesson.courseSkillTitle.course_title')
                    ->label('Course Title')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
                Group::make('summativeAssesment.lesson.lesson_title')
                    ->label('Lesson Title')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
                Group::make('summativeAssesment.exercise_title')
                    ->label('Summative Assesment Title')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
            ])->defaultGroup('summativeAssesment.lesson.courseSkillTitle.course_title')
            ->columns([
                Tables\Columns\TextColumn::make('summativeAssesment.lesson.courseSkillTitle.course_title')
                    ->label('Course Title')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('summativeAssesment.lesson.lesson_title')
                    ->label('Lesson Title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('summativeAssesment.exercise_title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('summativeAssesment.description')
                    ->label('Description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('summative_assesment_question')
                    ->label('Summative Questions')
                    ->searchable(),
                Tables\Columns\TextColumn::make('question_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sumChoices.choice_text')
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
            'index' => Pages\ListSumQuestions::route('/'),
            'create' => Pages\CreateSumQuestion::route('/create'),
            'edit' => Pages\EditSumQuestion::route('/{record}/edit'),
        ];
    }
}
