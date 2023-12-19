<?php

namespace App\Filament\Widgets;

use App\Models\ActQuestion;
use App\Models\ExeQuestion;
use App\Models\SumQuestion;
use Filament\Widgets\ChartWidget;

class WeeklyQuestionsChart extends ChartWidget
{
    protected static ?string $heading = 'Weekly Upload Chart';

    protected function getData(): array
    {
        // create a chart that logs Weekly total questions on all ActQuestions, ExeQuestions, SumQuestions, from 1st week of the previous 2nd month, to the last week of the current month
        // Get the start and end dates for the current month
        $startMonth = now()->startOfMonth();
        $endMonth = now()->endOfMonth();

        $data = [];
        $labels = [];

        // Get the total questions for the last 4 weeks of the current month
        for ($weekStart = $endMonth->copy()->subWeeks(3)->startOfWeek(); $weekStart->lte($endMonth); $weekStart->addWeek()) {
            $weekEnd = (clone $weekStart)->endOfWeek()->min($endMonth);
            $totalQuestions = ActQuestion::whereBetween('created_at', [$weekStart, $weekEnd])->count()
                + ExeQuestion::whereBetween('created_at', [$weekStart, $weekEnd])->count()
                + SumQuestion::whereBetween('created_at', [$weekStart, $weekEnd])->count();
            $data[] = $totalQuestions;
            $labels[] = $weekStart->format('M d') . ' - ' . $weekEnd->format('M d');
        }

        return [
            'datasets' => [
                [
                    'label' => 'total questions',
                    'data' => $data,
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getDescription(): ?string
    {
        return 'The number of questions uploaded per week.';
    }
}
