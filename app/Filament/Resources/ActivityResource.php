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
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->courseSkillTitle->course_title} => {$record->lesson_title}")
                    ->columnSpanFull(),
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
                    ->columnSpan(2),

                Section::make()
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
                                        Forms\Components\Repeater::make('actChoices')
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
                                            ->reorderable()
                                            ->cloneable()
                                            ->collapsed()
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
                                            ->defaultItems(0),
                                    ]),
                            ])
                            ->addAction(
                                fn (Action $action) => $action->label('Add Question')
                            )
                            ->reorderable()
                            ->cloneable()
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string => $state['activity_question'] ?? null)
                            ->defaultItems(0),
                    ]),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('activity_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('objective')
                    ->searchable(),
                Tables\Columns\TextColumn::make('solo_framework')
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
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
