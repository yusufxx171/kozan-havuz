<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Filament\Support\Fields;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make([
                    Section::make('Sayfa')->columns(2)->schema([
                        Fields::title('title', 'Başlık'),
                        Fields::slug(),
                        TextInput::make('subtitle')->label('Alt başlık')->columnSpanFull(),
                        RichEditor::make('body')->label('İçerik')->columnSpanFull(),
                    ]),
                    Fields::seo(),
                ])->columnSpan(['lg' => 2]),
                Group::make([
                    Section::make('Görsel')->schema([Fields::image('pages')->label('Banner görseli')]),
                    Section::make('Yayın')->schema([Toggle::make('is_active')->label('Yayında')->default(true)]),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
