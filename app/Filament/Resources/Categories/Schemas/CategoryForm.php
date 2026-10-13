<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Filament\Support\Fields;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make([
                    Section::make('Kategori bilgileri')->columns(2)->schema([
                        Fields::title('name', 'Kategori adı'),
                        Fields::slug(),
                        TextInput::make('subtitle')->label('Alt başlık')->maxLength(255)->columnSpanFull(),
                        Textarea::make('description')->label('Açıklama')->rows(4)->columnSpanFull(),
                    ]),
                    Fields::seo(),
                ])->columnSpan(['lg' => 2]),
                Group::make([
                    Section::make('Görünüm')->schema([
                        Fields::icon(),
                        Fields::image('categories')->label('Kapak görseli'),
                    ]),
                    Fields::publishing(),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
