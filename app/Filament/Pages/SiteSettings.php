<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * @property-read Schema $form
 */
class SiteSettings extends Page
{
    protected string $view = 'filament.pages.site-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Site Ayarları';

    protected static ?string $title = 'Site Ayarları';

    protected static string|UnitEnum|null $navigationGroup = 'Ayarlar';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Setting::allValues());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Tabs::make()->persistTabInQueryString()->tabs([
                    Tab::make('Firma & İletişim')->icon(Heroicon::OutlinedBuildingOffice)->schema([
                        Section::make()->columns(2)->schema([
                            TextInput::make('company_name')->label('Firma adı')->required(),
                            TextInput::make('company_title')->label('Ticari ünvan'),
                            TextInput::make('gsm')->label('Cep telefonu')->tel()->required(),
                            TextInput::make('phone')->label('Sabit hat')->tel(),
                            TextInput::make('whatsapp')->label('WhatsApp numarası')->helperText('Ülke koduyla, boşluksuz. Örn. 905392120695')->numeric(),
                            TextInput::make('email')->label('E-posta')->email()->helperText('İletişim formu bildirimleri bu adrese gelir.'),
                            Textarea::make('address')->label('Adres')->rows(2)->columnSpanFull(),
                            TextInput::make('working_hours')->label('Çalışma saatleri'),
                            TextInput::make('map_embed')->label('Google Harita embed linki')->url()->columnSpanFull(),
                        ]),
                    ]),
                    Tab::make('Sosyal Medya')->icon(Heroicon::OutlinedShare)->schema([
                        Section::make()->schema([
                            TextInput::make('instagram')->label('Instagram')->url()->prefixIcon(Heroicon::OutlinedCamera),
                            TextInput::make('facebook')->label('Facebook')->url(),
                            TextInput::make('youtube')->label('YouTube')->url(),
                        ]),
                    ]),
                    Tab::make('Metinler')->icon(Heroicon::OutlinedPencilSquare)->schema([
                        Section::make()->schema([
                            TextInput::make('slogan')->label('Slogan'),
                            TextInput::make('tagline')->label('Tanıtım cümlesi'),
                            Textarea::make('footer_about')->label('Alt bilgi (footer) metni')->rows(3),
                            FileUpload::make('catalog_pdf')->label('Katalog (PDF)')->acceptedFileTypes(['application/pdf'])
                                ->disk('public')->directory('catalog')->maxSize(20480)->downloadable(),
                        ]),
                    ]),
                    Tab::make('SEO')->icon(Heroicon::OutlinedMagnifyingGlass)->schema([
                        Section::make()->schema([
                            TextInput::make('seo_title')->label('Anasayfa başlığı (title)')->maxLength(70),
                            Textarea::make('seo_description')->label('Anasayfa açıklaması (meta description)')->rows(3)->maxLength(160),
                        ]),
                    ]),
                ]),
            ]);
    }

    /**
     * @return array<Action>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')->label('Kaydet')->submit('save'),
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();

        Setting::putMany(collect($state)->map(fn (mixed $value): ?string => is_array($value) ? (array_values($value)[0] ?? null) : $value)->all());

        Notification::make()->title('Ayarlar kaydedildi')->success()->send();
    }
}
