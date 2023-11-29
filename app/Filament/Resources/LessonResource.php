<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Filament\Resources\LessonResource\Pages\ListLessons;
use App\Filament\Resources\LessonResource\RelationManagers;
use App\Models\CourseSkillTitle;
use App\Models\Lesson;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
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
                                            ->columnSpan(2),
                                        Forms\Components\FileUpload::make('video_url')
                                            ->label('Video')
                                            ->disk('s3')
                                            ->directory('videos')
                                            ->maxSize(20000)
                                            ->visibility('public')
                                            ->columnSpan(1),
                                        Forms\Components\TextArea::make('video_description')
                                            ->placeholder('add video description')
                                            ->rows(3)
                                            ->columnSpan(1),
                                    ])
                                    ->columns(2)
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
                                            ->rows(2)
                                            ->columnSpan(2),
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
                                        Forms\Components\TextInput::make('exercise_title'),
                                        Forms\Components\TextInput::make('objective'),
                                        Section::make()
                                            ->schema([
                                                Forms\Components\Placeholder::make('Exercise Questions'),
                                                Forms\Components\Repeater::make('exeQuestions')
                                                    ->label('')
                                                    ->relationship()
                                                    ->schema([
                                                        Forms\Components\TextInput::make('exercise_question')
                                                            ->default('edit your exercise question')
                                                            ->columnSpan('full')
                                                            ->maxLength(255),
                                                        Forms\Components\TextInput::make('question_graphics')
                                                            ->placeholder(self::IMAGE_PLACEHOLDER)
                                                            ->columnSpan('full')
                                                            ->maxLength(255),
                                                        Forms\Components\Select::make('question_type')
                                                            ->options([
                                                                'multiple choice' => 'Multiple Choice',
                                                                'graphic choice' => 'Graphic Choice',
                                                                'fill in the blanks' => 'Fill in the Blanks',
                                                                'drag and drop' => 'Drag and Drop',
                                                            ])
                                                            ->columnSpan(1),
                                                        Forms\Components\Select::make('learning_tools')
                                                            ->options([
                                                                'selection' => 'Selection',
                                                                'pencil' => 'Pencil',
                                                                'calculator' => 'Calculator',
                                                                'white board' => 'White Board',
                                                            ])
                                                            ->columnSpan(1),

                                                        Section::make()
                                                            ->schema([
                                                                Forms\Components\Placeholder::make('Choices'),
                                                                Forms\Components\Repeater::make('exeChoices')
                                                                    ->label('')
                                                                    ->relationship()
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('choice_text')
                                                                            ->default('input the choice text')
                                                                            ->columnSpan('full')
                                                                            ->maxLength(255),
                                                                        Forms\Components\TextInput::make('choice_graphics')
                                                                            ->placeholder(self::IMAGE_PLACEHOLDER)
                                                                            ->maxLength(255),
                                                                        Forms\Components\Select::make('correct')
                                                                            ->options([
                                                                                'TRUE' => 'True',
                                                                                'FALSE' => 'False',
                                                                            ])
                                                                            ->columnSpan(1),
                                                                        Section::make()
                                                                            ->schema([
                                                                                Forms\Components\Placeholder::make('Feedback'),
                                                                                Forms\Components\Repeater::make('exeFeedback')
                                                                                    ->label('')
                                                                                    ->relationship()
                                                                                    ->schema([
                                                                                        Forms\Components\TextInput::make('exercise_feedback')
                                                                                            ->default('input new feedback')
                                                                                            ->label('')
                                                                                            ->maxLength(255),
                                                                                    ])
                                                                                    ->addAction(
                                                                                        fn (Action $action) => $action->label('Update Feedback')
                                                                                    )
                                                                                    ->collapsed()
                                                                                    ->itemLabel(fn (array $state): ?string => $state['exercise_feedback'] ?? null)
                                                                                    ->maxItems(1)
                                                                                    ->defaultItems(0),
                                                                            ]),

                                                                    ])
                                                                    ->addAction(
                                                                        fn (Action $action) => $action->label('Add Choices')
                                                                    )
                                                                    ->reorderable()
                                                                    ->cloneable()
                                                                    ->collapsed()
                                                                    ->itemLabel(fn (array $state): ?string => $state['choice_text'] ?? null)
                                                                    ->maxItems(4)
                                                                    ->defaultItems(0),
                                                            ]),

                                                    ])
                                                    ->addAction(
                                                        fn (Action $action) => $action->label('Add Question')
                                                    )
                                                    ->reorderable()
                                                    ->cloneable()
                                                    ->collapsed()
                                                    ->itemLabel(fn (array $state): ?string => $state['exercise_question'] ?? null)
                                                    ->defaultItems(0),
                                            ]),
                                    ])
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
                                        Forms\Components\TextInput::make('summative_assesment_title'),
                                        Forms\Components\TextInput::make('description'),
                                        Forms\Components\TextInput::make('level_id'),
                                        Section::make()
                                            ->schema([
                                                Forms\Components\Placeholder::make('Summative Questions'),
                                                Forms\Components\Repeater::make('sumQuestions')
                                                    ->label('')
                                                    ->relationship()
                                                    ->schema([
                                                        Forms\Components\TextInput::make('summative_assesment_question')
                                                            ->default('edit your summative question')
                                                            ->columnSpan('full')
                                                            ->maxLength(255),
                                                        Forms\Components\TextInput::make('question_graphics')
                                                            ->placeholder(self::IMAGE_PLACEHOLDER)
                                                            ->columnSpan('full')
                                                            ->maxLength(255),
                                                        Forms\Components\Select::make('question_type')
                                                            ->options([
                                                                'multiple choice' => 'Multiple Choice',
                                                                'graphic choice' => 'Graphic Choice',
                                                                'fill in the blanks' => 'Fill in the Blanks',
                                                                'drag and drop' => 'Drag and Drop',
                                                            ])
                                                            ->columnSpan(1),

                                                        Section::make()
                                                            ->schema([
                                                                Forms\Components\Placeholder::make('Choices'),
                                                                Forms\Components\Repeater::make('sumChoices')
                                                                    ->label('')
                                                                    ->relationship()
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('choice_text')
                                                                            ->default('input the choice text')
                                                                            ->columnSpan('full')
                                                                            ->maxLength(255),
                                                                        Forms\Components\TextInput::make('choice_graphics')
                                                                            ->placeholder(self::IMAGE_PLACEHOLDER)
                                                                            ->maxLength(255),
                                                                        Forms\Components\Select::make('correct')
                                                                            ->options([
                                                                                'TRUE' => 'True',
                                                                                'FALSE' => 'False',
                                                                            ])
                                                                            ->columnSpan(1),
                                                                    ])
                                                                    ->addAction(
                                                                        fn (Action $action) => $action->label('Add Choices')
                                                                    )
                                                                    ->reorderable()
                                                                    ->cloneable()
                                                                    ->collapsed()
                                                                    ->itemLabel(fn (array $state): ?string => $state['choice_text'] ?? null)
                                                                    ->maxItems(4)
                                                                    ->defaultItems(0),
                                                            ]),

                                                    ])
                                                    ->addAction(
                                                        fn (Action $action) => $action->label('Add Question')
                                                    )
                                                    ->cloneable()
                                                    ->collapsed()
                                                    ->itemLabel(fn (array $state): ?string => $state['summative_assesment_question'] ?? null)
                                                    ->defaultItems(0),
                                            ]),
                                    ])
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
                        ->size(TextColumnSize::Medium)
                        ->weight(FontWeight::Bold)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('videos.video_title')
                        ->label('')
                        ->listWithLineBreaks()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('activities.activity_title')
                        ->label('')
                        ->listWithLineBreaks()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('exercises.exercise_title')
                        ->label('')
                        ->size(TextColumnSize::Medium)
                        ->weight(FontWeight::Bold)
                        ->listWithLineBreaks()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('summativeAssesments.summative_assesment_title')
                        ->label('')
                        ->size(TextColumnSize::Medium)
                        ->weight(FontWeight::Bold)
                        ->listWithLineBreaks()
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
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
