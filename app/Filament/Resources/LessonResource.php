<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Filament\Resources\LessonResource\Pages\ListLessons;
use App\Filament\Resources\LessonResource\RelationManagers;
use App\Models\CourseSkillTitle;
use App\Models\Lesson;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Card;
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
    protected static ?string $model = Lesson::class;

    protected static ?int $navigationSort = 2;

    // protected static ?string $navigationLabel = 'Courses';

    // protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

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
                        Forms\Components\Card::make()
                            ->schema([
                                // Forms\Components\Select::make('course_skill_title_id')
                                //     ->label('Course Title')
                                //     ->options(CourseSkillTitle::query()->pluck('course_title', 'id')),

                                Forms\Components\TextInput::make('lesson_title')
                                    ->maxLength(255),

                            ])->columnSpan('full'),

                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\Placeholder::make('Lesson Content'),

                                Forms\Components\Repeater::make('videos')
                                    ->label('')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\TextInput::make('video_title')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('video_description')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('video_url')
                                            ->label('Video')
                                            ->maxLength(255),
                                    ])
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
                                        Forms\Components\TextInput::make('activity_title'),
                                        Forms\Components\TextInput::make('objective'),
                                        Forms\Components\Select::make('solo_framework')
                                            ->options([
                                                'Pre-Stractural' => 'Pre-Stractural',
                                                'Uni-Stractural' => 'Uni-Stractural',
                                                'Multi-Stractural' => 'Multi-Stractural',
                                                'Relational' => 'Relational',
                                                'Extended-Abstract' => 'Extended-Abstract',
                                            ]),
                                        Forms\Components\Card::make()
                                            ->schema([
                                                Forms\Components\Placeholder::make('Activity Questions'),
                                                Forms\Components\Repeater::make('actQuestions')
                                                    ->label('')
                                                    ->relationship()
                                                    ->schema([
                                                        Forms\Components\TextInput::make('activity_question')
                                                            ->default('edit your activity question')
                                                            ->columnSpan('full')
                                                            ->maxLength(255),
                                                        Forms\Components\TextInput::make('question_graphics')
                                                            ->placeholder('image url')
                                                            ->columnSpan('full')
                                                            ->maxLength(255),
                                                        Forms\Components\Select::make('question_type')
                                                            ->options([
                                                                'multiple choice' => 'Multiple Choice',
                                                                'graphic choice' => 'Graphic Choice',
                                                                'fill in the blank' => 'Fill in the Blank',
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

                                                        Forms\Components\Card::make()
                                                            ->schema([
                                                                Forms\Components\Placeholder::make('Choices'),
                                                                Forms\Components\Repeater::make('actChoices')
                                                                    ->label('')
                                                                    ->relationship()
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('choice_text')
                                                                            ->default('input the choice text')
                                                                            ->columnSpan('full')
                                                                            ->maxLength(255),
                                                                        Forms\Components\TextInput::make('choice_graphics')
                                                                            ->placeholder('image url')
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
                                                                                Forms\Components\Repeater::make('actFeedback')
                                                                                    ->label('')
                                                                                    ->relationship()
                                                                                    ->schema([
                                                                                        Forms\Components\TextInput::make('activity_feedback')
                                                                                            ->default('input new feedback')
                                                                                            ->label('')
                                                                                            ->maxLength(255),
                                                                                    ])
                                                                                    ->addAction(
                                                                                        fn (Action $action) => $action->label('Update Feedback')
                                                                                    )
                                                                                    ->collapsed()
                                                                                    ->itemLabel(fn (array $state): ?string => $state['activity_feedback'] ?? null)
                                                                                    ->maxItems(1)
                                                                                    ->defaultItems(0),
                                                                            ]),

                                                                    ])
                                                                    ->addAction(
                                                                        fn (Action $action) => $action->label('Add Choices')
                                                                    )
                                                                    ->collapsed()
                                                                    ->itemLabel(fn (array $state): ?string => $state['choice_text'] ?? null)
                                                                    ->maxItems(4)
                                                                    ->defaultItems(0),
                                                            ]),

                                                        Forms\Components\Card::make()
                                                            ->schema([
                                                                Forms\Components\Placeholder::make('Hints'),
                                                                Forms\Components\Repeater::make('actHints')
                                                                    ->label('')
                                                                    ->relationship()
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('first_hint')
                                                                            ->placeholder('add first hint')
                                                                            ->maxLength(255),
                                                                        Forms\Components\TextInput::make('second_hint')
                                                                            ->placeholder('add second hint')
                                                                            ->maxLength(255),
                                                                        Forms\Components\TextInput::make('third_hint')
                                                                            ->placeholder('add third hint')
                                                                            ->maxLength(255),
                                                                        Forms\Components\TextInput::make('technical_hint')
                                                                            ->placeholder('add technical hint')
                                                                            ->maxLength(255),
                                                                        Forms\Components\TextInput::make('growth_mindset_hint')
                                                                            ->placeholder('add growth mindset hint')
                                                                            ->maxLength(255),

                                                                    ])
                                                                    ->addAction(
                                                                        fn (Action $action) => $action->label('Update Hints')
                                                                    )
                                                                    ->maxItems(1)
                                                                    ->defaultItems(0),
                                                            ]),
                                                    ])
                                                    ->addAction(
                                                        fn (Action $action) => $action->label('Add Question')
                                                    )
                                                    ->cloneable()
                                                    ->collapsed()
                                                    ->itemLabel(fn (array $state): ?string => $state['activity_question'] ?? null)
                                                    ->defaultItems(0),
                                            ]),
                                    ])
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
                                        Forms\Components\Card::make()
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
                                                        Forms\Components\Select::make('question_type')
                                                            ->options([
                                                                'multiple choice' => 'Multiple Choice',
                                                                'graphic choice' => 'Graphic Choice',
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

                                                        Forms\Components\Card::make()
                                                            ->schema([
                                                                Forms\Components\Placeholder::make('Choices'),
                                                                Forms\Components\Repeater::make('exeChoices')
                                                                    ->label('')
                                                                    ->relationship()
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('choice_text')
                                                                            ->columnSpan('full')
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
                                        Forms\Components\Card::make()
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
                                                        Forms\Components\Select::make('question_type')
                                                            ->options([
                                                                'multiple choice' => 'Multiple Choice',
                                                                'graphic choice' => 'Graphic Choice',
                                                                'drag and drop' => 'Drag and Drop',
                                                            ])
                                                            ->columnSpan(1),

                                                        Forms\Components\Card::make()
                                                            ->schema([
                                                                Forms\Components\Placeholder::make('Choices'),
                                                                Forms\Components\Repeater::make('sumChoices')
                                                                    ->label('')
                                                                    ->relationship()
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('choice_text')
                                                                            ->columnSpan('full')
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
