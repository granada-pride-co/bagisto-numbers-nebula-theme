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
    $cardTone = $tone ?: ($tones[$product->id % count($tones)]);
    $priceHtml = $product->getTypeInstance()->getPriceHtml();
@endphp

<article
    class="group flex flex-col justify-between shrink-0 w-[270px] sm:w-[290px] md:w-[310px] transition-all duration-300"
    style="--card-tone: {{ $cardTone }};"
>
    {{-- Product Image & Art Stage --}}
    <div
        class="relative overflow-hidden aspect-[4/5] flex items-center justify-center transition-transform duration-500"
        style="background-color: var(--card-tone);"
    >
        {{-- Badge in Top Corner --}}
        @if ($badgeText)
            <span class="absolute top-4 start-4 z-10 bg-[#dfd6f6] text-[#2e2224] font-mono text-[9px] font-bold px-2 py-0.5 uppercase tracking-widest rounded-none shadow-xs">
                {{ $badgeText }}
            </span>
        @endif

        {{-- Product Main Link & Image --}}
        <a href="{{ $url }}" class="block w-full h-full p-6 flex items-center justify-center">
            @if ($baseImage)
                <img
                    src="{{ $baseImage }}"
                    alt="{{ $product->name }}"
                    class="max-w-full max-h-full object-contain transition-transform duration-700 group-hover:scale-105 filter drop-shadow-[0_10px_16px_rgba(0,0,0,0.08)]"
                    loading="lazy"
                />
            @else
                <div class="nc-product-art nc-product-art--compact group-hover:scale-105" style="--pack: {{ $cardTone }};">
                    <div class="nc-product-art__label">
                        <b class="font-serif text-xs uppercase tracking-wider block">
                            {{ $product->name }}
                        </b>
                    </div>
                </div>
            @endif
        </a>

        {{-- Quick Add Overlay Bar on Hover (Full width bar at bottom) --}}
        <button
            type="button"
            data-nc-quick-add
            data-product-id="{{ $product->id }}"
            class="absolute bottom-0 inset-x-0 bg-[#251f20] text-white font-mono text-xs font-bold py-3.5 text-center uppercase tracking-widest transition-all duration-300 opacity-0 translate-y-full group-hover:opacity-100 group-hover:translate-y-0 hover:bg-[#bd1765] z-20 cursor-pointer"
        >
            {{ trans('nc::app.cart.quick_add') }}
        </button>
    </div>

    {{-- Product Info Strip Below --}}
    <div class="pt-3 pb-1 flex flex-col gap-1.5">
        <div class="flex items-baseline justify-between gap-3">
            <h3 class="font-sans font-semibold text-sm md:text-base text-[#2e2224] truncate flex-1 leading-snug">
                <a href="{{ $url }}" class="hover:text-[#bd1765] transition-colors">
                    {{ $product->name }}
                </a>
            </h3>

            <div class="font-mono text-xs md:text-sm font-bold text-[#2e2224] shrink-0">
                {!! $priceHtml !!}
            </div>
        </div>

        @if ($product->short_description)
            <p class="text-[11px] md:text-xs text-[#2e2224]/60 line-clamp-1 leading-relaxed">
                {!! strip_tags($product->short_description) !!}
            </p>
        @endif
    </div>
</article>
