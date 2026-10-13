<x-layouts.site :title="$category->seo_title ?: $category->name" :description="$category->seo_description ?: $category->description" :image="$category->image">
    <x-page-hero :title="$category->name" :subtitle="$category->description" :image="$category->image" :breadcrumbs="['Ürünler' => route('products.index'), $category->name => null]" />

    <section class="py-12 sm:py-20">
        <div class="container-site">
            <div class="-mx-4 flex gap-2 overflow-x-auto px-4 pb-2 [scrollbar-width:none] sm:mx-0 sm:flex-wrap sm:px-0">
                @foreach ($categories as $item)
                    <a href="{{ route('products.category', $item) }}" @class([
                        'flex shrink-0 items-center gap-2 rounded-full px-5 py-2.5 text-sm font-semibold transition',
                        'bg-navy-700 text-white shadow-lg shadow-navy-700/20' => $item->is($category),
                        'border border-slate-200 text-navy-800 hover:border-leaf-500 hover:text-leaf-700' => ! $item->is($category),
                    ])>
                        <x-site-icon :name="$item->icon ?: 'droplet'" class="size-4" /> {{ $item->name }}
                    </a>
                @endforeach
            </div>

            <div class="mt-10 grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

    <x-cta-band />
</x-layouts.site>
