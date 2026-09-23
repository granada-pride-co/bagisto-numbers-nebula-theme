@props(['options' => []])

@inject('productRepository', 'Webkul\Product\Repositories\ProductRepository')

@php
    $isAr = app()->getLocale() === 'ar';
    $eyebrow = data_get($options, 'eyebrow') ?: trans('nc::app.sections.featured_products.default_eyebrow');
    $title = data_get($options, 'title') ?: trans('nc::app.sections.featured_products.default_title');
    $badgeText = data_get($options, 'badge_text') ?: trans('nc::app.sections.featured_products.default_badge_text');

    $productIdsRaw = data_get($options, 'filters.product_ids');
    $categoryId = data_get($options, 'filters.category_id');
    $limit = (int) (data_get($options, 'filters.limit') ?: 10);
    $sort = data_get($options, 'filters.sort') ?: 'desc';

    $specificIds = [];
    if (! empty($productIdsRaw)) {
        if (is_array($productIdsRaw)) {
            $specificIds = array_filter(array_map('intval', $productIdsRaw));
        } elseif (is_string($productIdsRaw)) {
            $specificIds = array_filter(array_map('intval', explode(',', $productIdsRaw)));
        }
    }

    if (! empty($specificIds)) {
        $products = $productRepository->scopeQuery(function ($query) use ($specificIds) {
            return $query->whereIn('products.id', $specificIds);
        })->all();

        // Preserve chosen order if possible
        $sortedProducts = collect($specificIds)
            ->map(fn ($id) => $products->firstWhere('id', $id))
            ->filter();

        $products = $sortedProducts->isNotEmpty() ? $sortedProducts : $products;
    } else {
        $params = array_filter([
            'category_id' => $categoryId,
            'limit'       => $limit,
            'sort'        => $sort === 'desc' ? 'created_at-desc' : 'created_at-asc',
        ]);

        $products = $productRepository->getAll($params);
    }

    $bgColor = data_get($options, 'bg_color') ?: '#fffefd';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
@endphp

<section class="border-b border-[var(--section-color,#2e2224)] py-16 px-4 md:px-8 overflow-hidden" id="shop" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg); color: var(--section-color); border-color: var(--section-color);">
    <div class="max-w-7xl mx-auto">
        {{-- Section Header with Slider Navigation Arrows --}}
        <div class="flex items-end justify-between gap-4 border-b border-[var(--section-color,#2e2224)]/20 pb-6 mb-8">
            <div class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                <p class="font-mono text-xs font-bold tracking-widest text-[#bd1765] uppercase mb-2">
                    {{ $eyebrow }}
                </p>
                <h2 class="font-serif text-2xl sm:text-3xl md:text-4xl font-bold" style="color: {{ $textColor }};">
                    {{ $title }}
                </h2>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('shop.search.index') }}" class="hidden sm:inline-block font-mono text-xs font-bold text-[#bd1765] hover:underline uppercase tracking-wider me-3">
                    {{ trans('nc::app.footer.shop_all') }} {{ app()->getLocale() === 'ar' ? '←' : '→' }}
                </a>

                {{-- Previous Slide Button --}}
                <button
                    type="button"
                    data-nc-slider-prev
                    aria-label="{{ trans('nc::app.general.previous') }}"
                    class="w-10 h-10 border border-[#2e2224] bg-white hover:bg-[#fbf8f1] flex items-center justify-center text-[#2e2224] transition-colors cursor-pointer"
                >
                    <svg class="w-4 h-4 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                {{-- Next Slide Button --}}
                <button
                    type="button"
                    data-nc-slider-next
                    aria-label="{{ trans('nc::app.general.next') }}"
                    class="w-10 h-10 border border-[#2e2224] bg-[#2e2224] hover:bg-[#bd1765] flex items-center justify-center text-white transition-colors cursor-pointer"
                >
                    <svg class="w-4 h-4 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        @if ($products->isNotEmpty())
            {{-- Single Row Horizontal Slider Container --}}
            <div
                data-nc-slider-container
                class="flex gap-4 sm:gap-6 overflow-x-auto scroll-smooth pb-4 pt-1 scrollbar-none snap-x snap-mandatory"
                style="scrollbar-width: none; -ms-overflow-style: none;"
            >
                @foreach ($products as $product)
                    <div class="snap-start shrink-0 w-[270px] sm:w-[290px] md:w-[310px]">
                        <x-nc::products.card :product="$product" :badge="$badgeText" />
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 font-serif text-lg text-[#2e2224]/60">
                {{ trans('nc::app.cart.empty_title') }}
            </div>
        @endif
    </div>
</section>
