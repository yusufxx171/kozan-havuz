<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Support\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

/**
 * Additional services, product categories with their products and contact details (October 2026).
 *
 * Only creates missing records and replaces the generic images of untouched ones (never admin uploads),
 * so it is safe to run on production:
 * php artisan db:seed --class=ExpandedOfferingsSeeder --force
 */
class ExpandedOfferingsSeeder extends Seeder
{
    /**
     * Generic images the first version of this seeder used before dedicated images were added.
     *
     * @var list<string>
     */
    private const PLACEHOLDER_IMAGES = [
        'seed/hero/selale-havuz.jpg',
        'seed/hero/kimyasal-havuz.jpg',
        'seed/misc/makine-dairesi.jpg',
        'seed/misc/teknik-servis.jpg',
        'seed/misc/bakim-temizlik.jpg',
        'seed/services/su-analizi.jpg',
    ];

    public function run(): void
    {
        $this->seedSettings();
        $this->seedServices();
        $this->seedCategories();
    }

    private function seedSettings(): void
    {
        Setting::query()->firstOrCreate(['key' => 'email_secondary'], ['value' => 'info@kozanhavuz.com.tr']);

        Cache::forget(Setting::CACHE_KEY);
    }

    private function seedServices(): void
    {
        $services = [
            ['Hamam, Sauna ve Buhar Odası Yapımı', 'hamam-sauna-ve-buhar-odasi-yapimi', 'flame', 'offerings/hamam-sauna-ve-buhar-odasi-yapimi.jpg', 'Otel, spa, spor salonu ve konutlar için hamam, sauna ve buhar odalarını projeden anahtar teslime kadar hayata geçiriyoruz.', [
                'Türk hamamı projelendirme ve yapımı', 'Fin saunası ve kabin sauna kurulumu', 'Buhar odası ve buhar jeneratörü montajı', 'Isıya ve neme dayanıklı yalıtım ve kaplama', 'Isıtıcı, kontrol paneli ve aksesuar temini', 'Periyodik bakım ve teknik servis',
            ]],
            ['Atık Su Arıtma Sistemleri', 'atik-su-aritma-sistemleri', 'recycle', 'offerings/atik-su-aritma-sistemleri.jpg', 'Evsel ve endüstriyel atık suları yasal deşarj standartlarına uygun şekilde arıtan, geri kazanımı mümkün kılan sistemler kuruyoruz.', [
                'Evsel ve endüstriyel atık su arıtma tesisleri', 'Paket arıtma sistemleri', 'Gri su geri kazanım çözümleri', 'Arıtma kimyasalları temini ve dozajlama', 'Deşarj standartlarına uygunluk analizleri', 'İşletme, bakım ve revizyon hizmetleri',
            ]],
            ['İçme Suyu Arıtma Sistemleri', 'icme-suyu-aritma-sistemleri', 'glass-water', 'offerings/icme-suyu-aritma-sistemleri.jpg', 'Konut, site, işletme ve tesisler için sağlıklı, temiz ve güvenli içme suyu sağlayan arıtma sistemleri kuruyoruz.', [
                'Ters ozmoz (RO) sistemleri', 'Kum, karbon ve multimedya filtreler', 'Su yumuşatma sistemleri', 'UV dezenfeksiyon ve klorlama', 'Su analizi ve ihtiyaç tespiti', 'Filtre değişimi ve periyodik bakım',
            ]],
            ['Kapalı Devre Su Şartlandırma', 'kapali-devre-su-sartlandirma', 'refresh-cw', 'offerings/kapali-devre-su-sartlandirma.jpg', 'Isıtma ve soğutma tesisatlarında korozyon, kireç ve tortuyu önleyerek sistem verimini ve ekipman ömrünü artırıyoruz.', [
                'Kalorifer ve kazan devreleri şartlandırması', 'Soğutma kulesi ve chiller devreleri', 'Tesisat temizliği (flushing) uygulamaları', 'Korozyon ve kireç önleyici kimyasal dozajı', 'Antifriz ve buz önleyici uygulamalar', 'Düzenli su analizi ve raporlama',
            ]],
        ];

        $nextSortOrder = (int) Service::query()->max('sort_order') + 1;

        foreach ($services as $index => [$title, $slug, $icon, $image, $summary, $features]) {
            $service = Service::query()->firstOrCreate(['slug' => $slug], fn (): array => [
                'title' => $title,
                'icon' => $icon,
                'summary' => $summary,
                'body' => '<p>'.$summary.'</p><p>Kozan Havuz olarak ihtiyaçlarınızı yerinde analiz ediyor, size en uygun çözümü uzman kadromuzla projelendirip uyguluyor ve uygulama sonrasında da bakım ve teknik destekle yanınızda olmaya devam ediyoruz.</p>',
                'features' => $features,
                'image' => $this->image($image),
                'is_featured' => false,
                'sort_order' => $nextSortOrder + $index,
            ]);

            $this->replacePlaceholderImage($service, $image);
        }
    }

    private function seedCategories(): void
    {
        $chemical = ['Kullanım Amacı', 'Kullanım Dozu', 'Uygulama Şekli'];
        $equipment = ['Kullanım Alanı', 'Özellikler', 'Seçenekler'];

        $categories = [
            [
                'name' => 'Hamam, Sauna ve Buhar Odası Ekipmanları',
                'slug' => 'hamam-sauna-ve-buhar-odasi-ekipmanlari',
                'icon' => 'thermometer',
                'image' => 'offerings/hamam-sauna-ve-buhar-odasi-ekipmanlari.jpg',
                'subtitle' => 'Isı ve Buhar Çözümleri',
                'description' => 'Sauna ısıtıcıları, buhar jeneratörleri, kontrol panelleri ve hamam, sauna, buhar odası aksesuarları.',
                'labels' => $equipment,
                'products' => [
                    ['Sauna Isıtıcıları', 'sauna-isiticilari', 'Kabin hacmine uygun güçte, hızlı ısınan ve homojen ısı dağılımı sağlayan elektrikli sauna ısıtıcıları.', [
                        'Ev, otel, spa ve spor salonu saunaları.', 'Paslanmaz çelik gövde, taş haznesi, aşırı ısınma koruması.', 'Kabin hacmine göre farklı güç seçenekleri; dahili veya harici kontrollü modeller.',
                    ]],
                    ['Buhar Jeneratörleri', 'buhar-jeneratorleri', 'Buhar odaları ve hamamlar için kesintisiz ve yoğun buhar üreten, güvenli ve verimli buhar jeneratörleri.', [
                        'Buhar odaları, Türk hamamları ve spa alanları.', 'Otomatik su besleme ve tahliye, kireç önleyici sistem, emniyet ventili.', 'Oda hacmine göre farklı kapasiteler; esans dozaj pompası opsiyonu.',
                    ]],
                    ['Sauna ve Buhar Kontrol Panelleri', 'sauna-ve-buhar-kontrol-panelleri', 'Sıcaklık, nem ve çalışma süresini kolayca ayarlamanızı sağlayan dijital kontrol panelleri.', [
                        'Sauna ısıtıcıları ve buhar jeneratörlerinin kontrolü.', 'Dijital ekran, sıcaklık ve süre ayarı, zaman programlama, aydınlatma kontrolü.', 'Duvar tipi ve dokunmatik modeller; cihaz markasına uyumlu seçenekler.',
                    ]],
                    ['Sauna Aksesuarları', 'sauna-aksesuarlari', 'Sauna keyfini tamamlayan kova, kepçe, termometre-higrometre, kum saati ve sauna taşları.', [
                        'Ev ve ticari saunalar.', 'Isıya dayanıklı ahşap ve metal malzemeler; volkanik sauna taşları.', 'Set halinde veya tek tek temin edilebilir.',
                    ]],
                ],
            ],
            [
                'name' => 'Atık Su Arıtma Kimyasalları',
                'slug' => 'atik-su-aritma-kimyasallari',
                'icon' => 'recycle',
                'image' => 'offerings/atik-su-aritma-kimyasallari.jpg',
                'subtitle' => 'Arıtma ve Geri Kazanım',
                'description' => 'Evsel ve endüstriyel atık su arıtımında kullanılan koagülant, flokülant, pH düzenleyici ve koku giderici kimyasallar.',
                'labels' => $chemical,
                'products' => [
                    ['Koagülantlar', 'koagulantlar', 'Atık sudaki askıda katıları ve kolloidal partikülleri destabilize ederek çökelmeye hazırlayan arıtma kimyasalları.', [
                        'Kimyasal arıtma ünitelerinde bulanıklık, KOİ ve fosfor giderimi.', 'Atık suyun karakterine göre jar testi ile belirlenir.', 'Hızlı karıştırma havuzuna dozaj pompası ile sürekli verilir.',
                    ]],
                    ['Polielektrolitler (Flokülant)', 'polielektrolitler-flokulant', 'Küçük partikülleri iri ve ağır floklar hâlinde birleştirerek hızlı çökelme ve çamur susuzlaştırma sağlar.', [
                        'Çöktürme havuzları ve çamur susuzlaştırma (filtre pres, dekantör) üniteleri.', 'Proses ve çamur özelliklerine göre jar testi ile belirlenir.', 'Seyreltik çözelti hazırlanarak yavaş karıştırma bölümüne dozlanır.',
                    ]],
                    ['pH Düzenleyiciler', 'atik-su-ph-duzenleyiciler', 'Atık suyun pH değerini proses ve deşarj limitlerine uygun aralıkta tutan asidik ve bazik kimyasallar.', [
                        'Nötralizasyon ünitelerinde pH ayarı.', 'Giriş ve hedef pH değerine göre, pH kontrol sistemi ile otomatik belirlenir.', 'pH probu kontrollü dozaj pompası ile nötralizasyon tankına verilir.',
                    ]],
                    ['Koku Gidericiler', 'koku-gidericiler', 'Atık su tesisleri, terfi istasyonları ve rögarlarda oluşan kötü kokuları kaynağında kontrol altına alır.', [
                        'Terfi merkezleri, dengeleme havuzları, çamur alanları ve kanalizasyon hatları.', 'Koku yoğunluğu ve debiye göre teknik ekibimizce belirlenir.', 'Doğrudan atık suya dozlama veya ortama püskürtme ile uygulanır.',
                    ]],
                    ['Köpük Kesiciler', 'kopuk-kesiciler', 'Havalandırma havuzlarında ve proses tanklarında oluşan köpüğü hızla dağıtır ve yeniden oluşumunu engeller.', [
                        'Biyolojik arıtma havalandırma havuzları ve proses tankları.', 'Köpük oluşum seviyesine göre düşük dozlarda kullanılır.', 'Köpük oluşan bölgeye dozaj pompası veya püskürtme ile verilir.',
                    ]],
                ],
            ],
            [
                'name' => 'Gider Açıcı Kimyasallar',
                'slug' => 'gider-acici-kimyasallar',
                'icon' => 'pipette',
                'image' => 'offerings/gider-acici-kimyasallar.jpg',
                'subtitle' => 'Tesisat Bakımı',
                'description' => 'Lavabo, gider, rögar ve tesisat hatlarındaki yağ, saç ve organik tıkanıklıkları etkili şekilde çözen kimyasallar.',
                'labels' => $chemical,
                'products' => [
                    ['Sıvı Gider Açıcı', 'sivi-gider-acici', 'Yağ, saç, sabun ve organik atıklardan oluşan tıkanıklıkları hızla çözen yoğun sıvı gider açıcı.', [
                        'Lavabo, banyo, mutfak ve duş giderlerindeki tıkanıklıkların açılması.', 'Tıkanıklığın durumuna göre ürün etiketindeki miktar kadar kullanılır.', 'Gidere dökülür, bekleme süresi sonunda bol sıcak su ile durulanır.',
                    ]],
                    ['Granül Gider Açıcı', 'granul-gider-acici', 'Suyla temas ettiğinde ısı açığa çıkararak inatçı yağ ve organik tıkanıklıkları parçalayan granül gider açıcı.', [
                        'Mutfak giderleri, yağ tutucu çıkışları ve ağır tıkanıklıklar.', 'Tıkanıklığın durumuna göre ürün etiketindeki miktar kadar kullanılır.', 'Gidere dökülür, üzerine bir miktar su eklenir; bekleme sonrası bol suyla durulanır.',
                    ]],
                    ['Biyolojik Gider ve Yağ Tutucu Bakım Ürünü', 'biyolojik-gider-bakim-urunu', 'Enzim ve bakteri kültürleri ile organik atık ve yağları doğal yolla parçalayarak tıkanıklık oluşumunu önler.', [
                        'Gider hatları, yağ tutucular, foseptik ve rögarların düzenli bakımı.', 'Hat uzunluğu ve kullanım yoğunluğuna göre periyodik olarak uygulanır.', 'Kullanımın az olduğu saatlerde gidere veya yağ tutucuya dökülerek uygulanır.',
                    ]],
                ],
            ],
            [
                'name' => 'Buz Önleyici Solüsyon',
                'slug' => 'buz-onleyici-solusyon',
                'icon' => 'snowflake',
                'image' => 'offerings/buz-onleyici-solusyon.jpg',
                'subtitle' => 'Kış Koruması',
                'description' => 'Isıtma ve soğutma tesisatları, yollar ve yürüme alanları için donmayı ve buzlanmayı önleyen solüsyonlar.',
                'labels' => $chemical,
                'products' => [
                    ['Tesisat Antifrizi', 'tesisat-antifrizi', 'Kapalı devre ısıtma, soğutma ve güneş enerjisi sistemlerinde donmayı ve korozyonu önleyen glikol bazlı antifriz.', [
                        'Kalorifer, chiller, fan-coil, ısı pompası ve güneş enerjisi devreleri.', 'İstenen donma noktasına göre sistem hacminin belirli bir oranında kullanılır.', 'Tesisata sirkülasyon pompası veya dolum ekipmanı ile karıştırılarak verilir.',
                    ]],
                    ['Gıda Uyumlu Antifriz', 'gida-uyumlu-antifriz', 'Gıda ve içme suyu ile dolaylı temas riski olan sistemler için düşük toksisiteli, propilen glikol bazlı antifriz.', [
                        'Gıda tesisleri, soğuk hava depoları ve içme suyu ile temas riski olan devreler.', 'İstenen donma noktasına göre sistem hacminin belirli bir oranında kullanılır.', 'Tesisata dolum ekipmanı ile karıştırılarak verilir; konsantrasyon düzenli kontrol edilir.',
                    ]],
                    ['Yol ve Yüzey Buz Çözücü', 'yol-ve-yuzey-buz-cozucu', 'Yürüme yolları, rampa, merdiven ve otopark alanlarında buzlanmayı önleyen ve oluşan buzu hızla çözen solüsyon.', [
                        'Site, otel, işyeri giriş ve otopark alanları, havuz çevresi yürüme yolları.', 'Zemin büyüklüğü ve hava koşullarına göre m² başına belirlenir.', 'Buzlanma öncesi önleyici olarak veya buz oluştuktan sonra yüzeye püskürtülür.',
                    ]],
                ],
            ],
            [
                'name' => 'Kapalı Devre ve Flushing Kimyasalları',
                'slug' => 'kapali-devre-ve-flushing-kimyasallari',
                'icon' => 'refresh-cw',
                'image' => 'offerings/kapali-devre-ve-flushing-kimyasallari.jpg',
                'subtitle' => 'Tesisat Şartlandırma',
                'description' => 'Kapalı devre ısıtma ve soğutma sistemleri için korozyon ve kireç önleyici, tesisat temizleme (flushing) kimyasalları.',
                'labels' => $chemical,
                'products' => [
                    ['Kapalı Devre Koruyucu', 'kapali-devre-koruyucu', 'Kapalı devre su sistemlerinde korozyon, kireçlenme ve tortu oluşumunu önleyerek ekipman ömrünü uzatır.', [
                        'Kalorifer kazanı, kombi, chiller ve fan-coil devreleri.', 'Sistem hacmine göre belirlenir; inhibitör seviyesi periyodik analizle takip edilir.', 'Temizlenmiş tesisata dolum sırasında veya dozaj kabı ile ilave edilir.',
                    ]],
                    ['Flushing (Tesisat Temizleme) Kimyasalı', 'flushing-tesisat-temizleme-kimyasali', 'Yeni ve mevcut tesisatlarda çamur, pas, yağ ve montaj kalıntılarını uzaklaştırarak sistemi devreye almaya hazırlar.', [
                        'Yeni tesisatların devreye alınması ve mevcut tesisatların bakım temizliği.', 'Sistem hacmi ve kirlilik düzeyine göre teknik ekibimizce belirlenir.', 'Tesisatta belirli süre sirküle edilir, ardından sistem boşaltılıp temiz suyla durulanır.',
                    ]],
                    ['Kireç ve Pas Sökücü', 'kirec-ve-pas-sokucu', 'Eşanjör, kazan ve boru yüzeylerindeki kireç ve pas tabakasını çözerek ısı transfer verimini geri kazandırır.', [
                        'Plakalı eşanjörler, kazanlar, boyler ve ısıtma-soğutma serpantinleri.', 'Kireç kalınlığı ve ekipman hacmine göre belirlenir.', 'Sirkülasyon pompası ile ekipman içinde dolaştırılır, ardından nötralize edilip durulanır.',
                    ]],
                    ['Kapalı Devre Biyositi', 'kapali-devre-biyositi', 'Kapalı devre ve soğutma sistemlerinde bakteri, yosun ve biyofilm oluşumunu kontrol altına alır.', [
                        'Kapalı devre soğutma sistemleri, soğutma kuleleri ve proses suları.', 'Sistem hacmi ve mikrobiyolojik yüke göre periyodik olarak uygulanır.', 'Dozaj pompası ile veya şok uygulama şeklinde sisteme verilir.',
                    ]],
                ],
            ],
            [
                'name' => 'Yüzey Temizleyici Kimyasallar',
                'slug' => 'yuzey-temizleyici-kimyasallar',
                'icon' => 'spray-can',
                'image' => 'offerings/yuzey-temizleyici-kimyasallar.jpg',
                'subtitle' => 'Temizlik ve Hijyen',
                'description' => 'Havuz kenarı, seramik, derz, paslanmaz ve genel yüzeyler için kir, kireç ve yağ çözücü temizlik kimyasalları.',
                'labels' => $chemical,
                'products' => [
                    ['Kireç ve Pas Çözücü Yüzey Temizleyici', 'kirec-ve-pas-cozucu-yuzey-temizleyici', 'Seramik, derz ve havuz kenarı yüzeylerindeki kireç, pas ve mineral birikintilerini etkili şekilde çözer.', [
                        'Havuz kenarı, seramik, derz, duş ve ıslak hacim yüzeyleri.', 'Kirlilik düzeyine göre saf veya suyla seyreltilerek kullanılır.', 'Yüzeye uygulanır, kısa süre bekletilip fırçalanır ve bol suyla durulanır.',
                    ]],
                    ['Su Hattı (Yağ Bandı) Temizleyici', 'su-hatti-yag-bandi-temizleyici', 'Havuz su seviyesi çizgisinde biriken yağ, güneş kremi ve kir bandını kolayca temizler.', [
                        'Havuz su seviyesi çizgisi, taşma kanalları ve skimmer çevresi.', 'Kirlilik düzeyine göre sünger veya bez ile doğrudan uygulanır.', 'Kirli bölgeye uygulanıp silinir; havuz suyu dengesini bozmayacak şekilde kullanılır.',
                    ]],
                    ['Paslanmaz Yüzey Temizleyici', 'paslanmaz-yuzey-temizleyici', 'Paslanmaz merdiven, tutamak ve ekipman yüzeylerindeki lekeleri temizler, parlaklık kazandırır.', [
                        'Havuz merdivenleri, tutamaklar, mutfak ve endüstriyel paslanmaz yüzeyler.', 'Yüzeye ince bir tabaka hâlinde uygulanır.', 'Yumuşak bez ile uygulanıp silinir, gerekirse durulanır.',
                    ]],
                    ['Genel Amaçlı Yüzey Temizleyici', 'genel-amacli-yuzey-temizleyici', 'Yağ ve kiri hızla çözen, tüm su ile yıkanabilir sert yüzeylerde kullanılabilen alkali temizleyici.', [
                        'Zemin, duvar, soyunma odası, makine dairesi ve genel alanlar.', 'Kirlilik düzeyine göre suyla seyreltilerek kullanılır.', 'Paspas, fırça veya yer yıkama makinesi ile uygulanır.',
                    ]],
                ],
            ],
        ];

        $nextSortOrder = (int) Category::query()->max('sort_order') + 1;

        foreach ($categories as $index => $data) {
            $category = Category::query()->firstOrCreate(['slug' => $data['slug']], fn (): array => [
                'name' => $data['name'],
                'subtitle' => $data['subtitle'],
                'description' => $data['description'],
                'icon' => $data['icon'],
                'image' => $this->image($data['image']),
                'sort_order' => $nextSortOrder + $index,
            ]);

            $this->replacePlaceholderImage($category, $data['image']);

            foreach ($data['products'] as $productIndex => [$name, $slug, $summary, $specValues]) {
                $productImage = File::exists(database_path("seeders/images/offerings/{$slug}.jpg")) ? "offerings/{$slug}.jpg" : $data['image'];

                $product = Product::query()->firstOrCreate(['slug' => $slug], fn (): array => [
                    'category_id' => $category->id,
                    'name' => $name,
                    'summary' => $summary,
                    'description' => '<p>'.$summary.'</p><p>İhtiyacınıza en uygun ürünü seçmeniz, doğru kullanım ve dozaj konusunda uzman ekibimiz size destek olur.</p>',
                    'image' => $this->image($productImage),
                    'specs' => collect($data['labels'])->zip($specValues)->map(fn ($pair): array => ['label' => $pair[0], 'value' => $pair[1]])->all(),
                    'is_featured' => false,
                    'sort_order' => $productIndex,
                ]);

                $this->replacePlaceholderImage($product, $productImage);
            }
        }
    }

    /**
     * Swap the generic image the first version of this seeder assigned for the dedicated one,
     * leaving images uploaded from the admin panel untouched.
     */
    private function replacePlaceholderImage(Service|Category|Product $record, string $relativePath): void
    {
        if (in_array($record->image, self::PLACEHOLDER_IMAGES, true)) {
            $record->update(['image' => $this->image($relativePath)]);
        }
    }

    /**
     * Publish a bundled seed image to the public disk (if missing) and return its stored path.
     */
    private function image(string $relativePath): string
    {
        $target = 'seed/'.$relativePath;
        $source = database_path('seeders/images/'.$relativePath);

        if (File::exists($source) && ! Media::disk()->exists($target)) {
            Media::disk()->put($target, File::get($source));
        }

        return $target;
    }
}
