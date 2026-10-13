<x-layouts.site title="Ürünler" description="Havuz kimyasalları, havuz ekipmanları ve havuz otomasyon sistemleri. Kozan Havuz ürün grupları.">
    <x-page-hero title="Ürünlerimiz" subtitle="Havuz kimyasallarından ekipmanlara, akıllı otomasyon sistemlerine kadar ihtiyacınız olan tüm ürünler." image="seed/hero/kimyasal-havuz.jpg" :breadcrumbs="['Ürünler' => null]" />

    {{-- Category quick nav --}}
    <div class="sticky top-20 z-30 border-b border-slate-100 bg-white/95 backdrop-blur lg:top-24">
        <div class="container-site flex gap-2 overflow-x-auto py-3 [scrollbar-width:none]">
            @foreach ($categories as $category)
                <a href="#{{ $category->slug }}" class="flex shrink-0 items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-navy-800 transition hover:border-leaf-500 hover:bg-leaf-50 hover:text-leaf-700">
                    <x-site-icon :name="$category->icon ?: 'droplet'" class="size-4 text-leaf-600" /> {{ $category->name }}
                </a>
            @endforeach
            @if (! empty($site['catalog_pdf']))
                <a href="{{ Media::url($site['catalog_pdf']) }}" target="_blank" class="ml-auto flex shrink-0 items-center gap-2 rounded-full bg-navy-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-navy-800">
                    <x-site-icon name="download" class="size-4" /> Katalog (PDF)
                </a>
            @endif
        </div>
    </div>

    @foreach ($categories as $category)
        <section id="{{ $category->slug }}" @class(['scroll-mt-40 py-16 sm:py-20', 'bg-navy-50/60' => $loop->even])>
            <div class="container-site">
                <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-end">
                    <div class="reveal max-w-2xl">
                        <p class="eyebrow">{{ $category->subtitle }}</p>
                        <h2 class="section-title mt-3">{{ $category->name }}</h2>
                        <p class="mt-4 text-slate-500">{{ $category->description }}</p>
                    </div>
                    <a href="{{ route('products.category', $category) }}" class="btn-outline shrink-0">Kategoriye Git <x-site-icon name="arrow-right" class="size-4" /></a>
                </div>
                <div class="mt-10 grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4">
                    @foreach ($category->products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach

    <x-cta-band />
</x-layouts.site>
