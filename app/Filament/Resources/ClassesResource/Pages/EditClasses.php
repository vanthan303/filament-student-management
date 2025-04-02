<?php

namespace App\Filament\Resources\ClassesResource\Pages;

use App\Filament\Resources\ClassesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClasses extends EditRecord
{
    protected static string $resource = ClassesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Hiển thị nút Delete khi bên giao diện chỉnh sửa
            Actions\DeleteAction::make(),
        ];
    }
}
