<?php

namespace App\Filament\Widgets;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1; // Sắp xếp vị trí của widget này trong dashboard | 1 vị trí đầu tiên

    protected function getStats(): array
    {
        return [
            // Hiển thị 3 ô tính tổng số lượng bản ghi trong bảng classes, sections, students ngoài Dashboard
            Stat::make('Total Classes', Classes::count())
                ->icon('heroicon-o-academic-cap')
                ->color('success'),

            Stat::make('Total Sections', Section::count())
                ->icon('heroicon-o-rectangle-stack')
                ->color('warning'),

            Stat::make('Total Students', Student::count())
                ->icon('heroicon-o-user-group')
                ->color('danger'),
        ];
    }
}
