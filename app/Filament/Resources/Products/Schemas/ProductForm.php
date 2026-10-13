<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Filament\Support\Fields;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make([
                    Section::make('Ürün bilgileri')->columns(2)->schema([
                        Fields::title('name', 'Ürün adı'),
                        Fields::slug(),
                        Textarea::make('summary')->label('Kısa açıklama')->rows(2)->maxLength(255)->columnSpanFull()
                            ->helperText('Ürün kartlarında ve listede görünür.'),
                        RichEditor::make('description')->label('Detaylı açıklama')->columnSpanFull(),
                    ]),
                    Section::make('Teknik bilgiler')
                        ->description('Örn. Kullanım Amacı, Kullanım Dozu, Uygulama Aralığı, Ölçüler…')
                        ->schema([
                            Repeater::make('specs')
                                ->hiddenLabel()
                                ->schema([
                                    TextInput::make('label')->label('Başlık')->required(),
                                    Textarea::make('value')->label('Değer')->rows(2)->required(),
                                ])
                                ->columns(2)
                                ->reorderable()
                                ->collapsible()
                                ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                                ->addActionLabel('Bilgi ekle')
                                ->defaultItems(0),
                        ]),
                    Fields::seo(),
                ])->columnSpan(['lg' => 2]),

                Group::make([
                    Section::make('Kategori')->schema([
                        Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),
                    Section::make('Görseller')->schema([
                        Fields::image('products')->label('Ana görsel')->required(),
                        FileUpload::make('gallery')->label('Galeri')->image()->multiple()->reorderable()
                            ->disk('public')->directory('products/gallery')->maxFiles(8)->maxSize(5120),
                    ]),
                    Fields::publishing(featured: true, featuredLabel: 'Öne çıkan ürün'),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
