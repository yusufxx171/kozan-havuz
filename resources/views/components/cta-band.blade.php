@php($phoneHref = 'tel:'.preg_replace('/\D+/', '', $site['gsm'] ?? ''))

<section class="container-site py-16 sm:py-20">
    <div class="reveal relative isolate overflow-hidden rounded-[2rem] bg-navy-800 px-6 py-12 sm:px-12 lg:px-16 lg:py-16">
        <img src="{{ Storage::url('seed/hero/selale-havuz.jpg') }}" alt="" class="absolute inset-0 -z-20 size-full object-cover opacity-30">
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-navy-900 via-navy-800/90 to-navy-700/40"></div>
        <div class="grid items-center gap-8 lg:grid-cols-[1fr_auto]">
            <div>
                <p class="eyebrow text-leaf-400">Havuzunuz Emin Ellerde</p>
                <h2 class="mt-3 max-w-2xl text-3xl font-extrabold leading-tight text-white sm:text-4xl">Hayalinizdeki havuz için ücretsiz keşif ve teklif alın.</h2>
                <p class="mt-4 max-w-xl text-navy-100">Projeden uygulamaya, bakım ve teknik desteğe kadar tüm süreçlerde güvenilir iş ortağınız olmaktan gurur duyuyoruz.</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row lg:flex-col">
                <a href="{{ route('contact') }}" class="btn-primary px-8 py-4 text-base">Teklif Alın <x-site-icon name="arrow-right" class="size-5" /></a>
                <a href="{{ $phoneHref }}" class="btn-ghost-light px-8 py-4 text-base"><x-site-icon name="phone" class="size-5" /> {{ $site['gsm'] ?? '' }}</a>
            </div>
        </div>
    </div>
</section>
