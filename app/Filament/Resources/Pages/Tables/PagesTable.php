<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Başlık')->searchable()->weight('bold'),
                TextColumn::make('slug')->label('Adres')->prefix('/'),
                ToggleColumn::make('is_active')->label('Yayında'),
                TextColumn::make('updated_at')->label('Güncellendi')->since(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
