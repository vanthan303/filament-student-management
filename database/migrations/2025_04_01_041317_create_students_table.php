<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Hàm tạo 1 table mới có tên là students
     * foreignId('class_id') : tạo ra cột "class_id" có kiểu dữ liệu là "unsigned big integer" là "khoá ngoại"
     * constrained('classes'): tự tìm đến bảng "classes" và tham chiếu đến cột "id" là khoá chính
     * ->onDelete('cascade') : nếu có sử dụng thêm thì khi xóa 1 bản ghi ở bảng "classes" thì sẽ tự động xóa tất cả các bản ghi ở bảng "students" có cùng "class_id"
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes');
            $table->foreignId('section_id')->constrained('sections');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
