@props(['options' => []])

@inject('categoryRepository', 'Webkul\Category\Repositories\CategoryRepository')

@php
    $isAr = app()->getLocale() === 'ar';
    $kicker = data_get($options, 'kicker') ?: trans('nc::app.sections.concerns.default_kicker');

    $defaultItems = [
        [
            'name'     => trans('nc::app.sections.concerns.item_1_name'),
            'copy'     => trans('nc::app.sections.concerns.item_1_copy'),
            'image'    => asset('themes/shop/nebula-cosmetics/images/cleo-hero-skin.jpg'),
            'btn_text' => trans('nc::app.sections.concerns.default_btn_text'),
            'btn_link' => '#shop',
        ],
        [
            'name'     => trans('nc::app.sections.concerns.item_2_name'),
            'copy'     => trans('nc::app.sections.concerns.item_2_copy'),
            'image'    => asset('themes/shop/nebula-cosmetics/images/cleo-concern-portrait.jpg'),
            'btn_text' => trans('nc::app.sections.concerns.default_btn_text'),
            'btn_link' => '#shop',
        ],
        [
            'name'     => trans('nc::app.sections.concerns.item_3_name'),
            'copy'     => trans('nc::app.sections.concerns.item_3_copy'),
            'image'    => asset('themes/shop/nebula-cosmetics/images/cleo-concern-application.jpg'),
            'btn_text' => trans('nc::app.sections.concerns.default_btn_text'),
            'btn_link' => '#shop',
        ],
        [
            'name'     => trans('nc::app.sections.concerns.item_4_name'),
            'copy'     => trans('nc::app.sections.concerns.item_4_copy'),
            'image'    => asset('themes/shop/nebula-cosmetics/images/cleo-concern-texture.jpg'),
            'btn_text' => trans('nc::app.sections.concerns.default_btn_text'),
            'btn_link' => '#shop',
        ],
        [
            'name'     => trans('nc::app.sections.concerns.item_5_name'),
            'copy'     => trans('nc::app.sections.concerns.item_5_copy'),
            'image'    => asset('themes/shop/nebula-cosmetics/images/cleo-hero-product.jpg'),
            'btn_text' => trans('nc::app.sections.concerns.default_btn_text'),
            'btn_link' => '#shop',
        ],
    ];

    $rawItems = data_get($options, 'items');
    $items = ! empty($rawItems) && is_array($rawItems) ? $rawItems : $defaultItems;
    $channelCategories = $categoryRepository->getVisibleCategoryTree(core()->getCurrentChannel()->root_category_id)->values();
    $bgColor = data_get($options, 'bg_color') ?: '#f7b7ba';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
@endphp

<section class="border-b border-t border-[#2e2224]/15 overflow-hidden" id="concerns" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg);">
    {{-- Header Banner --}}
    <div class="nc-section-header py-4 px-6 border-b border-[#2e2224]/15 text-center" style="color: var(--section-color);">
        <h2 class="nc-section-title font-mono text-xs font-bold tracking-widest uppercase" style="color: var(--section-color);">
            {{ $kicker }}
        </h2>
    </div>

    {{-- 5 Columns Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 divide-y sm:divide-y-0 lg:divide-x rtl:lg:divide-x-reverse divide-[var(--section-color,#2e2224)]/20" style="background-color: var(--section-bg);">
        @foreach ($items as $index => $item)
            @php
                $categoryId = data_get($item, 'category_id');
                $category = $categoryId ? $categoryRepository->find($categoryId) : null;
                $fallbackCat = $channelCategories->get($index);
                $activeCategory = $category ?: $fallbackCat;

                $catName = $activeCategory?->name;
                $catDesc = $activeCategory?->description ? strip_tags($activeCategory->description) : null;
                $catImage = \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::categoryImage($activeCategory);
                $catUrl = $activeCategory?->slug ? route('shop.product_or_category.index', $activeCategory->slug) : null;

                $default = $defaultItems[$index % count($defaultItems)];

                $title = data_get($item, 'name') ?: ($category?->name ?: $default['name']);
                $copy = data_get($item, 'copy') ?: ($category?->description ? strip_tags($category->description) : $default['copy']);
                $link = data_get($item, 'btn_link') ?: ($category?->slug ? route('shop.product_or_category.index', $category->slug) : $default['btn_link']);
                $btnText = data_get($item, 'btn_text') ?: trans('nc::app.sections.concerns.default_btn_text');

                $customImage = data_get($item, 'image');

                if ($customImage) {
                    $img = \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::url($customImage, $default['image']);
                } elseif ($catImage) {
                    $img = $catImage;
                } else {
                    $img = $default['image'];
                }
            @endphp
            <article class="flex flex-col justify-between bg-[#f7b7ba] group">
                {{-- Card Image --}}
                <div class="aspect-square overflow-hidden border-b border-[#2e2224] bg-[#ebd8c8]">
                    <img
                        src="{{ $img }}"
                        alt="{{ $title }}"
                        loading="lazy"
                        class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                    />
                </div>

                {{-- Card Details --}}
                <div class="p-6 flex flex-col items-center justify-between text-center flex-1 gap-4 text-[#2e2224]" style="background-color: var(--section-bg);">
                    <div class="space-y-2">
                        <h3 class="font-mono font-bold text-sm sm:text-base tracking-wide text-[#2e2224]">
                            <a href="{{ $link }}" class="hover:underline">
                                {{ $title }}
                            </a>
                        </h3>
                        <p class="font-mono text-[11px] leading-relaxed opacity-85 text-[#2e2224] max-w-[220px] mx-auto">
                            {{ $copy }}
                        </p>
                    </div>

                    <a
                        href="{{ $link }}"
                        class="inline-block bg-white text-[#2e2224] border border-[#2e2224] font-mono text-[11px] font-bold tracking-widest uppercase px-5 py-2 transition-all hover:bg-[#2e2224] hover:text-white"
                    >
                        {{ $btnText }}
                    </a>
                </div>
            </article>
        @endforeach
    </div>
</section>
