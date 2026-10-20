<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use App\Models\Setting;
use App\Support\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

/**
 * Additional services, product categories and contact details (October 2026).
 *
 * Only creates missing records, so it is safe to run on production:
 * php artisan db:seed --class=ExpandedOfferingsSeeder --force
 */
class ExpandedOfferingsSeeder extends Seeder
{
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
            ['Hamam, Sauna ve Buhar Odası Yapımı', 'hamam-sauna-ve-buhar-odasi-yapimi', 'flame', 'hero/selale-havuz.jpg', 'Otel, spa, spor salonu ve konutlar için hamam, sauna ve buhar odalarını projeden anahtar teslime kadar hayata geçiriyoruz.', [
                'Türk hamamı projelendirme ve yapımı', 'Fin saunası ve kabin sauna kurulumu', 'Buhar odası ve buhar jeneratörü montajı', 'Isıya ve neme dayanıklı yalıtım ve kaplama', 'Isıtıcı, kontrol paneli ve aksesuar temini', 'Periyodik bakım ve teknik servis',
            ]],
            ['Atık Su Arıtma Sistemleri', 'atik-su-aritma-sistemleri', 'recycle', 'misc/makine-dairesi.jpg', 'Evsel ve endüstriyel atık suları yasal deşarj standartlarına uygun şekilde arıtan, geri kazanımı mümkün kılan sistemler kuruyoruz.', [
                'Evsel ve endüstriyel atık su arıtma tesisleri', 'Paket arıtma sistemleri', 'Gri su geri kazanım çözümleri', 'Arıtma kimyasalları temini ve dozajlama', 'Deşarj standartlarına uygunluk analizleri', 'İşletme, bakım ve revizyon hizmetleri',
            ]],
            ['İçme Suyu Arıtma Sistemleri', 'icme-suyu-aritma-sistemleri', 'glass-water', 'services/su-analizi.jpg', 'Konut, site, işletme ve tesisler için sağlıklı, temiz ve güvenli içme suyu sağlayan arıtma sistemleri kuruyoruz.', [
                'Ters ozmoz (RO) sistemleri', 'Kum, karbon ve multimedya filtreler', 'Su yumuşatma sistemleri', 'UV dezenfeksiyon ve klorlama', 'Su analizi ve ihtiyaç tespiti', 'Filtre değişimi ve periyodik bakım',
            ]],
            ['Kapalı Devre Su Şartlandırma', 'kapali-devre-su-sartlandirma', 'refresh-cw', 'misc/teknik-servis.jpg', 'Isıtma ve soğutma tesisatlarında korozyon, kireç ve tortuyu önleyerek sistem verimini ve ekipman ömrünü artırıyoruz.', [
                'Kalorifer ve kazan devreleri şartlandırması', 'Soğutma kulesi ve chiller devreleri', 'Tesisat temizliği (flushing) uygulamaları', 'Korozyon ve kireç önleyici kimyasal dozajı', 'Antifriz ve buz önleyici uygulamalar', 'Düzenli su analizi ve raporlama',
            ]],
        ];

        $nextSortOrder = (int) Service::query()->max('sort_order') + 1;

        foreach ($services as $index => [$title, $slug, $icon, $image, $summary, $features]) {
            Service::query()->firstOrCreate(['slug' => $slug], [
                'title' => $title,
                'icon' => $icon,
                'summary' => $summary,
                'body' => '<p>'.$summary.'</p><p>Kozan Havuz olarak ihtiyaçlarınızı yerinde analiz ediyor, size en uygun çözümü uzman kadromuzla projelendirip uyguluyor ve uygulama sonrasında da bakım ve teknik destekle yanınızda olmaya devam ediyoruz.</p>',
                'features' => $features,
                'image' => $this->image($image),
                'is_featured' => false,
                'sort_order' => $nextSortOrder + $index,
            ]);
        }
    }

    private function seedCategories(): void
    {
        $categories = [
            ['Hamam, Sauna ve Buhar Odası Ekipmanları', 'hamam-sauna-ve-buhar-odasi-ekipmanlari', 'thermometer', 'hero/selale-havuz.jpg', 'Isı ve Buhar Çözümleri', 'Sauna ısıtıcıları, buhar jeneratörleri, kontrol panelleri ve hamam, sauna, buhar odası aksesuarları.'],
            ['Atık Su Arıtma Kimyasalları', 'atik-su-aritma-kimyasallari', 'recycle', 'misc/makine-dairesi.jpg', 'Arıtma ve Geri Kazanım', 'Evsel ve endüstriyel atık su arıtımında kullanılan koagülant, flokülant, pH düzenleyici ve koku giderici kimyasallar.'],
            ['Gider Açıcı Kimyasallar', 'gider-acici-kimyasallar', 'pipette', 'misc/bakim-temizlik.jpg', 'Tesisat Bakımı', 'Lavabo, gider, rögar ve tesisat hatlarındaki yağ, saç ve organik tıkanıklıkları etkili şekilde çözen kimyasallar.'],
            ['Buz Önleyici Solüsyon', 'buz-onleyici-solusyon', 'snowflake', 'hero/kimyasal-havuz.jpg', 'Kış Koruması', 'Isıtma ve soğutma tesisatları, yollar ve yürüme alanları için donmayı ve buzlanmayı önleyen solüsyonlar.'],
            ['Kapalı Devre ve Flushing Kimyasalları', 'kapali-devre-ve-flushing-kimyasallari', 'refresh-cw', 'misc/teknik-servis.jpg', 'Tesisat Şartlandırma', 'Kapalı devre ısıtma ve soğutma sistemleri için korozyon ve kireç önleyici, tesisat temizleme (flushing) kimyasalları.'],
            ['Yüzey Temizleyici Kimyasallar', 'yuzey-temizleyici-kimyasallar', 'spray-can', 'misc/bakim-temizlik.jpg', 'Temizlik ve Hijyen', 'Havuz kenarı, seramik, derz, paslanmaz ve genel yüzeyler için kir, kireç ve yağ çözücü temizlik kimyasalları.'],
        ];

        $nextSortOrder = (int) Category::query()->max('sort_order') + 1;

        foreach ($categories as $index => [$name, $slug, $icon, $image, $subtitle, $description]) {
            Category::query()->firstOrCreate(['slug' => $slug], [
                'name' => $name,
                'subtitle' => $subtitle,
                'description' => $description,
                'icon' => $icon,
                'image' => $this->image($image),
                'sort_order' => $nextSortOrder + $index,
            ]);
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
