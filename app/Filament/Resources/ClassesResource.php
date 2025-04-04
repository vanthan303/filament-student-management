<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Classes;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ClassesResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClassesResource\RelationManagers;

class ClassesResource extends Resource
{
    protected static ?string $model = Classes::class;


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /* Tạo ra 1 Khối block mới với tên 'Academic Management' chứa Module Class */
    protected static ?string $navigationGroup = 'Academic Management';


    /**
     * Hàm tạo ra form nhập liệu
     * Áp dụng cho các trang create, edit
     *
    */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                /**
                 * Tạo các textfield để nhập liệu và chỉnh sửa được tạo ở đây
                */

                // tạo ra 1 textfield name dùng để nhập mới hoặc chỉnh sửa
                TextInput::make('name')
                    ->required() // bắt buộc nhập
                    ->unique(ignoreRecord:true) // không được trùng với các bản ghi khác trong bảng (duy nhất)
                    ->maxLength(255), // tối đa 255 ký tự
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
                TextColumn::make('name') // thay thế tên cột "name" thành "Họ và tên" trong bảng, // hiển thị cột name (name giống với tên cột trong CSDL)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('sections.name') // hiển thị cột "name" từ function sections () {...} ở Models/Classes.php
                    ->badge(),


                TextColumn::make('students_count')
                    ->counts('students') // đếm số lượng bản ghi trong bảng students
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Hiển thị các button Edit, Delete trên list
                Tables\Actions\EditAction::make(), // button Edit
                Tables\Actions\DeleteAction::make(), // button Delete
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    /**
     *
     *
     *
    */
    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    /**
     * Hàm tạo ra các phần giao diện index, view, create, edit
    */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClasses::route('/'), // hiển thị giao diện index
            'create' => Pages\CreateClasses::route('/create'), // hiển thị giao diện tạo mới
            'edit' => Pages\EditClasses::route('/{record}/edit'), // hiển thị giao diện chỉnh sửa
        ];
    }
}
