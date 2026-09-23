@php
    $cart = \Webkul\Checkout\Facades\Cart::getCart();
    $items = $cart?->items ?? collect();
    $total = $cart?->base_sub_total ?? 0;
@endphp

<div id="nc-cart-drawer-overlay"></div>

<aside id="nc-cart-drawer" aria-label="{{ trans('nc::app.cart.your_bag') }}">
    <div class="flex items-center justify-between p-6 border-b border-[#2e2224] bg-[#fbf8f1]">
        <h2 class="font-mono text-sm font-bold tracking-widest uppercase">
            {{ trans('nc::app.cart.your_bag') }} (<span data-nc-cart-count>{{ (int) ($cart?->items_qty ?? 0) }}</span>)
        </h2>
        <button
            type="button"
            data-nc-cart-close
            class="w-8 h-8 aspect-square flex items-center justify-center border border-[#2e2224] bg-white text-[#2e2224] hover:bg-[#bd1765] hover:text-white hover:border-[#bd1765] transition-colors cursor-pointer"
            aria-label="{{ trans('nc::app.header.close') }}"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div id="nc-cart-drawer-body" class="flex-1 overflow-y-auto p-6 flex flex-col gap-6">
        <div id="nc-cart-empty-state" class="{{ $items->isEmpty() ? '' : 'hidden ' }}h-full flex flex-col items-center justify-center text-center gap-4 py-12">
            <svg class="w-16 h-16 text-[#bd1765]/40" viewBox="0 0 92 82" fill="currentColor">
                <path d="M46 72C28 52 27 28 46 3c19 25 18 49 0 69Z" opacity=".62"/>
                <path d="M42 72C21 63 10 45 12 17c24 13 35 31 30 55Z" opacity=".82"/>
                <path d="M50 72c21-9 32-27 30-55-24 13-35 31-30 55Z" opacity=".82"/>
                <ellipse cx="46" cy="72" rx="14" ry="9"/>
            </svg>
            <p class="font-serif text-lg text-[#2e2224]/80">
                {{ trans('nc::app.cart.empty_title') }}
            </p>
            <button
                type="button"
                data-nc-cart-close
                class="nc-btn nc-btn--dark mt-2"
            >
                {{ trans('nc::app.cart.keep_shopping') }}
            </button>
        </div>

        <div id="nc-cart-items-list" class="{{ $items->isEmpty() ? 'hidden ' : '' }}flex flex-col gap-6">
            @foreach ($items as $item)
                @php
                    $product = $item->product;
                    $images = $product->getTypeInstance()->getBaseImage($item);
                    $imageUrl = $images['small_image_url'] ?? asset('themes/shop/nebula-cosmetics/images/cleo-hero-product.jpg');
                @endphp
                <div class="flex gap-4 pb-6 border-b border-[#2e2224]/10">
                    <img
                        src="{{ $imageUrl }}"
                        alt="{{ $item->name }}"
                        class="w-20 h-20 object-cover border border-[#2e2224]"
                    />
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-serif font-bold text-sm leading-snug">{{ $item->name }}</h3>
                            <p class="font-mono text-xs text-[#2e2224]/60 mt-1">
                                {{ trans('nc::app.cart.qty') }}: {{ $item->quantity }}
                            </p>
                        </div>
                        <div class="font-mono text-sm font-bold text-[var(--magenta)]">
                            {{ core()->currency($item->base_total) }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="nc-cart-drawer-footer" class="{{ $items->isEmpty() ? 'hidden ' : '' }}p-6 border-t border-[#2e2224] bg-white flex flex-col gap-4">
        <div class="flex items-center justify-between font-mono text-sm font-bold">
            <span>{{ trans('nc::app.cart.subtotal') }}</span>
            <span id="nc-cart-drawer-subtotal" class="text-base text-[var(--magenta)]">{{ core()->currency($total) }}</span>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <a
                href="{{ route('shop.checkout.cart.index') }}"
                class="nc-btn nc-btn--light text-center"
            >
                {{ trans('nc::app.cart.view_cart') }}
            </a>
            <a
                href="{{ route('shop.checkout.onepage.index') }}"
                class="nc-btn nc-btn--primary text-center"
            >
                {{ trans('nc::app.cart.checkout') }}
            </a>
        </div>
    </div>
</aside>
