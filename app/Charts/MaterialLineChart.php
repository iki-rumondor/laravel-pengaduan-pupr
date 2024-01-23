<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class MaterialLineChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        return $this->chart->barChart()
            ->setTitle('Sales during 2021.')
            ->setSubtitle('Physical sales vs Digital sales.')
            ->addData('Physical sales', [40, 93, 35])
            ->addData('Digital sales', [70, 29, 77])
            ->addData('Digital sales', [56, 43, 46])
            ->addData('Digital sales', [67, 28, 68])
            ->addData('Digital sales', [76, 87, 75])
            ->addData('Digital sales', [34, 75, 71])
            ->addData('Digital sales', [67, 46, 69])
            ->addData('Digital sales', [34, 98, 94])
            ->addData('Digital sales', [58, 37, 21])
            ->addData('Digital sales', [65, 87, 76])
            ->addData('Digital sales', [47, 56, 43])
            ->addData('Digital sales', [49, 89, 89])
            ->addData('Digital sales', [49, 89, 89])
            ->addData('Digital sales', [49, 89, 89])
            ->addData('Digital sales', [49, 89, 89])
            ->addData('Digital sales', [49, 89, 89])
            ->addData('Digital sales', [49, 89, 89])
            ->addData('Digital sales', [49, 89, 89])
            ->addData('Digital sales', [49, 89, 89])
            ->addData('Digital sales', [49, 89, 89])
            ->setXAxis(['January', 'February', 'March'])
            ->setFontColor('#fff');
    }
}
