<span class="price-label text-xs text-[#2e2224]/60 block w-full">
    @lang('shop::app.products.prices.configurable.as-low-as')
</span>

@if (isset($prices['final']) && $prices['final']['price'] < $prices['regular']['price'])
    <span class="regular-price text-xs font-semibold text-gray-400 line-through">
        {{ $prices['regular']['formatted_price'] }}
    </span>

    <span class="final-price font-bold text-[var(--magenta)]">
        {{ $prices['final']['formatted_price'] }}
    </span>
@else
    <span class="final-price font-bold text-[var(--magenta)]">
        {{ $prices['regular']['formatted_price'] }}
    </span>
@endif
