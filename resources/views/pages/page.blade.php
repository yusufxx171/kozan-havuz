<x-layouts.site :title="$page->seo_title ?: $page->title" :description="$page->seo_description">
    <x-page-hero :title="$page->title" :subtitle="$page->subtitle" :image="$page->image" :breadcrumbs="[$page->title => null]" />

    <section class="py-16 sm:py-20">
        <div class="container-site max-w-3xl">
            <div class="prose-site">{!! $page->body !!}</div>
        </div>
    </section>
</x-layouts.site>
