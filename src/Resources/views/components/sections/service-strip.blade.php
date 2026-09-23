@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#fffefd';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';

    $defaultItems = [
        [
            'icon_name'   => 'shipping',
            'title'       => trans('nc::app.sections.service_strip.item_1_title'),
            'description' => trans('nc::app.sections.service_strip.item_1_desc'),
        ],
        [
            'icon_name'   => 'spark',
            'title'       => trans('nc::app.sections.service_strip.item_2_title'),
            'description' => trans('nc::app.sections.service_strip.item_2_desc'),
        ],
        [
            'icon_name'   => 'leaf',
            'title'       => trans('nc::app.sections.service_strip.item_3_title'),
            'description' => trans('nc::app.sections.service_strip.item_3_desc'),
        ],
        [
            'icon_name'   => 'star',
            'title'       => trans('nc::app.sections.service_strip.item_4_title'),
            'description' => trans('nc::app.sections.service_strip.item_4_desc'),
        ],
    ];

    $rawItems = data_get($options, 'items');
    $items = ! empty($rawItems) && is_array($rawItems) ? $rawItems : $defaultItems;
@endphp

<section
    class="border-b border-[#2e2224]/15 py-12 sm:py-16 px-4 sm:px-6 lg:px-8 transition-colors"
    dir="{{ $isAr ? 'rtl' : 'ltr' }}"
    style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg);"
    aria-label="{{ trans('nc::app.sections.service_strip.title') }}"
>
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-0 divide-y sm:divide-y-0 lg:divide-x rtl:lg:divide-x-reverse divide-[#2e2224]/15">
            @foreach ($items as $index => $item)
                @php
                    $imageUrl = ! empty($item['image'])
                        ? \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::url($item['image'])
                        : null;
                    $icon = strtolower(trim($item['icon_name'] ?? ''));
                @endphp

                <div class="pt-6 sm:pt-0 sm:px-6 lg:px-8 flex flex-col items-center text-center gap-3.5 group">
                    @if ($imageUrl)
                        <div class="w-14 h-14 sm:w-16 sm:h-16 shrink-0 rounded-2xl bg-white/90 border border-[#2e2224]/10 shadow-xs flex items-center justify-center p-2.5 transition-all duration-300 group-hover:scale-110 group-hover:border-[#bd1765]/30 group-hover:shadow-md">
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $item['title'] ?? '' }}"
                                class="max-w-full max-h-full object-contain transition-transform duration-300 group-hover:scale-105"
                                loading="lazy"
                            />
                        </div>
                    @else
                        <div class="w-14 h-14 sm:w-16 sm:h-16 shrink-0 rounded-full bg-[#bd1765]/10 text-[#bd1765] border border-[#bd1765]/20 flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:bg-[#bd1765]/15 group-hover:border-[#bd1765]/35 group-hover:shadow-md">
                            @if ($icon === 'shipping' || (! $icon && $index === 0))
                                <svg class="w-7 h-7 sm:w-8 sm:h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                                    <path d="M15 18H9" />
                                    <path d="M19 18h2a1 1 0 0 0 1-1v-5.5a1.5 1.5 0 0 0-.44-1.06L18.5 7.38A1.5 1.5 0 0 0 17.44 7H14v11h1" />
                                    <circle cx="7" cy="18" r="2" />
                                    <circle cx="17" cy="18" r="2" />
                                </svg>
                            @elseif ($icon === 'leaf' || (! $icon && $index === 2))
                                <svg class="w-7 h-7 sm:w-8 sm:h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 21a9 9 0 01-9-9c0-4.97 4.03-9 9-9 4.14 0 7.63 2.8 8.66 6.64.33 1.24.47 2.53.42 3.82-.14 3.63-2.91 6.54-6.58 6.54H12z" />
                                    <path d="M12 21V12" />
                                </svg>
                            @elseif ($icon === 'star' || (! $icon && $index === 3))
                                <svg class="w-7 h-7 sm:w-8 sm:h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                </svg>
                            @elseif ($icon === 'shield')
                                <svg class="w-7 h-7 sm:w-8 sm:h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    <path d="m9 12 2 2 4-4" />
                                </svg>
                            @else
                                <svg class="w-7 h-7 sm:w-8 sm:h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            @endif
                        </div>
                    @endif

                    <div class="flex flex-col items-center gap-1.5 max-w-[240px]">
                        <h3 class="font-sans text-sm sm:text-base font-bold text-[#2e2224] tracking-normal transition-colors duration-200 group-hover:text-[#bd1765]">
                            {{ $item['title'] ?? '' }}
                        </h3>

                        <p class="text-xs sm:text-sm leading-relaxed opacity-75">
                            {{ $item['description'] ?? '' }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
