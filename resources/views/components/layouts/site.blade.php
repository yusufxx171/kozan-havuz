@props([
    'title' => null,
    'description' => null,
    'image' => null,
])

@php
    $pageTitle = $title ? $title.' | '.($site['company_name'] ?? 'Kozan Havuz') : ($site['seo_title'] ?? config('app.name'));
    $pageDescription = $description ?: ($site['seo_description'] ?? null);
    $ogImage = $image ? Media::url($image) : asset('images/logo.png');
@endphp

<!DOCTYPE html>
<html lang="tr" class="scroll-pt-24">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="theme-color" content="#00416b">
        <script>document.documentElement.classList.add('js')</script>

        <title>{{ $pageTitle }}</title>
        @if ($pageDescription)
            <meta name="description" content="{{ $pageDescription }}">
        @endif
        <link rel="canonical" href="{{ url()->current() }}">

        <meta property="og:type" content="website">
        <meta property="og:locale" content="tr_TR">
        <meta property="og:site_name" content="{{ $site['company_name'] ?? 'Kozan Havuz' }}">
        <meta property="og:title" content="{{ $pageTitle }}">
        @if ($pageDescription)
            <meta property="og:description" content="{{ $pageDescription }}">
        @endif
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{ url($ogImage) }}">

        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script type="application/ld+json">
            {!! json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'LocalBusiness',
                'name' => $site['company_name'] ?? 'Kozan Havuz',
                'image' => asset('images/logo.png'),
                'url' => url('/'),
                'telephone' => $site['gsm'] ?? null,
                'email' => $site['email'] ?? null,
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Altınşehir Mah. Uğur Sok. No:9B',
                    'addressLocality' => 'Başakşehir',
                    'addressRegion' => 'İstanbul',
                    'postalCode' => '34775',
                    'addressCountry' => 'TR',
                ],
                'sameAs' => array_values(array_filter([$site['instagram'] ?? null, $site['facebook'] ?? null, $site['youtube'] ?? null])),
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
        </script>
    </head>
    <body class="flex min-h-dvh flex-col">
        {{-- Shared clip-paths for the catalog-style wave image cut --}}
        <svg width="0" height="0" class="absolute" aria-hidden="true">
            <defs>
                <clipPath id="wave-left" clipPathUnits="objectBoundingBox">
                    <path d="M0.2,0 C0.04,0.16 0.17,0.36 0.08,0.54 C0,0.7 0.03,0.88 0.16,1 L1,1 L1,0 Z" />
                </clipPath>
                <clipPath id="wave-bottom" clipPathUnits="objectBoundingBox">
                    <path d="M0,0 L1,0 L1,0.86 C0.8,0.97 0.62,0.84 0.42,0.92 C0.26,0.98 0.12,0.97 0,0.9 Z" />
                </clipPath>
            </defs>
        </svg>

        <a href="#icerik" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-[100] focus:rounded-full focus:bg-white focus:px-4 focus:py-2 focus:font-semibold focus:text-navy-800">İçeriğe geç</a>

        @include('partials.header')

        <main id="icerik" class="flex-1">
            {{ $slot }}
        </main>

        @include('partials.footer')
        @include('partials.floating-actions')
    </body>
</html>
