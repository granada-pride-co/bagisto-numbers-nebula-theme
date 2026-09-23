<p class="price-label text-xs text-[#2e2224]/60 max-sm:text-[10px] max-sm:leading-4">
    @lang('shop::app.products.prices.grouped.starting-at')
</p>

<p class="final-price font-bold text-[var(--magenta)] max-sm:leading-4">
    {{ $prices['final']['formatted_price'] }}
</p>
