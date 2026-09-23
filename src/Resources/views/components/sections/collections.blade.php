@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $kicker = data_get($options, 'kicker') ?: ($isAr ? 'تسوقي حسب المجموعة' : 'SHOP BY COLLECTION');

    $defaultItems = [
        ['name' => $isAr ? 'المقشرات' : 'Exfoliants', 'format' => 'jar', 'tone' => '#ef88b4', 'link' => '#shop'],
        ['name' => $isAr ? 'المرطبات' : 'Moisturisers', 'format' => 'jar', 'tone' => '#a6e7d5', 'link' => '#shop'],
        ['name' => $isAr ? 'السيروم' : 'Serums', 'format' => 'bottle', 'tone' => '#f7a7be', 'link' => '#shop'],
        ['name' => $isAr ? 'العين والشفاه' : 'Eye + Lip', 'format' => 'tube', 'tone' => '#d9c7ff', 'link' => '#shop'],
        ['name' => $isAr ? 'الأقنعة' : 'Masks', 'format' => 'pouch', 'tone' => '#f2c7a7', 'link' => '#shop'],
    ];

    $rawItems = data_get($options, 'items');
    $items = ! empty($rawItems) && is_array($rawItems) ? $rawItems : $defaultItems;
@endphp

<section class="border-b border-t border-[#2e2224] bg-[#f7b7ba] overflow-hidden" id="collections">
    {{-- Header Banner --}}
    <div class="py-4 px-6 border-b border-[#2e2224] text-center bg-[#f7b7ba]">
        <h2 class="font-mono text-xs font-bold tracking-widest text-[#2e2224] uppercase">
            {{ $kicker }}
        </h2>
    </div>

    {{-- 5 Columns Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 divide-y sm:divide-y-0 lg:divide-x rtl:lg:divide-x-reverse divide-[#2e2224] bg-[#f7b7ba]">
        @foreach ($items as $item)
            <a
                href="{{ $item['link'] ?? '#shop' }}"
                class="group flex flex-col items-center justify-center gap-4 py-12 px-6 text-center bg-[#f7b7ba] hover:bg-[#f4aab0] transition-colors"
            >
                <div
                    class="nc-product-art nc-product-art--compact group-hover:scale-105 transition-transform duration-300"
                    style="--pack: {{ $item['tone'] ?? '#f089a8' }};"
                >
                    <div class="nc-product-art__label">
                        <svg class="w-4 h-4 text-[#bd1765]" viewBox="0 0 92 82" fill="currentColor">
                            <path d="M46 72C28 52 27 28 46 3c19 25 18 49 0 69Z" opacity=".62"/>
                            <path d="M42 72C21 63 10 45 12 17c24 13 35 31 30 55Z" opacity=".82"/>
                            <path d="M50 72c21-9 32-27 30-55-24 13-35 31-30 55Z" opacity=".82"/>
                            <ellipse cx="46" cy="72" rx="14" ry="9"/>
                        </svg>
                        <b class="font-serif text-[10px] uppercase tracking-wider block mt-1">
                            {{ trans('nc::app.brand.name') }}
                        </b>
                    </div>
                </div>

                <span class="font-mono text-xs font-bold tracking-wider text-[#2e2224] uppercase mt-1">
                    {{ $item['name'] ?? '' }}
                </span>
            </a>
        @endforeach
    </div>
</section>
