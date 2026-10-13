<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Mesaj')->columnSpan(['lg' => 2])->schema([
                    TextEntry::make('subject')->label('Konu')->placeholder('—'),
                    TextEntry::make('message')->label('Mesaj')->prose()->columnSpanFull(),
                ]),
                Section::make('Gönderen')->columnSpan(['lg' => 1])->schema([
                    TextEntry::make('name')->label('Ad Soyad')->weight('bold'),
                    TextEntry::make('phone')->label('Telefon')->copyable()->url(fn ($record): string => 'tel:'.$record->phone),
                    TextEntry::make('email')->label('E-posta')->copyable()->placeholder('—'),
                    TextEntry::make('created_at')->label('Tarih')->dateTime('d.m.Y H:i'),
                    TextEntry::make('ip_address')->label('IP')->placeholder('—'),
                ]),
            ]);
    }
}
