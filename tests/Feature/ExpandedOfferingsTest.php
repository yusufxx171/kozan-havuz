<?php

namespace Tests\Feature;

use App\Models\Category;
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

    public function test_empty_categories_show_an_inquiry_box(): void
    {
        $this->get('/urunler/kategori/buz-onleyici-solusyon')
            ->assertOk()
            ->assertSee('Buz Önleyici Solüsyon hakkında bilgi alın');

        $this->get('/urunler')
            ->assertOk()
            ->assertSee('Yüzey Temizleyici Kimyasallar')
            ->assertSee('Gider Açıcı Kimyasallar hakkında bilgi alın');
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
    }
}
