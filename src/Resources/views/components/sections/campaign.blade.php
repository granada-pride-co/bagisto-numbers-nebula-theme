@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgImage = \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::url(
        data_get($options, 'bg_image'),
        asset('themes/shop/nebula-cosmetics/images/cleo-ritual-wide.jpg')
    );

    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'مصنوعة لبشرة حقيقية' : 'MADE FOR REAL SKIN');
    $title = data_get($options, 'title') ?: ($isAr ? 'تناقلي الطقوس جيلاً بعد جيل.' : 'Pass the ritual on.');
    $description = data_get($options, 'description') ?: ($isAr ? 'حكمة توارثتها الأجيال، مواد فعالة حديثة، ورف تجميل متكامل يفيض بالجمال.' : 'Generational wisdom. Modern actives. One very good shelf.');
    $btnText = data_get($options, 'btn_text') ?: ($isAr ? 'ابني روتينكِ الخاص' : 'BUILD YOUR ROUTINE');
    $btnLink = data_get($options, 'btn_link') ?: '#routine';
@endphp

<section class="relative min-h-[480px] md:min-h-[580px] flex items-center justify-center border-b border-[#2e2224] overflow-hidden">
    <img
        src="{{ $bgImage }}"
        alt="{{ $title }}"
        class="absolute inset-0 w-full h-full object-cover"
    />
    <div class="absolute inset-0 bg-gradient-to-t from-[#2e2224]/85 via-[#2e2224]/40 to-transparent"></div>

    <div class="relative z-10 max-w-2xl mx-auto px-6 text-center text-white py-16 reveal">
        <p class="font-mono text-xs font-bold tracking-widest uppercase mb-3 text-white/90">
            {{ $eyebrow }}
        </p>
        <h2 class="font-serif text-3xl md:text-5xl font-bold mb-4 leading-tight">
            {{ $title }}
        </h2>
        <p class="text-sm md:text-base text-white/85 mb-8 leading-relaxed">
            {{ $description }}
        </p>
        <a href="{{ $btnLink }}" class="nc-btn nc-btn--light">
            {{ $btnText }}
        </a>
    </div>
</section>
