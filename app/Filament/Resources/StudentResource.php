<?php

namespace App\Filament\Resources;



use Filament\Tables;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Exports\StudentsExport;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\StudentResource\Pages;
use Maatwebsite\Excel\Facades\Excel;



class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    /**
     * Hàm tạo ra form nhập liệu
     * Áp dụng cho các trang create, edit
     *
    */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                // Tạo ra dropdown list với cột "class_id" là khoá ngoại
                Select::make('class_id')
                    ->live()
                    ->relationship('class', 'name') // lấy dữ liệu từ function class() {...} ở Models/Student.php và hiển thị cột "name" ở bảng classes
                    ->required(), // bắt buộc nhập liệu

                // Tạo ra dropdown list với cột "section_id" là khoá ngoại
                Select::make('section_id')
                    ->label('Section') // thay thế tên cột "section_id" thành "Section" trong bảng
                    ->options(function (Get $get) {  // Khi "click chọn class" nào thì "các section" của class đó sẽ hiện ra
                        $classId = $get('class_id'); // lấy giá trị của class_id

                        // Nếu class_id tồn tại thì lấy dữ liệu từ bảng sections
                        if ($classId) {
                            return \App\Models\Section::where('class_id', $classId)->pluck('name', 'id')->toArray();
                        }
                    }),

                // Tạo ra textfield "name" dùng để nhập mới hoặc chỉnh sửa
                TextInput::make('name')
                    ->autofocus() // tự động focus vào textfield này khi mở trang create
                    ->required(), // bắt buộc nhập liệu

                TextInput::make('email')
                    ->unique() // kiểm tra tính duy nhất của email, email tồn tại trước đó rồi thì không cho insert vào nữa
                    ->required() // bắt buộc nhập liệu
                    ->email(), // kiểm tra định dạng email
            ]);
    }



    /**
     * Hàm hiển thị danh sách các bản ghi trong bảng
     * Tạo ra các cột, bộ lọc, các button Edit, Delete
     *
    */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                /*
                    ->label('Họ và tên') : thay thế tên cột "name" thành "Họ và tên" trong bảng
                    ->sortable() : cho phép sắp xếp theo cột này
                    ->searchable() : cho phép tìm kiếm theo cột này
                */


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
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('export') // Tạo ra button Export file excel
                        ->label('Export to Excel')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (Collection $records){
                            return Excel::download(new StudentsExport($records), 'students.xlsx');
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
