<div class="bg-white border border-[#2e2224] p-6 md:p-8 shadow-luxury">
    <!-- Header -->
    <div class="flex items-center justify-between pb-4 border-b border-[#2e2224]/15 mb-6">
        <h2 class="font-serif font-bold text-xl md:text-2xl text-[#2e2224] uppercase tracking-wide">
            @lang('shop::app.checkout.onepage.summary.cart-summary')
        </h2>
        <span class="font-mono text-xs font-bold px-2 py-0.5 bg-[#fbf8f1] border border-[#2e2224]/30 text-[#2e2224]">
            @{{ cart.items_count }} {{ trans('nc::app.cart.items') ?? 'ITEMS' }}
        </span>
    </div>

    <!-- Cart Items List -->
    <div class="divide-y divide-[#2e2224]/10 max-h-80 overflow-y-auto pe-2 mb-6">
        <div
            class="flex items-start gap-4 py-4 first:pt-0 last:pb-0"
            v-for="item in cart.items"
        >
            {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_image.before') !!}

            <img
                class="w-16 h-16 object-cover border border-[#2e2224] bg-[#fbf8f1] shrink-0"
                :src="item.base_image?.small_image_url || '/themes/shop/nebula-cosmetics/images/cleo-hero-product.jpg'"
                :alt="item.name"
                width="64"
                height="64"
            />

            {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_image.after') !!}

            <div class="flex-1 min-w-0">
                {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_name.before') !!}

                <h3 class="font-serif font-bold text-sm text-[#2e2224] truncate">
                    @{{ item.name }}
                </h3>

                {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_name.after') !!}

                <div class="mt-1 flex items-center justify-between">
                    <span class="font-mono text-xs text-[#2e2224]/60">
                        QTY: @{{ item.quantity }}
                    </span>

                    <span class="font-mono text-sm font-bold text-[#bd1765]">
                        <template v-if="displayTax.prices == 'including_tax'">
                            @{{ item.formatted_price_incl_tax }}
                        </template>
                        <template v-else>
                            @{{ item.formatted_price }}
                        </template>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Apply Coupon -->
    <div class="pt-4 border-t border-[#2e2224]/10 mb-6">
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.coupon.before') !!}

        @include('shop::checkout.coupon')

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.coupon.after') !!}
    </div>

    <!-- Cart Totals Breakdown -->
    <div class="space-y-3 font-mono text-xs border-t border-[#2e2224]/10 pt-4 text-[#2e2224]">
        <!-- Sub Total -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.sub_total.before') !!}

        <div class="flex justify-between items-center">
            <span class="uppercase text-[#2e2224]/70">
                @lang('shop::app.checkout.onepage.summary.sub-total')
            </span>

            <span class="font-bold">
                <template v-if="displayTax.subtotal == 'including_tax'">
                    @{{ cart.formatted_sub_total_incl_tax }}
                </template>
                <template v-else>
                    @{{ cart.formatted_sub_total }}
                </template>
            </span>
        </div>

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.sub_total.after') !!}

        <!-- Discount -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.discount_amount.before') !!}

        <template v-if="cart.discount_amount && parseFloat(cart.discount_amount) > 0">
            <div class="flex justify-between items-center text-emerald-700 font-bold">
                <span class="uppercase">
                    @lang('shop::app.checkout.onepage.summary.discount-amount')
                </span>

                <span>
                    - @{{ cart.formatted_discount_amount }}
                </span>
            </div>
        </template>

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.discount_amount.after') !!}

        <!-- Delivery Charges -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.before') !!}

        <div class="flex justify-between items-center">
            <span class="uppercase text-[#2e2224]/70">
                @lang('shop::app.checkout.onepage.summary.delivery-charges')
            </span>

            <span class="font-bold text-[#bd1765]">
                <template v-if="displayTax.shipping == 'including_tax'">
                    + @{{ cart.formatted_shipping_amount_incl_tax }}
                </template>
                <template v-else>
                    + @{{ cart.formatted_shipping_amount }}
                </template>
            </span>
        </div>

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.after') !!}

        <!-- Tax -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.tax.before') !!}

        <div class="flex justify-between items-center" v-if="cart.tax_total && parseFloat(cart.tax_total) > 0">
            <span class="uppercase text-[#2e2224]/70">
                @lang('shop::app.checkout.onepage.summary.tax')
            </span>

            <span class="font-bold">
                + @{{ cart.formatted_tax_total }}
            </span>
        </div>

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.tax.after') !!}

        <!-- Grand Total -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.grand_total.before') !!}

        <div class="pt-4 mt-4 border-t-2 border-[#2e2224] flex justify-between items-baseline">
            <span class="font-mono text-sm font-bold uppercase tracking-wider text-[#2e2224]">
                @lang('shop::app.checkout.onepage.summary.grand-total')
            </span>

            <span class="font-serif text-2xl md:text-3xl font-bold text-[#bd1765]">
                @{{ cart.formatted_grand_total }}
            </span>
        </div>

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.grand_total.after') !!}
    </div>
</div>
