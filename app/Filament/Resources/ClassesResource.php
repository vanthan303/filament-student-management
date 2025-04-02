<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassesResource\Pages;
use App\Filament\Resources\ClassesResource\RelationManagers;
use App\Models\Classes;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassesResource extends Resource
{
    protected static ?string $model = Classes::class;

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

                /* các textfield để nhập liệu và chỉnh sửa được tạo ở đây */

                TextInput::make('name'), // tạo ra 1 textfield name dùng để nhập mới hoặc chỉnh sửa
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
                TextColumn::make('name'), // định dạng hiển thị thời gian
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
