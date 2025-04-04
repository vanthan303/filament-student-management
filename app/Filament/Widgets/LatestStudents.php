<?php

namespace App\Filament\Widgets;


use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Student;
use Filament\Tables\Columns\TextColumn;


class LatestStudents extends BaseWidget
{

    protected static ?int $sort = 2; // Sắp xếp vị trí của widget này trong dashboard | 2 vị trí bên dưới

    protected int | string | array $columnSpan = 'full'; // Chiếm 2 cột trong layout

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Student::query()
                    ->latest()
                    ->take(5) // Lấy 5 record sinh viên mới nhất
            )
            ->columns([
                // Hiển thị cột name và cho phép search theo name này
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(), // thay thế tên cột "name" thành "Họ và tên" trong bảng

                // Hiển thị cột email và cho phép search theo email này
                TextColumn::make('email')
                    ->sortable()
                    ->searchable(), // thay thế tên cột "email" thành "Email" trong bảng

                TextColumn::make('class.name') // hiển thị cột "name" từ function class() {...} ở Models/Student.php
                    ->badge()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('section.name') // hiển thị cột "name" từ function class() {...} ở Models/Student.php
                    ->badge()
                    ->sortable()
                    ->searchable(),
            ]);
    }
}
