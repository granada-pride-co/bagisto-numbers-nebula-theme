<p class="price-label text-xs text-[#2e2224]/60 max-sm:text-[10px] max-sm:leading-4">
    {{ $label }}
</p>

@if (isset($prices['final']) && $prices['final']['price'] < $prices['regular']['price'])
    <p
        class="regular-price text-xs font-semibold text-gray-400 line-through max-sm:text-[11px] max-sm:leading-4"
        aria-label="{{ $prices['regular']['formatted_price'] }}"
    >
        {{ $prices['regular']['formatted_price'] }}
    </p>

    <p class="final-price font-bold text-[var(--magenta)] max-sm:leading-4">
        {{ $prices['final']['formatted_price'] }}
    </p>
@else
    <p class="final-price font-bold text-[var(--magenta)] max-sm:leading-4">
        {{ $prices['regular']['formatted_price'] }}
    </p>
@endif
