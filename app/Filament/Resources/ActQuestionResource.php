<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActQuestionResource\Pages;
use App\Filament\Resources\ActQuestionResource\RelationManagers;
use App\Models\ActQuestion;
use App\Models\Lesson;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
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

    protected static ?string $navigationGroup = 'Contents';

    protected static ?string $navigationLabel = 'Activities';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //Use the schema in table() method to create a form
                Forms\Components\Select::make('activity_id')
                    ->relationship('activity', 'activity_title')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('activity_question')
                    ->required()
                    ->maxLength(100)
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
                                Forms\Components\Select::make('correct')
                                    ->options([
                                        'TRUE' => 'True',
                                        'FALSE' => 'False',
                                    ])
                                    ->columnSpan(1),
                                FileUpload::make('choice_graphics')
                                    ->label('choice Img')
                                    ->image()
                                    ->imagePreviewHeight('250')
                                    ->imageEditor()
                                    ->disk('s3')
                                    ->directory('act_choice_img')
                                    ->visibility('public')
                                    ->columnSpan(2),
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
                            ->columns(2)
                            ->grid(2)
                            ->addAction(
                                fn (Action $action) => $action->label('Add Choices')
                            )
                            ->reorderable()
                            ->cloneable()
                            ->itemLabel(fn (array $state): ?string => $state['choice_text'] ?? null)
                            ->maxItems(4)
                            ->defaultItems(0),
                    ]),

                Section::make()
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
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string => $state['first_hint'] ?? null)
                            ->defaultItems(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('activity.lesson.courseSkillTitle.course_title')
                    ->getDescriptionFromRecordUsing(fn (ActQuestion $record): string => $record->activity->lesson->courseSkillTitle->skill_name)
                    ->label('Course Title')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
                Group::make('activity.lesson.lesson_title')
                    ->getDescriptionFromRecordUsing(fn (ActQuestion $record): string => $record->activity->lesson->courseSkillTitle->course_title)
                    ->label('Lesson Title')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
                Group::make('activity.activity_title')
                    ->label('Activity Title')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
            ])->defaultGroup('activity.lesson.lesson_title')
            ->columns([
                Tables\Columns\TextColumn::make('activity.lesson.courseSkillTitle.course_title')
                    ->label('Course Title')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('activity.lesson.lesson_title')
                    ->label('Lesson Title')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('activity.activity_title')
                    ->description(fn (ActQuestion $record): string => $record->activity->solo_framework)
                    ->numeric()
                    ->sortable(),
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
