@inject ('reviewHelper', 'Webkul\Product\Helpers\Review')
@inject ('productViewHelper', 'Webkul\Product\Helpers\View')

@php
    $avgRatings = (float) $reviewHelper->getAverageRating($product);
    $totalReviews = (int) $reviewHelper->getTotalReviews($product);
    $percentageRatings = $reviewHelper->getPercentageRating($product);
    $customAttributeValues = $productViewHelper->getAdditionalData($product);
    $attributeData = collect($customAttributeValues)->filter(fn ($item) => ! empty($item['value']));
    
    $galleryImages = product_image()->getGalleryImages($product);
    $baseImage = ! empty($galleryImages) 
        ? ($galleryImages[0]['large_image_url'] ?? $galleryImages[0]['original_image_url']) 
        : (product_image()->getProductBaseImage($product)['large_image_url'] ?? asset('themes/shop/nebula-cosmetics/images/cleo-hero-product.jpg'));
    $baseZoomImage = ! empty($galleryImages)
        ? ($galleryImages[0]['original_image_url'] ?? $baseImage)
        : $baseImage;

    $primaryCategory = $product->categories->first();
    $isConfigurable = $product->getTypeInstance()->hasVariants();
    $configurableConfig = $isConfigurable
        ? app(\Webkul\Product\Helpers\ConfigurableOption::class)->getConfigurationConfig($product)
        : null;
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

    <div class="nc-product-view py-10 md:py-14 bg-[#fffefd]">
        <div class="nc-container max-w-7xl mx-auto px-6">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-xs font-mono text-[#2e2224]/60 mb-6" aria-label="{{ trans('nc::app.general.breadcrumb') }}">
                <a href="{{ route('shop.home.index') }}" class="hover:text-[var(--primary,#bd1765)] transition-colors">
                    {{ trans('nc::app.header.home') }}
                </a>
                <span>/</span>
                @if ($primaryCategory)
                    <a href="{{ $primaryCategory->url ?: route('shop.product_or_category.index', $primaryCategory->slug) }}" class="hover:text-[var(--primary,#bd1765)] transition-colors">
                        {{ $primaryCategory->name }}
                    </a>
                    <span>/</span>
                @endif
                <span class="text-[#2e2224] font-bold">{{ $product->name }}</span>
            </nav>

            {{-- Main Product Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start mb-16">
                {{-- Product Media Stage --}}
                <div class="lg:col-span-7">
                    <div
                        id="nc-product-stage-container"
                        class="relative overflow-hidden bg-[#fbf8f1] border border-[var(--secondary,#2e2224)]/20 aspect-square flex items-center justify-center p-4 md:p-6 select-none cursor-crosshair group"
                    >
                        <span class="absolute top-4 start-4 z-10 bg-[var(--primary,#bd1765)] text-white font-mono text-[10px] font-bold px-3 py-1 uppercase tracking-widest pointer-events-none shadow-xs">
                            {{ trans('nc::app.cart.bestseller') }}
                        </span>

                        <button
                            type="button"
                            id="nc-open-zoom-btn"
                            class="absolute bottom-4 end-4 z-10 bg-white/90 hover:bg-white text-[#2e2224] border border-[var(--secondary,#2e2224)]/20 px-3 py-1.5 font-mono text-[11px] font-bold uppercase tracking-wider flex items-center gap-1.5 shadow-sm transition-all hover:border-[var(--primary,#bd1765)] hover:text-[var(--primary,#bd1765)] cursor-pointer"
                            aria-label="{{ trans('nc::app.products.click_to_zoom') }}"
                        >
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                <line x1="11" y1="8" x2="11" y2="14"></line>
                                <line x1="8" y1="11" x2="14" y2="11"></line>
                            </svg>
                            <span class="hidden sm:inline">{{ trans('nc::app.products.click_to_zoom') }}</span>
                        </button>

                        <div class="w-full h-full flex items-center justify-center overflow-hidden pointer-events-none">
                            <img
                                id="nc-main-product-image"
                                src="{{ $baseImage }}"
                                data-zoom-src="{{ $baseZoomImage }}"
                                alt="{{ $product->name }}"
                                class="max-h-full max-w-full w-auto h-auto object-contain transition-transform duration-150 ease-out filter drop-shadow-[0_10px_20px_rgba(0,0,0,0.08)] pointer-events-none"
                            />
                        </div>
                    </div>

                    @if (count($galleryImages) > 1)
                        <div id="nc-gallery-thumbnails" class="grid grid-cols-5 gap-3 mt-4">
                            @foreach ($galleryImages as $idx => $im)
                                <button
                                    type="button"
                                    data-image-index="{{ $idx }}"
                                    data-large-url="{{ $im['large_image_url'] ?? $im['original_image_url'] }}"
                                    data-zoom-url="{{ $im['original_image_url'] ?? $im['large_image_url'] }}"
                                    class="nc-thumb-btn aspect-square bg-white border {{ $idx === 0 ? 'nc-thumb-active' : 'border-[var(--secondary,#2e2224)]/20' }} hover:border-[var(--primary,#bd1765)] overflow-hidden p-1.5 transition-all cursor-pointer flex items-center justify-center"
                                >
                                    <img src="{{ $im['small_image_url'] ?? $im['medium_image_url'] }}" alt="{{ $im['alt'] ?? $product->name }}" class="w-full h-full object-contain pointer-events-none" />
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Product Buy Box & Details --}}
                <div class="lg:col-span-5 flex flex-col gap-6">
                    <div>
                        <span class="font-mono text-xs uppercase tracking-widest text-[var(--primary,#bd1765)] font-bold block mb-2">
                            {{ $primaryCategory ? $primaryCategory->name : trans('nc::app.brand.name') }}
                        </span>

                        <h1 class="font-mono font-bold text-2xl md:text-4xl text-[#2e2224] leading-tight mb-3">
                            {{ $product->name }}
                        </h1>

                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-1 text-[var(--primary,#bd1765)]">
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

                    {{-- Price Box --}}
                    <div class="p-5 bg-[#fbf8f1] border border-[var(--secondary,#2e2224)]/20 flex items-center justify-between">
                        <div>
                            <span class="block text-[10px] font-mono text-[#2e2224]/70 uppercase tracking-widest font-bold">
                                {{ trans('nc::app.cart.subtotal') }}
                            </span>
                            <div id="nc-product-price-box" class="nc-product-view-price font-mono text-2xl font-bold text-[var(--primary,#bd1765)]">
                                {!! $product->getTypeInstance()->getPriceHtml() !!}
                            </div>
                        </div>

                        <div>
                            @if ($product->haveSufficientQuantity(1))
                                <span id="nc-product-stock-badge" class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-400 text-xs font-mono font-bold">
                                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                    {{ trans('nc::app.products.in_stock') }}
                                </span>
                            @else
                                <span id="nc-product-stock-badge" class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 text-red-800 border border-red-400 text-xs font-mono font-bold">
                                    <span class="w-2 h-2 rounded-full bg-red-600"></span>
                                    {{ trans('nc::app.products.out_of_stock') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    @if ($product->short_description)
                        <div class="font-mono text-xs md:text-sm text-[#2e2224]/85 leading-relaxed border-b border-[#2e2224]/15 pb-4">
                            {!! $product->short_description !!}
                        </div>
                    @endif

                    {{-- Add to Cart Form --}}
                    <form id="nc-product-form" action="{{ route('shop.api.checkout.cart.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="selected_configurable_option" id="nc-selected-configurable-option" value="">

                        {{-- Configurable Options Pickers --}}
                        @if ($isConfigurable && ! empty($configurableConfig['attributes']))
                            <div id="nc-configurable-options" class="space-y-4 pt-2 border-t border-[#2e2224]/15">
                                @foreach ($configurableConfig['attributes'] as $attr)
                                    <div class="nc-config-attribute" data-attribute-id="{{ $attr['id'] }}">
                                        <input type="hidden" name="super_attribute[{{ $attr['id'] }}]" id="nc-super-attr-{{ $attr['id'] }}" value="">

                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-mono text-xs uppercase tracking-wider font-bold text-[#2e2224]">
                                                {{ $attr['label'] }}:
                                                <span class="text-[var(--primary,#bd1765)] font-bold nc-selected-label"></span>
                                            </span>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-2.5">
                                            @foreach ($attr['options'] as $option)
                                                @if ($attr['swatch_type'] === 'color' && ! empty($option['swatch_value']))
                                                    <button
                                                        type="button"
                                                        data-attr-id="{{ $attr['id'] }}"
                                                        data-option-id="{{ $option['id'] }}"
                                                        data-option-label="{{ $option['label'] }}"
                                                        title="{{ $option['label'] }}"
                                                        class="nc-swatch-option nc-swatch-color w-8 h-8 rounded-full border border-[var(--secondary,#2e2224)]/30 hover:border-[var(--primary,#bd1765)] p-0.5 transition-all cursor-pointer relative"
                                                    >
                                                        <span class="w-full h-full rounded-full block" style="background-color: {{ $option['swatch_value'] }};"></span>
                                                    </button>
                                                @elseif ($attr['swatch_type'] === 'image' && ! empty($option['swatch_value']))
                                                    <button
                                                        type="button"
                                                        data-attr-id="{{ $attr['id'] }}"
                                                        data-option-id="{{ $option['id'] }}"
                                                        data-option-label="{{ $option['label'] }}"
                                                        title="{{ $option['label'] }}"
                                                        class="nc-swatch-option nc-swatch-image w-10 h-10 border border-[var(--secondary,#2e2224)]/30 hover:border-[var(--primary,#bd1765)] p-1 transition-all cursor-pointer"
                                                    >
                                                        <img src="{{ $option['swatch_value'] }}" alt="{{ $option['label'] }}" class="w-full h-full object-cover" />
                                                    </button>
                                                @else
                                                    <button
                                                        type="button"
                                                        data-attr-id="{{ $attr['id'] }}"
                                                        data-option-id="{{ $option['id'] }}"
                                                        data-option-label="{{ $option['label'] }}"
                                                        class="nc-swatch-option nc-swatch-text font-mono text-xs font-bold px-3.5 py-2 border border-[var(--secondary,#2e2224)]/30 bg-white text-[#2e2224] hover:border-[var(--primary,#bd1765)] transition-all cursor-pointer uppercase"
                                                    >
                                                        {{ $option['label'] }}
                                                    </button>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Quantity and Actions --}}
                        <div class="space-y-4 pt-2">
                            <div class="flex items-center gap-3">
                                <label for="nc-product-qty" class="font-mono text-xs font-bold uppercase text-[#2e2224] tracking-wider">
                                    {{ trans('nc::app.cart.qty') }}:
                                </label>
                                <div class="flex items-center border border-[var(--secondary,#2e2224)]/30 bg-white">
                                    <button
                                        type="button"
                                        id="nc-qty-decrement"
                                        class="w-10 h-10 flex items-center justify-center font-mono text-base font-bold text-[#2e2224] hover:bg-[var(--primary,#bd1765)] hover:text-white transition-colors cursor-pointer"
                                    >
                                        -
                                    </button>
                                    <input
                                        type="number"
                                        id="nc-product-qty"
                                        name="quantity"
                                        value="1"
                                        min="1"
                                        class="w-14 h-10 text-center font-mono text-sm font-bold border-x border-[var(--secondary,#2e2224)]/30 outline-none text-[#2e2224]"
                                    />
                                    <button
                                        type="button"
                                        id="nc-qty-increment"
                                        class="w-10 h-10 flex items-center justify-center font-mono text-base font-bold text-[#2e2224] hover:bg-[var(--primary,#bd1765)] hover:text-white transition-colors cursor-pointer"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row items-center gap-3">
                                <button
                                    type="submit"
                                    id="nc-add-to-cart-btn"
                                    data-nc-product-submit
                                    class="w-full sm:flex-1 bg-[var(--primary,#bd1765)] text-white font-mono text-xs font-bold py-4 px-6 uppercase tracking-widest hover:brightness-90 transition-all border border-[var(--primary,#bd1765)] text-center cursor-pointer shadow-sm hover:shadow-md"
                                >
                                    {{ trans('nc::app.products.add_to_bag') }}
                                </button>

                                <a
                                    href="{{ route('shop.customers.account.wishlist.index') }}"
                                    class="w-full sm:w-auto p-4 border border-[var(--secondary,#2e2224)]/30 bg-white hover:border-[var(--primary,#bd1765)] hover:text-[var(--primary,#bd1765)] transition-colors flex items-center justify-center text-[#2e2224]"
                                    aria-label="{{ trans('nc::app.header.wishlist') }}"
                                >
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="pt-4 border-t border-[#2e2224]/15 flex items-center justify-between text-xs font-mono text-[#2e2224]/70">
                        <span>{{ trans('nc::app.products.sku') }}: <strong>{{ $product->sku }}</strong></span>
                        <span>{{ trans('nc::app.brand.name') }} · {{ trans('nc::app.brand.subtitle') }}</span>
                    </div>
                </div>
            </div>

            {{-- Full Product Description & Specs Box --}}
            <div class="bg-white border border-[var(--secondary,#2e2224)]/20 p-8 md:p-12 mb-16 shadow-xs">
                <div class="space-y-8">
                    <div class="border-b border-[#2e2224]/15 pb-8">
                        <h2 class="font-mono font-bold text-xl md:text-2xl text-[#2e2224] uppercase tracking-wide mb-4">
                            {{ trans('nc::app.products.details') }}
                        </h2>
                        <div class="font-mono text-xs md:text-sm text-[#2e2224]/85 leading-relaxed">
                            {!! $product->description !!}
                        </div>
                    </div>

                    @if ($attributeData->isNotEmpty())
                        <div class="border-b border-[#2e2224]/15 pb-8">
                            <h2 class="font-mono font-bold text-xl md:text-2xl text-[#2e2224] uppercase tracking-wide mb-4">
                                {{ trans('nc::app.products.specifications') }}
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($attributeData as $attr)
                                    <div class="p-3 bg-[#fbf8f1] border border-[var(--secondary,#2e2224)]/20 flex items-center justify-between text-xs font-mono">
                                        <span class="uppercase font-bold text-[var(--primary,#bd1765)] tracking-wider">{{ $attr['label'] }}</span>
                                        <span class="text-[#2e2224] font-bold">{{ $attr['value'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div id="reviews">
                        <h2 class="font-mono font-bold text-xl md:text-2xl text-[#2e2224] uppercase tracking-wide mb-4">
                            {{ trans('nc::app.products.reviews') }} ({{ $totalReviews }})
                        </h2>
                        <div class="p-8 bg-[#fbf8f1] border border-[var(--secondary,#2e2224)]/20 text-center">
                            <p class="font-mono text-sm text-[#2e2224]/80 mb-2 font-bold">
                                {{ trans('nc::app.products.no_reviews') }}
                            </p>
                            <span class="font-mono text-xs text-[var(--primary,#bd1765)] uppercase font-bold tracking-wider">
                                {{ trans('nc::app.products.be_first_review') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Fullscreen Zoom Lightbox Modal --}}
    <div
        id="nc-zoom-modal"
        class="fixed inset-0 z-50 bg-[#070b14]/95 backdrop-blur-md hidden flex flex-col justify-between p-4 md:p-6 transition-opacity duration-300"
        role="dialog"
        aria-modal="true"
        aria-label="{{ trans('nc::app.products.click_to_zoom') }}"
    >
        {{-- Modal Header --}}
        <div class="flex items-center justify-between text-white border-b border-white/10 pb-3">
            <div class="flex items-center gap-3">
                <span class="font-mono text-xs font-bold tracking-widest text-[#f089a8] uppercase">
                    {{ $product->name }}
                </span>
                <span id="nc-zoom-counter" class="font-mono text-xs text-white/50"></span>
            </div>

            <div class="flex items-center gap-2">
                <button
                    type="button"
                    id="nc-zoom-in-btn"
                    class="p-2 bg-white/10 hover:bg-white/20 text-white rounded transition-colors cursor-pointer"
                    title="{{ trans('nc::app.products.zoom_in') }}"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        <line x1="11" y1="8" x2="11" y2="14"></line>
                        <line x1="8" y1="11" x2="14" y2="11"></line>
                    </svg>
                </button>
                <button
                    type="button"
                    id="nc-zoom-out-btn"
                    class="p-2 bg-white/10 hover:bg-white/20 text-white rounded transition-colors cursor-pointer"
                    title="{{ trans('nc::app.products.zoom_out') }}"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        <line x1="8" y1="11" x2="14" y2="11"></line>
                    </svg>
                </button>
                <button
                    type="button"
                    id="nc-zoom-reset-btn"
                    class="px-2.5 py-1.5 bg-white/10 hover:bg-white/20 text-white font-mono text-xs rounded transition-colors cursor-pointer"
                    title="{{ trans('nc::app.products.reset_zoom') }}"
                >
                    1:1
                </button>
                <button
                    type="button"
                    id="nc-zoom-close-btn"
                    class="p-2 bg-[var(--primary,#bd1765)] hover:brightness-90 text-white rounded font-mono text-xs font-bold transition-colors cursor-pointer ms-2"
                    title="{{ trans('nc::app.products.close_zoom') }}"
                >
                    ✕
                </button>
            </div>
        </div>

        {{-- Modal Image Viewport --}}
        <div id="nc-zoom-viewport" class="relative flex-1 w-full h-full overflow-hidden flex items-center justify-center my-4 cursor-grab">
            <button
                type="button"
                id="nc-zoom-prev-btn"
                class="absolute start-4 z-20 w-10 h-10 rounded-full bg-black/60 hover:bg-black/90 text-white flex items-center justify-center transition-colors cursor-pointer"
                aria-label="{{ trans('nc::app.general.previous') }}"
            >
                ‹
            </button>

            <img
                id="nc-zoom-modal-img"
                src="{{ $baseZoomImage }}"
                alt="{{ $product->name }}"
                class="max-h-[80vh] max-w-[85vw] object-contain transition-transform duration-200 select-none"
                draggable="false"
            />

            <button
                type="button"
                id="nc-zoom-next-btn"
                class="absolute end-4 z-20 w-10 h-10 rounded-full bg-black/60 hover:bg-black/90 text-white flex items-center justify-center transition-colors cursor-pointer"
                aria-label="{{ trans('nc::app.general.next') }}"
            >
                ›
            </button>
        </div>

        {{-- Modal Thumbnails --}}
        <div id="nc-zoom-modal-thumbs" class="flex items-center justify-center gap-2 overflow-x-auto py-2"></div>
    </div>

    {{-- Embedded Data --}}
    @if ($isConfigurable && $configurableConfig)
        <script type="application/json" id="nc-configurable-config">
            {!! json_encode($configurableConfig) !!}
        </script>
    @endif

    <script type="application/json" id="nc-gallery-data">
        {!! json_encode($galleryImages) !!}
    </script>
</x-nc::layouts>
