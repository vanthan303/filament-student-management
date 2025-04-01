<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    use HasFactory;

    /**
     * protected $fillable : bảo vệ ứng dụng của bạn khỏi lỗ hổng Mass Assignment
     * Khai báo các cột trong mảng này để cho phép gán dữ liệu hàng loạt trong migration
     * Các "cột không được khai báo trong mảng này" khi chạy lệnh migration thì laravel sẽ bỏ qua nó
     *
     * Ở đây các cột 'class_id', 'section_id', 'name', 'email' được phép gán dữ liệu hàng loạt
     *
     * Ngoài ra còn có thuộc tính $guarded, thuộc tính này ngược lại với $fillable
     * $guarded là một mảng chứa các cột không được phép gán dữ liệu hàng loạt
     * Nếu bạn không muốn khai báo các cột được phép gán dữ liệu hàng loạt thì bạn có thể sử dụng thuộc tính này
     * VD: $guarded = ['id', 'created_at', 'updated_at'];
     * Khi đó các cột 'id', 'created_at', 'updated_at' sẽ không được phép gán dữ liệu hàng loạt
     * Còn lại các cột khác sẽ được phép gán dữ liệu hàng loạt
     * */
    protected $fillable = [
        'class_id',
        'section_id',
        'name',
        'email',
    ];


    /*
        Khởi tạo mối quan hệ
        belongsTo : Student sẽ thuộc Class
        Bảng "students" có cột "class_id" là "khóa ngoại" tham chiếu đến cột "id" ở bảng "classes"
    */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }


    /*
        Khởi tạo mối quan hệ
        belongsTo : Student sẽ thuộc Section
        Bảng "students" có cột "class_id" là "khóa ngoại" tham chiếu đến cột "id" ở bảng "sections"
    */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
