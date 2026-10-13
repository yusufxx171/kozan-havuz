<x-mail::message>
# Yeni iletişim mesajı

**Ad Soyad:** {{ $contactMessage->name }}
**Telefon:** {{ $contactMessage->phone }}
@if ($contactMessage->email)
**E-posta:** {{ $contactMessage->email }}
@endif
@if ($contactMessage->subject)
**Konu:** {{ $contactMessage->subject }}
@endif

<x-mail::panel>
{{ $contactMessage->message }}
</x-mail::panel>

<x-mail::button :url="url('/admin/contact-messages')">
Yönetim panelinde görüntüle
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
