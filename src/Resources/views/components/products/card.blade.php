@props([
    'product' => null,
    'badge' => null,
])

@php
    if (! $product) {
        return;
    }

    $baseImage = product_image()->getProductBaseImage($product)['medium_image_url'] 
        ?? asset('themes/shop/nebula-cosmetics/images/cleo-hero-product.jpg');
    $badgeText = $badge ?: trans('nc::app.cart.bestseller');
    $url = $product->url_key ? route('shop.product_or_category.index', $product->url_key) : '#';
@endphp

<article class="group flex flex-col justify-between border border-[#2e2224] bg-white transition-shadow hover:shadow-lg">
    <div class="relative overflow-hidden aspect-square bg-[#fbf8f1] flex items-center justify-center border-b border-[#2e2224]">
        <span class="absolute top-3 start-3 z-10 bg-[#bd1765] text-white font-mono text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider">
            {{ $badgeText }}
        </span>

        <a href="{{ $url }}" class="block w-full h-full">
            <img
                src="{{ $baseImage }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            />
        </a>

        <button
            type="button"
            data-nc-quick-add
            data-product-id="{{ $product->id }}"
            class="absolute bottom-0 inset-x-0 bg-[#2e2224] text-white font-mono text-xs font-bold py-3 text-center uppercase tracking-wider transition-all duration-300 opacity-0 translate-y-full group-hover:opacity-100 group-hover:translate-y-0 hover:bg-[#bd1765]"
        >
            {{ trans('nc::app.cart.quick_add') }} +
        </button>
    </div>

    <div class="p-5 flex flex-col justify-between flex-1 gap-3 bg-[#fbf8f1]">
        <div>
            <h3 class="font-serif font-bold text-base md:text-lg leading-snug">
                <a href="{{ $url }}" class="hover:text-[#bd1765] transition-colors">
                    {{ $product->name }}
                </a>
            </h3>

            @if ($product->short_description)
                <p class="text-xs text-[#2e2224]/70 line-clamp-2 mt-1">
                    {!! strip_tags($product->short_description) !!}
                </p>
            @endif
        </div>

        <div class="font-mono text-sm md:text-base font-bold text-[#bd1765]">
            {!! $product->getTypeInstance()->getPriceHtml() !!}
        </div>
    </div>
</article>
