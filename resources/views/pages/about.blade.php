<x-layouts.site title="Kurumsal" :description="$page->seo_description ?: 'Kozan Havuz hakkında: değerlerimiz, çalışma sürecimiz ve neden bizi tercih etmelisiniz.'" :image="$page->image">
    <x-page-hero title="Hakkımızda" :subtitle="$page->subtitle" :image="$page->image" :breadcrumbs="['Kurumsal' => null]" />

    <section class="py-16 sm:py-24">
        <div class="container-site grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div class="reveal">
                <p class="eyebrow">Kozan Havuz</p>
                <h2 class="section-title mt-3">Profesyonel Havuz Çözümlerinde <span class="text-leaf-600">Güvenilir İş Ortağınız</span></h2>
                <div class="prose-site mt-6">{!! $page->body !!}</div>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('services.index') }}" class="btn-navy">Uygulamalarımız <x-site-icon name="arrow-right" class="size-4" /></a>
                    <a href="{{ route('contact') }}" class="btn-primary">Bize Ulaşın</a>
                </div>
            </div>
            <div class="reveal relative">
                <img src="{{ Storage::url('seed/hero/selale-havuz.jpg') }}" alt="Kozan Havuz uygulaması" loading="lazy" class="aspect-[4/3] w-full rounded-[2.5rem] rounded-br-[6rem] object-cover shadow-2xl shadow-navy-900/20">
                <div class="absolute -bottom-8 -left-2 rounded-3xl bg-navy-800 p-6 text-white shadow-xl sm:left-8">
                    <p class="text-sm text-navy-100 italic">Suyun huzurunu</p>
                    <p class="text-xl font-extrabold">yaşam alanlarınıza <span class="text-leaf-400">taşıyoruz.</span></p>
                </div>
            </div>
        </div>
    </section>

    <section id="degerlerimiz" class="bg-navy-50/60 py-16 sm:py-24">
        <div class="container-site">
            <x-section-heading eyebrow="Değerlerimiz" title="Bizi Biz Yapan <span class='text-leaf-600'>Değerler</span>" />
            <div class="mt-12 grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-5">
                @foreach ([
                    ['shield-check', 'Güven', 'Güvenilir hizmet anlayışı ile her zaman yanınızdayız.'],
                    ['award', 'Kalite', 'En kaliteli ürün ve hizmetlerle uzun ömürlü çözümler sunarız.'],
                    ['smile', 'Memnuniyet', 'Müşteri memnuniyeti odaklı yaklaşımımızla fark yaratırız.'],
                    ['settings', 'Uzmanlık', 'Deneyimli kadromuzla profesyonel çözümler üretiyoruz.'],
                    ['leaf', 'Sürdürülebilirlik', 'Doğayı koruyan, enerji tasarruflu ve çevre dostu sistemler kullanıyoruz.'],
                ] as [$icon, $title, $text])
                    <div class="card reveal p-5 text-center sm:p-7 @if ($loop->last) col-span-2 lg:col-span-1 @endif">
                        <span @class(['mx-auto flex size-16 items-center justify-center rounded-2xl', 'bg-leaf-50 text-leaf-600' => $loop->odd, 'bg-navy-50 text-navy-700' => $loop->even])><x-site-icon :name="$icon" class="size-8" /></span>
                        <h3 class="mt-4 text-lg font-bold">{{ $title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="calisma-surecimiz" class="py-16 sm:py-24">
        <div class="container-site">
            <x-section-heading eyebrow="Çalışma Sürecimiz" title="Keşiften Teslime, <span class='text-leaf-600'>Teslimden Sonra da</span>" description="Projeden uygulamaya, bakım ve teknik desteğe kadar tüm süreçlerde yanınızdayız." />
            <ol class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['search', 'Keşif & Analiz', 'İhtiyacınızı yerinde analiz ediyor, size en uygun çözüm önerilerini sunuyoruz.'],
                    ['blueprint', 'Proje & Tasarım', 'Modern ve estetik projelerle hayalinizdeki havuzu tasarlıyoruz.'],
                    ['wrench', 'Uygulama', 'Uzman ekibimizle kaliteli malzeme ve işçilikle uyguluyoruz.'],
                    ['clipboard-check', 'Test & Devreye Alma', 'Havuzunuzu tüm testlerden geçirip sorunsuz şekilde kullanıma hazır hale getiriyoruz.'],
                    ['leaf', 'Bakım & Destek', 'Düzenli bakım ve teknik destek ile havuzunuzun ömrünü uzatıyoruz.'],
                    ['headset', '7/24 Yanınızdayız', 'Her zaman ulaşabileceğiniz teknik destek ekibimizle hizmetinizdeyiz.'],
                ] as [$icon, $title, $text])
                    <li class="card reveal relative overflow-hidden p-7">
                        <span class="absolute -top-4 -right-2 text-8xl font-extrabold text-navy-50 select-none">{{ $loop->iteration }}</span>
                        <span class="relative flex size-14 items-center justify-center rounded-2xl bg-navy-700 text-white"><x-site-icon :name="$icon" class="size-7" /></span>
                        <h3 class="relative mt-5 text-lg font-bold">{{ $title }}</h3>
                        <p class="relative mt-2 text-[15px] leading-relaxed text-slate-500">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="bg-navy-900 py-16 sm:py-20">
        <div class="container-site grid grid-cols-2 gap-6 text-center lg:grid-cols-5">
            @foreach ([['shield-check', 'Garantili Ürün ve Hizmet'], ['users', 'Uzman Kadro'], ['award', 'Yüksek Kalite Standartları'], ['clock', 'Zamanında Teslim'], ['smile', 'Müşteri Odaklı Yaklaşım']] as [$icon, $label])
                <div class="reveal @if ($loop->last) col-span-2 lg:col-span-1 @endif">
                    <span class="mx-auto flex size-16 items-center justify-center rounded-full bg-white/10 text-leaf-400 ring-1 ring-white/15"><x-site-icon :name="$icon" class="size-8" /></span>
                    <p class="mt-4 font-bold text-white">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <x-cta-band />
</x-layouts.site>
