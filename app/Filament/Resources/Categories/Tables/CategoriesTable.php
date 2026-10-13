<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Support\Media;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('image')->label('')->disk(Media::diskName())->imageSize(56),
                TextColumn::make('name')->label('Kategori')->searchable()->weight('bold')->description(fn ($record): ?string => $record->subtitle),
                TextColumn::make('products_count')->label('Ürün sayısı')->counts('products')->badge(),
                ToggleColumn::make('is_active')->label('Yayında'),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
