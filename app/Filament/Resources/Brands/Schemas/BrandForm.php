<?php

namespace App\Filament\Resources\Brands\Schemas;

use App\Filament\Support\Fields;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Marka')->schema([
                    TextInput::make('name')->label('Marka adı')->required()->maxLength(255),
                    TextInput::make('url')->label('Web sitesi')->url()->maxLength(255),
                    Fields::image('brands', 'logo', 'Logo'),
                ])->columnSpan(['lg' => 2]),
                Fields::publishing()->columnSpan(['lg' => 1]),
            ]);
    }
}
