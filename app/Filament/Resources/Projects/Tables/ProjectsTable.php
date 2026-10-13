<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Support\Media;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('image')->label('')->disk(Media::diskName())->imageSize(56),
                TextColumn::make('title')->label('Proje')->searchable()->weight('bold'),
                TextColumn::make('type')->label('Tip')->badge(),
                TextColumn::make('location')->label('Konum'),
                ToggleColumn::make('is_active')->label('Yayında'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
