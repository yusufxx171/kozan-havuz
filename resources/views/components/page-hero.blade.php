@props(['title', 'subtitle' => null, 'image' => null, 'breadcrumbs' => []])

<section class="relative isolate overflow-hidden bg-navy-900">
    @if ($image)
        <img src="{{ Media::url($image) }}" alt="" class="absolute inset-0 -z-20 size-full object-cover opacity-35">
    @endif
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-navy-950/95 via-navy-900/85 to-navy-800/40"></div>
    <img src="{{ asset('images/logo-white.png') }}" alt="" class="pointer-events-none absolute top-1/2 -right-16 -z-10 hidden w-80 -translate-y-1/2 opacity-[0.06] md:block" aria-hidden="true">

    <div class="container-site py-14 sm:py-20 lg:py-24">
        <nav aria-label="Sayfa yolu" class="mb-5">
            <ol class="flex flex-wrap items-center gap-1.5 text-sm font-medium text-navy-200">
                <li><a href="{{ route('home') }}" class="transition hover:text-white">Anasayfa</a></li>
                @foreach ($breadcrumbs as $label => $url)
                    <li class="flex items-center gap-1.5">
                        <x-site-icon name="chevron-right" class="size-3.5 text-leaf-400" />
                        @if ($url)
                            <a href="{{ $url }}" class="transition hover:text-white">{{ $label }}</a>
                        @else
                            <span class="text-white" aria-current="page">{{ $label }}</span>
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>
        <h1 class="max-w-3xl text-3xl font-extrabold leading-tight text-white sm:text-5xl">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-4 max-w-2xl text-base leading-relaxed text-navy-100 sm:text-lg">{{ $subtitle }}</p>
        @endif
    </div>

    <svg class="absolute inset-x-0 -bottom-px block h-8 w-full text-white sm:h-12" viewBox="0 0 1440 60" preserveAspectRatio="none" aria-hidden="true">
        <path fill="currentColor" d="M0 60V30c180 26 360 30 560 12S940 0 1120 8s260 22 320 30v22Z" />
        <path fill="none" stroke="#589d20" stroke-width="3" d="M0 30c180 26 360 30 560 12S940 0 1120 8s260 22 320 30" />
    </svg>
</section>
