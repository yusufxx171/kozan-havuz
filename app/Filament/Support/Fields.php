<?php

namespace App\Filament\Support;

use App\Support\Media;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

/**
 * Reusable admin form fields shared by the content resources.
 */
class Fields
{
    /**
     * Icons available in the public site's <x-site-icon> set.
     *
     * @var array<string, string>
     */
    public const ICONS = [
        'pool' => 'Havuz', 'droplet' => 'Su damlası', 'waves' => 'Dalga', 'flask' => 'Kimyasal',
        'filter' => 'Filtre', 'cpu' => 'Otomasyon', 'wrench' => 'Anahtar', 'settings' => 'Dişli',
        'test-tube' => 'Test tüpü', 'leaf' => 'Yaprak', 'lightbulb' => 'Aydınlatma', 'shield-check' => 'Kalkan',
        'award' => 'Ödül', 'headset' => 'Destek', 'sparkles' => 'Parıltı', 'blueprint' => 'Proje',
        'flame' => 'Alev', 'thermometer' => 'Termometre', 'recycle' => 'Geri dönüşüm', 'glass-water' => 'Su bardağı',
        'refresh-cw' => 'Döngü', 'snowflake' => 'Kar tanesi', 'spray-can' => 'Sprey', 'pipette' => 'Pipet',
    ];

    /**
     * Title input that fills the slug field while creating a record.
     */
    public static function title(string $name, string $label): TextInput
    {
        return TextInput::make($name)
            ->label($label)
            ->required()
            ->maxLength(255)
            ->live(onBlur: true)
            ->afterStateUpdated(function (Get $get, Set $set, ?string $state, string $operation): void {
                if ($operation === 'create' || blank($get('slug'))) {
                    $set('slug', Str::slug((string) $state));
                }
            });
    }

    public static function slug(): TextInput
    {
        return TextInput::make('slug')
            ->label('URL (slug)')
            ->helperText('Sayfa adresinde görünen kısım. Türkçe karakter ve boşluk kullanmayın.')
            ->required()
            ->maxLength(255)
            ->alphaDash()
            ->unique(ignoreRecord: true);
    }

    public static function image(string $directory, string $name = 'image', string $label = 'Görsel'): FileUpload
    {
        return FileUpload::make($name)
            ->label($label)
            ->image()
            ->imageEditor()
            ->disk(Media::diskName())
            ->directory($directory)
            ->maxSize(5120)
            ->helperText('JPG/PNG/WebP, en fazla 5 MB.');
    }

    public static function icon(): Select
    {
        return Select::make('icon')
            ->label('İkon')
            ->options(self::ICONS)
            ->searchable()
            ->native(false);
    }

    public static function publishing(bool $featured = false, string $featuredLabel = 'Anasayfada göster'): Section
    {
        return Section::make('Yayın')
            ->schema(array_filter([
                Toggle::make('is_active')->label('Yayında')->default(true),
                $featured ? Toggle::make('is_featured')->label($featuredLabel)->default(false) : null,
                TextInput::make('sort_order')->label('Sıra')->numeric()->default(0)->helperText('Küçük sayı önce gösterilir.'),
            ]));
    }

    public static function seo(): Section
    {
        return Section::make('SEO')
            ->description('Boş bırakılırsa başlık ve özet kullanılır.')
            ->collapsed()
            ->schema([
                TextInput::make('seo_title')->label('SEO başlığı')->maxLength(70),
                Textarea::make('seo_description')->label('SEO açıklaması')->rows(3)->maxLength(160),
            ]);
    }
}
