<?php

namespace Tests\Feature;

use App\Filament\Pages\SiteSettings;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\SiteContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->seed(SiteContentSeeder::class);
        $this->actingAs(User::factory()->create());
    }

    public function test_guests_are_redirected_to_login(): void
    {
        auth()->logout();

        $this->get('/admin')->assertRedirect('/admin/login');
    }

    /**
     * @return array<string, array{string}>
     */
    public static function adminPages(): array
    {
        return collect(['products', 'categories', 'services', 'projects', 'sliders', 'pages', 'brands'])
            ->flatMap(fn (string $resource): array => [
                "{$resource} index" => ["/admin/{$resource}"],
                "{$resource} create" => ["/admin/{$resource}/create"],
            ])
            ->merge([
                'dashboard' => ['/admin'],
                'messages' => ['/admin/contact-messages'],
                'settings' => ['/admin/site-settings'],
            ])
            ->all();
    }

    #[DataProvider('adminPages')]
    public function test_admin_pages_render(string $uri): void
    {
        $this->get($uri)->assertOk();
    }

    public function test_product_edit_page_renders(): void
    {
        $product = Product::query()->firstOrFail();

        $this->get("/admin/products/{$product->slug}/edit")->assertOk()->assertSee($product->name);
    }

    public function test_viewing_a_message_marks_it_as_read(): void
    {
        $message = ContactMessage::query()->create(['name' => 'Test', 'phone' => '0532 000 00 00', 'message' => 'Merhaba']);

        $this->get("/admin/contact-messages/{$message->getKey()}")->assertOk()->assertSee('Merhaba');

        $this->assertNotNull($message->fresh()->read_at);
    }

    public function test_site_settings_can_be_saved(): void
    {
        Livewire::test(SiteSettings::class)
            ->set('data.gsm', '0555 111 22 33')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('0555 111 22 33', Setting::get('gsm'));
    }
}
