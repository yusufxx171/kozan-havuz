<x-layouts.site :title="$product->seo_title ?: $product->name" :description="$product->seo_description ?: $product->summary" :image="$product->image">
    <x-page-hero :title="$product->name" :image="$product->category->image" :breadcrumbs="['Ürünler' => route('products.index'), $product->category->name => route('products.category', $product->category), $product->name => null]" />

    <section class="py-12 sm:py-20">
        <div class="container-site grid gap-10 lg:grid-cols-2 lg:gap-16">
            <div class="lg:sticky lg:top-32 lg:self-start">
                <div class="card relative overflow-hidden p-8 sm:p-12">
                    <img src="{{ asset('images/logo.png') }}" alt="" class="absolute -right-16 -bottom-16 w-64 opacity-[0.05]" aria-hidden="true">
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="relative mx-auto aspect-square w-full max-w-md object-contain">
                </div>
                @if (! empty($product->gallery))
                    <div class="mt-4 grid grid-cols-4 gap-3">
                        @foreach ($product->gallery as $image)
                            <img src="{{ Storage::url($image) }}" alt="{{ $product->name }}" loading="lazy" class="aspect-square w-full rounded-2xl border border-slate-100 object-contain p-2">
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <a href="{{ route('products.category', $product->category) }}" class="inline-flex items-center gap-2 rounded-full bg-leaf-50 px-4 py-1.5 text-sm font-semibold text-leaf-700">
                    <x-site-icon :name="$product->category->icon ?: 'droplet'" class="size-4" /> {{ $product->category->name }}
                </a>
                <h2 class="mt-4 text-3xl font-extrabold sm:text-4xl">{{ $product->name }}</h2>
                <p class="mt-4 text-lg leading-relaxed text-slate-600">{{ $product->summary }}</p>

                @if (! empty($product->specs))
                    <dl class="mt-8 divide-y divide-slate-100 overflow-hidden rounded-3xl border border-slate-100">
                        @foreach ($product->specs as $spec)
                            <div class="grid gap-1 p-5 sm:grid-cols-[180px_1fr] sm:gap-6">
                                <dt class="font-bold text-navy-800">{{ $spec['label'] ?? '' }}</dt>
                                <dd class="text-[15px] leading-relaxed text-slate-600">{{ $spec['value'] ?? '' }}</dd>
                            </div>
                        @endforeach
                    </dl>
                @endif

                @if ($product->description)
                    <div class="prose-site mt-8">{!! $product->description !!}</div>
                @endif

                <div class="mt-8 rounded-3xl bg-navy-50/70 p-6">
                    <p class="font-bold text-navy-900">Bu ürün hakkında bilgi ve fiyat almak ister misiniz?</p>
                    <p class="mt-1 text-sm text-slate-500">Havuzunuza en uygun ürün ve dozaj için uzman ekibimiz size yardımcı olsun.</p>
                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}?text={{ rawurlencode($product->name.' hakkında bilgi almak istiyorum.') }}" target="_blank" rel="noopener" class="btn w-full bg-[#25D366] text-white hover:brightness-95"><x-site-icon name="whatsapp" class="size-5" /> WhatsApp ile Sor</a>
                        <a href="{{ route('contact', ['konu' => $product->name]) }}" class="btn-navy w-full">Teklif İste</a>
                    </div>
                </div>

                <ul class="mt-8 grid grid-cols-3 gap-3 text-center text-xs font-semibold text-navy-800 sm:text-sm">
                    <li class="rounded-2xl border border-slate-100 p-4"><x-site-icon name="shield-check" class="mx-auto mb-2 size-6 text-leaf-600" /> Kaliteli Ürün</li>
                    <li class="rounded-2xl border border-slate-100 p-4"><x-site-icon name="headset" class="mx-auto mb-2 size-6 text-leaf-600" /> Teknik Destek</li>
                    <li class="rounded-2xl border border-slate-100 p-4"><x-site-icon name="award" class="mx-auto mb-2 size-6 text-leaf-600" /> Garanti</li>
                </ul>
            </div>
        </div>
    </section>

    @if ($relatedProducts->isNotEmpty())
        <section class="bg-navy-50/60 py-16 sm:py-20">
            <div class="container-site">
                <x-section-heading align="left" eyebrow="{{ $product->category->name }}" title="Benzer Ürünler" />
                <div class="mt-10 grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4">
                    @foreach ($relatedProducts as $related)
                        <x-product-card :product="$related" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.site>
