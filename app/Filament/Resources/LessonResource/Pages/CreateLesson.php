<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use App\Filament\Resources\CourseSkillTitleResource;
use App\Filament\Traits\HasParentResource;

class CreateLesson extends CreateRecord
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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set the parent relationship key to the parent resource's ID.
        $data[$this->getParentRelationshipKey()] = $this->parent->id;

        return $data;
    }
}
