<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Support\Fields;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make([
                    Section::make('Uygulama / hizmet bilgileri')->columns(2)->schema([
                        Fields::title('title', 'Başlık'),
                        Fields::slug(),
                        Textarea::make('summary')->label('Kısa açıklama')->rows(2)->maxLength(255)->columnSpanFull(),
                        RichEditor::make('body')->label('Detaylı içerik')->columnSpanFull(),
                        TagsInput::make('features')->label('Neler yapıyoruz? (maddeler)')->placeholder('Madde yazıp Enter’a basın')->columnSpanFull(),
                    ]),
                    Fields::seo(),
                ])->columnSpan(['lg' => 2]),
                Group::make([
                    Section::make('Görünüm')->schema([
                        Fields::icon(),
                        Fields::image('services')->required(),
                    ]),
                    Fields::publishing(featured: true),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
