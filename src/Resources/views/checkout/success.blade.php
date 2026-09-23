<x-shop::layouts
    :has-header="true"
    :has-feature="false"
    :has-footer="true"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.checkout.success.thanks')
    </x-slot>

    <!-- Page Content -->
    <div class="min-h-[70vh] bg-[#fbf8f1] py-12 md:py-20 flex items-center justify-center">
        <div class="max-w-2xl w-full mx-auto px-6">
            <div class="bg-white border border-[#2e2224] p-8 md:p-14 text-center shadow-[0_8px_30px_rgba(46,34,36,0.06)] relative overflow-hidden">
                <!-- Subtle luxury accent bar on top -->
                <div class="absolute top-0 inset-x-0 h-1 bg-[#bd1765]"></div>

                {{ view_render_event('bagisto.shop.checkout.success.image.before', ['order' => $order]) }}

                <!-- Luxury Checkmark Icon -->
                <div class="w-16 h-16 md:w-20 md:h-20 mx-auto mb-6 rounded-full border border-[#2e2224] bg-[#fbf8f1] flex items-center justify-center text-[#bd1765]">
                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>

                {{ view_render_event('bagisto.shop.checkout.success.image.after', ['order' => $order]) }}

                <!-- Thank You Title -->
                <h1 class="font-serif text-3xl md:text-4xl font-bold text-[#2e2224] uppercase tracking-wide mb-3">
                    @lang('shop::app.checkout.success.thanks')
                </h1>

                <!-- Order ID Badge -->
                <div class="inline-block my-4 px-6 py-2.5 bg-[#fbf8f1] border border-[#2e2224]/20 font-mono text-xs md:text-sm">
                    @if (auth()->guard('customer')->user())
                        @lang('shop::app.checkout.success.order-id-info', [
                            'order_id' => '<a class="text-[#bd1765] hover:underline font-bold" href="'.route('shop.customers.account.orders.view', $order->id).'">#'.$order->increment_id.'</a>'
                        ])
                    @else
                        @lang('shop::app.checkout.success.order-id-info', ['order_id' => '<span class="font-bold text-[#2e2224]">#'.$order->increment_id.'</span>'])
                    @endif
                </div>

                <!-- Confirmation Message -->
                <p class="font-sans text-sm md:text-base text-[#2e2224]/70 max-w-md mx-auto leading-relaxed mt-2 mb-8">
                    @if (! empty($order->checkout_message))
                        {!! nl2br($order->checkout_message) !!}
                    @else
                        @lang('shop::app.checkout.success.info')
                    @endif
                </p>

                {{ view_render_event('bagisto.shop.checkout.success.continue-shopping.before', ['order' => $order]) }}

                <!-- Continue Shopping CTA -->
                <a
                    href="{{ route('shop.home.index') }}"
                    class="inline-flex items-center justify-center gap-3 bg-[#2e2224] hover:bg-[#bd1765] text-white font-mono text-xs md:text-sm font-bold uppercase tracking-widest px-10 py-4 transition-all shadow-md"
                >
                    <span>@lang('shop::app.checkout.cart.index.continue-shopping')</span>
                    <span class="rtl:rotate-180 font-mono">→</span>
                </a>

                {{ view_render_event('bagisto.shop.checkout.success.continue-shopping.after', ['order' => $order]) }}
            </div>
        </div>
    </div>
</x-shop::layouts>
