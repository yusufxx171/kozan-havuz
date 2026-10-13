@props(['service'])

<a href="{{ route('services.show', $service) }}" class="group card reveal flex flex-col overflow-hidden transition duration-300 hover:-translate-y-1 hover:shadow-[0_20px_50px_-20px_rgba(0,65,107,0.35)]">
    <div class="relative aspect-[4/3] overflow-hidden">
        <img src="{{ Media::url($service->image) }}" alt="{{ $service->title }}" loading="lazy" class="size-full object-cover transition duration-700 group-hover:scale-110">
        <div class="absolute inset-0 bg-gradient-to-t from-navy-950/50 to-transparent"></div>
    </div>
    <div class="relative flex flex-1 flex-col p-6 pt-9">
        <span class="absolute -top-7 left-6 flex size-14 items-center justify-center rounded-2xl bg-leaf-600 text-white shadow-lg shadow-leaf-600/30 ring-4 ring-white transition group-hover:bg-navy-700">
            <x-site-icon :name="$service->icon ?: 'droplet'" class="size-7" />
        </span>
        <h3 class="text-xl font-bold text-navy-900 transition group-hover:text-leaf-700">{{ $service->title }}</h3>
        <p class="mt-2 flex-1 text-[15px] leading-relaxed text-slate-500">{{ $service->summary }}</p>
        <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-bold text-navy-700 group-hover:text-leaf-700">
            Detaylı Bilgi <x-site-icon name="arrow-right" class="size-4 transition group-hover:translate-x-1" />
        </span>
    </div>
</a>
