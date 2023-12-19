<?php

namespace App\Filament\Widgets;

use App\Models\ActQuestion;
use App\Models\ExeQuestion;
use App\Models\SumQuestion;
use Filament\Widgets\ChartWidget;

class TotalQuestionsChart extends ChartWidget
{
    protected static ?string $heading = 'Questions Upload Daily Chart';

    protected function getData(): array
    {
        // create a chart that logs daily total questions on all ActQuestions, ExeQuestions, SumQuestions, from Monday to Sunday
        // Get the total questions for each day of the week
        $data = [];
        for ($i = 0; $i < 7; $i++) {
            $day = now()->startOfWeek()->addDays($i);
            $totalQuestions = ActQuestion::whereDate('created_at', $day)->select('created_at')
                ->union(ExeQuestion::whereDate('created_at', $day)->select('created_at'))
                ->union(SumQuestion::whereDate('created_at', $day)->select('created_at'))
                ->count();
            $data[] = $totalQuestions;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Questions uploaded',
                    'data' => $data,
                ],
            ],
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
