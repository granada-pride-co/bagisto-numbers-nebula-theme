@inject ('productRepository', 'Webkul\Product\Repositories\ProductRepository')

@php
    $sort = request('sort', 'created_at-desc');
    $sortMap = [
        'created_at-desc' => ['created_at', 'desc'],
        'created_at-asc'  => ['created_at', 'asc'],
        'price-asc'       => ['price', 'asc'],
        'price-desc'      => ['price', 'desc'],
        'name-asc'        => ['name', 'asc'],
        'name-desc'       => ['name', 'desc'],
    ];

    $sortParams = $sortMap[$sort] ?? ['created_at', 'desc'];

    $products = $productRepository->getAll([
        'category_id' => $category->id,
        'sort'        => $sortParams[0],
        'order'       => $sortParams[1],
        'limit'       => 16,
    ]);

    $subcategories = $category->children ?? collect();
@endphp

<x-nc::layouts :title="trim($category->meta_title) ?: $category->name">
    @push('meta')
        <meta
            name="description"
            content="{{ trim($category->meta_description) ?: \Illuminate\Support\Str::limit(strip_tags($category->description), 120, '') }}"
        />
        <meta
            name="keywords"
            content="{{ $category->meta_keywords }}"
        />
    @endPush

    <div class="nc-category-view py-12 md:py-16">
        <div class="nc-container">
            <nav class="flex items-center gap-2 text-xs font-mono text-[#2e2224]/60 mb-8" aria-label="Breadcrumb">
                <a href="{{ route('shop.home.index') }}" class="hover:text-[#bd1765] transition-colors">
                    {{ trans('nc::app.header.home') }}
                </a>
                <span>/</span>
                <span class="text-[#2e2224] font-bold">{{ $category->name }}</span>
            </nav>

            <div class="relative overflow-hidden bg-white border border-[#2e2224] p-8 md:p-14 mb-12 text-center">
                <span class="font-mono text-xs uppercase tracking-widest text-[#bd1765] font-bold block mb-3">
                    {{ trans('nc::app.brand.name') }} · {{ trans('nc::app.categories.all_products') }}
                </span>
                <h1 class="font-serif font-bold text-3xl md:text-5xl text-[#2e2224] mb-4">
                    {{ $category->name }}
                </h1>
                @if ($category->description)
                    <p class="font-serif text-[#2e2224]/80 text-base md:text-lg max-w-2xl mx-auto leading-relaxed">
                        {!! strip_tags($category->description) !!}
                    </p>
                @endif
            </div>

            @if ($subcategories->isNotEmpty())
                <div class="flex flex-wrap items-center justify-center gap-2 mb-12">
                    @foreach ($subcategories as $sub)
                        <a
                            href="{{ $sub->url ?: ($sub->slug ? route('shop.product_or_category.index', $sub->slug) : route('shop.search.index', ['category_id' => $sub->id])) }}"
                            class="px-4 py-2 bg-white border border-[#2e2224] text-xs font-mono font-bold hover:bg-[#bd1765] hover:text-white transition-colors"
                        >
                            {{ $sub->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 bg-white border border-[#2e2224] mb-8">
                <div class="font-mono text-xs text-[#2e2224]/70">
                    {{ trans('nc::app.categories.showing_count', ['count' => $products->count(), 'total' => $products->total()]) }}
                </div>

                <div class="flex items-center gap-3">
                    <label for="nc-sort-by" class="font-mono text-xs font-bold uppercase text-[#2e2224]">
                        {{ trans('nc::app.categories.sort_by') }}:
                    </label>
                    <select
                        id="nc-sort-by"
                        onchange="window.location.href = this.value"
                        class="bg-[#fbf8f1] border border-[#2e2224] text-xs font-mono py-1.5 px-3 outline-none cursor-pointer"
                    >
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'created_at-desc']) }}" {{ $sort === 'created_at-desc' ? 'selected' : '' }}>
                            {{ trans('nc::app.categories.sort_latest') }}
                        </option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price-asc']) }}" {{ $sort === 'price-asc' ? 'selected' : '' }}>
                            {{ trans('nc::app.categories.sort_price_low') }}
                        </option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price-desc']) }}" {{ $sort === 'price-desc' ? 'selected' : '' }}>
                            {{ trans('nc::app.categories.sort_price_high') }}
                        </option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'name-asc']) }}" {{ $sort === 'name-asc' ? 'selected' : '' }}>
                            {{ trans('nc::app.categories.sort_name_az') }}
                        </option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'name-desc']) }}" {{ $sort === 'name-desc' ? 'selected' : '' }}>
                            {{ trans('nc::app.categories.sort_name_za') }}
                        </option>
                    </select>
                </div>
            </div>

            @if ($products->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
                    @foreach ($products as $prod)
                        <x-nc::products.card :product="$prod" />
                    @endforeach
                </div>

                <div class="mt-8 flex justify-center">
                    {{ $products->links() }}
                </div>
            @else
                <div class="py-20 px-8 text-center bg-white border border-[#2e2224] my-12">
                    <p class="font-serif text-lg text-[#2e2224]/80 mb-4">
                        {{ trans('nc::app.categories.no_products') }}
                    </p>
                    <a
                        href="{{ route('shop.home.index') }}"
                        class="inline-block px-6 py-3 bg-[#bd1765] text-white font-mono text-xs font-bold uppercase tracking-widest hover:bg-[#8f0e4b] transition-colors"
                    >
                        {{ trans('nc::app.cart.keep_shopping') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-nc::layouts>
