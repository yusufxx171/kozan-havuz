<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                IconColumn::make('read_at')->label('')->boolean()
                    ->trueIcon('heroicon-o-envelope-open')->falseIcon('heroicon-s-envelope')
                    ->trueColor('gray')->falseColor('success'),
                TextColumn::make('name')->label('Ad Soyad')->searchable()->weight('bold'),
                TextColumn::make('phone')->label('Telefon')->searchable(),
                TextColumn::make('subject')->label('Konu')->placeholder('—')->limit(40),
                TextColumn::make('message')->label('Mesaj')->limit(60)->toggleable(),
                TextColumn::make('created_at')->label('Tarih')->dateTime('d.m.Y H:i')->sortable(),
            ])
            ->filters([
                TernaryFilter::make('read_at')->label('Okunma')->nullable()
                    ->trueLabel('Okunanlar')->falseLabel('Okunmayanlar'),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
