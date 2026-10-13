<x-layouts.site>
    {{-- ============ HERO SLIDER ============ --}}
    <section data-slider class="relative isolate overflow-hidden bg-gradient-to-br from-white via-white to-navy-50" aria-roledescription="carousel" aria-label="Öne çıkanlar">
        <img src="{{ asset('images/logo.png') }}" alt="" class="pointer-events-none absolute top-10 -left-32 -z-10 hidden w-[520px] opacity-[0.05] lg:block" aria-hidden="true">

        <div class="grid">
            @foreach ($sliders as $slide)
                <div data-slide @class([
                    'col-start-1 row-start-1 transition-opacity duration-700 ease-out',
                    'opacity-0 pointer-events-none [&.is-active]:opacity-100 [&.is-active]:pointer-events-auto [&.is-active]:z-10',
                    'is-active' => $loop->first,
                ]) aria-roledescription="slide" aria-label="{{ $loop->iteration }} / {{ $loop->count }}">
                    {{-- Image --}}
                    <div class="relative h-64 sm:h-96 lg:absolute lg:inset-y-0 lg:right-0 lg:h-auto lg:w-[54%]">
                        <img src="{{ Media::url($slide->image) }}" alt="{{ $slide->title }}"
                             @if (! $loop->first) loading="lazy" @else fetchpriority="high" @endif
                             class="size-full object-cover [clip-path:url(#wave-bottom)] lg:[clip-path:url(#wave-left)]">
                        <svg class="pointer-events-none absolute inset-0 hidden size-full -translate-x-3 lg:block" viewBox="0 0 1 1" preserveAspectRatio="none" aria-hidden="true">
                            <path d="M0.2,0 C0.04,0.16 0.17,0.36 0.08,0.54 C0,0.7 0.03,0.88 0.16,1" fill="none" stroke="#589d20" stroke-width="6" vector-effect="non-scaling-stroke" />
                        </svg>
                        <div class="absolute right-6 bottom-10 hidden size-36 rotate-[-8deg] flex-col items-center justify-center rounded-full border-4 border-white bg-navy-800 text-center text-white shadow-2xl xl:flex">
                            <span class="text-sm italic text-navy-100">Havuzunuz</span>
                            <span class="text-xl font-extrabold text-leaf-400">BİZİMLE</span>
                            <span class="text-base font-extrabold">GÜVENDE</span>
                        </div>
                    </div>

                    {{-- Text --}}
                    <div class="container-site relative">
                        <div class="py-10 sm:py-14 lg:flex lg:min-h-[600px] lg:w-[48%] lg:flex-col lg:justify-center lg:py-20 xl:min-h-[660px]">
                            @if ($slide->eyebrow)
                                <p class="eyebrow">{{ $slide->eyebrow }}</p>
                            @endif
                            <h1 class="mt-4 text-[2rem] leading-[1.1] font-extrabold text-navy-800 sm:text-5xl xl:text-6xl">{{ $slide->title }}</h1>
                            @if ($slide->description)
                                <p class="mt-5 max-w-xl text-base leading-relaxed text-slate-600 sm:text-lg">{{ $slide->description }}</p>
                            @endif
                            <div class="mt-8 flex flex-wrap gap-3">
                                @if ($slide->primary_button_text)
                                    <a href="{{ $slide->primary_button_url }}" class="btn-navy px-7 py-3.5">{{ $slide->primary_button_text }} <x-site-icon name="arrow-right" class="size-4" /></a>
                                @endif
                                @if ($slide->secondary_button_text)
                                    <a href="{{ $slide->secondary_button_url }}" class="btn-primary px-7 py-3.5">{{ $slide->secondary_button_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($sliders->count() > 1)
            <div class="container-site pointer-events-none relative z-20 -mt-6 pb-8 lg:absolute lg:inset-x-0 lg:bottom-8 lg:mt-0 lg:pb-0">
                <div class="pointer-events-auto flex items-center gap-4 lg:w-[48%]">
                    <button type="button" data-slider-prev class="flex size-11 items-center justify-center rounded-full border border-navy-100 bg-white text-navy-700 shadow-sm transition hover:bg-navy-700 hover:text-white" aria-label="Önceki">
                        <x-site-icon name="chevron-left" class="size-5" />
                    </button>
                    <div class="flex items-center gap-2">
                        @foreach ($sliders as $slide)
                            <button type="button" data-slider-dot class="h-2.5 w-2.5 rounded-full bg-navy-200 transition-all duration-300 [&.is-active]:w-8 [&.is-active]:bg-leaf-600 @if ($loop->first) is-active @endif" aria-label="{{ $loop->iteration }}. slayt"></button>
                        @endforeach
                    </div>
                    <button type="button" data-slider-next class="flex size-11 items-center justify-center rounded-full border border-navy-100 bg-white text-navy-700 shadow-sm transition hover:bg-navy-700 hover:text-white" aria-label="Sonraki">
                        <x-site-icon name="chevron-right" class="size-5" />
                    </button>
                </div>
            </div>
        @endif
    </section>

    {{-- ============ FEATURE STRIP ============ --}}
    <section class="relative z-20 bg-navy-50/60 pb-4 lg:bg-transparent lg:pb-0">
        <div class="container-site">
            <div class="card reveal grid grid-cols-2 divide-slate-100 lg:-mt-6 lg:grid-cols-4 lg:divide-x">
                @foreach ([
                    ['shield-check', 'Kalite', 'Yüksek kalite standartları'],
                    ['droplet', 'Güven', 'Güvenilir ürün ve hizmet'],
                    ['settings', 'Tecrübe', 'Yılların bilgi ve tecrübesi'],
                    ['leaf', 'Çevre Dostu', 'Doğaya duyarlı çözümler'],
                ] as [$icon, $title, $text])
                    <div class="flex flex-col items-center gap-3 p-5 text-center sm:flex-row sm:p-7 sm:text-left">
                        <span class="flex size-14 shrink-0 items-center justify-center rounded-2xl bg-leaf-50 text-leaf-600">
                            <x-site-icon :name="$icon" class="size-7" />
                        </span>
                        <span>
                            <span class="block text-base font-bold text-navy-900">{{ $title }}</span>
                            <span class="block text-sm text-slate-500">{{ $text }}</span>
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ ABOUT ============ --}}
    <section class="py-20 sm:py-24">
        <div class="container-site grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div class="reveal relative">
                <div class="overflow-hidden rounded-[2.5rem] rounded-tl-[6rem] shadow-2xl shadow-navy-900/20">
                    <img src="{{ Media::url('seed/hero/gece-havuz.jpg') }}" alt="Kozan Havuz gece aydınlatmalı havuz uygulaması" loading="lazy" class="aspect-[4/3] w-full object-cover">
                </div>
                <div class="absolute -bottom-8 left-4 flex items-center gap-4 rounded-3xl bg-white p-4 pr-6 shadow-xl sm:left-8">
                    <span class="flex size-14 items-center justify-center rounded-2xl bg-navy-700 text-white"><x-site-icon name="headset" class="size-7" /></span>
                    <span>
                        <span class="block text-sm text-slate-500">7/24 Teknik Destek</span>
                        <a href="tel:{{ preg_replace('/\D+/', '', $site['gsm'] ?? '') }}" class="block text-lg font-extrabold text-navy-900">{{ $site['gsm'] ?? '' }}</a>
                    </span>
                </div>
                <div class="absolute -top-5 -right-3 hidden size-28 items-center justify-center rounded-full bg-leaf-600 p-4 text-center text-sm leading-tight font-bold text-white shadow-xl ring-8 ring-white sm:flex">
                    Her projede aynı özen
                </div>
            </div>

            <div class="reveal">
                <p class="eyebrow">Kozan Havuz</p>
                <h2 class="section-title mt-3">Her Havuz Bir <span class="text-leaf-600">Yaşam Alanıdır.</span></h2>
                <p class="mt-5 text-lg leading-relaxed">Havuzunuzu hayalinizdeki gibi tasarlıyor, uzman kadromuz ve kaliteli ürünlerimizle yaşam alanlarınıza değer katıyoruz. Estetik tasarımlarımız, ileri teknoloji ekipmanlarımız ve titiz işçiliğimiz ile hayalinizdeki havuzu gerçeğe dönüştürüyoruz.</p>
                <ul class="mt-8 grid gap-4 sm:grid-cols-2">
                    @foreach (['Projeden teslimata anahtar teslim', 'Kaliteli ve garantili ekipman', 'Doğru kimyasal, doğru sonuç', 'Periyodik bakım ve teknik servis', 'Uzman ve deneyimli kadro', 'Çevreye duyarlı çözümler'] as $item)
                        <li class="flex items-start gap-3 font-semibold text-navy-900">
                            <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-full bg-leaf-100 text-leaf-700"><x-site-icon name="check" class="size-4" /></span>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
                <div class="mt-10 flex flex-wrap gap-3">
                    <a href="{{ route('about') }}" class="btn-navy">Hakkımızda <x-site-icon name="arrow-right" class="size-4" /></a>
                    @if (! empty($site['catalog_pdf']))
                        <a href="{{ Media::url($site['catalog_pdf']) }}" target="_blank" class="btn-outline"><x-site-icon name="download" class="size-4" /> Kataloğu İndir</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ============ PRODUCT GROUPS ============ --}}
    <section class="bg-navy-50/60 py-20 sm:py-24">
        <div class="container-site">
            <x-section-heading eyebrow="Ürünlerimiz" title="Havuzunuz İçin <span class='text-leaf-600'>İhtiyacınız Olan Her Şey</span>" description="Kimyasallardan ekipmanlara, akıllı otomasyon sistemlerine kadar geniş ürün yelpazemizle havuzunuz her zaman hazır." />

            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @foreach ($categories as $category)
                    <a href="{{ route('products.category', $category) }}" class="group reveal relative isolate flex min-h-[340px] flex-col justify-end overflow-hidden rounded-[2rem] p-7 shadow-xl shadow-navy-900/10 sm:min-h-[420px]">
                        <img src="{{ Media::url($category->image) }}" alt="{{ $category->name }}" loading="lazy" class="absolute inset-0 -z-20 size-full object-cover transition duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-navy-950/95 via-navy-900/50 to-transparent"></div>
                        <span class="mb-auto flex size-14 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/30 backdrop-blur">
                            <x-site-icon :name="$category->icon ?: 'droplet'" class="size-7" />
                        </span>
                        <span class="text-sm font-semibold text-leaf-400">{{ $category->products_count }} ürün grubu</span>
                        <h3 class="mt-1 text-2xl font-extrabold text-white">{{ $category->name }}</h3>
                        <p class="mt-2 text-sm text-navy-100">{{ $category->subtitle }}</p>
                        <span class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-white">
                            Ürünleri İncele
                            <span class="flex size-8 items-center justify-center rounded-full bg-leaf-600 transition group-hover:translate-x-1"><x-site-icon name="arrow-right" class="size-4" /></span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ SERVICES ============ --}}
    <section class="py-20 sm:py-24">
        <div class="container-site">
            <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-end">
                <x-section-heading align="left" eyebrow="Uygulamalarımız" title="Projeden Uygulamaya <span class='text-leaf-600'>Tüm Hizmetlerimiz</span>" />
                <a href="{{ route('services.index') }}" class="btn-outline shrink-0">Tüm Uygulamalar <x-site-icon name="arrow-right" class="size-4" /></a>
            </div>
            <div class="mt-12 grid gap-x-6 gap-y-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <x-service-card :service="$service" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ FEATURED PRODUCTS ============ --}}
    <section class="bg-gradient-to-b from-white to-navy-50/60 pb-20 sm:pb-24">
        <div class="container-site">
            <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-end">
                <x-section-heading align="left" eyebrow="Öne Çıkan Ürünler" title="Doğru Kimyasal, <span class='text-leaf-600'>Doğru Sonuç</span>" />
                <a href="{{ route('products.index') }}" class="btn-outline shrink-0">Tüm Ürünler <x-site-icon name="arrow-right" class="size-4" /></a>
            </div>
            <div class="mt-12 grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4">
                @foreach ($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ AUTOMATION BAND ============ --}}
    <section class="relative isolate overflow-hidden bg-navy-900 py-20 text-white sm:py-24">
        <img src="{{ asset('images/logo-white.png') }}" alt="" class="pointer-events-none absolute -bottom-20 -left-20 -z-10 w-96 opacity-[0.04]" aria-hidden="true">
        <div class="container-site grid items-center gap-12 lg:grid-cols-2">
            <div class="reveal">
                <p class="eyebrow text-leaf-400">Akıllı Kontrol, Maksimum Konfor</p>
                <h2 class="section-title mt-3 !text-white">Havuz Otomasyon Sistemleri</h2>
                <p class="mt-5 text-lg leading-relaxed text-navy-100">Havuzunuzun tüm fonksiyonlarını akıllı sistemlerle kontrol altına alarak konforu ve tasarrufu bir arada sunuyoruz.</p>
                <ul class="mt-8 grid gap-3 sm:grid-cols-2">
                    @foreach (['Su kalitesini sürekli kontrol altında tutar', 'Kimyasal tüketimini azaltır', 'Enerji tasarrufu sağlar', 'Kullanımı kolay, güvenli ve pratiktir', 'Uzaktan erişim ve izleme imkânı', 'Ekipmanların ömrünü uzatır'] as $item)
                        <li class="flex items-start gap-3 text-[15px] text-navy-50">
                            <x-site-icon name="check-circle" class="mt-0.5 size-5 shrink-0 text-leaf-400" /> {{ $item }}
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('products.category', 'havuz-otomasyon-sistemleri') }}" class="btn-primary mt-10">Otomasyon Ürünleri <x-site-icon name="arrow-right" class="size-4" /></a>
            </div>
            <div class="reveal relative">
                <img src="{{ Media::url('seed/misc/akilli-kontrol.jpg') }}" alt="Akıllı havuz kontrol uygulaması" loading="lazy" class="w-full rounded-[2rem] shadow-2xl ring-1 ring-white/10">
                <div class="absolute -bottom-6 left-6 grid grid-cols-3 gap-2 rounded-2xl bg-white p-3 text-center text-navy-900 shadow-xl sm:left-10 sm:gap-4 sm:p-4">
                    @foreach ([['pH', '7.2'], ['ORP', '650 mV'], ['Klor', '1.5 ppm']] as [$label, $value])
                        <span class="px-2">
                            <span class="block text-xs font-semibold text-slate-500">{{ $label }}</span>
                            <span class="block text-sm font-extrabold sm:text-base">{{ $value }}</span>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============ WHY US + PROCESS ============ --}}
    <section class="py-20 sm:py-24">
        <div class="container-site">
            <x-section-heading eyebrow="Neden Kozan Havuz?" title="Havuzunuz <span class='text-leaf-600'>Emin Ellerde</span>" description="Kalite, güven ve müşteri memnuniyetini ön planda tutarak havuzlarınızın her zaman en iyi durumda olması için çalışıyoruz." />
            <div class="mt-12 grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-5">
                @foreach ([
                    ['award', 'Uzman Kadro', 'Alanında deneyimli ve eğitimli profesyonel ekip.'],
                    ['shield-check', 'Kalite Odaklı', 'Yüksek kalite standartlarında ürün ve hizmet anlayışı.'],
                    ['smile', 'Müşteri Memnuniyeti', 'İhtiyaçlarınıza özel çözümler, %100 memnuniyet.'],
                    ['leaf', 'Çevreye Duyarlı', 'Doğayı koruyan, sürdürülebilir ve çevre dostu çözümler.'],
                    ['headset', '7/24 Teknik Destek', 'Satış sonrası destek ile her zaman yanınızdayız.'],
                ] as [$icon, $title, $text])
                    <div class="card reveal p-5 text-center transition hover:-translate-y-1 sm:p-6 @if ($loop->last) col-span-2 lg:col-span-1 @endif">
                        <span class="mx-auto flex size-16 items-center justify-center rounded-full bg-navy-50 text-navy-700"><x-site-icon :name="$icon" class="size-8" /></span>
                        <h3 class="mt-4 text-base font-bold text-navy-900 sm:text-lg">{{ $title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ $text }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-20">
                <x-section-heading eyebrow="Çalışma Sürecimiz" title="6 Adımda <span class='text-leaf-600'>Kusursuz Havuz</span>" />
                <ol class="relative mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-6 lg:gap-4">
                    <span class="absolute top-8 right-[8%] left-[8%] hidden border-t-2 border-dashed border-leaf-200 lg:block" aria-hidden="true"></span>
                    @foreach ([
                        ['search', 'Keşif & Analiz', 'İhtiyacınızı analiz ediyor, size en uygun çözümü öneriyoruz.'],
                        ['blueprint', 'Proje & Tasarım', 'Modern ve estetik projelerle hayalinizdeki havuzu tasarlıyoruz.'],
                        ['wrench', 'Uygulama', 'Uzman ekibimizle kaliteli malzeme ve işçilikle uyguluyoruz.'],
                        ['clipboard-check', 'Test & Devreye Alma', 'Tüm testleri yapıp havuzunuzu kullanıma hazır hale getiriyoruz.'],
                        ['leaf', 'Bakım & Destek', 'Düzenli bakım ve teknik destekle ömrünü uzatıyoruz.'],
                        ['headset', '7/24 Yanınızdayız', 'Her zaman ulaşabileceğiniz teknik destek ekibimizle hizmetinizdeyiz.'],
                    ] as [$icon, $title, $text])
                        <li class="reveal relative flex gap-4 lg:flex-col lg:items-center lg:text-center">
                            <span class="relative flex size-16 shrink-0 items-center justify-center rounded-full bg-white text-navy-700 shadow-lg ring-1 ring-slate-100">
                                <x-site-icon :name="$icon" class="size-7" />
                                <span @class(['absolute -top-1 -right-1 flex size-6 items-center justify-center rounded-full text-xs font-bold text-white', 'bg-leaf-600' => $loop->odd, 'bg-navy-700' => $loop->even])>{{ $loop->iteration }}</span>
                            </span>
                            <span>
                                <span class="block font-bold text-navy-900 lg:mt-4">{{ $title }}</span>
                                <span class="mt-1 block text-sm leading-relaxed text-slate-500">{{ $text }}</span>
                            </span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>

    {{-- ============ PROJECTS ============ --}}
    @if ($projects->isNotEmpty())
        <section class="bg-navy-50/60 py-20 sm:py-24">
            <div class="container-site">
                <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-end">
                    <x-section-heading align="left" eyebrow="Projelerimizden Örnekler" title="Her Projede Aynı Özen, <span class='text-leaf-600'>Her Havuzda Aynı Kalite</span>" />
                    <a href="{{ route('services.index') }}#projeler" class="btn-outline shrink-0">Tüm Projeler <x-site-icon name="arrow-right" class="size-4" /></a>
                </div>
                <div class="mt-12 grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4">
                    @foreach ($projects as $project)
                        <figure class="group reveal relative overflow-hidden rounded-3xl shadow-lg">
                            <img src="{{ Media::url($project->image) }}" alt="{{ $project->title }}" loading="lazy" class="aspect-[4/5] w-full object-cover transition duration-700 group-hover:scale-110 sm:aspect-[3/4]">
                            <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-navy-950/90 to-transparent p-4 pt-16 sm:p-5">
                                <span class="block text-xs font-semibold text-leaf-400 sm:text-sm">{{ $project->location }}</span>
                                <span class="block text-sm font-bold text-white sm:text-lg">{{ $project->title }}</span>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-cta-band />
</x-layouts.site>
