<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\SiteContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SitePagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->seed(SiteContentSeeder::class);
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function pages(): array
    {
        return [
            'home' => ['/', 'Profesyonel Havuz Çözümlerinde'],
            'about' => ['/kurumsal', 'Değerlerimiz'],
            'services' => ['/uygulamalarimiz', 'Havuz Yapımı'],
            'service detail' => ['/uygulamalarimiz/havuz-yapimi', 'Neler Yapıyoruz?'],
            'products' => ['/urunler', 'Havuz Otomasyon Sistemleri'],
            'category' => ['/urunler/kategori/havuz-kimyasallari', 'Klor Tablet'],
            'product detail' => ['/urunler/klor-tablet', 'Kullanım Dozu'],
            'contact' => ['/iletisim', 'Teklif ve Bilgi Formu'],
            'kvkk' => ['/sayfa/kvkk', 'KVKK Aydınlatma Metni'],
        ];
    }

    #[DataProvider('pages')]
    public function test_public_pages_render(string $uri, string $expectedText): void
    {
        $this->get($uri)
            ->assertOk()
            ->assertSee($expectedText)
            ->assertSee('0539 212 06 95');
    }

    public function test_inactive_product_is_not_reachable(): void
    {
        Product::query()->where('slug', 'klor-tablet')->update(['is_active' => false]);

        $this->get('/urunler/klor-tablet')->assertNotFound();
        $this->get('/urunler')->assertDontSee('Klor Tablet');
    }

    public function test_unknown_product_returns_404(): void
    {
        $this->get('/urunler/olmayan-urun')->assertNotFound();
    }
}
