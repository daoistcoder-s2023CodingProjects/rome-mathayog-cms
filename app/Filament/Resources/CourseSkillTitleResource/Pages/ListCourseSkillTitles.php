<?php

namespace App\Filament\Resources\CourseSkillTitleResource\Pages;

use App\Filament\Resources\CourseSkillTitleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCourseSkillTitles extends ListRecords
{
    protected static string $resource = CourseSkillTitleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
