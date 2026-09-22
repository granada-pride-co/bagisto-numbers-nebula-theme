@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#f4789c';

    $image = \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::url(
        data_get($options, 'image'),
        asset('themes/shop/nebula-cosmetics/images/cleo-concern-application.jpg')
    );

    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'مزايا فريدة في كل خطوة' : 'PERKS BEHIND EVERY PETAL');
    $title = data_get($options, 'title') ?: ($isAr ? 'انضمي إلى مكافآت سديم.' : 'Join Cleo Rewards.');
    $description = data_get($options, 'description') ?: ($isAr ? 'اجمعي النقاط مع كل تركيبة تقتنينها، وافتحي هدايا أعياد الميلاد وتجربة المنتجات الحصرية أولاً بأول. البشرة الجميلة تستحق مزايا إضافية.' : 'Earn points on every formula, unlock birthday treats and get first access to new drops. Good skin should come with benefits.');
    $linkText = data_get($options, 'link_text') ?: ($isAr ? 'اكتشفي المزيد' : 'LEARN MORE');
    $linkUrl = data_get($options, 'link_url') ?: '#newsletter';
@endphp

<section class="border-b border-[#2e2224]" id="rewards" style="background-color: {{ $bgColor }};">
    <div class="grid grid-cols-1 lg:grid-cols-2">
        {{-- Promo Image (Left Column) --}}
        <div class="border-b lg:border-b-0 lg:border-e border-[#2e2224] overflow-hidden min-h-[450px]">
            <img
                src="{{ $image }}"
                alt="{{ $title }}"
                class="w-full h-full object-cover"
            />
        </div>

        {{-- Text Content Box (Right Column) --}}
        <div class="p-8 md:p-16 flex flex-col justify-center reveal" style="background-color: {{ $bgColor }};">
            <p class="font-mono text-xs font-bold tracking-widest text-[#2e2224]/80 uppercase mb-4">
                {{ $eyebrow }}
            </p>
            <h2 class="font-mono text-3xl md:text-5xl font-bold text-[#2e2224] leading-tight mb-6">
                {!! nl2br(e($title)) !!}
            </h2>
            <p class="font-mono text-xs md:text-sm text-[#2e2224]/85 leading-relaxed max-w-md mb-8">
                {{ $description }}
            </p>
            <div>
                <a
                    href="{{ $linkUrl }}"
                    class="inline-flex items-center gap-2 font-mono text-xs font-bold tracking-wider text-[#2e2224] hover:underline uppercase"
                >
                    {{ $linkText }}
                    <svg class="w-4 h-4 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
