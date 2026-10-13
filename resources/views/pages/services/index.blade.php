<x-layouts.site title="Uygulamalarımız" description="Havuz yapımı, ekipman montajı, su analizi, bakım-onarım, peyzaj ve danışmanlık hizmetlerimiz.">
    <x-page-hero title="Uygulamalarımız" subtitle="Havuzunuzu hayalinizdeki gibi tasarlıyor; projeden uygulamaya, bakımdan teknik desteğe kadar tüm süreçlerde yanınızda oluyoruz." image="seed/hero/gece-havuz.jpg" :breadcrumbs="['Uygulamalarımız' => null]" />

    <section class="py-16 sm:py-24">
        <div class="container-site">
            <x-section-heading eyebrow="Hizmetlerimiz" title="Havuzunuz İçin <span class='text-leaf-600'>Uçtan Uca Çözümler</span>" />
            <div class="mt-14 grid gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <x-service-card :service="$service" />
                @endforeach
            </div>
        </div>
    </section>

    @if ($projects->isNotEmpty())
        <section id="projeler" class="bg-navy-50/60 py-16 sm:py-24">
            <div class="container-site">
                <x-section-heading eyebrow="Projelerimizden Örnekler" title="Her Projede <span class='text-leaf-600'>Aynı Özen</span>" description="Kapalı yüzme havuzlarından villa havuzlarına, taşmalı sonsuz havuzlardan dekoratif havuzlara kadar." />
                <div class="mt-12 grid gap-4 sm:grid-cols-2 sm:gap-6">
                    @foreach ($projects as $project)
                        <figure class="group reveal relative overflow-hidden rounded-[2rem] shadow-lg">
                            <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" loading="lazy" class="aspect-[16/10] w-full object-cover transition duration-700 group-hover:scale-105">
                            <figcaption class="absolute inset-x-0 bottom-0 flex items-end justify-between gap-4 bg-gradient-to-t from-navy-950/90 to-transparent p-6 pt-20">
                                <span>
                                    <span class="block text-sm font-semibold text-leaf-400">{{ $project->type }} · {{ $project->location }}</span>
                                    <span class="block text-xl font-bold text-white">{{ $project->title }}</span>
                                </span>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-cta-band />
</x-layouts.site>
