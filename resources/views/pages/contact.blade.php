@php($phoneHref = 'tel:'.preg_replace('/\D+/', '', $site['gsm'] ?? ''))

<x-layouts.site title="İletişim" description="Kozan Havuz iletişim bilgileri: Altınşehir Mah. Uğur Sok. No:9B Başakşehir / İstanbul. Teklif ve bilgi için bize ulaşın.">
    <x-page-hero title="İletişim" subtitle="Havuzunuzla ilgili her konuda bize ulaşın; ücretsiz keşif ve teklif için hemen yazın." image="seed/hero/villa-havuz.jpg" :breadcrumbs="['İletişim' => null]" />

    <section class="py-12 sm:py-20">
        <div class="container-site grid gap-10 lg:grid-cols-[400px_1fr] lg:gap-12">
            {{-- Contact cards --}}
            <div class="space-y-4">
                @foreach ([
                    ['smartphone', 'Telefon / WhatsApp', $site['gsm'] ?? '', $phoneHref],
                    ['phone', 'Sabit Hat', $site['phone'] ?? '', 'tel:'.preg_replace('/\D+/', '', $site['phone'] ?? '')],
                    ['mail', 'E-posta', $site['email'] ?? '', 'mailto:'.($site['email'] ?? '')],
                    ['mail', 'E-posta', $site['email_secondary'] ?? '', 'mailto:'.($site['email_secondary'] ?? '')],
                    ['map-pin', 'Adres', $site['address'] ?? '', 'https://www.google.com/maps/search/?api=1&query='.rawurlencode($site['address'] ?? '')],
                    ['clock', 'Çalışma Saatleri', $site['working_hours'] ?? '', null],
                ] as [$icon, $label, $value, $href])
                    @continue(blank($value))
                    <{{ $href ? 'a' : 'div' }} @if ($href) href="{{ $href }}" @if (str_starts_with($href, 'http')) target="_blank" rel="noopener" @endif @endif class="card reveal flex items-start gap-4 p-5 transition hover:border-leaf-200">
                        <span class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-leaf-50 text-leaf-600"><x-site-icon :name="$icon" class="size-6" /></span>
                        <span class="min-w-0">
                            <span class="block text-sm font-semibold text-slate-400">{{ $label }}</span>
                            <span class="block font-bold break-words text-navy-900">{{ $value }}</span>
                        </span>
                    </{{ $href ? 'a' : 'div' }}>
                @endforeach

                <a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}?text={{ rawurlencode('Merhaba, bilgi almak istiyorum.') }}" target="_blank" rel="noopener" class="btn w-full bg-[#25D366] py-4 text-base text-white hover:brightness-95">
                    <x-site-icon name="whatsapp" class="size-5" /> WhatsApp ile Hemen Yazın
                </a>
            </div>

            {{-- Form --}}
            <div class="card reveal p-6 sm:p-10">
                <h2 class="text-2xl font-extrabold sm:text-3xl">Teklif ve Bilgi Formu</h2>
                <p class="mt-2 text-slate-500">Formu doldurun, uzman ekibimiz en kısa sürede size dönüş yapsın.</p>

                @if (session('status'))
                    <div class="mt-6 flex items-start gap-3 rounded-2xl border border-leaf-200 bg-leaf-50 p-4 font-semibold text-leaf-800" role="status">
                        <x-site-icon name="check-circle" class="size-6 shrink-0" /> {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" class="mt-8 grid gap-5 sm:grid-cols-2" novalidate>
                    @csrf
                    <div class="hidden" aria-hidden="true">
                        <label>Web sitesi <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                    </div>

                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-navy-900">Ad Soyad *</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name" class="form-input" placeholder="Adınız Soyadınız">
                        @error('name') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="mb-2 block text-sm font-semibold text-navy-900">Telefon *</label>
                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required autocomplete="tel" inputmode="tel" class="form-input" placeholder="05xx xxx xx xx">
                        @error('phone') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-navy-900">E-posta</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" class="form-input" placeholder="ornek@mail.com">
                        @error('email') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="subject" class="mb-2 block text-sm font-semibold text-navy-900">Konu</label>
                        <input id="subject" name="subject" type="text" value="{{ old('subject', $subject) }}" class="form-input" placeholder="Örn. Havuz yapımı" list="konu-onerileri">
                        <datalist id="konu-onerileri">
                            @foreach ($navServices as $service)
                                <option value="{{ $service->title }}"></option>
                            @endforeach
                            @foreach ($navCategories as $category)
                                <option value="{{ $category->name }}"></option>
                            @endforeach
                        </datalist>
                        @error('subject') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="message" class="mb-2 block text-sm font-semibold text-navy-900">Mesajınız *</label>
                        <textarea id="message" name="message" rows="5" required class="form-input resize-y" placeholder="Havuzunuz ve ihtiyacınız hakkında kısaca bilgi verin.">{{ old('message') }}</textarea>
                        @error('message') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="flex items-start gap-3 text-sm text-slate-600">
                            <input type="checkbox" name="kvkk" value="1" @checked(old('kvkk')) class="mt-0.5 size-5 shrink-0 rounded border-slate-300 text-leaf-600 accent-leaf-600">
                            <span><a href="{{ route('pages.show', 'kvkk') }}" target="_blank" class="font-semibold text-leaf-700 underline">KVKK Aydınlatma Metni</a>’ni okudum, kişisel verilerimin talebime dönüş yapılması amacıyla işlenmesini kabul ediyorum.</span>
                        </label>
                        @error('kvkk') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        @error('website') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="btn-primary w-full py-4 text-base sm:w-auto sm:px-10">
                            Gönder <x-site-icon name="send" class="size-5" />
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @if (! empty($site['map_embed']))
        <section class="container-site pb-16 sm:pb-20">
            <div class="reveal overflow-hidden rounded-[2rem] border border-slate-100 shadow-lg">
                <iframe src="{{ $site['map_embed'] }}" title="Kozan Havuz konum haritası" class="h-80 w-full sm:h-[440px]" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
            </div>
        </section>
    @endif
</x-layouts.site>
