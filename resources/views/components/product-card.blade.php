@props(['product'])

<a href="{{ route('products.show', $product) }}" class="group card reveal flex flex-col overflow-hidden transition duration-300 hover:-translate-y-1 hover:border-leaf-200 hover:shadow-[0_20px_50px_-20px_rgba(0,65,107,0.35)]">
    <div class="relative aspect-square overflow-hidden bg-white p-6">
        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" loading="lazy" class="size-full object-contain transition duration-500 group-hover:scale-105">
        @if ($product->relationLoaded('category') && $product->category)
            <span class="absolute top-4 left-4 rounded-full bg-navy-50 px-3 py-1 text-xs font-semibold text-navy-700">{{ $product->category->name }}</span>
        @endif
    </div>
    <div class="flex flex-1 flex-col border-t border-slate-100 p-5 sm:p-6">
        <h3 class="text-lg font-bold text-navy-900 transition group-hover:text-leaf-700">{{ $product->name }}</h3>
        <p class="mt-2 line-clamp-2 flex-1 text-sm leading-relaxed text-slate-500">{{ $product->summary }}</p>
        <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-bold text-leaf-600">
            Detaylı Bilgi <x-site-icon name="arrow-right" class="size-4 transition group-hover:translate-x-1" />
        </span>
    </div>
</a>
