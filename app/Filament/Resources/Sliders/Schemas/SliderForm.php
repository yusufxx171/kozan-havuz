<?php

namespace App\Filament\Resources\Sliders\Schemas;

use App\Filament\Support\Fields;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make([
                    Section::make('Slayt metni')->schema([
                        TextInput::make('eyebrow')->label('Üst başlık')->placeholder('Örn. Çözüm Ortağınız')->maxLength(255),
                        TextInput::make('title')->label('Başlık')->required()->maxLength(255),
                        Textarea::make('description')->label('Açıklama')->rows(3),
                    ]),
                    Section::make('Butonlar')->columns(2)->schema([
                        TextInput::make('primary_button_text')->label('1. buton yazısı'),
                        TextInput::make('primary_button_url')->label('1. buton linki')->placeholder('/urunler'),
                        TextInput::make('secondary_button_text')->label('2. buton yazısı'),
                        TextInput::make('secondary_button_url')->label('2. buton linki')->placeholder('/iletisim'),
                    ]),
                ])->columnSpan(['lg' => 2]),
                Group::make([
                    Section::make('Görsel')->schema([
                        Fields::image('sliders')->required()->helperText('Dikey veya kare görseller en iyi sonucu verir. En fazla 5 MB.'),
                    ]),
                    Fields::publishing(),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
