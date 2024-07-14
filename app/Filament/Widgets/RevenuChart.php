<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class RevenuChart extends ChartWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Revenue Per Day';

    protected function getData(): array
    {
        $data = Trend::model(Payment::class)
            ->between(
                start: now()->subDays(30),
                end: now(),
            )
            ->perDay()
            ->sum('total');
    
        return [
            'datasets' => [
                [
                    'label' => 'Revenu ($)',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
