@php
    $phoneHref = 'tel:'.preg_replace('/\D+/', '', $site['gsm'] ?? '');
    $navItems = [
        ['label' => 'Kurumsal', 'route' => 'about', 'active' => 'about'],
        ['label' => 'Uygulamalarımız', 'route' => 'services.index', 'active' => 'services.*', 'children' => $navServices->map(fn ($service) => ['label' => $service->title, 'url' => route('services.show', $service)])],
        ['label' => 'Ürünler', 'route' => 'products.index', 'active' => 'products.*', 'children' => $navCategories->map(fn ($category) => ['label' => $category->name, 'url' => route('products.category', $category), 'icon' => $category->icon])],
        ['label' => 'İletişim', 'route' => 'contact', 'active' => 'contact'],
    ];
@endphp

{{-- Top bar --}}
<div class="hidden bg-navy-900 text-sm text-navy-100 md:block">
    <div class="container-site flex h-11 items-center justify-between gap-6">
        <div class="flex items-center gap-6">
            <a href="{{ $phoneHref }}" class="flex items-center gap-2 transition hover:text-white">
                <x-site-icon name="phone" class="size-4 text-leaf-400" /> {{ $site['gsm'] ?? '' }}
            </a>
            <a href="mailto:{{ $site['email'] ?? '' }}" class="flex items-center gap-2 transition hover:text-white">
                <x-site-icon name="mail" class="size-4 text-leaf-400" /> {{ $site['email'] ?? '' }}
            </a>
            <span class="hidden items-center gap-2 lg:flex">
                <x-site-icon name="clock" class="size-4 text-leaf-400" /> {{ $site['working_hours'] ?? '' }}
            </span>
        </div>
        <div class="flex items-center gap-4">
            <span class="hidden font-medium italic text-navy-200 xl:inline">{{ $site['slogan'] ?? '' }}</span>
            @if (! empty($site['instagram']))
                <a href="{{ $site['instagram'] }}" target="_blank" rel="noopener" class="flex items-center gap-2 transition hover:text-white" aria-label="Instagram">
                    <x-site-icon name="instagram" class="size-4" /> <span class="hidden lg:inline">@kozan.havuz</span>
                </a>
            @endif
        </div>
    </div>
</div>

{{-- Main header --}}
<header data-header class="sticky top-0 z-50 border-b border-transparent bg-white/95 backdrop-blur transition-[box-shadow,border-color] duration-300 [&.is-scrolled]:border-slate-100 [&.is-scrolled]:shadow-[0_8px_30px_-12px_rgba(0,65,107,0.18)]">
    <div class="container-site flex h-20 items-center justify-between gap-6 lg:h-24">
        <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-3" aria-label="{{ $site['company_name'] ?? 'Kozan Havuz' }} ana sayfa">
            <img src="{{ asset('images/logo.png') }}" alt="{{ $site['company_name'] ?? 'Kozan Havuz' }} logo" class="h-16 w-auto lg:h-20" width="320" height="310">
        </a>

        <nav class="hidden items-center gap-1 lg:flex" aria-label="Ana menü">
            @foreach ($navItems as $item)
                @php($isActive = request()->routeIs($item['active']))
                @if (! empty($item['children']) && $item['children']->isNotEmpty())
                    <div class="group relative">
                        <a href="{{ route($item['route']) }}" @class([
                            'flex items-center gap-1 rounded-full px-4 py-2.5 text-[15px] font-semibold transition',
                            'text-leaf-700 bg-leaf-50' => $isActive,
                            'text-navy-900 hover:text-leaf-700' => ! $isActive,
                        ])>
                            {{ $item['label'] }}
                            <x-site-icon name="chevron-down" class="size-4 transition group-hover:rotate-180 group-focus-within:rotate-180" />
                        </a>
                        <div class="invisible absolute top-full left-1/2 z-50 w-72 -translate-x-1/2 translate-y-2 pt-3 opacity-0 transition duration-200 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100">
                            <div class="card overflow-hidden p-2">
                                @foreach ($item['children'] as $child)
                                    <a href="{{ $child['url'] }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold text-navy-900 transition hover:bg-leaf-50 hover:text-leaf-700">
                                        <span class="size-1.5 rounded-full bg-leaf-500"></span>
                                        {{ $child['label'] }}
                                    </a>
                                @endforeach
                                <a href="{{ route($item['route']) }}" class="mt-1 flex items-center justify-between rounded-2xl bg-navy-50 px-4 py-3 text-sm font-bold text-navy-700 transition hover:bg-navy-100">
                                    Tümünü Gör <x-site-icon name="arrow-right" class="size-4" />
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route($item['route']) }}" @class([
                        'rounded-full px-4 py-2.5 text-[15px] font-semibold transition',
                        'text-leaf-700 bg-leaf-50' => $isActive,
                        'text-navy-900 hover:text-leaf-700' => ! $isActive,
                    ])>{{ $item['label'] }}</a>
                @endif
            @endforeach
        </nav>

        <div class="flex items-center gap-2">
            <a href="{{ route('contact') }}" class="btn-primary hidden sm:inline-flex">
                Teklif Alın <x-site-icon name="arrow-right" class="size-4" />
            </a>
            <a href="{{ $phoneHref }}" class="flex size-11 items-center justify-center rounded-full bg-navy-50 text-navy-700 sm:hidden" aria-label="Bizi arayın">
                <x-site-icon name="phone" class="size-5" />
            </a>
            <button type="button" data-menu-open class="flex size-11 items-center justify-center rounded-full bg-navy-700 text-white lg:hidden" aria-label="Menüyü aç" aria-controls="mobil-menu" aria-expanded="false">
                <x-site-icon name="menu" class="size-5" />
            </button>
        </div>
    </div>
</header>

{{-- Mobile drawer --}}
<div id="mobil-menu" data-menu class="pointer-events-none fixed inset-0 z-[60] lg:hidden [&.is-open]:pointer-events-auto" aria-hidden="true">
    <div data-menu-close class="absolute inset-0 bg-navy-950/60 opacity-0 backdrop-blur-sm transition duration-300 [[data-menu].is-open_&]:opacity-100"></div>
    <div class="absolute inset-y-0 right-0 flex w-[88%] max-w-sm translate-x-full flex-col bg-white shadow-2xl transition duration-300 [[data-menu].is-open_&]:translate-x-0">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="{{ $site['company_name'] ?? 'Kozan Havuz' }} logo" class="h-14 w-auto">
            </a>
            <button type="button" data-menu-close class="flex size-11 items-center justify-center rounded-full bg-slate-100 text-navy-900" aria-label="Menüyü kapat">
                <x-site-icon name="x" class="size-5" />
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-4" aria-label="Mobil menü">
            <a href="{{ route('home') }}" class="flex items-center rounded-2xl px-4 py-3.5 text-base font-bold text-navy-900 hover:bg-slate-50">Anasayfa</a>
            @foreach ($navItems as $item)
                @if (! empty($item['children']) && $item['children']->isNotEmpty())
                    <details class="group" @if (request()->routeIs($item['active'])) open @endif>
                        <summary class="flex cursor-pointer list-none items-center justify-between rounded-2xl px-4 py-3.5 text-base font-bold text-navy-900 hover:bg-slate-50 [&::-webkit-details-marker]:hidden">
                            {{ $item['label'] }}
                            <x-site-icon name="chevron-down" class="size-5 text-leaf-600 transition group-open:rotate-180" />
                        </summary>
                        <div class="mb-2 ml-4 space-y-0.5 border-l-2 border-leaf-100 pl-3">
                            @foreach ($item['children'] as $child)
                                <a href="{{ $child['url'] }}" class="block rounded-xl px-3 py-2.5 text-[15px] font-medium text-slate-600 hover:bg-leaf-50 hover:text-leaf-700">{{ $child['label'] }}</a>
                            @endforeach
                            <a href="{{ route($item['route']) }}" class="block rounded-xl px-3 py-2.5 text-[15px] font-bold text-navy-700">Tümünü Gör →</a>
                        </div>
                    </details>
                @else
                    <a href="{{ route($item['route']) }}" class="flex items-center rounded-2xl px-4 py-3.5 text-base font-bold text-navy-900 hover:bg-slate-50">{{ $item['label'] }}</a>
                @endif
            @endforeach
        </nav>

        <div class="space-y-3 border-t border-slate-100 p-5 pb-[max(1.25rem,env(safe-area-inset-bottom))]">
            <a href="{{ route('contact') }}" class="btn-primary w-full">Teklif Alın</a>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ $phoneHref }}" class="btn-outline w-full px-3"><x-site-icon name="phone" class="size-4" /> Ara</a>
                <a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}" target="_blank" rel="noopener" class="btn w-full bg-[#25D366] px-3 text-white"><x-site-icon name="whatsapp" class="size-4" /> WhatsApp</a>
            </div>
        </div>
    </div>
</div>
