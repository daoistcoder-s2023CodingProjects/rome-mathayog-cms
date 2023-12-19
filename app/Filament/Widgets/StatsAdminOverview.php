<?php

namespace App\Filament\Widgets;

use App\Models\ActQuestion;
use App\Models\CourseSkillTitle;
use App\Models\ExeQuestion;
use App\Models\SumQuestion;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Courses', CourseSkillTitle::query()->count())
                ->description('Courses in the database')
                ->color('success'),
            // make a stat for Courses that has lesson instance on it
            Stat::make('Courses in Progress', CourseSkillTitle::query()->whereHas('lessons')->count())
                ->description('Courses with course content')
                ->color('success'),

            // make a stat for Courses that had model inside lesson instance such as ActQuestion, ExeQuestion, SumQuestion where updated today
            Stat::make('Updated Courses Today', CourseSkillTitle::query()->whereHas('lessons', function ($query) {
                $query->whereHas('activities.actQuestions', function ($query) {
                    $query->whereDate('updated_at', today());
                })
                    ->orWhereHas('exercises.exeQuestions', function ($query) {
                        $query->whereDate('updated_at', today());
                    })
                    ->orWhereHas('summativeAssesments.sumQuestions', function ($query) {
                        $query->whereDate('updated_at', today());
                    })
                    ->orWhereHas('videos', function ($query) {
                        $query->whereDate('updated_at', today());
                    });
            })->count())
                ->description('Courses updated today')
                ->color('success'),

            // make a stat for all questions in ActQuestion, ExeQuestion, SumQuestion
            Stat::make('Questions', ActQuestion::query()->count() +
                ExeQuestion::query()->count() + SumQuestion::query()->count())
                ->description('Total questions in the database')
                ->color('success'),

            // make a stat for total question created today
            Stat::make('Questions for Today', ActQuestion::query()->whereDate('created_at', today())->count() + ExeQuestion::query()->whereDate('created_at', today())->count() + SumQuestion::query()->whereDate('created_at', today())->count())
                ->description('questions uploaded today')
                ->color('success'),

            // make a stat for total question created this week
            Stat::make('Questions this Week', ActQuestion::query()->whereBetween('created_at', [today()->startOfWeek(), today()->endOfWeek()])->count() + ExeQuestion::query()->whereBetween('created_at', [today()->startOfWeek(), today()->endOfWeek()])->count() + SumQuestion::query()->whereBetween('created_at', [today()->startOfWeek(), today()->endOfWeek()])->count())
                ->description('questions uploaded this week')
                ->color('success'),

            // Stat::make('Activity Questions', ActQuestion::query()->count())
            //     ->description('questions in activities')
            //     ->color('success'),
            // Stat::make('Exercise Questions', ExeQuestion::query()->count())
            //     ->description('questions in exercises')
            //     ->color('success'),
            // Stat::make('Summative Questions', SumQuestion::query()->count())
            //     ->description('questions in summative assesments')
            //     ->color('success') //-use in future,
        ];
    }
}
