<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Section;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SectionResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SectionResource\RelationManagers;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Validation\Rules\Exists;
use Filament\Forms\Get;
use Illuminate\Validation\Rules\Unique;

class SectionResource extends Resource
{
    protected static ?string $model = Section::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /* Tạo ra 1 Khối block mới với tên 'Academic Management' chứa Module Section */
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

                Select::make('class_id') // tạo ra 1 dropdown list với cột "class_id" là khoá ngoại
                    ->relationship('class', 'name'), // lấy dữ liệu từ function class() {...} ở Models/Section.php và hiển thị cột "name" ở bảng classes


                // tạo ra 1 textfield name dùng để nhập mới hoặc chỉnh sửa
                TextInput::make('name')
                    ->required() // bắt buộc nhập
                    ->maxLength(255) // tối đa 255 ký tự
                    ->unique(ignoreRecord:true, modifyRuleUsing: function (Get $get, Unique $rule){
                        return $rule->where('class_id', $get('class_id')); // chỉ kiểm tra duy nhất trong class_id này
                    }), // không được trùng với các bản ghi khác trong bảng (duy nhất)
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
                TextColumn::make('name'),
                TextColumn::make('class.name') // hiển thị cột "name" từ function class() {...} ở Models/Section.php
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
