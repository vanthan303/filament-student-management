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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassesResource extends Resource
{
    protected static ?string $model = Classes::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    /**
     * Hàm tạo ra form nhập liệu và chỉnh sửa
     *
    */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // các textfield để nhập liệu và chỉnh sửa được tạo ở đây

                TextInput::make('name'), // tạo ra 1 textfield name dùng để nhập mới hoặc chỉnh sửa
            ]);
    }


    /**
     * Hàm hiển thị danh sách các bản ghi trong bảng
     *
    */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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

    /**
     * tạo ra các phần giao diện index, view, create, edit
    */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClasses::route('/'),
            'create' => Pages\CreateClasses::route('/create'),
            'edit' => Pages\EditClasses::route('/{record}/edit'),
        ];
    }
}
