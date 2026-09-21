@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $text = data_get($options, 'text') ?: ($isAr ? 'شاهدي تركيباتنا على أرض الواقع' : 'SEE THE LAB IN REAL LIFE');
    $handle = data_get($options, 'handle') ?: '@NEBULA.COSMETICS';
    $link = data_get($options, 'link') ?: '#top';
@endphp

<section class="border-b border-[#2e2224] bg-[#fbf8f1] py-8 px-6 text-center">
    <div class="max-w-4xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-6 font-mono text-xs font-bold tracking-widest text-[#2e2224] uppercase">
        <span>{{ $text }}</span>
        <a
            href="{{ $link }}"
            class="inline-flex items-center gap-2 text-[#bd1765] hover:underline"
        >
            {{ $handle }}
            <svg class="w-4 h-4 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</section>
