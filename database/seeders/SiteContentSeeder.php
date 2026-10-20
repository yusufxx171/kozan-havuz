<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Support\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Initial site content taken from the Kozan Havuz catalog (2026).
 */
class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->publishSeedImages();
        $this->seedSettings();
        $this->seedSliders();
        $this->seedCatalog();
        $this->seedServices();
        $this->seedProjects();
        $this->seedPages();
    }

    /**
     * Copy every bundled seed image (incl. decorative ones used directly in views) to the public disk.
     */
    private function publishSeedImages(): void
    {
        foreach (File::allFiles(database_path('seeders/images')) as $file) {
            $target = 'seed/'.$file->getRelativePathname();

            if (! Media::disk()->exists($target)) {
                Media::disk()->put($target, $file->getContents());
            }
        }
    }

    /**
     * Stored path of a bundled seed image on the public disk.
     */
    private function image(string $relativePath): string
    {
        return 'seed/'.$relativePath;
    }

    private function seedSettings(): void
    {
        Setting::putMany([
            'company_name' => 'Kozan Havuz',
            'company_title' => 'Kozan Grup Danışmanlık San. ve Tic.',
            'slogan' => 'Suyun Gücü, Doğanın Huzuru',
            'tagline' => 'Profesyonel Havuz Çözümlerinde Güvenilir İş Ortağınız',
            'phone' => '0212 801 80 40',
            'gsm' => '0539 212 06 95',
            'whatsapp' => '905392120695',
            'email' => 'info@kozangrupticaret.com.tr',
            'email_secondary' => 'info@kozanhavuz.com.tr',
            'address' => 'Altınşehir Mah. Uğur Sok. No:9B, 34775 Başakşehir / İstanbul',
            'working_hours' => 'Pazartesi – Cumartesi: 09:00 – 18:30',
            'instagram' => 'https://www.instagram.com/kozan.havuz/',
            'facebook' => null,
            'youtube' => null,
            'map_embed' => 'https://www.google.com/maps?q=Alt%C4%B1n%C5%9Fehir+U%C4%9Fur+Sk.+9B+Ba%C5%9Fak%C5%9Fehir+%C4%B0stanbul&output=embed',
            'catalog_pdf' => $this->image('kozan-havuz-katalog.pdf'),
            'footer_about' => 'Havuz yapımından kimyasal tedarikine, ekipman montajından periyodik bakıma kadar havuzunuzla ilgili tüm süreçlerde güvenilir çözüm ortağınız.',
            'seo_title' => 'Kozan Havuz | Havuz Yapımı, Kimyasalları ve Ekipmanları',
            'seo_description' => 'Kozan Havuz; havuz yapımı, havuz kimyasalları, havuz ekipmanları, otomasyon sistemleri, bakım-onarım ve peyzaj çözümleri sunar. Başakşehir / İstanbul.',
        ]);
    }

    private function seedSliders(): void
    {
        $slides = [
            [
                'eyebrow' => 'Çözüm Ortağınız',
                'title' => 'Profesyonel Havuz Çözümlerinde Güvenilir İş Ortağınız',
                'description' => 'Havuz yapımından kimyasal tedarikine, ekipmandan periyodik bakıma kadar tüm süreçlerde yanınızdayız.',
                'image' => 'hero/villa-havuz.jpg',
                'primary_button_text' => 'Uygulamalarımız',
                'primary_button_url' => '/uygulamalarimiz',
            ],
            [
                'eyebrow' => 'Temiz Su, Sağlıklı Yaşam',
                'title' => 'Havuz Kimyasalları',
                'description' => 'Havuz suyunun sağlıklı, temiz ve berrak kalmasını sağlayan yüksek kaliteli kimyasal ürünlerimizle güvenli yüzme keyfi sunuyoruz.',
                'image' => 'hero/kimyasal-havuz.jpg',
                'primary_button_text' => 'Kimyasalları İncele',
                'primary_button_url' => '/urunler/kategori/havuz-kimyasallari',
            ],
            [
                'eyebrow' => 'Kaliteli Ekipman, Mükemmel Havuz',
                'title' => 'Havuz Ekipmanları',
                'description' => 'Yüksek performanslı, uzun ömürlü ve güvenilir ekipmanlarla havuzunuzda mükemmel sirkülasyon ve hijyen.',
                'image' => 'hero/ekipman-havuz.jpg',
                'primary_button_text' => 'Ekipmanları İncele',
                'primary_button_url' => '/urunler/kategori/havuz-ekipmanlari',
            ],
            [
                'eyebrow' => 'Akıllı Kontrol, Maksimum Konfor',
                'title' => 'Havuz Otomasyon Sistemleri',
                'description' => 'Havuzunuzun tüm fonksiyonlarını akıllı sistemlerle kontrol altına alarak konforu ve tasarrufu bir arada sunuyoruz.',
                'image' => 'hero/otomasyon-gece.jpg',
                'primary_button_text' => 'Otomasyonu Keşfet',
                'primary_button_url' => '/urunler/kategori/havuz-otomasyon-sistemleri',
            ],
            [
                'eyebrow' => 'Yeşil Bir Yaşam, Daha Güzel Yarınlar',
                'title' => 'Peyzaj Çözümleri',
                'description' => 'Havuz çevrenizi estetik, fonksiyonel ve sürdürülebilir peyzaj çözümleriyle yaşam alanına dönüştürüyoruz.',
                'image' => 'hero/peyzaj.jpg',
                'primary_button_text' => 'Peyzaj Hizmeti',
                'primary_button_url' => '/uygulamalarimiz/peyzaj-ve-cevre-duzenleme',
            ],
        ];

        foreach ($slides as $index => $slide) {
            Slider::query()->updateOrCreate(['title' => $slide['title']], [
                ...$slide,
                'image' => $this->image($slide['image']),
                'secondary_button_text' => 'Teklif Alın',
                'secondary_button_url' => '/iletisim',
                'sort_order' => $index,
            ]);
        }
    }

    private function seedCatalog(): void
    {
        $catalog = [
            [
                'name' => 'Havuz Kimyasalları',
                'slug' => 'havuz-kimyasallari',
                'icon' => 'flask',
                'image' => 'hero/kimyasal-havuz.jpg',
                'subtitle' => 'Temiz su, sağlıklı yaşam',
                'description' => 'Havuz suyunun sağlıklı, temiz ve berrak kalmasını sağlayan yüksek kaliteli kimyasal ürünlerimiz ile güvenli yüzme keyfi sunuyoruz. Doğru kimyasal, doğru sonuç: düzenli kimyasal bakım, havuz ekipmanlarının ömrünü uzatır.',
                'products' => [
                    ['Klor Tablet', 'klor-tablet', 'Yavaş eriyen tablet formu ile uzun süreli dezenfeksiyon sağlar. Berrak ve hijyenik su için idealdir.', [
                        'Kullanım Amacı' => 'Havuz suyunda yavaş çözünerek sürekli klorlama sağlar. Stabilizatörlü yapısı sayesinde klorun suda kalma süresini uzatarak kararlı bir hijyen ortamı oluşturur.',
                        'Kullanım Dozu' => '100 m³ havuz suyu için günlük yaklaşık 1 tablet (200 gr).',
                        'Uygulama Aralığı' => 'Serbest klor seviyesi 1–3 ppm olacak şekilde düzenli kontrol edilerek uygulanır.',
                    ]],
                    ['Granül Klor', 'granul-klor', 'Hızlı çözünen granül formu ile etkili klorlama sağlar. Şok klorlama için mükemmeldir.', [
                        'Kullanım Amacı' => 'Havuz suyunda hızlı çözünerek bakteri, virüs, mantar ve yosun oluşumunu önler; şok ve günlük klorlamada kullanılır.',
                        'Kullanım Dozu' => '100 m³ havuz suyu için günlük 150–540 gr (ürün tipine göre). Şoklama için 250–555 gr.',
                        'Uygulama Aralığı' => 'Açık havuzlarda 1–3 ppm, kapalı havuzlarda 1–1,5 ppm serbest klor düzeyi korunur.',
                    ]],
                    ['Sıvı Klor', 'sivi-klor', 'Kolay dozajlanan sıvı formu ile hızlı dezenfeksiyon sağlar. Günlük kullanım için uygundur.', [
                        'Kullanım Amacı' => 'Stabilizatör içermeyen sodyum hipoklorit bileşiğidir; dozaj pompaları ile sürekli ve kararlı dezenfeksiyon sağlar.',
                        'Kullanım Dozu' => 'Açık havuzda 100 m³ için 1–3 kg; şok dozlamada 5–10 kg.',
                        'Uygulama Aralığı' => 'pH 7,2–7,6 aralığında, serbest klor düzeyi kontrol edilerek düzenli kullanılır.',
                    ]],
                    ['pH Plus', 'ph-plus', 'pH değerini yükselterek suyun ideal seviyeye gelmesini sağlar.', [
                        'Kullanım Amacı' => 'Havuz suyunun pH değerini hızlı ve güvenli şekilde yükselterek dezenfektanların verimli çalışmasını sağlar.',
                        'Kullanım Dozu' => 'pH değerini 0,1 birim yükseltmek için 100 m³ havuz suyuna 750–1500 gr.',
                        'Uygulama Aralığı' => 'pH değeri 7,2–7,6 aralığında tutulacak şekilde kontrol edilerek uygulanır.',
                    ]],
                    ['pH Minus', 'ph-minus', 'pH değerini düşürerek suyun ideal seviyeye gelmesini sağlar.', [
                        'Kullanım Amacı' => 'Havuz suyunun pH değerini hızlı ve güvenli şekilde düşürerek hijyen ve kullanıcı konforunu korur.',
                        'Kullanım Dozu' => 'pH değerini 0,1 birim düşürmek için 100 m³ havuz suyuna 750–1500 gr.',
                        'Uygulama Aralığı' => 'pH değeri 7,2–7,6 aralığında tutulacak şekilde kontrol edilerek uygulanır.',
                    ]],
                    ['Çöktürücü', 'cokturucu', 'Suda bulunan askıda partikülleri dibe çökertir ve berraklık sağlar.', [
                        'Kullanım Amacı' => 'Bulanıklığa neden olan kir ve partikülleri topaklayarak dibe çökmesini veya filtrede tutulmasını sağlar.',
                        'Kullanım Dozu' => '100 m³ havuz suyu için bulanıklık durumuna göre 140–600 ml.',
                        'Uygulama Aralığı' => 'Haftada bir, filtrasyon öncesi ön arıtma sırasında uygulanır.',
                    ]],
                    ['Yosun Önleyici', 'yosun-onleyici', 'Yosun oluşumunu önler ve suyun temiz kalmasını sağlar.', [
                        'Kullanım Amacı' => 'Oluşmuş yosunu yok eder, yeni yosun oluşumunu kontrol eder ve klor tüketimini optimize eder.',
                        'Kullanım Dozu' => 'İlk kullanım / şok: 25–40 gr/m³. Düzenli kullanım: 7,5–25 gr/m³.',
                        'Uygulama Aralığı' => 'Düzenli kullanımda haftada bir; kış bakımında ayda bir.',
                    ]],
                    ['Parlatıcı', 'parlatici', 'Suyun berraklığını artırır, parlak ve canlı bir görünüm kazandırır.', [
                        'Kullanım Amacı' => 'Topaklama sırasında tutulamayan kolloidal ve ince asılı maddeleri, yağlı ve metal tuzu artıklarını tutar.',
                        'Kullanım Dozu' => '100 m³ havuz suyu için bulanıklık durumuna göre 1–2 L.',
                        'Uygulama Aralığı' => 'Filtrasyon öncesi; havuzun parlaklık ve renk durumuna göre günlük, haftalık veya aylık.',
                    ]],
                ],
            ],
            [
                'name' => 'Havuz Ekipmanları',
                'slug' => 'havuz-ekipmanlari',
                'icon' => 'filter',
                'image' => 'hero/ekipman-havuz.jpg',
                'subtitle' => 'Kaliteli ekipman, mükemmel havuz',
                'description' => 'Yüksek performanslı, uzun ömürlü ve güvenilir havuz ekipmanlarımız ile havuzunuzda mükemmel sirkülasyon ve hijyen sağlıyoruz.',
                'products' => [
                    ['Kum Filtreleri', 'kum-filtreleri', 'Yüksek filtrasyon gücü ile havuz suyunun temiz ve berrak kalmasını sağlar.', [], 'kum-filtresi'],
                    ['Havuz Pompaları', 'havuz-pompalari', 'Güçlü ve sessiz çalışma özelliği ile su sirkülasyonunu etkin şekilde sağlar.', [], 'havuz-pompasi'],
                    ['Vanalar', 'vanalar', 'Dayanıklı ve ergonomik yapısı ile kolay kullanım ve uzun ömür sunar.', [], 'vana'],
                    ['Skimmer', 'skimmer', 'Yüzeydeki kir ve kalıntıların havuz sistemine alınmasını sağlayan etkili çözüm.', []],
                    ['Nozullar', 'nozullar', 'Suyun havuza homojen dağılımını sağlayarak mükemmel sirkülasyon sunar.', [], 'nozul'],
                    ['Izgaralar', 'izgaralar', 'Havuz dip ve taşma ızgaraları ile güvenli ve estetik çözümler sunar.', [], 'izgara'],
                    ['Havuz Süpürgeleri', 'havuz-supurgeleri', 'Havuz tabanının kolay ve etkili temizliği için tasarlanmış süpürge çeşitleri.', [], 'havuz-supurgesi'],
                    ['Vakum Hortumları', 'vakum-hortumlari', 'Esnek ve dayanıklı yapısı ile uzun ömürlü kullanım imkânı sağlar.', [], 'vakum-hortumu'],
                    ['Test Kitleri', 'test-kitleri', 'Suyun kimyasal değerlerini ölçerek ideal dengenin korunmasına yardımcı olur.', [], 'test-kiti'],
                    ['Merdivenler', 'merdivenler', 'Paslanmaz çelikten üretilen merdivenler ile güvenli giriş ve çıkış imkânı sağlar.', [], 'merdiven'],
                ],
            ],
            [
                'name' => 'Havuz Otomasyon Sistemleri',
                'slug' => 'havuz-otomasyon-sistemleri',
                'icon' => 'cpu',
                'image' => 'hero/otomasyon-gece.jpg',
                'subtitle' => 'Akıllı kontrol, maksimum konfor',
                'description' => 'Havuzunuzun tüm fonksiyonlarını akıllı sistemlerle kontrol altına alarak konforu ve tasarrufu bir arada sunuyoruz. Su kalitesi sürekli kontrol altında kalır, kimyasal tüketimi azalır, uzaktan erişim ve izleme imkânı sağlanır.',
                'products' => [
                    ['Tuz Klor Jeneratörleri', 'tuz-klor-jeneratorleri', 'Tuzlu su elektrolizi ile doğal klor üreterek havuz suyunu hijyenik ve temiz tutar.', [], 'tuz-klor-jeneratoru'],
                    ['Dozaj Pompaları', 'dozaj-pompalari', 'Kimyasal dozajlama işlemlerini hassas ve otomatik olarak gerçekleştirir.', [], 'dozaj-pompasi'],
                    ['pH Kontrol Sistemleri', 'ph-kontrol-sistemleri', 'pH seviyesini ideal aralıkta tutarak su kalitesini korur.', [], 'ph-kontrol-sistemi'],
                    ['Redoks (ORP) Kontrol Sistemleri', 'redoks-orp-kontrol-sistemleri', 'Redoks değerini sürekli izler ve klor seviyesini otomatik olarak dengeler.', [], 'redoks-orp-kontrol'],
                ],
            ],
        ];

        foreach ($catalog as $categoryIndex => $data) {
            $category = Category::query()->updateOrCreate(['slug' => $data['slug']], [
                'name' => $data['name'],
                'subtitle' => $data['subtitle'],
                'description' => $data['description'],
                'icon' => $data['icon'],
                'image' => $this->image($data['image']),
                'sort_order' => $categoryIndex,
            ]);

            foreach ($data['products'] as $productIndex => $item) {
                [$name, $slug, $summary, $specs] = $item;
                $imageName = $item[4] ?? $slug;

                Product::query()->updateOrCreate(['slug' => $slug], [
                    'category_id' => $category->id,
                    'name' => $name,
                    'summary' => $summary,
                    'description' => '<p>'.$data['subtitle'].' anlayışıyla; ihtiyacınıza en uygun ürünü seçmeniz, doğru kullanım ve dozaj konusunda uzman ekibimiz size destek olur.</p>',
                    'image' => $this->image('products/'.$imageName.'.jpg'),
                    'specs' => collect($specs)->map(fn (string $value, string $label): array => ['label' => $label, 'value' => $value])->values()->all(),
                    'is_featured' => $productIndex < 4,
                    'sort_order' => $productIndex,
                ]);
            }
        }
    }

    private function seedServices(): void
    {
        $services = [
            ['Havuz Yapımı', 'pool', 'havuz-yapimi', 'Modern tasarım ve mühendislik çözümleri ile size özel havuz projeleri hayata geçiriyoruz.', [
                'Açık ve kapalı yüzme havuzları', 'Villa ve site havuzları', 'Taşmalı / sonsuz havuzlar', 'Betonarme ve su yalıtımı', 'Makine dairesi projelendirme ve imalatı', 'Mevcut havuzların revizyonu',
            ]],
            ['Ekipman Tedariki ve Montajı', 'wrench', 'havuz-ekipmanlari', 'Pompa, filtre, ısıtıcı, aydınlatma ve tüm havuz ekipmanlarında en kaliteli ürünleri sunuyor, montajını yapıyoruz.', [
                'Kum filtreleri ve filtrasyon pompaları', 'Havuz aydınlatma (LED) sistemleri', 'Skimmer, nozul ve ızgaralar', 'Paslanmaz merdiven ve tutamaklar', 'Mekanik PVC tesisat', 'Yedek parça temini',
            ]],
            ['Su Analizi ve Dengeleme', 'test-tube', 'su-analizi', 'Düzenli su analizi ve dengeleme ile havuz suyunun sağlıklı, temiz ve güvenli kalmasını sağlıyoruz.', [
                'pH, klor ve alkalinite ölçümleri', 'Sertlik ve siyanürik asit kontrolü', 'Kimyasal dozaj planlaması', 'Sezon başı su şartlandırma', 'Yönetmeliğe uygun kontrol kayıtları',
            ]],
            ['Bakım ve Onarım', 'settings', 'bakim-onarim', 'Periyodik bakım ve teknik servis hizmetleri ile havuzunuzun sorunsuz çalışmasını sağlıyoruz.', [
                'Haftalık ve aylık rutin bakım', 'Filtre ve kum değişimi', 'Pompa tamir ve bakımı', 'Sezon açılış ve kapanış hazırlığı', 'Kış bakımı', '7/24 teknik destek',
            ]],
            ['Peyzaj ve Çevre Düzenleme', 'leaf', 'peyzaj', 'Havuz çevrenizi estetik, fonksiyonel ve sürdürülebilir peyzaj çözümleri ile yaşam alanına dönüştürüyoruz.', [
                'Doğal ve estetik yeşil alanlar', 'Otomatik sulama sistemleri', 'Mevsimsel ve kalıcı bitkilendirme', 'Dış mekân aydınlatma', 'Düzenli bakım ve destek',
            ]],
            ['Danışmanlık ve Proje', 'waves', 'danismanlik-proje', 'Keşiften projelendirmeye, uygulamadan teslimata kadar tüm süreçlerde profesyonel danışmanlık sağlıyoruz.', [
                'Ücretsiz keşif ve ihtiyaç analizi', 'Havuz tasarım ve projelendirme', 'Mevzuata uygunluk danışmanlığı', 'Havuz operatör eğitimi', 'Anahtar teslim uygulama',
            ]],
        ];

        foreach ($services as $index => [$title, $icon, $imageName, $summary, $features]) {
            Service::query()->updateOrCreate(['slug' => Str::slug($title)], [
                'title' => $title,
                'icon' => $icon,
                'summary' => $summary,
                'body' => '<p>'.$summary.'</p><p>Kozan Havuz olarak her projeye aynı özeni, her havuza aynı kaliteyi sunuyoruz. İhtiyaçlarınızı yerinde analiz ediyor, size en uygun çözümü uzman kadromuzla uyguluyor ve uygulama sonrasında da yanınızda olmaya devam ediyoruz.</p>',
                'features' => $features,
                'image' => $this->image('services/'.$imageName.'.jpg'),
                'sort_order' => $index,
            ]);
        }
    }

    private function seedProjects(): void
    {
        $projects = [
            ['Kapalı Yüzme Havuzu', 'Kapalı Havuz', 'kapali-yuzme-havuzu'],
            ['Villa Havuzu', 'Villa Havuzu', 'villa-havuzu'],
            ['Taşmalı / Sonsuz Havuz', 'Sonsuz Havuz', 'tasmali-sonsuz-havuz'],
            ['Dekoratif Havuz', 'Dekoratif Havuz', 'dekoratif-havuz'],
        ];

        foreach ($projects as $index => [$title, $type, $imageName]) {
            Project::query()->updateOrCreate(['slug' => Str::slug($title)], [
                'title' => $title,
                'type' => $type,
                'location' => 'İstanbul',
                'image' => $this->image('projects/'.$imageName.'.jpg'),
                'sort_order' => $index,
            ]);
        }
    }

    private function seedPages(): void
    {
        Page::query()->updateOrCreate(['slug' => 'hakkimizda'], [
            'title' => 'Hakkımızda',
            'subtitle' => 'Suyun Gücü, Doğanın Huzuru',
            'image' => $this->image('hero/gece-havuz.jpg'),
            'body' => '<p><strong>Kozan Havuz</strong>; havuz sistemleri ve havuz kimyasalları alanında, projeden uygulamaya, bakımdan teknik desteğe kadar tüm süreçlerde güvenilir iş ortağınız olmak için çalışır.</p>'
                .'<p>Havuzunuzu hayalinizdeki gibi tasarlıyor, uzman kadromuz ve kaliteli ürünlerimizle yaşam alanlarınıza değer katıyoruz. Estetik tasarımlarımız, ileri teknoloji ekipmanlarımız ve titiz işçiliğimiz ile hayalinizdeki havuzu gerçeğe dönüştürüyoruz.</p>'
                .'<p>Kalite, güven ve müşteri memnuniyetini ön planda tutarak, havuzlarınızın her zaman en iyi durumda olması için çalışmaya devam ediyoruz.</p>',
        ]);

        Page::query()->updateOrCreate(['slug' => 'kvkk'], [
            'title' => 'KVKK Aydınlatma Metni',
            'body' => '<p>Bu metin, 6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında iletişim formu aracılığıyla paylaştığınız kişisel verilerin (ad soyad, telefon, e-posta ve mesaj içeriği) yalnızca talebinize dönüş yapmak amacıyla işlendiğini bildirmek için hazırlanmıştır.</p>'
                .'<p>Verileriniz üçüncü kişilerle paylaşılmaz; Kanun’un 11. maddesi kapsamındaki haklarınız için bizimle iletişime geçebilirsiniz.</p>',
        ]);
    }
}
