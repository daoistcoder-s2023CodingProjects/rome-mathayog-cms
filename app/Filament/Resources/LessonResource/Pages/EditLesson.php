<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use App\Filament\Resources\CourseSkillTitleResource;
use App\Filament\Traits\HasParentResource;

class EditLesson extends EditRecord
{
    use HasParentResource;

    protected static string $parentResource = CourseSkillTitleResource::class;

    protected static string $resource = LessonResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getParentResource()::getUrl('lessons.index', [
            'parent' => $this->parent,
        ]);
    }

    protected function configureDeleteAction(Actions\DeleteAction $action): void
    {
        $resource = static::getResource();

        $action->authorize($resource::canDelete($this->getRecord()))
            ->successRedirectUrl($this->getParentResource()::getUrl('lessons.index', [
                'parent' => $this->parent,
            ]));
    }
}
