@if ($prices['final']['price'] < $prices['regular']['price'])
    <span
        class="regular-price font-medium text-zinc-400 line-through text-xs md:text-sm"
        aria-label="{{ $prices['regular']['formatted_price'] }}"
    >
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
