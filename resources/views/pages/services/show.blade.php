<x-layouts.site :title="$service->seo_title ?: $service->title" :description="$service->seo_description ?: $service->summary" :image="$service->image">
    <x-page-hero :title="$service->title" :subtitle="$service->summary" :image="$service->image" :breadcrumbs="['Uygulamalarımız' => route('services.index'), $service->title => null]" />

    <section class="py-16 sm:py-24">
        <div class="container-site grid gap-12 lg:grid-cols-[1fr_360px] lg:gap-16">
            <article>
                <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}" class="aspect-[16/9] w-full rounded-[2rem] object-cover shadow-xl">
                <div class="prose-site mt-10">{!! $service->body !!}</div>

                @if (! empty($service->features))
                    <h2 class="mt-12 text-2xl font-extrabold">Neler Yapıyoruz?</h2>
                    <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach ($service->features as $feature)
                            <li class="flex items-start gap-3 rounded-2xl border border-slate-100 bg-navy-50/50 p-4 font-semibold text-navy-900">
                                <span class="flex size-7 shrink-0 items-center justify-center rounded-full bg-leaf-600 text-white"><x-site-icon name="check" class="size-4" /></span>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </article>

            <aside class="space-y-6 lg:sticky lg:top-32 lg:self-start">
                <div class="card p-3">
                    <p class="px-4 pt-3 pb-2 text-sm font-bold tracking-wider text-slate-400 uppercase">Diğer Uygulamalar</p>
                    @foreach ($otherServices as $other)
                        <a href="{{ route('services.show', $other) }}" class="flex items-center justify-between gap-3 rounded-2xl px-4 py-3 font-semibold text-navy-900 transition hover:bg-leaf-50 hover:text-leaf-700">
                            <span class="flex items-center gap-3"><x-site-icon :name="$other->icon ?: 'droplet'" class="size-5 text-leaf-600" /> {{ $other->title }}</span>
                            <x-site-icon name="chevron-right" class="size-4 text-slate-400" />
                        </a>
                    @endforeach
                </div>
                <div class="relative overflow-hidden rounded-3xl bg-navy-800 p-7 text-white">
                    <img src="{{ asset('images/logo-white.png') }}" alt="" class="absolute -right-10 -bottom-10 w-44 opacity-10">
                    <p class="text-sm font-semibold text-leaf-400">Ücretsiz keşif</p>
                    <p class="mt-2 text-2xl font-extrabold">{{ $service->title }} için teklif alın</p>
                    <a href="{{ route('contact', ['konu' => $service->title]) }}" class="btn-primary mt-6 w-full">Teklif İste</a>
                    <a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}?text={{ rawurlencode($service->title.' hakkında bilgi almak istiyorum.') }}" target="_blank" rel="noopener" class="btn-ghost-light mt-3 w-full"><x-site-icon name="whatsapp" class="size-4" /> WhatsApp</a>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.site>
