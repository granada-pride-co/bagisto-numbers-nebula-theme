@inject ('reviewHelper', 'Webkul\Product\Helpers\Review')
@inject ('productViewHelper', 'Webkul\Product\Helpers\View')

@php
    $avgRatings = (float) $reviewHelper->getAverageRating($product);
    $totalReviews = (int) $reviewHelper->getTotalReviews($product);
    $percentageRatings = $reviewHelper->getPercentageRating($product);
    $customAttributeValues = $productViewHelper->getAdditionalData($product);
    $attributeData = collect($customAttributeValues)->filter(fn ($item) => ! empty($item['value']));
    $images = $product->images;
    $baseImage = product_image()->getProductBaseImage($product)['medium_image_url'] 
        ?? asset('themes/shop/nebula-cosmetics/images/cleo-hero-product.jpg');
    $primaryCategory = $product->categories->first();
@endphp

<x-nc::layouts :title="trim($product->meta_title) ?: $product->name">
    @push('meta')
        <meta
            name="description"
            content="{{ trim($product->meta_description) ?: \Illuminate\Support\Str::limit(strip_tags($product->description), 120, '') }}"
        />
        <meta
            name="keywords"
            content="{{ $product->meta_keywords }}"
        />
    @endPush

    <div class="nc-product-view py-12 md:py-16">
        <div class="nc-container">
            <nav class="flex items-center gap-2 text-xs font-mono text-[#2e2224]/60 mb-8" aria-label="Breadcrumb">
                <a href="{{ route('shop.home.index') }}" class="hover:text-[#bd1765] transition-colors">
                    {{ trans('nc::app.header.home') }}
                </a>
                <span>/</span>
                @if ($primaryCategory)
                    <a href="{{ $primaryCategory->url ?: route('shop.product_or_category.index', $primaryCategory->slug) }}" class="hover:text-[#bd1765] transition-colors">
                        {{ $primaryCategory->name }}
                    </a>
                    <span>/</span>
                @endif
                <span class="text-[#2e2224] font-bold">{{ $product->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start mb-20">
                <div class="lg:col-span-7">
                    <div class="relative overflow-hidden bg-white border border-[#2e2224] aspect-square flex items-center justify-center p-6">
                        <span class="absolute top-4 start-4 z-10 bg-[#bd1765] text-white font-mono text-[10px] font-bold px-2.5 py-1 uppercase tracking-widest">
                            {{ trans('nc::app.cart.bestseller') }}
                        </span>

                        <img
                            id="nc-main-product-image"
                            src="{{ $baseImage }}"
                            alt="{{ $product->name }}"
                            class="max-h-[85%] max-w-[85%] object-contain transition-transform duration-500 hover:scale-105"
                        />
                    </div>

                    @if ($images->count() > 1)
                        <div class="grid grid-cols-5 gap-3 mt-4">
                            @foreach ($images as $im)
                                <button
                                    type="button"
                                    onclick="document.getElementById('nc-main-product-image').src = '{{ $im->url }}'"
                                    class="aspect-square bg-white border border-[#2e2224]/30 hover:border-[#bd1765] overflow-hidden p-2 transition-colors cursor-pointer"
                                >
                                    <img src="{{ $im->url }}" alt="{{ $product->name }}" class="w-full h-full object-contain" />
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-5 flex flex-col gap-6">
                    <div>
                        <span class="font-mono text-xs uppercase tracking-widest text-[#bd1765] font-bold block mb-2">
                            {{ $primaryCategory ? $primaryCategory->name : trans('nc::app.brand.name') }}
                        </span>

                        <h1 class="font-serif font-bold text-3xl md:text-4xl text-[#2e2224] leading-tight mb-3">
                            {{ $product->name }}
                        </h1>

                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-1 text-[#bd1765]">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $avgRatings >= $i ? 'fill-current' : 'opacity-25' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="font-mono text-xs text-[#2e2224]/70">
                                ({{ $totalReviews }} {{ trans('nc::app.products.reviews') }})
                            </span>
                        </div>
                    </div>

                    <div class="p-4 bg-white border border-[#2e2224] flex items-center justify-between">
                        <div>
                            <span class="block text-[10px] font-mono text-[#2e2224]/60 uppercase tracking-widest">
                                {{ trans('nc::app.cart.subtotal') }}
                            </span>
                            <div class="font-mono text-2xl font-bold text-[#bd1765]">
                                {!! $product->getTypeInstance()->getPriceHtml() !!}
                            </div>
                        </div>

                        <div>
                            @if ($product->haveSufficientQuantity(1))
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-300 text-xs font-mono font-bold">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    {{ trans('nc::app.products.in_stock') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-700 border border-red-300 text-xs font-mono font-bold">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    {{ trans('nc::app.products.out_of_stock') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    @if ($product->short_description)
                        <div class="font-serif text-base text-[#2e2224]/80 leading-relaxed border-b border-[#2e2224]/15 pb-4">
                            {!! $product->short_description !!}
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <label for="nc-product-qty" class="font-mono text-xs font-bold uppercase text-[#2e2224]">
                                {{ trans('nc::app.cart.qty') }}:
                            </label>
                            <div class="flex items-center border border-[#2e2224] bg-white">
                                <button
                                    type="button"
                                    onclick="const q = document.getElementById('nc-product-qty'); if(parseInt(q.value) > 1) q.value = parseInt(q.value) - 1;"
                                    class="w-9 h-9 flex items-center justify-center font-mono hover:bg-[#bd1765] hover:text-white transition-colors"
                                >
                                    -
                                </button>
                                <input
                                    type="number"
                                    id="nc-product-qty"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                    class="w-12 h-9 text-center font-mono text-sm border-x border-[#2e2224] outline-none"
                                />
                                <button
                                    type="button"
                                    onclick="const q = document.getElementById('nc-product-qty'); q.value = parseInt(q.value) + 1;"
                                    class="w-9 h-9 flex items-center justify-center font-mono hover:bg-[#bd1765] hover:text-white transition-colors"
                                >
                                    +
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-3">
                            <button
                                type="button"
                                data-nc-quick-add
                                data-product-id="{{ $product->id }}"
                                class="w-full sm:flex-1 bg-[#bd1765] text-white font-mono text-sm font-bold py-4 px-6 uppercase tracking-wider hover:bg-[#8f0e4b] transition-colors shadow-md text-center cursor-pointer"
                            >
                                {{ trans('nc::app.products.add_to_bag') }}
                            </button>

                            <a
                                href="{{ route('shop.customers.account.wishlist.index') }}"
                                class="w-full sm:w-auto p-4 border border-[#2e2224] bg-white hover:border-[#bd1765] hover:text-[#bd1765] transition-colors flex items-center justify-center"
                                aria-label="Wishlist"
                            >
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-[#2e2224]/15 flex items-center justify-between text-xs font-mono text-[#2e2224]/70">
                        <span>{{ trans('nc::app.products.sku') }}: <strong>{{ $product->sku }}</strong></span>
                        <span>{{ trans('nc::app.brand.name') }} · {{ trans('nc::app.brand.subtitle') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-[#2e2224] p-8 md:p-12 mb-20">
                <div class="space-y-8">
                    <div class="border-b border-[#2e2224]/15 pb-8">
                        <h2 class="font-serif font-bold text-2xl text-[#2e2224] mb-4">
                            {{ trans('nc::app.products.details') }}
                        </h2>
                        <div class="font-serif text-base md:text-lg text-[#2e2224]/85 leading-relaxed">
                            {!! $product->description !!}
                        </div>
                    </div>

                    @if ($attributeData->isNotEmpty())
                        <div class="border-b border-[#2e2224]/15 pb-8">
                            <h2 class="font-serif font-bold text-2xl text-[#2e2224] mb-4">
                                {{ trans('nc::app.products.specifications') }}
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($attributeData as $attr)
                                    <div class="p-3 bg-[#fbf8f1] border border-[#2e2224]/20 flex items-center justify-between text-xs">
                                        <span class="font-mono uppercase font-bold text-[#bd1765]">{{ $attr['label'] }}</span>
                                        <span class="font-serif text-[#2e2224]">{{ $attr['value'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div id="reviews">
                        <h2 class="font-serif font-bold text-2xl text-[#2e2224] mb-4">
                            {{ trans('nc::app.products.reviews') }} ({{ $totalReviews }})
                        </h2>
                        <div class="p-6 bg-[#fbf8f1] border border-[#2e2224]/20 text-center">
                            <p class="font-serif text-[#2e2224]/80 text-base mb-2">
                                {{ trans('nc::app.products.no_reviews') }}
                            </p>
                            <span class="font-mono text-xs text-[#bd1765] uppercase font-bold">
                                {{ trans('nc::app.products.be_first_review') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-nc::layouts>
