<?php

namespace App\Charts;

use App\Models\Employee;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class EmployeeChart
{
    protected $chart;

    public function __construct()
    {
        $this->chart = new LarapexChart;
    }

    public function build()
    {
        $employeeData = Employee::select('position_id')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('position_id')
            ->with('position')
            ->get();

        return $this->chart->barChart()
            ->setTitle('Posisi')
            ->setSubtitle('Posisi dengan Jumlah Karyawan Terbanyak')
            ->setDataset([
                [
                    'name' => 'Jumlah Karyawan',
                    'data' => $employeeData->pluck('count')->toArray()
                ]
            ])
            ->setXAxis($employeeData->pluck('position.name')->toArray());
    }
}
