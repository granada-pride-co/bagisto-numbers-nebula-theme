@props(['options' => []])

@inject('productRepository', 'Webkul\Product\Repositories\ProductRepository')

@php
    $isAr = app()->getLocale() === 'ar';
    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'نتائج مثبتة' : "WHAT'S WORKING");
    $title = data_get($options, 'title') ?: ($isAr ? 'عناية فائقة لبشرة متألقة.' : 'Hard-working skin care.');
    $badgeText = data_get($options, 'badge_text') ?: ($isAr ? 'الأكثر طلباً' : 'BESTSELLER');

    $categoryId = data_get($options, 'filters.category_id');
    $limit = (int) (data_get($options, 'filters.limit') ?: 8);
    $sort = data_get($options, 'filters.sort') ?: 'desc';

    $params = array_filter([
        'category_id' => $categoryId,
        'limit'       => $limit,
        'sort'        => $sort === 'desc' ? 'created_at-desc' : 'created_at-asc',
    ]);

    $products = $productRepository->getAll($params);
@endphp

<section class="border-b border-[#2e2224] bg-[#fffefd] py-16 px-6" id="shop">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-[#2e2224] pb-6 mb-10">
            <div>
                <p class="font-mono text-xs font-bold tracking-widest text-[#bd1765] uppercase mb-2">
                    {{ $eyebrow }}
                </p>
                <h2 class="font-serif text-3xl md:text-4xl font-bold text-[#2e2224]">
                    {{ $title }}
                </h2>
            </div>
            <a href="{{ route('shop.search.index') }}" class="font-mono text-xs font-bold text-[#bd1765] hover:underline uppercase tracking-wider">
                {{ trans('nc::app.footer.shop_all') }} →
            </a>
        </div>

        @if ($products->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <x-nc::products.card :product="$product" :badge="$badgeText" />
                @endforeach
            </div>
        @else
            <div class="text-center py-12 font-serif text-lg text-[#2e2224]/60">
                {{ trans('nc::app.cart.empty_title') }}
            </div>
        @endif
    </div>
</section>
