<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('image')->label('')->disk('public')->imageSize(56),
                TextColumn::make('title')->label('Başlık')->searchable()->weight('bold')->description(fn ($record): ?string => $record->summary)->wrap(),
                ToggleColumn::make('is_featured')->label('Anasayfada'),
                ToggleColumn::make('is_active')->label('Yayında'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
