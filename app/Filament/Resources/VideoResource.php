<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Filament\Resources\VideoResource\RelationManagers;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Contents';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //Use the schema in table() method to create a form
                Forms\Components\Select::make('lesson_id')
                    ->relationship('lesson', 'lesson_id')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->courseSkillTitle->course_title} => {$record->lesson_title} ")
                    ->columnSpan(1),
                Forms\Components\TextInput::make('video_title')
                    ->required()
                    ->maxLength(100)
                    ->columnSpan(1),
                FileUpload::make('video_url')
                    ->label('Video')
                    ->disk('s3')
                    ->directory('videos')
                    ->maxSize(20000)
                    ->visibility('public')
                    ->columnSpan(1),
                Forms\Components\Textarea::make('video_description')
                    ->rows(3)
                    ->required()
                    ->maxLength(65535)
                    ->columnSpan(1),

            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('lesson.courseSkillTitle.course_title')
                    ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('id', $direction))
                    ->getDescriptionFromRecordUsing(fn (Video $record): string => $record->lesson->lesson_title)
                    ->label('Course Title')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
            ])->defaultGroup('lesson.courseSkillTitle.course_title')
            ->columns([
                Tables\Columns\TextColumn::make('lesson.lesson_title')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('video_title')
                    ->description(fn (Video $record): string => $record->video_description)
                    ->searchable(),
                Tables\Columns\TextColumn::make('video_url')
                    ->label('Video URL')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
