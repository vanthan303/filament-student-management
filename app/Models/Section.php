<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'class_id',
        'name',
    ];


    /*
        Khởi tạo mối quan hệ
        belongsTo : Section sẽ thuộc Class
        Bảng "sections" có cột "class_id" là "khóa ngoại" tham chiếu đến cột "id" ở bảng "classes"
    */
    public function class()
    {
        return $this->belongsTo(Classes::class);
    }


    /*
        Khởi tạo mối quan hệ
        hasMany : Section có nhiều Student
        Bảng "students" có cột "student_id" là "khóa ngoại" tham chiếu đến cột "id" ở bảng "studens"
    */
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
