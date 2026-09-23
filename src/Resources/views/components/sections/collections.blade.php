@props(['options' => []])

@inject('categoryRepository', 'Webkul\Category\Repositories\CategoryRepository')

@php
    $isAr = app()->getLocale() === 'ar';
    $kicker = data_get($options, 'kicker') ?: trans('nc::app.sections.collections.default_kicker');

    $defaultItems = [
        ['name' => trans('nc::app.sections.collections.items_exfoliants'), 'tone' => '#ef88b4', 'link' => '#shop'],
        ['name' => trans('nc::app.sections.collections.items_moisturisers'), 'tone' => '#a6e7d5', 'link' => '#shop'],
        ['name' => trans('nc::app.sections.collections.items_serums'), 'tone' => '#f7a7be', 'link' => '#shop'],
        ['name' => trans('nc::app.sections.collections.items_eye_lip'), 'tone' => '#d9c7ff', 'link' => '#shop'],
        ['name' => trans('nc::app.sections.collections.items_masks'), 'tone' => '#f2c7a7', 'link' => '#shop'],
    ];

    $rawItems = data_get($options, 'items');
    $items = ! empty($rawItems) && is_array($rawItems) ? $rawItems : $defaultItems;
    $bgColor = data_get($options, 'bg_color') ?: '#f7b7ba';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
@endphp

<section class="border-b border-t border-[#2e2224]/15 overflow-hidden" id="collections" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg);">
    {{-- Header Banner --}}
    <div class="nc-section-header py-4 px-6 border-b border-[#2e2224]/15 text-center" style="color: var(--section-color);">
        <h2 class="nc-section-title font-mono text-xs font-bold tracking-widest uppercase" style="color: var(--section-color);">
            {{ $kicker }}
        </h2>
    </div>

    {{-- 5 Columns Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 divide-y sm:divide-y-0 lg:divide-x rtl:lg:divide-x-reverse divide-[var(--section-color,#2e2224)]/20" style="background-color: var(--section-bg);">
        @foreach ($items as $item)
            @php
                $categoryId = data_get($item, 'category_id');
                $category = $categoryId ? $categoryRepository->find($categoryId) : null;

                $catName = $category?->name;
                $catUrl = $category?->slug ? route('shop.product_or_category.index', $category->slug) : null;
                $catImage = \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::categoryImage($category);
                $customImage = data_get($item, 'image');

                if ($customImage) {
                    $img = \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::url($customImage);
                } elseif ($catImage) {
                    $img = $catImage;
                } else {
                    $img = null;
                }

                $name = data_get($item, 'name') ?: ($catName ?: '');
                $link = data_get($item, 'link') ?: ($catUrl ?: '#shop');
                $tone = data_get($item, 'tone') ?: '#ef88b4';
            @endphp
            <a
                href="{{ $link }}"
                class="group flex flex-col items-center justify-center gap-4 py-12 px-6 text-center bg-[#f7b7ba] hover:bg-[#f4aab0] transition-colors"
            >
                <div
                    class="nc-product-art nc-product-art--compact group-hover:scale-105 transition-transform duration-300"
                    style="--pack: {{ $tone }}; background-color: {{ $tone }};"
                >
                    @if ($img)
                        <img
                            src="{{ $img }}"
                            alt="{{ $name }}"
                            loading="lazy"
                            class="w-full h-full object-contain p-2.5 relative z-10 transition-transform duration-300 group-hover:scale-105"
                        />
                    @else
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
                    @endif
                </div>

                <span class="font-mono text-xs font-bold tracking-wider uppercase mt-1 text-[#2e2224] group-hover:text-[#bd1765] transition-colors">
                    {{ $name }}
                </span>
            </a>
        @endforeach
    </div>
</section>
