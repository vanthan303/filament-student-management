<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'name',
    ];


    /*
        Khởi tạo mối quan hệ
        hasMany : Classes sẽ có nhiều Sections
        Bảng "classes" có cột "id" là "khóa chính" tham chiếu đến cột "class_id" ở bảng "sections"
        Laravel sẽ tự động giả định rằng ở bảng "sections" có cột "class_id" là "khóa ngoại" tham chiếu đến cột "id" ở bảng "classes"
    */
    public function sections()
    {
        return $this->hasMany(Section::class, 'class_id');
    }


    /*
        Khởi tạo mối quan hệ
        hasMany : Classes sẽ có nhiều Students
        Bảng "classes" có cột "id" là "khóa chính" tham chiếu đến cột "class_id" ở bảng "students"
        Laravel sẽ tự động giả định rằng ở bảng "students" có cột "class_id" là "khóa ngoại" tham chiếu đến cột "id" ở bảng "classes"
    */
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
