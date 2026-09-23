@props(['options' => []])

@php
    $quote = data_get($options, 'quote') ?: trans('nc::app.sections.manifesto.default_quote');
    $author = data_get($options, 'author') ?: (trans('nc::app.brand.name') . ' ' . trans('nc::app.brand.subtitle'));
    $bgColor = data_get($options, 'bg_color') ?: '#fffefd';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
@endphp

<section class="py-16 md:py-24 px-6 border-b border-[var(--section-color,#2e2224)] text-center" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg); color: var(--section-color); border-color: var(--section-color);">
    <div class="max-w-4xl mx-auto reveal">
        <blockquote class="font-serif text-2xl md:text-4xl italic leading-relaxed mb-4" style="color: {{ $textColor }};">
            {{ $quote }}
        </blockquote>
        <cite class="font-mono text-xs tracking-widest text-[#bd1765] uppercase not-italic font-bold">
            — {{ $author }}
        </cite>
    </div>
</section>
