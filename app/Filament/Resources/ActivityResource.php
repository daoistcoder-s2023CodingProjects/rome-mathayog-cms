<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Filament\Resources\ActivityResource\RelationManagers;
use App\Models\Activity;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
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

class ActivityResource extends Resource
{
    // variable for place holders and select options
    const IMAGE_PLACEHOLDER = 'image url';

    protected static ?string $model = Activity::class;

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Contents';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('lesson_id')
                    ->relationship('lesson', 'lesson_id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->courseSkillTitle->course_title} => {$record->lesson_title} =>")
                    ->columnSpan(1),
                Forms\Components\TextInput::make('activity_title')
                    ->maxLength(255)
                    ->columnSpan(1),
                Forms\Components\Select::make('solo_framework')
                    ->options([
                        'Pre-Stractural' => 'Pre-Stractural',
                        'Uni-Stractural' => 'Uni-Stractural',
                        'Multi-Stractural' => 'Multi-Stractural',
                        'Relational' => 'Relational',
                        'Extended-Abstract' => 'Extended-Abstract',
                    ])
                    ->columnSpan(1),
                Forms\Components\Textarea::make('objective')
                    ->rows(3)
                    ->columnSpan(3),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('lesson.lesson_title')
                // ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('id', $direction))
                ->getTitleFromRecordUsing(fn (Activity $record): string => 'Course Title: ' . $record->lesson->courseSkillTitle->course_title)
                ->getDescriptionFromRecordUsing(fn (Activity $record): string => 'Lesson Title: ' . $record->lesson->lesson_title)
                ->collapsible()
                ->titlePrefixedWithLabel(false),
            ])->defaultGroup('lesson.lesson_title')
            ->columns([
                Stack::make([
                    Tables\Columns\TextColumn::make('activity_title')
                        ->description(fn (Activity $record): ?string => 'Objective: ' . $record->objective ?? 'Objective-skill: Add Obective')
                        ->weight(FontWeight::Bold)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('solo_framework')
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
            RelationManagers\ActQuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
