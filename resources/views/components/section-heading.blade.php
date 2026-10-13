@props(['eyebrow' => null, 'title', 'description' => null, 'align' => 'center', 'dark' => false])

<div {{ $attributes->class(['reveal max-w-2xl', 'mx-auto text-center' => $align === 'center']) }}>
    @if ($eyebrow)
        <p @class(['eyebrow', 'justify-center' => $align === 'center', 'text-leaf-400' => $dark])>{{ $eyebrow }}</p>
    @endif
    <h2 @class(['section-title mt-3', '!text-white' => $dark])>{!! $title !!}</h2>
    @if ($description)
        <p @class(['mt-4 text-base leading-relaxed sm:text-lg', 'text-navy-100' => $dark, 'text-slate-500' => ! $dark])>{{ $description }}</p>
    @endif
</div>
