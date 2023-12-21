<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use App\Filament\Resources\LessonResource\Pages;
use App\Filament\Resources\LessonResource\Pages\ListLessons;
use App\Filament\Resources\LessonResource\RelationManagers;

use App\Models\Activity;
use App\Models\CourseSkillTitle;
use App\Models\Lesson;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;


use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\Alignment;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Grouping\Group;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Illuminate\Contracts\Support\Htmlable;

class LessonResource extends Resource
{
    // variable for place holders and select options
    const IMAGE_PLACEHOLDER = 'image url';

    protected static ?string $model = Lesson::class;

    protected static ?int $navigationSort = 2;

    protected static bool $shouldRegisterNavigation = false;

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record->lesson_title;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('lesson_title')
                                    ->placeholder('add lesson title')
                                    ->maxLength(255),

                            ])->columnSpan('full'),

                        Section::make()
                            ->schema([
                                Forms\Components\Placeholder::make('Lesson Content'),

                                Forms\Components\Repeater::make('videos')
                                    ->label('')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\TextInput::make('video_title')
                                            ->placeholder('add video title')
                                            ->maxLength(255)
                                            ->columnSpan(1),
                                        Forms\Components\TextInput::make('video_description')
                                            ->placeholder('add video description')
                                            ->maxLength(255)
                                            ->columnSpan(2),
                                        Forms\Components\FileUpload::make('video_url')
                                            ->label('Video')
                                            ->disk('s3')
                                            ->directory('videos')
                                            ->maxSize(20000)
                                            ->visibility('public')
                                            ->columnSpan(3),
                                    ])
                                    ->columns(3)
                                    ->deleteAction(
                                        fn (Action $action) => $action->label('Delete Video')
                                            ->requiresConfirmation()
                                            ->modalDescription('Are you sure you\'d like to delete this Video? This cannot be undone.')
                                            ->modalSubmitActionLabel('Yes, delete it')
                                    )
                                    ->addAction(
                                        fn (Action $action) => $action->label('Add Video')
                                    )
                                    ->collapseAllAction(
                                        fn (Action $action) => $action->label('')
                                    )
                                    ->expandAllAction(
                                        fn (Action $action) => $action->label('')
                                    )
                                    ->collapsed()
                                    ->itemLabel(fn (array $state): ?string => $state['video_title'] ?? null)
                                    ->defaultItems(0),

                                Forms\Components\Repeater::make('activities')
                                    ->label('')
                                    ->relationship()
                                    ->schema([
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
                                        Forms\Components\TextInput::make('objective')
                                            ->maxLength(255)
                                            ->columnSpan(2),

                                        Actions::make([
                                            Action::make('addNewActivityQuestion')
                                                ->label('Add New Activity Question')
                                                ->url(fn ($record): string => $record ? ActivityResource::getUrl('edit', ['record' => $record->id]) : '#')
                                                ->color('success')
                                                ->icon('heroicon-m-plus')

                                        ])->columnSpan(2)->alignment(Alignment::Center)

                                    ])
                                    ->columns(2)
                                    ->deleteAction(
                                        fn (Action $action) => $action->label('Delete Activity')
                                            ->requiresConfirmation()
                                            ->modalDescription('Are you sure you\'d like to delete this Activity? This cannot be undone.')
                                            ->modalSubmitActionLabel('Yes, delete it')
                                    )
                                    ->addAction(
                                        fn (Action $action) => $action->label('Add Activity')
                                    )
                                    ->collapseAllAction(
                                        fn (Action $action) => $action->label('')
                                    )
                                    ->expandAllAction(
                                        fn (Action $action) => $action->label('')
                                    )
                                    ->collapsed()
                                    ->itemLabel(fn (array $state): ?string => $state['activity_title'] ?? null)
                                    ->defaultItems(0),

                                Forms\Components\Repeater::make('exercises')
                                    ->label('')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\TextInput::make('exercise_title')
                                            ->maxLength(255)
                                            ->columnSpan(1),
                                        Forms\Components\TextInput::make('objective')
                                            ->maxLength(255)
                                            ->columnSpan(2),

                                        Actions::make([
                                            Action::make('addNewExerciseQuestion')
                                                ->label('Add New Exercise Question')
                                                ->url(fn ($record): string => $record ? ExerciseResource::getUrl('edit', ['record' => $record->id]) : '#')
                                                ->color('success')
                                                ->icon('heroicon-m-plus')

                                        ])->columnSpan(3)->alignment(Alignment::Center)
                                    ])
                                    ->columns(3)
                                    ->deleteAction(
                                        fn (Action $action) => $action->label('Delete Exercise')
                                            ->requiresConfirmation()
                                            ->modalDescription('Are you sure you\'d like to delete this Exercise? This cannot be undone.')
                                            ->modalSubmitActionLabel('Yes, delete it')
                                    )
                                    ->addAction(
                                        fn (Action $action) => $action->label('Add Exercise')
                                    )
                                    ->collapseAllAction(
                                        fn (Action $action) => $action->label('')
                                    )
                                    ->expandAllAction(
                                        fn (Action $action) => $action->label('')
                                    )
                                    ->collapsed()
                                    ->itemLabel(fn (array $state): ?string => $state['exercise_title'] ?? null)
                                    ->defaultItems(0),

                                Forms\Components\Repeater::make('summativeAssesments')
                                    ->label('')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\TextInput::make('summative_assesment_title')
                                            ->maxLength(255)
                                            ->columnSpan(2),
                                        Forms\Components\TextInput::make('level_id')
                                            ->default('2')
                                            ->maxLength(255)
                                            ->columnSpan(1),
                                        Forms\Components\TextInput::make('description')
                                            ->maxLength(255)
                                            ->columnSpan(3),

                                        Actions::make([
                                            Action::make('addNewSummativeQuestion')
                                                ->label('Add New Summative Question')
                                                ->url(fn ($record): string => $record ? SummativeAssesmentResource::getUrl('edit', ['record' => $record->id]) : '#')
                                                ->color('success')
                                                ->icon('heroicon-m-plus')

                                        ])->columnSpan(3)->alignment(Alignment::Center)

                                    ])
                                    ->columns(3)
                                    ->deleteAction(
                                        fn (Action $action) => $action->label('Delete Summative Assesment')
                                            ->requiresConfirmation()
                                            ->modalDescription('Are you sure you\'d like to delete this Summative Assesment? This cannot be undone.')
                                            ->modalSubmitActionLabel('Yes, delete it')
                                    )
                                    ->addAction(
                                        fn (Action $action) => $action->label('Add Summative Assesment')
                                    )
                                    ->collapseAllAction(
                                        fn (Action $action) => $action->label('')
                                    )
                                    ->expandAllAction(
                                        fn (Action $action) => $action->label('')
                                    )
                                    ->collapsed()
                                    ->itemLabel(fn (array $state): ?string => $state['summative_assesment_title'] ?? null)
                                    ->defaultItems(0),
                            ])->columnSpan('full')
                    ])->columnSpan('full'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('courseSkillTitle.course_title')
                    ->getDescriptionFromRecordUsing(fn (Lesson $record): string => $record->courseSkillTitle->subTopic->sub_topic_title)
                    ->titlePrefixedWithLabel(false),
                Group::make('lesson_title')
                    ->titlePrefixedWithLabel(false),
            ])->defaultGroup('courseSkillTitle.course_title')->groupsInDropdownOnDesktop()
            ->columns([
                Stack::make([
                    Tables\Columns\TextColumn::make('lesson_title')
                        ->size(TextColumnSize::Small)
                        ->weight(FontWeight::Bold)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('videos.video_title')
                        ->label('')
                        ->listWithLineBreaks()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('activities.activity_title')
                        ->label('')
                        ->state(fn (Lesson $record): string => $record->activities->map(function ($activity) {
                            return $activity->activity_title . ' <em>- activity id:</em> <strong>' . $activity->id . '</strong>';
                        })->implode('<br>'))
                        ->html()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('exercises.exercise_title')
                        ->label('')
                        ->state(fn (Lesson $record): string => $record->exercises->map(function ($exercise) {
                            return $exercise->exercise_title . ' <em>- exercise id:</em> <strong>' . $exercise->id . '</strong>';
                        })->implode('<br>'))
                        ->html()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('summativeAssesments.summative_assesment_title')
                        ->label('')
                        ->state(fn (Lesson $record): string => $record->summativeAssesments->map(function ($summativeAssesment) {
                            return $summativeAssesment->summative_assesment_title . ' <em>- summative id:</em> <strong>' . $summativeAssesment->id . '</strong>';
                        })->implode('<br>'))
                        ->html()
                        ->searchable(),
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([])
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
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
        ];
    }
}
