<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use Database\Seeders\ExpandedOfferingsSeeder;
use Database\Seeders\SiteContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExpandedOfferingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->seed([SiteContentSeeder::class, ExpandedOfferingsSeeder::class]);
    }

    public function test_new_services_are_listed_and_have_detail_pages(): void
    {
        $this->get('/uygulamalarimiz')
            ->assertOk()
            ->assertSee('Hamam, Sauna ve Buhar Odası Yapımı')
            ->assertSee('Atık Su Arıtma Sistemleri')
            ->assertSee('İçme Suyu Arıtma Sistemleri')
            ->assertSee('Kapalı Devre Su Şartlandırma');

        $this->get('/uygulamalarimiz/icme-suyu-aritma-sistemleri')
            ->assertOk()
            ->assertSee('Ters ozmoz (RO) sistemleri');
    }

    public function test_new_categories_list_products_with_details(): void
    {
        $this->get('/urunler/kategori/gider-acici-kimyasallar')
            ->assertOk()
            ->assertSee('Sıvı Gider Açıcı')
            ->assertSee('Biyolojik Gider ve Yağ Tutucu Bakım Ürünü');

        $this->get('/urunler/flushing-tesisat-temizleme-kimyasali')
            ->assertOk()
            ->assertSee('Kullanım Amacı')
            ->assertSee('Yeni tesisatların devreye alınması');

        $this->get('/urunler/sauna-isiticilari')
            ->assertOk()
            ->assertSee('Kullanım Alanı');
    }

    public function test_empty_categories_show_an_inquiry_box(): void
    {
        Product::query()->whereRelation('category', 'slug', 'buz-onleyici-solusyon')->delete();

        $this->get('/urunler/kategori/buz-onleyici-solusyon')
            ->assertOk()
            ->assertSee('Buz Önleyici Solüsyon hakkında bilgi alın');

        $this->get('/urunler')
            ->assertOk()
            ->assertSee('Buz Önleyici Solüsyon hakkında bilgi alın');
    }

    public function test_secondary_email_is_shown_across_the_site(): void
    {
        $this->get('/iletisim')
            ->assertOk()
            ->assertSee('info@kozangrupticaret.com.tr')
            ->assertSee('mailto:info@kozanhavuz.com.tr', false);
    }

    public function test_seeder_does_not_overwrite_edited_records(): void
    {
        Service::query()->where('slug', 'atik-su-aritma-sistemleri')->update(['title' => 'Düzenlenmiş Başlık']);

        $this->seed(ExpandedOfferingsSeeder::class);

        $this->assertSame('Düzenlenmiş Başlık', Service::query()->where('slug', 'atik-su-aritma-sistemleri')->value('title'));
        $this->assertSame(1, Category::query()->where('slug', 'gider-acici-kimyasallar')->count());
        $this->assertSame(3, Product::query()->whereRelation('category', 'slug', 'gider-acici-kimyasallar')->count());
    }

    public function test_seeder_replaces_generic_images_but_keeps_uploaded_ones(): void
    {
        Service::query()->where('slug', 'atik-su-aritma-sistemleri')->update(['image' => 'seed/misc/makine-dairesi.jpg']);
        Product::query()->where('slug', 'koagulantlar')->update(['image' => 'seed/misc/makine-dairesi.jpg']);
        Product::query()->where('slug', 'kopuk-kesiciler')->update(['image' => 'uploads/kopuk.jpg']);

        $this->seed(ExpandedOfferingsSeeder::class);

        $this->assertSame('seed/offerings/atik-su-aritma-sistemleri.jpg', Service::query()->where('slug', 'atik-su-aritma-sistemleri')->value('image'));
        $this->assertSame('seed/offerings/koagulantlar.jpg', Product::query()->where('slug', 'koagulantlar')->value('image'));
        $this->assertSame('uploads/kopuk.jpg', Product::query()->where('slug', 'kopuk-kesiciler')->value('image'));
        Storage::disk('public')->assertExists('seed/offerings/koagulantlar.jpg');
    }

    public function test_products_without_a_dedicated_image_use_their_category_image(): void
    {
        $this->assertSame('seed/offerings/gider-acici-kimyasallar.jpg', Product::query()->where('slug', 'sivi-gider-acici')->value('image'));
    }
}
