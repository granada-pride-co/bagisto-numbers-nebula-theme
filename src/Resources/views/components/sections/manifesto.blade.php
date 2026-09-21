@props(['options' => []])

@php
    $quote = data_get($options, 'quote') ?: (app()->getLocale() === 'ar' ? '«تركيبات تعتني بالبشرة أولاً، مكونات فعالة، ونتائج ملموسة.»' : '"Skin-first formulas, active ingredients, visible results."');
    $author = data_get($options, 'author') ?: (trans('nc::app.brand.name') . ' ' . trans('nc::app.brand.subtitle'));
@endphp

<section class="py-16 md:py-24 px-6 border-b border-[#2e2224] bg-[#fffefd] text-center">
    <div class="max-w-4xl mx-auto reveal">
        <blockquote class="font-serif text-2xl md:text-4xl italic text-[#2e2224] leading-relaxed mb-4">
            {{ $quote }}
        </blockquote>
        <cite class="font-mono text-xs tracking-widest text-[#bd1765] uppercase not-italic font-bold">
            — {{ $author }}
        </cite>
    </div>
</section>
