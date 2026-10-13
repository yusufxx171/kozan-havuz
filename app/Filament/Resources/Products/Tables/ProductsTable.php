<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('image')->label('')->disk('public')->square()->imageSize(56),
                TextColumn::make('name')->label('Ürün')->searchable()->sortable()->weight('bold')
                    ->description(fn ($record): ?string => $record->summary),
                TextColumn::make('category.name')->label('Kategori')->badge()->sortable(),
                ToggleColumn::make('is_featured')->label('Öne çıkan'),
                ToggleColumn::make('is_active')->label('Yayında'),
                TextColumn::make('updated_at')->label('Güncellendi')->since()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')->label('Kategori')->relationship('category', 'name'),
                TernaryFilter::make('is_active')->label('Yayında'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
