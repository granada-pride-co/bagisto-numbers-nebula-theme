@props(['options' => []])

@php
    $skinImage = \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::url(
        data_get($options, 'skin_image'),
        asset('themes/shop/nebula-cosmetics/images/cleo-hero-skin.jpg')
    );

    $productImageRaw = data_get($options, 'product_image');
    $productImage = $productImageRaw
        ? \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::url(
            $productImageRaw,
            asset('themes/shop/nebula-cosmetics/images/cleo-hero-product.jpg')
        )
        : asset('themes/shop/nebula-cosmetics/images/cleo-hero-product.jpg');

    $eyebrow = data_get($options, 'eyebrow') ?: trans('nc::app.sections.hero.default_eyebrow');
    $headline = data_get($options, 'headline') ?: trans('nc::app.sections.hero.default_headline');
    $subtitle = data_get($options, 'subtitle') ?: trans('nc::app.brand.tagline');
    $btnText = data_get($options, 'btn_text') ?: trans('nc::app.sections.hero.default_btn_text');
    $btnLink = data_get($options, 'btn_link') ?: '#shop';
    $brandMark = data_get($options, 'brand_mark_text') ?: (trans('nc::app.brand.name') . ' ' . trans('nc::app.brand.subtitle'));
    $bgColor = data_get($options, 'bg_color');
    $textColor = data_get($options, 'text_color') ?: '#ffffff';
@endphp

<section class="nc-hero" id="top" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" style="{{ $bgColor ? 'background-color: ' . $bgColor . ';' : '' }}">
    <div class="nc-hero__panel">
        <img src="{{ $skinImage }}" alt="{{ $headline }}" />
        <div class="nc-hero__shade"></div>
        <div class="nc-hero__copy {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
            <p class="font-mono text-xs tracking-widest uppercase mb-3 opacity-90" style="color: {{ $textColor }};">{{ $eyebrow }}</p>
            <h1 class="font-serif text-4xl md:text-6xl font-bold leading-tight mb-4" style="color: {{ $textColor }};">{!! nl2br(e($headline)) !!}</h1>
            <p class="text-sm md:text-base opacity-85 max-w-md mb-6 leading-relaxed" style="color: {{ $textColor }};">{{ $subtitle }}</p>
            <a href="{{ $btnLink }}" class="nc-btn nc-btn--light">
                {{ $btnText }}
            </a>
        </div>
    </div>

    <div class="nc-hero__panel">
        <img src="{{ $productImage }}" alt="{{ $brandMark }}" />
        <div class="absolute inset-x-0 bottom-8 flex flex-col items-center justify-center gap-2 text-white/90 pointer-events-none">
            <svg class="w-8 h-8" viewBox="0 0 92 82" fill="currentColor">
                <path d="M46 72C28 52 27 28 46 3c19 25 18 49 0 69Z" opacity=".62"/>
                <path d="M42 72C21 63 10 45 12 17c24 13 35 31 30 55Z" opacity=".82"/>
                <path d="M50 72c21-9 32-27 30-55-24 13-35 31-30 55Z" opacity=".82"/>
                <ellipse cx="46" cy="72" rx="14" ry="9"/>
            </svg>
            <span class="font-serif text-lg tracking-widest font-bold">{{ $brandMark }}</span>
        </div>
    </div>
</section>
