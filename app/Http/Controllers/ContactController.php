<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('pages.contact', [
            'subject' => request()->string('konu')->limit(120)->toString(),
        ]);
    }

    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $message = ContactMessage::query()->create([
            ...$request->safe()->only(['name', 'email', 'phone', 'subject', 'message']),
            'ip_address' => $request->ip(),
        ]);

        $recipient = config('mail.contact_recipient') ?: Setting::get('email');

        if ($recipient) {
            try {
                Mail::to($recipient)->send(new NewContactMessage($message));
            } catch (Throwable $exception) {
                // The message is already stored in the admin panel; never fail the visitor's request on mail errors.
                Log::warning('İletişim formu e-postası gönderilemedi.', ['error' => $exception->getMessage()]);
            }
        }

        return to_route('contact')->with('status', 'Mesajınız bize ulaştı. En kısa sürede size dönüş yapacağız.');
    }
}
