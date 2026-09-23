@props([
    'product' => null,
    'badge'   => null,
    'tone'    => null,
])

@php
    if (! $product) {
        return;
    }

    $baseImage = product_image()->getProductBaseImage($product)['medium_image_url'] ?? null;
    $badgeText = $badge ?: trans('nc::app.cart.bestseller');
    $url = $product->url_key ? route('shop.product_or_category.index', $product->url_key) : '#';

    $tones = ['#f3f4f1', '#eaf5ee', '#fdeded', '#f1edf7', '#f8eee4', '#eef5f8'];
    $cardTone = $tone ?: ($tones[($product->id ?? 0) % count($tones)]);
    $priceHtml = $product->getTypeInstance()->getPriceHtml();

    $prices = $product->getTypeInstance()->getProductPrices();
    $regularPrice = $prices['regular']['price'] ?? 0;
    $finalPrice = $prices['final']['price'] ?? 0;
    $hasDiscount = $finalPrice < $regularPrice;
    $discountPercentage = ($hasDiscount && $regularPrice > 0)
        ? round((($regularPrice - $finalPrice) / $regularPrice) * 100)
        : 0;
@endphp

<article
    {{ $attributes->merge(['class' => 'group relative flex flex-col justify-between w-full h-full bg-white border border-[#2e2224]/12 hover:border-[#91e4d9] transition-all duration-300 shadow-[0_2px_8px_rgba(46,34,36,0.03)] hover:shadow-[0_12px_24px_rgba(46,34,36,0.08)] overflow-hidden']) }}
    style="--card-tone: {{ $cardTone }};"
>
    <div class="h-[2px] w-full bg-[#91e4d9]"></div>

    <div
        class="relative overflow-hidden aspect-[4/5] flex items-center justify-center border-b border-[#91e4d9]/25"
        style="background-color: var(--card-tone);"
    >
        <div class="absolute top-3 inset-x-3 z-10 flex items-center justify-between pointer-events-none gap-2">
            @if ($hasDiscount && $discountPercentage > 0)
                <span class="bg-[#bd1765] text-white font-mono text-[10px] font-bold px-2 py-0.5 uppercase tracking-wider shadow-xs">
                    -{{ $discountPercentage }}%
                </span>
            @else
                <span></span>
            @endif

            @if ($badgeText)
                <span class="bg-[#91e4d9] text-[#2e2224] font-mono text-[10px] font-bold px-2.5 py-1 uppercase tracking-wider shadow-xs">
                    {{ $badgeText }}
                </span>
            @endif
        </div>

        <a href="{{ $url }}" class="block w-full h-full">
            @if ($baseImage)
                <img
                    src="{{ $baseImage }}"
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105"
                    loading="lazy"
                />
            @else
                <img
                    src="{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}"
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover object-center opacity-85 transition-transform duration-700 group-hover:scale-105"
                    loading="lazy"
                />
            @endif
        </a>

        <button
            type="button"
            data-nc-quick-add
            data-product-id="{{ $product->id }}"
            data-product-type="{{ $product->type }}"
            data-product-url="{{ $url }}"
            class="absolute bottom-0 inset-x-0 bg-[#251f20] text-white font-mono text-xs font-bold py-3.5 text-center uppercase tracking-widest transition-all duration-300 opacity-0 translate-y-full group-hover:opacity-100 group-hover:translate-y-0 hover:bg-[#bd1765] z-20 cursor-pointer"
        >
            {{ trans('nc::app.cart.quick_add') }}
        </button>
    </div>

    <div class="p-4 sm:p-5 flex flex-col flex-1 justify-between gap-3 bg-white">
        <div class="flex flex-col gap-1.5">
            <h3 class="font-sans font-bold text-sm sm:text-base text-[#2e2224] leading-snug line-clamp-2 min-h-[2.5rem] sm:min-h-[2.75rem]">
                <a href="{{ $url }}" class="hover:text-[#bd1765] transition-colors">
                    {{ $product->name }}
                </a>
            </h3>

            @if ($product->short_description)
                <p class="text-[11px] sm:text-xs text-[#2e2224]/65 line-clamp-2 leading-relaxed">
                    {!! strip_tags($product->short_description) !!}
                </p>
            @endif
        </div>

        <div class="pt-3 mt-auto border-t border-[#91e4d9]/40 flex items-center justify-between gap-2">
            <div class="nc-product-card-price font-mono flex items-baseline gap-2 flex-wrap">
                {!! $priceHtml !!}
            </div>

            <button
                type="button"
                data-nc-quick-add
                data-product-id="{{ $product->id }}"
                data-product-type="{{ $product->type }}"
                data-product-url="{{ $url }}"
                aria-label="{{ trans('nc::app.cart.quick_add') }}"
                title="{{ trans('nc::app.cart.quick_add') }}"
                class="w-9 h-9 border border-[#91e4d9] bg-[#91e4d9]/20 hover:bg-[#91e4d9] text-[#2e2224] flex items-center justify-center transition-colors cursor-pointer shrink-0"
            >
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </button>
        </div>
    </div>
</article>
