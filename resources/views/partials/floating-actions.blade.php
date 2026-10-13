@php($phoneHref = 'tel:'.preg_replace('/\D+/', '', $site['gsm'] ?? ''))

{{-- Desktop: floating WhatsApp bubble --}}
<a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}?text={{ rawurlencode('Merhaba, bilgi almak istiyorum.') }}" target="_blank" rel="noopener"
   class="group fixed right-6 bottom-6 z-40 hidden items-center gap-3 sm:flex" aria-label="WhatsApp ile yazın">
    <span class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-navy-900 opacity-0 shadow-lg transition group-hover:opacity-100">WhatsApp ile yazın</span>
    <span class="relative flex size-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-xl shadow-[#25D366]/30 transition group-hover:scale-105">
        <span class="absolute inset-0 animate-ping rounded-full bg-[#25D366] opacity-30"></span>
        <x-site-icon name="whatsapp" class="relative size-7" />
    </span>
</a>

{{-- Mobile: bottom action bar --}}
<div class="fixed inset-x-0 bottom-0 z-40 border-t border-slate-200 bg-white/95 px-3 pt-2 pb-[max(0.5rem,env(safe-area-inset-bottom))] backdrop-blur sm:hidden">
    <div class="grid grid-cols-3 gap-2">
        <a href="{{ $phoneHref }}" class="flex flex-col items-center gap-0.5 rounded-xl py-1.5 text-xs font-semibold text-navy-800">
            <x-site-icon name="phone" class="size-5 text-navy-700" /> Ara
        </a>
        <a href="https://wa.me/{{ $site['whatsapp'] ?? '' }}?text={{ rawurlencode('Merhaba, bilgi almak istiyorum.') }}" target="_blank" rel="noopener" class="flex flex-col items-center gap-0.5 rounded-xl py-1.5 text-xs font-semibold text-navy-800">
            <x-site-icon name="whatsapp" class="size-5 text-[#25D366]" /> WhatsApp
        </a>
        <a href="{{ route('contact') }}" class="flex flex-col items-center gap-0.5 rounded-xl bg-leaf-600 py-1.5 text-xs font-semibold text-white">
            <x-site-icon name="send" class="size-5" /> Teklif Al
        </a>
    </div>
</div>
