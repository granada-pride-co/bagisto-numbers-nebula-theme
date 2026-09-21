@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';

    $defaultItems = [
        [
            'title' => $isAr ? 'شحن مجاني' : 'FREE SHIPPING',
            'description' => $isAr ? 'للطلبات المؤهلة في كافة المناطق' : 'On orders over qualifying amounts',
        ],
        [
            'title' => $isAr ? 'تركيبات ذكية' : 'SKIN-SMART FORMULAS',
            'description' => $isAr ? 'مصنوعة لروتين عناية حقيقي وفعّال' : 'Made for real daily routines',
        ],
        [
            'title' => $isAr ? 'مكونات طبيعية' : 'NATURAL ROOTS',
            'description' => $isAr ? 'مستوحاة من أنقى المستخلصات النباتية' : 'Rooted in botanical science',
        ],
        [
            'title' => $isAr ? 'مكافآت سديم' : 'NEBULA REWARDS',
            'description' => $isAr ? 'نقاط، مزايا، وتجارب استثنائية' : 'Points, perks and previews',
        ],
    ];

    $rawItems = data_get($options, 'items');
    $items = ! empty($rawItems) && is_array($rawItems) ? $rawItems : $defaultItems;
@endphp

<section class="border-b border-[#2e2224] bg-[#fffefd] py-10 px-6" aria-label="{{ trans('nc::app.sections.service_strip.title') }}">
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 divide-y sm:divide-y-0 sm:divide-x rtl:sm:divide-x-reverse divide-[#2e2224]/15">
        @foreach ($items as $item)
            <div class="pt-6 sm:pt-0 sm:px-6 first:ps-0 flex flex-col gap-1 text-center sm:text-start">
                <b class="font-mono text-xs font-bold tracking-widest text-[#2e2224] uppercase">
                    {{ $item['title'] ?? '' }}
                </b>
                <span class="text-xs text-[#2e2224]/70">
                    {{ $item['description'] ?? '' }}
                </span>
            </div>
        @endforeach
    </div>
</section>
