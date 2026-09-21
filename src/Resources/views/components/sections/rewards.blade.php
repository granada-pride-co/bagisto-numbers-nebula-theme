@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $image = data_get($options, 'image') 
        ? asset('storage/' . data_get($options, 'image')) 
        : asset('themes/shop/nebula-cosmetics/images/cleo-concern-application.jpg');

    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'مزايا فريدة في كل خطوة' : 'PERKS BEHIND EVERY PETAL');
    $title = data_get($options, 'title') ?: ($isAr ? 'انضمي إلى مكافآت سديم.' : 'Join Nebula Rewards.');
    $description = data_get($options, 'description') ?: ($isAr ? 'اجمعي النقاط مع كل تركيبة تقتنينها، وافتحي هدايا أعياد الميلاد وتجربة المنتجات الحصرية أولاً بأول. البشرة الجميلة تستحق مزايا إضافية.' : 'Earn points on every formula, unlock birthday treats and get first access to new drops. Good skin should come with benefits.');
    $linkText = data_get($options, 'link_text') ?: ($isAr ? 'اكتشفي المزيد' : 'LEARN MORE');
    $linkUrl = data_get($options, 'link_url') ?: '#newsletter';
@endphp

<section class="border-b border-[#2e2224] bg-[#fffefd]" id="rewards">
    <div class="grid grid-cols-1 lg:grid-cols-2">
        <div class="p-8 md:p-16 flex flex-col justify-center order-2 lg:order-1 reveal">
            <p class="font-mono text-xs font-bold tracking-widest text-[#bd1765] uppercase mb-3">
                {{ $eyebrow }}
            </p>
            <h2 class="font-serif text-3xl md:text-5xl font-bold text-[#2e2224] leading-tight mb-4">
                {{ $title }}
            </h2>
            <p class="text-sm md:text-base text-[#2e2224]/80 leading-relaxed mb-8">
                {{ $description }}
            </p>
            <div>
                <a
                    href="{{ $linkUrl }}"
                    class="inline-flex items-center gap-2 font-mono text-xs font-bold tracking-wider text-[#bd1765] hover:underline uppercase"
                >
                    {{ $linkText }}
                    <svg class="w-4 h-4 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="border-b lg:border-b-0 lg:border-s border-[#2e2224] overflow-hidden min-h-[380px] order-1 lg:order-2">
            <img
                src="{{ $image }}"
                alt="{{ $title }}"
                class="w-full h-full object-cover"
            />
        </div>
    </div>
</section>
