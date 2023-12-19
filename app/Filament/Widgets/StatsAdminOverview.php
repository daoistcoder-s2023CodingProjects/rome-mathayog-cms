<?php

namespace App\Filament\Widgets;

use App\Models\ActQuestion;
use App\Models\ExeQuestion;
use App\Models\SumQuestion;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Activity Questions', ActQuestion::query()->count())
                ->description('All questions in activities')
                ->color('success'),
            Stat::make('Exercise Questions', ExeQuestion::query()->count())
                ->description('All questions in exercises')
                ->color('success'),
            Stat::make('Summative Questions', SumQuestion::query()->count())
                ->description('All questions in summative assesments')
                ->color('success'),
        ];
    }
}
