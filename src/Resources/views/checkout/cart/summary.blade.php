<!-- Cart Summary Sidebar -->
<div class="w-full lg:w-96 shrink-0">
    {!! view_render_event('bagisto.shop.checkout.cart.summary.title.before') !!}

    <div class="bg-white border border-[#2e2224]/15 p-6 md:p-8 shadow-[0_4px_20px_rgba(46,34,36,0.06)]">
        <p
            class="font-serif text-2xl font-bold text-[#2e2224] uppercase tracking-wide"
            role="heading"
            aria-level="1"
        >
            @lang('shop::app.checkout.cart.summary.cart-summary')
        </p>

        {!! view_render_event('bagisto.shop.checkout.cart.summary.title.after') !!}

        <div class="mt-6 grid gap-4">
            <!-- Estimate Tax and Shipping -->
            @if (core()->getConfigData('sales.checkout.shopping_cart.estimate_shipping'))
                <template v-if="cart.have_stockable_items">
                    @include('shop::checkout.cart.summary.estimate-shipping')
                </template>
            @endif

            <!-- Sub Total -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.sub_total.before') !!}

            <template v-if="displayTax.subtotal == 'including_tax'">
                <div class="flex justify-between items-center">
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/60">
                        @lang('shop::app.checkout.cart.summary.sub-total')
                    </p>

                    <p class="font-mono text-sm font-bold text-[#2e2224]">
                        @{{ cart.formatted_sub_total_incl_tax }}
                    </p>
                </div>
            </template>

            <template v-else-if="displayTax.subtotal == 'both'">
                <div class="flex justify-between items-center">
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/60">
                        @lang('shop::app.checkout.cart.summary.sub-total')
                    </p>

                    <div class="text-right">
                        <p class="font-mono text-sm font-bold text-[#2e2224]">
                            @{{ cart.formatted_sub_total_incl_tax }}
                        </p>

                        <p class="font-mono text-[10px] text-[#2e2224]/40 italic">
                            @lang('shop::app.checkout.cart.summary.excl-tax') @{{ cart.formatted_sub_total }}
                        </p>
                    </div>
                </div>
            </template>

            <template v-else>
                <div class="flex justify-between items-center">
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/60">
                        @lang('shop::app.checkout.cart.summary.sub-total')
                    </p>

                    <p class="font-mono text-sm font-bold text-[#2e2224]">
                        @{{ cart.formatted_sub_total }}
                    </p>
                </div>
            </template>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.sub_total.after') !!}

            <!-- Discount -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.discount_amount.before') !!}

            <template v-if="cart.discount_amount && parseFloat(cart.discount_amount) > 0">
                <div
                    class="flex justify-between items-center"
                    v-if="parseFloat(cart.items_discount_amount || 0) <= 0 || parseFloat(cart.shipping_discount_amount || 0) <= 0"
                >
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-[#bd1765]">
                        @lang('shop::app.checkout.cart.summary.discount-amount')
                    </p>

                    <p class="font-mono text-sm font-bold text-[#bd1765]">
                        - @{{ cart.formatted_discount_amount }}
                    </p>
                </div>

                <div
                    class="flex flex-col gap-2 border-y border-[#2e2224]/10 py-3"
                    v-else
                >
                    <div
                        class="flex cursor-pointer justify-between items-center"
                        @click="cart.show_discount_breakdown = ! cart.show_discount_breakdown"
                    >
                        <p class="font-mono text-xs font-bold uppercase tracking-wider text-[#bd1765]">
                            @lang('shop::app.checkout.cart.summary.discount-amount')
                        </p>

                        <p class="flex items-center gap-1 font-mono text-sm font-bold text-[#bd1765]">
                            - @{{ cart.formatted_discount_amount }}

                            <span
                                class="text-lg"
                                :class="{'icon-arrow-up': cart.show_discount_breakdown, 'icon-arrow-down': ! cart.show_discount_breakdown}"
                            ></span>
                        </p>
                    </div>

                    <div
                        class="flex flex-col gap-1"
                        v-show="cart.show_discount_breakdown"
                    >
                        <div class="flex justify-between gap-1">
                            <p class="font-mono text-[10px] text-[#2e2224]/50">
                                @lang('shop::app.checkout.cart.summary.items-discount')
                            </p>

                            <p class="font-mono text-[10px] font-bold text-[#2e2224]/50">
                                - @{{ cart.formatted_items_discount_amount }}
                            </p>
                        </div>

                        <div class="flex justify-between gap-1">
                            <p class="font-mono text-[10px] text-[#2e2224]/50">
                                @lang('shop::app.checkout.cart.summary.shipping-discount')
                            </p>

                            <p class="font-mono text-[10px] font-bold text-[#2e2224]/50">
                                - @{{ cart.formatted_shipping_discount_amount }}
                            </p>
                        </div>
                    </div>
                </div>
            </template>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.discount_amount.after') !!}

            <!-- Apply Coupon -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.coupon.before') !!}

            @include('shop::checkout.coupon')

            {!! view_render_event('bagisto.shop.checkout.cart.summary.coupon.after') !!}

            <!-- Shipping Rates -->
            {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.before') !!}

            <template v-if="displayTax.shipping == 'including_tax'">
                <div class="flex justify-between items-center">
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/60">
                        @lang('shop::app.checkout.cart.summary.delivery-charges')
                    </p>

                    <p class="font-mono text-sm font-bold text-[#2e2224]">
                        + @{{ cart.formatted_shipping_amount_incl_tax }}
                    </p>
                </div>
            </template>

            <template v-else-if="displayTax.shipping == 'both'">
                <div class="flex justify-between items-center">
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/60">
                        @lang('shop::app.checkout.cart.summary.delivery-charges')
                    </p>

                    <div class="text-right">
                        <p class="font-mono text-sm font-bold text-[#2e2224]">
                            + @{{ cart.formatted_shipping_amount_incl_tax }}
                        </p>

                        <p class="font-mono text-[10px] text-[#2e2224]/40 italic">
                            @lang('shop::app.checkout.cart.summary.excl-tax') @{{ cart.formatted_shipping_amount }}
                        </p>
                    </div>
                </div>
            </template>

            <template v-else>
                <div class="flex justify-between items-center">
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/60">
                        @lang('shop::app.checkout.cart.summary.delivery-charges')
                    </p>

                    <p class="font-mono text-sm font-bold text-[#2e2224]">
                        + @{{ cart.formatted_shipping_amount }}
                    </p>
                </div>
            </template>

            {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.after') !!}

            <!-- Taxes -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.tax.before') !!}

            @php
                $showTaxBreakdown = (bool) core()->getConfigData('sales.taxes.shopping_cart.show_tax_breakdown');
            @endphp

            <div
                class="flex justify-between items-center"
                v-if="! cart.tax_total"
            >
                <p class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/60">
                    @lang('shop::app.checkout.cart.summary.tax')
                </p>

                <p class="font-mono text-sm font-bold text-[#2e2224]">
                    + @{{ cart.formatted_tax_total }}
                </p>
            </div>

            @if ($showTaxBreakdown)
                <div
                    class="flex flex-col gap-2 border-y border-[#2e2224]/10 py-3"
                    v-else
                >
                    <button
                        type="button"
                        class="flex w-full cursor-pointer items-center justify-between gap-2 text-right focus-visible:ring-2 focus-visible:ring-[#bd1765] focus-visible:outline-hidden"
                        @click="cart.show_taxes = ! cart.show_taxes"
                    >
                        <p class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/60">
                            @lang('shop::app.checkout.cart.summary.tax')
                        </p>

                        <p class="flex items-center gap-1.5 font-mono text-sm font-bold text-[#2e2224]">
                            <template v-if="displayTax.subtotal === 'including_tax' || displayTax.subtotal === 'both'">
                                @{{ cart.formatted_tax_total }}

                                <span class="font-mono text-[10px] italic font-normal text-[#2e2224]/40">
                                    (@lang('shop::app.checkout.cart.summary.included'))
                                </span>
                            </template>

                            <template v-else>+ @{{ cart.formatted_tax_total }}</template>

                            <span
                                class="text-lg"
                                :class="{'icon-arrow-up': cart.show_taxes, 'icon-arrow-down': ! cart.show_taxes}"
                            ></span>
                        </p>
                    </button>

                    <div
                        class="flex flex-col gap-2"
                        v-show="cart.show_taxes"
                    >
                        <div
                            class="flex flex-col gap-1"
                            v-for="taxLine in cart.applied_taxes_breakdown"
                        >
                            <p class="font-mono text-xs font-bold text-[#2e2224]/60">
                                @{{ taxLine.rate }}
                            </p>

                            <div
                                class="flex items-center justify-between gap-2 ps-3"
                                v-for="product in taxLine.items"
                            >
                                <p class="truncate font-mono text-[10px] text-[#2e2224]/40">
                                    @{{ product.name }}
                                </p>

                                <p class="shrink-0 whitespace-nowrap font-mono text-[10px] text-[#2e2224]/40">
                                    <template v-if="displayTax.subtotal === 'including_tax' || displayTax.subtotal === 'both'">@{{ product.tax_amount }}</template>

                                    <template v-else>+ @{{ product.tax_amount }}</template>

                                    <span class="italic">(@{{ product.taxable_amount }})</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div
                    class="flex justify-between items-center"
                    v-else
                >
                    <p class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/60">
                        @lang('shop::app.checkout.cart.summary.tax')
                    </p>

                    <p class="flex items-center justify-end gap-1.5 font-mono text-sm font-bold text-[#2e2224]">
                        <template v-if="displayTax.subtotal === 'including_tax' || displayTax.subtotal === 'both'">
                            @{{ cart.formatted_tax_total }}

                            <span class="font-mono text-[10px] italic font-normal text-[#2e2224]/40">
                                (@lang('shop::app.checkout.cart.summary.included'))
                            </span>
                        </template>

                        <template v-else>+ @{{ cart.formatted_tax_total }}</template>
                    </p>
                </div>
            @endif

            {!! view_render_event('bagisto.shop.checkout.cart.summary.tax.after') !!}

            <!-- Divider -->
            <div class="border-t border-[#2e2224]/15 my-2"></div>

            <!-- Cart Grand Total -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.grand_total.before') !!}

            <div class="flex justify-between items-center">
                <p class="font-serif text-xl font-bold text-[#2e2224] uppercase tracking-wide">
                    @lang('shop::app.checkout.cart.summary.grand-total')
                </p>

                <p class="font-serif text-2xl font-bold text-[#bd1765]">
                    @{{ cart.formatted_grand_total }}
                </p>
            </div>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.grand_total.after') !!}

            {!! view_render_event('bagisto.shop.checkout.cart.summary.proceed_to_checkout.before') !!}

            <a
                href="{{ route('shop.checkout.onepage.index') }}"
                class="mt-4 w-full inline-flex items-center justify-center bg-[#bd1765] hover:bg-[#8f0e4b] text-white font-mono text-xs md:text-sm font-bold uppercase tracking-widest py-4 transition-colors"
            >
                @lang('shop::app.checkout.cart.summary.proceed-to-checkout')
            </a>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.proceed_to_checkout.after') !!}
        </div>
    </div>
</div>
