<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseSkillTitleResource\Pages;
use App\Filament\Resources\CourseSkillTitleResource\RelationManagers;
use App\Models\CourseSkillTitle;
use App\Models\SubTopic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Support\Htmlable;

use App\Filament\Resources\LessonResource\Pages\CreateLesson;
use App\Filament\Resources\LessonResource\Pages\EditLesson;
use App\Filament\Resources\LessonResource\Pages\ListLessons;
class CourseSkillTitleResource extends Resource
{
    protected static ?string $model = CourseSkillTitle::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Skills Map';

    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record->course_title;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sub_topic_id')
                    ->options(SubTopic::query()->pluck('sub_topic_title', 'id'))
                    ->required()
                    ->reactive(),
                Forms\Components\TextInput::make('course_title')
                    ->maxLength(255),
                Forms\Components\TextInput::make('skill_name')
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                // Group::make('subTopic.topic.level.level')
                //     ->getDescriptionFromRecordUsing(fn (CourseSkillTitle $record): string => $record->subTopic->topic->level->pisa_framework)
                //     ->collapsible()
                //     ->titlePrefixedWithLabel(false),
                Group::make('subTopic.topic.level.content_area')
                    ->collapsible()
                    ->label('Content Area')
                    ->titlePrefixedWithLabel(false),
                Group::make('subTopic.topic.level.pisa_framework')
                    ->collapsible()
                    ->label('Pisa Framework')
                    ->titlePrefixedWithLabel(false),
                Group::make('subTopic.topic.topic_title')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
                Group::make('subTopic.sub_topic_title')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('subTopic.topic.level.level')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('subTopic.topic.level.content_area')
                    ->label('Content Area')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('subTopic.topic.level.pisa_framework')
                    ->label('Pisa Framework')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('subTopic.topic.topic_title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subTopic.sub_topic_title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course_title')
                    // ->description(fn (CourseSkillTitle $record): string => $record->skill_name)
                    ->searchable(),
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
                Tables\Actions\Action::make('Manage course content')
                ->color('success')
                ->icon('heroicon-m-academic-cap')
                ->url(fn (CourseSkillTitle $record): string => self::getUrl('lessons.index', [
                    'parent' => $record->id,
                ])),
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
            'index' => Pages\ListCourseSkillTitles::route('/'),
            'edit' => Pages\EditCourseSkillTitle::route('/{record}/edit'),

              // Lessons 
              'lessons.index' => ListLessons::route('/{parent}/lessons'),
              'lessons.create' => CreateLesson::route('/{parent}/lessons/create'),
              'lessons.edit' => EditLesson::route('/{parent}/lessons/{record}/edit'),
        ];
    }

    public static function getUrl(string $name = 'index', array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null): string
    {
        $parameters['tenant'] ??= ($tenant ?? Filament::getTenant());

        $routeBaseName = static::getRouteBaseName(panel: $panel);
        $routeFullName = "{$routeBaseName}.{$name}";
        $routePath = Route::getRoutes()->getByName($routeFullName)->uri();

        if (str($routePath)->contains('{parent}')) {
            $parameters['parent'] ??= (request()->route('parent') ?? request()->input('parent'));
        }

        return route($routeFullName, $parameters, $isAbsolute);
    }
}
