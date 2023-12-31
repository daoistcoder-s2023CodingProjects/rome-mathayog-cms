<?php

namespace App\Filament\Resources\ActivityResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Actions\Action;


use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;

use Filament\Support\Enums\FontWeight;

use Filament\Resources\RelationManagers\RelationManager;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActQuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'actQuestions';

    protected static ?string $title = 'Activity Questions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //Use the schema in table() method to create a form
                // Forms\Components\Select::make('activity_id')
                //     ->relationship('activity', 'activity_id')
                //     ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->lesson->courseSkillTitle->course_title} => {$record->lesson->lesson_title} => {$record->activity_title} ")
                //     ->columnSpanFull(),
                Forms\Components\TextInput::make('activity_question')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('filActQuestion')
                    ->label('Fil-Activity question')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('activity_question')
                            ->default('add filipino translation')
                            ->label('')
                            ->maxLength(255),
                    ])
                    ->addAction(
                        fn (Action $action) => $action->label('Update Fil-translation')
                    )
                    ->collapsed()
                    ->itemLabel(fn (array $state): ?string => $state['activity_question'] ?? null)
                    ->maxItems(1)
                    ->defaultItems(0)
                    ->columnSpanFull(),

                FileUpload::make('question_graphics')
                    ->label('Question Img')
                    ->image()
                    ->imagePreviewHeight('250')
                    ->imageEditor()
                    ->disk('s3')
                    ->directory('act_question_img')
                    ->visibility('public')
                    ->columnSpan(2),
                Forms\Components\Select::make('question_type')
                    ->options([
                        'multiple choice' => 'Multiple Choice',
                        'graphic choice' => 'Graphic Choice',
                        'fill in the blanks' => 'Fill in the Blanks',
                        'drag and drop' => 'Drag and Drop',
                        'tables' => 'Tables',
                    ])
                    ->required()
                    ->columnSpan(1),
                Forms\Components\Select::make('learning_tools')
                    ->options([
                        'selection' => 'Selection',
                        'pencil' => 'Pencil',
                        'calculator' => 'Calculator',
                        'white board' => 'White Board',
                    ])
                    ->required()
                    ->columnSpan(1),

                Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('Choices'),
                        Forms\Components\Repeater::make('actChoices')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('choice_text')
                                    ->default('input the choice text')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                // Fil-ActChoice
                                Forms\Components\Repeater::make('filActChoice')
                                    ->label('Fil-Choice')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\TextInput::make('choice_text')
                                            ->default('add filipino translation')
                                            ->label('')
                                            ->maxLength(255),
                                    ])
                                    ->addAction(
                                        fn (Action $action) => $action->label('Update Fil-translation')
                                    )
                                    ->collapsed()
                                    ->itemLabel(fn (array $state): ?string => $state['choice_text'] ?? null)
                                    ->maxItems(1)
                                    ->defaultItems(0)
                                    ->columnSpan(1),

                                Forms\Components\Select::make('correct')
                                    ->options([
                                        'TRUE' => 'True',
                                        'FALSE' => 'False',
                                    ])
                                    ->columnSpan(1),

                                FileUpload::make('choice_graphics') //ChoiceGraphics
                                    ->label('choice Img')
                                    ->image()
                                    ->imagePreviewHeight('250')
                                    ->imageEditor()
                                    ->disk('s3')
                                    ->directory('act_choice_img')
                                    ->visibility('public')
                                    ->columnSpan(3),

                                Forms\Components\Repeater::make('actFeedback') //ActFeedback
                                    ->label('Eng-feedback')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\TextInput::make('activity_feedback')
                                            ->default('update english feedback')
                                            ->label('')
                                            ->maxLength(255),
                                    ])
                                    ->addAction(
                                        fn (Action $action) => $action->label('Update Eng-feedback')
                                    )
                                    ->collapsed()
                                    ->itemLabel(fn (array $state): ?string => $state['activity_feedback'] ?? null)
                                    ->maxItems(1)
                                    ->defaultItems(0)
                                    ->columnSpan(3),

                                Forms\Components\Repeater::make('filActFeedback') //Fil-ActFeedback
                                    ->label('Fil-feedback')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\TextInput::make('activity_feedback')
                                            ->default('update filipino feedback')
                                            ->label('')
                                            ->maxLength(255),
                                    ])
                                    ->addAction(
                                        fn (Action $action) => $action->label('Update Fil-feedback')
                                    )
                                    ->collapsed()
                                    ->itemLabel(fn (array $state): ?string => $state['activity_feedback'] ?? null)
                                    ->maxItems(1)
                                    ->defaultItems(0)
                                    ->columnSpan(3),

                            ])
                            ->columns(3)
                            ->grid(2)
                            ->addAction(
                                fn (Action $action) => $action->label('Add Choices')
                            )
                            ->reorderable()
                            ->cloneable()
                            ->itemLabel(fn (array $state): ?string => $state['choice_text'] ?? null)
                            ->collapsible()
                            ->maxItems(4)
                            ->defaultItems(0),
                    ]),

                // ActHint
                Forms\Components\Repeater::make('actHints')
                    ->label('Hints')
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
                        fn (Action $action) => $action->label('Update Eng-hints')
                    )
                    ->maxItems(1)
                    ->collapsed()
                    ->itemLabel(fn (array $state): ?string => $state['first_hint'] ?? null)
                    ->defaultItems(0)
                    ->columnSpanFull(),

                // Fil-ActHint
                Forms\Components\Repeater::make('filActHints')
                    ->label('Fil-hints')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('first_hint')
                            ->label('Fil-first hint')
                            ->placeholder('add first hint')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('second_hint')
                            ->label('Fil-second hint')
                            ->placeholder('add second hint')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('third_hint')
                            ->label('Fil-third hint')
                            ->placeholder('add third hint')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('technical_hint')
                            ->label('Fil-technical hint')
                            ->placeholder('add technical hint')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('growth_mindset_hint')
                            ->label('Fil-growth mindset hint')
                            ->placeholder('add growth mindset hint')
                            ->maxLength(255),

                    ])
                    ->addAction(
                        fn (Action $action) => $action->label('Update Fil-hints')
                    )
                    ->maxItems(1)
                    ->collapsed()
                    ->itemLabel(fn (array $state): ?string => $state['first_hint'] ?? null)
                    ->defaultItems(0)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Activity Questions')
            ->columns([
                Stack::make([
                    Tables\Columns\TextColumn::make('activity_question')
                        ->searchable()
                        ->grow(true)
                        ->weight(FontWeight::Bold),
                    Split::make([
                        Stack::make([
                            // -put column here
                            Tables\Columns\TextColumn::make('question_type')
                                ->badge()
                                ->searchable(),
                            Tables\Columns\TextColumn::make('learning_tools')
                                ->badge()
                                ->searchable(),
                        ])->grow(false),
                        Split::make([
                            // -put column here
                            Tables\Columns\TextColumn::make('actChoices.choice_text')
                                ->label('Choices')
                                ->badge()
                                ->color('warning')
                                ->searchable()
                                ->grow(false),
                            Tables\Columns\TextColumn::make('actChoices.actFeedback.activity_feedback')
                                ->label('Feedbacks')
                                ->badge()
                                ->color('gray')
                                ->searchable(),
                        ]),
                    ]),
                ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Add New Activity Question'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete Activity Question')
                    ->modalDescription('Are you sure you\'d like to delete this Question? This cannot be undone.')
                    ->modalSubmitActionLabel('Yes, delete it'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
