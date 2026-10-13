<?php

namespace Tests\Feature;

use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, string>
     */
    private function validPayload(): array
    {
        return [
            'name' => 'Ayşe Yılmaz',
            'phone' => '0532 000 00 00',
            'email' => 'ayse@example.com',
            'subject' => 'Havuz Yapımı',
            'message' => 'Villa havuzu için keşif rica ediyorum.',
            'kvkk' => '1',
        ];
    }

    public function test_valid_message_is_stored_and_emailed(): void
    {
        Mail::fake();
        Setting::putMany(['email' => 'info@kozanhavuz.test']);

        $this->post('/iletisim', $this->validPayload())
            ->assertRedirect('/iletisim')
            ->assertSessionHas('status');

        $this->assertDatabaseHas('contact_messages', ['name' => 'Ayşe Yılmaz', 'subject' => 'Havuz Yapımı']);
        Mail::assertSent(NewContactMessage::class, fn (NewContactMessage $mail): bool => $mail->hasTo('info@kozanhavuz.test'));
    }

    public function test_required_fields_and_kvkk_consent_are_validated(): void
    {
        $this->post('/iletisim', [])
            ->assertSessionHasErrors(['name', 'phone', 'message', 'kvkk']);

        $this->assertSame(0, ContactMessage::query()->count());
    }

    public function test_honeypot_submissions_are_rejected(): void
    {
        $this->post('/iletisim', [...$this->validPayload(), 'website' => 'http://spam.example'])
            ->assertSessionHasErrors('website');

        $this->assertSame(0, ContactMessage::query()->count());
    }
}
