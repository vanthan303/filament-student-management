<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use illuminate\Database\Eloquent\Collection;
use Carbon\Carbon; // Thêm thư viện Carbon để xử lý ngày tháng


class StudentsExport implements FromCollection, WithMapping, WithHeadings
{

    use Exportable;


    /**
    * constructor
    */
    public function __construct(public Collection $records)
    {

    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->records;
    }


    /**
     * Hàm ánh xạ dữ liệu từ bảng student sang các cột trong excel
    * @param Student $student
    */
    public function map($student): array
    {
        return [
            $student->name,
            $student->email,
            $student->class->name,
            $student->section->name,
            Carbon::parse($student->created_at)->format('d/m/Y H:i:s'), // Định dạng ngày tháng giờ phút giây
            Carbon::parse($student->updated_at)->format('d/m/Y H:i:s'), // Định dạng ngày tháng giờ phút giây
        ];
    }


    /**
    * Hàm tạo ra 6 cột heading tương ứng trong excel
    */
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Class',
            'Section',
            'Time Created',
            'Time Updated',
        ];
    }


}
