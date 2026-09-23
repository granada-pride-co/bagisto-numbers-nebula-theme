@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#fffefd';

    $defaultItems = [
        [
            'icon_name'   => 'shipping',
            'title'       => $isAr ? 'شحن مجاني' : 'FREE SHIPPING',
            'description' => $isAr ? 'للطلبات المؤهلة في كافة المناطق' : 'On orders over qualifying amounts',
        ],
        [
            'icon_name'   => 'spark',
            'title'       => $isAr ? 'تركيبات ذكية' : 'SKIN-SMART FORMULAS',
            'description' => $isAr ? 'مصنوعة لروتين عناية حقيقي وفعّال' : 'Made for real daily routines',
        ],
        [
            'icon_name'   => 'leaf',
            'title'       => $isAr ? 'مكونات طبيعية' : 'NATURAL ROOTS',
            'description' => $isAr ? 'مستوحاة من أنقى المستخلصات النباتية' : 'Rooted in botanical science',
        ],
        [
            'icon_name'   => 'star',
            'title'       => $isAr ? 'مكافآت سديم' : 'NEBULA REWARDS',
            'description' => $isAr ? 'نقاط، مزايا، وتجارب استثنائية' : 'Points, perks and previews',
        ],
    ];

    $rawItems = data_get($options, 'items');
    $items = ! empty($rawItems) && is_array($rawItems) ? $rawItems : $defaultItems;
@endphp

<section
    class="border-b border-[#2e2224] py-12 px-6 transition-colors"
    style="background-color: {{ $bgColor }};"
    aria-label="{{ trans('nc::app.sections.service_strip.title') }}"
>
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 divide-y sm:divide-y-0 sm:divide-x rtl:sm:divide-x-reverse divide-[#2e2224]/15">
        @foreach ($items as $index => $item)
            @php
                $imageUrl = ! empty($item['image'])
                    ? \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::url($item['image'])
                    : null;
                $icon = strtolower(trim($item['icon_name'] ?? ''));
            @endphp

            <div class="pt-6 sm:pt-0 sm:px-6 first:ps-0 flex flex-col items-center sm:items-start gap-3 text-center sm:text-start">
                {{-- Icon or Uploaded Image Above Each Feature --}}
                @if ($imageUrl)
                    <div class="w-10 h-10 shrink-0 flex items-center justify-center">
                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $item['title'] ?? '' }}"
                            class="max-w-full max-h-full object-contain"
                            loading="lazy"
                        />
                    </div>
                @else
                    <div class="w-10 h-10 shrink-0 rounded-full bg-[#bd1765]/10 text-[#bd1765] flex items-center justify-center">
                        @if ($icon === 'shipping' || (! $icon && $index === 0))
                            {{-- Shipping Truck / Delivery Icon --}}
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a2 2 0 014 0m0 0a2 2 0 014 0m-4 0V9a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a2 2 0 00-4 0m-4 0a2 2 0 104 0m-4 0H5" />
                            </svg>
                        @elseif ($icon === 'leaf' || (! $icon && $index === 2))
                            {{-- Organic / Nature Leaf Icon --}}
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 01-9-9c0-4.97 4.03-9 9-9 4.14 0 7.63 2.8 8.66 6.64.33 1.24.47 2.53.42 3.82-.14 3.63-2.91 6.54-6.58 6.54H12z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21V12" />
                            </svg>
                        @elseif ($icon === 'star' || (! $icon && $index === 3))
                            {{-- Reward / Star Icon --}}
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        @elseif ($icon === 'shield')
                            {{-- Guarantee / Shield Icon --}}
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        @else
                            {{-- Spark / Beauty Formula Icon --}}
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        @endif
                    </div>
                @endif

                <div class="flex flex-col gap-1">
                    <b class="font-mono text-xs font-bold tracking-widest text-[#2e2224] uppercase">
                        {{ $item['title'] ?? '' }}
                    </b>
                    <span class="text-xs text-[#2e2224]/70 leading-relaxed">
                        {{ $item['description'] ?? '' }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</section>
