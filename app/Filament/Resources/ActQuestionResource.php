<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActQuestionResource\Pages;
use App\Filament\Resources\ActQuestionResource\RelationManagers;
use App\Models\ActQuestion;
use App\Models\Lesson;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActQuestionResource extends Resource
{
    protected static ?string $model = ActQuestion::class;

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Activities';

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
                Group::make('activity.lesson.courseSkillTitle.course_title')
                    ->label('Course Title')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
                Group::make('activity.lesson.lesson_title')
                    ->label('Lesson Title')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
                Group::make('activity.activity_title')
                    ->label('Activity Title')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
            ])->defaultGroup('activity.lesson.courseSkillTitle.course_title')
            ->columns([
                Tables\Columns\TextColumn::make('activity.lesson.courseSkillTitle.course_title')
                    ->label('Course Title')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('activity.lesson.lesson_title')
                    ->label('Lesson Title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('activity.activity_title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('activity.solo_framework')
                    ->label('Solo Framework')
                    ->searchable(),
                Tables\Columns\TextColumn::make('activity_question')
                    ->searchable(),
                Tables\Columns\TextColumn::make('question_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('learning_tools')
                    ->searchable(),
                Tables\Columns\TextColumn::make('actChoices.choice_text')
                    ->label('Choices')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('actChoices.actFeedback.activity_feedback')
                    ->label('Feedbacks')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('actHints.first_hint')
                    ->label('Hint')
                    ->searchable(),
                Tables\Columns\TextColumn::make('actHints.technical_hint')
                    ->label('Technical Hint')
                    ->searchable(),
                Tables\Columns\TextColumn::make('actHints.growth_mindset_hint')
                    ->label('Growth mindset Hint')
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
            'index' => Pages\ListActQuestions::route('/'),
            'create' => Pages\CreateActQuestion::route('/create'),
            'edit' => Pages\EditActQuestion::route('/{record}/edit'),
        ];
    }
}
