@props(['category'])

<div {{ $attributes->merge(['class' => 'card reveal flex flex-col items-start gap-6 p-8 sm:flex-row sm:items-center sm:justify-between']) }}>
    <div class="flex items-start gap-4">
        <span class="flex size-14 shrink-0 items-center justify-center rounded-2xl bg-leaf-50 text-leaf-600"><x-site-icon :name="$category->icon ?: 'droplet'" class="size-7" /></span>
        <div>
            <h3 class="text-lg font-bold text-navy-900">{{ $category->name }} hakkında bilgi alın</h3>
            <p class="mt-1 text-[15px] text-slate-500">Bu gruptaki ürünlerimiz, teknik özellikleri ve fiyatları için uzman ekibimizle iletişime geçin.</p>
        </div>
    </div>
    <div class="flex shrink-0 flex-wrap gap-3">
        <a href="{{ route('contact') }}" class="btn-primary">Teklif Alın <x-site-icon name="arrow-right" class="size-4" /></a>
        <a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}?text={{ rawurlencode($category->name.' hakkında bilgi almak istiyorum.') }}" target="_blank" rel="noopener" class="btn bg-[#25D366] text-white hover:brightness-95"><x-site-icon name="whatsapp" class="size-4" /> WhatsApp</a>
    </div>
</div>
