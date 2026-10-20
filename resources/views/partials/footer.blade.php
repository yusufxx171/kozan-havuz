@php($phoneHref = 'tel:'.preg_replace('/\D+/', '', $site['gsm'] ?? ''))

<footer class="relative overflow-hidden bg-navy-900 text-navy-100">
    {{-- Wave edge --}}
    <svg class="block h-10 w-full text-white sm:h-16" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true">
        <path fill="currentColor" d="M0 0h1440v34c-160 34-340 46-540 24S520 6 340 16 80 70 0 58Z" />
        <path fill="none" stroke="#589d20" stroke-width="3" d="M0 58c80 12 160-32 340-42s360 20 560 42 380 10 540-24" />
    </svg>

    <img src="{{ asset('images/logo-white.png') }}" alt="" class="pointer-events-none absolute -right-24 bottom-0 w-96 opacity-[0.04]" aria-hidden="true">

    <div class="container-site relative grid gap-12 py-14 sm:grid-cols-2 lg:grid-cols-12 lg:py-16">
        <div class="lg:col-span-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-white.png') }}" alt="{{ $site['company_name'] ?? 'Kozan Havuz' }}" class="h-20 w-auto">
                <span class="flex flex-col text-2xl leading-none font-extrabold">
                    <span class="text-white">KOZAN</span><span class="text-leaf-400">HAVUZ</span>
                </span>
            </a>
            <p class="mt-6 max-w-sm leading-relaxed text-navy-200">{{ $site['footer_about'] ?? '' }}</p>
            <p class="mt-4 text-lg font-semibold italic text-leaf-400">{{ $site['slogan'] ?? '' }}</p>
        </div>

        <div class="lg:col-span-2">
            <h3 class="text-base font-bold text-white">Kurumsal</h3>
            <ul class="mt-5 space-y-3 text-[15px]">
                <li><a href="{{ route('about') }}" class="transition hover:text-leaf-400">Hakkımızda</a></li>
                <li><a href="{{ route('about') }}#degerlerimiz" class="transition hover:text-leaf-400">Değerlerimiz</a></li>
                <li><a href="{{ route('about') }}#calisma-surecimiz" class="transition hover:text-leaf-400">Çalışma Sürecimiz</a></li>
                <li><a href="{{ route('services.index') }}#projeler" class="transition hover:text-leaf-400">Projelerimiz</a></li>
                <li><a href="{{ route('contact') }}" class="transition hover:text-leaf-400">İletişim</a></li>
            </ul>
        </div>

        <div class="lg:col-span-3">
            <h3 class="text-base font-bold text-white">Uygulamalarımız</h3>
            <ul class="mt-5 space-y-3 text-[15px]">
                @foreach ($navServices as $service)
                    <li><a href="{{ route('services.show', $service) }}" class="transition hover:text-leaf-400">{{ $service->title }}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="sm:col-span-2 lg:col-span-3">
            <h3 class="text-base font-bold text-white">Bize Ulaşın</h3>
            <ul class="mt-5 space-y-4 text-[15px]">
                <li class="flex gap-3">
                    <x-site-icon name="map-pin" class="mt-0.5 size-5 shrink-0 text-leaf-400" />
                    <span>{{ $site['address'] ?? '' }}</span>
                </li>
                <li>
                    <a href="{{ $phoneHref }}" class="flex gap-3 transition hover:text-white">
                        <x-site-icon name="smartphone" class="size-5 shrink-0 text-leaf-400" /> {{ $site['gsm'] ?? '' }}
                    </a>
                </li>
                @if (! empty($site['phone']))
                    <li>
                        <a href="tel:{{ preg_replace('/\D+/', '', $site['phone']) }}" class="flex gap-3 transition hover:text-white">
                            <x-site-icon name="phone" class="size-5 shrink-0 text-leaf-400" /> {{ $site['phone'] }}
                        </a>
                    </li>
                @endif
                <li>
                    <a href="mailto:{{ $site['email'] ?? '' }}" class="flex gap-3 break-all transition hover:text-white">
                        <x-site-icon name="mail" class="size-5 shrink-0 text-leaf-400" /> {{ $site['email'] ?? '' }}
                    </a>
                </li>
                @if (! empty($site['email_secondary']))
                    <li>
                        <a href="mailto:{{ $site['email_secondary'] }}" class="flex gap-3 break-all transition hover:text-white">
                            <x-site-icon name="mail" class="size-5 shrink-0 text-leaf-400" /> {{ $site['email_secondary'] }}
                        </a>
                    </li>
                @endif
                <li class="flex gap-3">
                    <x-site-icon name="clock" class="size-5 shrink-0 text-leaf-400" /> {{ $site['working_hours'] ?? '' }}
                </li>
            </ul>
            @if (! empty($site['instagram']))
                <a href="{{ $site['instagram'] }}" target="_blank" rel="noopener" class="mt-6 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/20">
                    <x-site-icon name="instagram" class="size-4" /> @kozan.havuz
                </a>
            @endif
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="container-site flex flex-col items-center justify-between gap-3 py-6 pb-24 text-sm text-navy-200 sm:flex-row sm:pb-6">
            <p>© {{ now()->year }} {{ $site['company_name'] ?? 'Kozan Havuz' }}. Tüm hakları saklıdır.</p>
            <a href="{{ route('pages.show', 'kvkk') }}" class="transition hover:text-white">KVKK Aydınlatma Metni</a>
        </div>
    </div>
</footer>
