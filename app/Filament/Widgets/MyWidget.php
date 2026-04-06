<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class MyWidget extends ChartWidget
{
    protected ?string $heading = 'My Widget';

    public function getColumns(): int | array
    {
        return [
            'md' => 4,
            'xl' => 5,
        ];
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'valores',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['Jan', 'Fev', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
