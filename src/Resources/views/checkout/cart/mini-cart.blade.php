<!-- Mini Cart Vue Component -->
<v-mini-cart>
    <button
        type="button"
        class="icon-cart cursor-pointer text-2xl hover:text-[#bd1765] transition-colors"
        aria-label="@lang('shop::app.checkout.cart.mini-cart.shopping-cart')"
    ></button>
</v-mini-cart>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-mini-cart-template"
    >
        {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.before') !!}

        @if (core()->getConfigData('sales.checkout.mini_cart.display_mini_cart'))
            <x-shop::drawer>
                <!-- Drawer Toggler -->
                <x-slot:toggle>
                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.before') !!}

                    <span class="relative">
                        <button
                            type="button"
                            class="icon-cart cursor-pointer text-2xl hover:text-[#bd1765] transition-colors"
                            aria-label="@lang('shop::app.checkout.cart.mini-cart.shopping-cart')"
                            @click="getCart"
                        ></button>

                        @if (core()->getConfigData('sales.checkout.mini_cart.summary') == 'display_item_quantity')
                            <span
                                class="absolute -top-3 rounded-full bg-[#bd1765] px-1.5 py-0.5 font-mono text-[10px] font-bold text-white ltr:left-4 rtl:right-4"
                                v-if="cart?.items_qty"
                            >
                                @{{ cart.items_qty }}
                            </span>
                        @else
                            <span
                                class="absolute -top-3 rounded-full bg-[#bd1765] px-1.5 py-0.5 font-mono text-[10px] font-bold text-white ltr:left-4 rtl:right-4"
                                v-if="cart?.items_count"
                            >
                                @{{ cart.items_count }}
                            </span>
                        @endif
                    </span>

                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.after') !!}
                </x-slot>

                <!-- Drawer Header -->
                <x-slot:header class="p-6 border-b border-[#2e2224]/10 bg-[#fbf8f1]">
                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.header.before') !!}

                    <div class="flex items-center justify-between">
                        <p class="font-serif text-2xl font-bold uppercase tracking-wider text-[#2e2224]">
                            @lang('shop::app.checkout.cart.mini-cart.shopping-cart')
                        </p>
                    </div>

                    <p class="font-mono text-xs text-[#2e2224]/60 mt-1" v-if="{{ json_encode((bool) core()->getConfigData('sales.checkout.mini_cart.offer_info')) }}">
                        {{ core()->getConfigData('sales.checkout.mini_cart.offer_info')}}
                    </p>

                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.header.after') !!}
                </x-slot>

                <!-- Drawer Content -->
                <x-slot:content class="p-6 bg-white">
                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.before') !!}

                    <!-- Cart Item Listing -->
                    <div
                        class="grid gap-6"
                        v-if="cart?.items?.length"
                    >
                        <div
                            class="flex gap-x-4 border-b border-[#2e2224]/10 pb-6"
                            v-for="item in cart?.items"
                        >
                            <!-- Cart Item Image -->
                            {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.image.before') !!}

                            <div class="shrink-0">
                                <a :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', item.product_url_key)">
                                    <img
                                        :src="item.base_image.small_image_url"
                                        :alt="item.base_image.alt"
                                        class="w-20 h-20 border border-[#2e2224]/20 object-cover"
                                    />
                                </a>
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.image.after') !!}

                            <!-- Cart Item Information -->
                            <div class="grid flex-1 place-content-start justify-stretch gap-y-2">
                                <div class="flex justify-between gap-2">
                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.name.before') !!}

                                    <a
                                        class="max-w-[75%]"
                                        :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', item.product_url_key)"
                                    >
                                        <p class="font-serif text-sm font-bold text-[#2e2224] hover:text-[#bd1765] transition-colors leading-snug">
                                            @{{ item.name }}
                                        </p>
                                    </a>

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.name.after') !!}

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.price.before') !!}

                                    <template v-if="displayTax.prices == 'including_tax'">
                                        <p class="font-serif text-base font-bold text-[#bd1765]">
                                            @{{ item.formatted_price_incl_tax }}
                                        </p>
                                    </template>

                                    <template v-else-if="displayTax.prices == 'both'">
                                        <p class="flex flex-col text-right font-serif text-base font-bold text-[#bd1765]">
                                            @{{ item.formatted_price_incl_tax }}

                                            <span class="font-mono text-[10px] font-normal text-[#2e2224]/50">
                                                @lang('shop::app.checkout.cart.mini-cart.excl-tax')
                                                <span class="font-bold">@{{ item.formatted_price }}</span>
                                            </span>
                                        </p>
                                    </template>

                                    <template v-else>
                                        <p class="font-serif text-base font-bold text-[#bd1765]">
                                            @{{ item.formatted_price }}
                                        </p>
                                    </template>

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.price.after') !!}
                                </div>

                                <!-- Cart Item Options Container -->
                                <div
                                    class="grid select-none gap-x-2 gap-y-1"
                                    v-if="item.options.length"
                                >
                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.product_details.before') !!}

                                    <!-- Details Toggler -->
                                    <div>
                                        <button
                                            type="button"
                                            class="flex cursor-pointer items-center gap-x-2 font-mono text-xs uppercase tracking-wider text-[#2e2224]/60 hover:text-[#bd1765] transition-colors"
                                            @click="item.option_show = ! item.option_show"
                                        >
                                            @lang('shop::app.checkout.cart.mini-cart.see-details')

                                            <span
                                                class="text-base"
                                                :class="{'icon-arrow-up': item.option_show, 'icon-arrow-down': ! item.option_show}"
                                            ></span>
                                        </button>
                                    </div>

                                    <!-- Option Details -->
                                    <div
                                        class="grid gap-1"
                                        v-show="item.option_show"
                                    >
                                        <template v-for="attribute in item.options">
                                            <div class="grid gap-0.5">
                                                <p class="font-mono text-[10px] font-bold uppercase tracking-wider text-[#2e2224]/50">
                                                    @{{ attribute.attribute_name + ':' }}
                                                </p>

                                                <p class="font-mono text-xs text-[#2e2224]">
                                                    <template v-if="attribute?.attribute_type === 'file'">
                                                        <a
                                                            :href="attribute.file_url"
                                                            class="text-[#bd1765] underline"
                                                            target="_blank"
                                                            :download="attribute.file_name"
                                                        >
                                                            @{{ attribute.file_name }}
                                                        </a>
                                                    </template>

                                                    <template v-else>
                                                        @{{ attribute.option_label }}
                                                    </template>
                                                </p>
                                            </div>
                                        </template>
                                    </div>

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.product_details.after') !!}
                                </div>

                                <div class="flex items-center justify-between gap-4 mt-1">
                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.quantity_changer.before') !!}

                                    <!-- Cart Item Quantity Changer -->
                                    <x-shop::quantity-changer
                                        v-if="item.can_change_qty"
                                        ::key="'qty-' + item.id + '-' + refreshKey"
                                        class="flex max-w-max items-center gap-x-2.5 border border-[#2e2224] px-2.5 py-1 text-xs font-mono"
                                        name="quantity"
                                        ::value="item?.quantity"
                                        :removable="true"
                                        @change="updateItem($event, item)"
                                        @remove="removeItem(item.id)"
                                    />

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.quantity_changer.after') !!}

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.remove_button.before') !!}

                                    <!-- Cart Item Remove Button -->
                                    <button
                                        type="button"
                                        class="cursor-pointer font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/50 hover:text-red-600 transition-colors"
                                        @click="removeItem(item.id)"
                                    >
                                        @lang('shop::app.checkout.cart.mini-cart.remove')
                                    </button>

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.remove_button.after') !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty Cart Section -->
                    <div
                        class="py-20 text-center"
                        v-else
                    >
                        <img
                            class="w-20 h-20 mx-auto opacity-70 mb-4"
                            src="{{ bagisto_asset('images/thank-you.png') }}"
                            loading="lazy"
                            decoding="async"
                        >

                        <p
                            class="font-serif text-lg text-[#2e2224]"
                            role="heading"
                        >
                            @lang('shop::app.checkout.cart.mini-cart.empty-cart')
                        </p>
                    </div>

                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.after') !!}
                </x-slot>

                <!-- Drawer Footer -->
                <x-slot:footer class="p-6 border-t border-[#2e2224]/10 bg-[#fbf8f1]">
                    <div
                        v-if="cart?.items?.length"
                        class="grid gap-4"
                    >
                        <div
                            class="flex items-center justify-between pb-3 border-b border-[#2e2224]/15"
                            :class="{'justify-end!': isLoading}"
                        >
                            {!! view_render_event('bagisto.shop.checkout.mini-cart.subtotal.before') !!}

                            <template v-if="! isLoading">
                                <p class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/60">
                                    @lang('shop::app.checkout.cart.mini-cart.subtotal')
                                </p>

                                <template v-if="displayTax.subtotal == 'including_tax'">
                                    <p class="font-serif text-2xl font-bold text-[#bd1765]">
                                        @{{ cart.formatted_sub_total_incl_tax }}
                                    </p>
                                </template>

                                <template v-else-if="displayTax.subtotal == 'both'">
                                    <div class="text-right">
                                        <p class="font-serif text-2xl font-bold text-[#bd1765]">
                                            @{{ cart.formatted_sub_total_incl_tax }}
                                        </p>

                                        <span class="font-mono text-[10px] text-[#2e2224]/50">
                                            @lang('shop::app.checkout.cart.mini-cart.excl-tax')
                                            <span class="font-bold">@{{ cart.formatted_sub_total }}</span>
                                        </span>
                                    </div>
                                </template>

                                <template v-else>
                                    <p class="font-serif text-2xl font-bold text-[#bd1765]">
                                        @{{ cart.formatted_sub_total }}
                                    </p>
                                </template>
                            </template>

                            <template v-else>
                                <svg
                                    class="w-6 h-6 animate-spin text-[#bd1765]"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    aria-hidden="true"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    ></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                            </template>

                            {!! view_render_event('bagisto.shop.checkout.mini-cart.subtotal.after') !!}
                        </div>

                        {!! view_render_event('bagisto.shop.checkout.mini-cart.action.before') !!}

                        <!-- Cart Action Buttons -->
                        <div class="grid gap-2.5">
                            {!! view_render_event('bagisto.shop.checkout.mini-cart.continue_to_checkout.before') !!}

                            <a
                                href="{{ route('shop.checkout.onepage.index') }}"
                                class="w-full text-center bg-[#bd1765] hover:bg-[#8f0e4b] text-white font-mono text-xs font-bold uppercase tracking-widest py-3.5 px-6 transition-colors shadow-sm"
                            >
                                @lang('shop::app.checkout.cart.mini-cart.continue-to-checkout')
                            </a>

                            {!! view_render_event('bagisto.shop.checkout.mini-cart.continue_to_checkout.after') !!}

                            <a
                                href="{{ route('shop.checkout.cart.index') }}"
                                class="w-full text-center border border-[#2e2224] bg-white text-[#2e2224] hover:bg-[#2e2224] hover:text-white font-mono text-xs font-bold uppercase tracking-widest py-3 px-6 transition-colors"
                            >
                                @lang('shop::app.checkout.cart.mini-cart.view-cart')
                            </a>
                        </div>

                        {!! view_render_event('bagisto.shop.checkout.mini-cart.action.after') !!}
                    </div>
                </x-slot>
            </x-shop::drawer>
        @else
            <a
                href="{{ route('shop.checkout.onepage.index') }}"
                aria-label="@lang('shop::app.checkout.cart.mini-cart.shopping-cart')"
            >
                {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.before') !!}

                <span class="relative">
                    <span
                        class="icon-cart cursor-pointer text-2xl hover:text-[#bd1765] transition-colors"
                        aria-hidden="true"
                    ></span>

                    <span
                        class="absolute -top-3 rounded-full bg-[#bd1765] px-1.5 py-0.5 font-mono text-[10px] font-bold text-white ltr:left-4 rtl:right-4"
                        v-if="cart?.items_qty"
                    >
                        @{{ cart.items_qty }}
                    </span>
                </span>

                {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.after') !!}
            </a>
        @endif

        {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.after') !!}
    </script>

    @php
        $hasCartItems = (bool) \Webkul\Checkout\Facades\Cart::getCart()?->items->isNotEmpty();

        $willResponseBeCached = \Webkul\FPC\FullPageCache::willCache();
    @endphp

    <script type="module">
        app.component("v-mini-cart", {
            template: '#v-mini-cart-template',

            data() {
                @if ($willResponseBeCached)
                    let miniCart = '<bagisto-response-cache-mini-cart>';
                @else
                    let miniCart = {!! $hasCartItems ? 'null' : json_encode(['items_qty' => 0, 'items' => []]) !!};
                @endif

                return  {
                    refreshKey: 0,

                    cart: miniCart,

                    isLoading: false,

                    displayTax: {
                        prices: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_prices') }}",
                        subtotal: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_subtotal') }}",
                    },
                };
            },

            mounted() {
                if (typeof this.cart === 'string') {
                    this.cart = null;
                }

                if (! this.cart) {
                    this.getCart();
                }

                this.$emitter.on('update-mini-cart', (cart) => {
                    this.cart = cart;
                });
            },

            methods: {
                getCart() {
                    this.$axios.get('{{ route('shop.api.checkout.cart.index') }}')
                        .then(response => {
                            this.cart = response.data.data;
                        })
                        .catch(error => {});
                },

                updateItem(quantity, item) {
                    this.isLoading = true;

                    let qty = {};

                    qty[item.id] = quantity;

                    this.$axios.put('{{ route('shop.api.checkout.cart.update') }}', { qty })
                        .then(response => {
                            this.isLoading = false;

                            const payload = response.data.data;

                            if (payload && payload.items !== undefined) {
                                this.cart = payload;
                            } else {
                                this.$emitter.emit('add-flash', {
                                    type: 'warning',
                                    message: payload?.message || response.data.message,
                                });
                            }

                            this.refreshKey++;
                        })
                        .catch(error => {
                            this.isLoading = false;

                            this.$emitter.emit('add-flash', {
                                type: 'error',
                                message: error.response?.data?.message || error.message,
                            });

                            this.refreshKey++;
                        });
                },

                removeItem(itemId) {
                    this.$emitter.emit('open-confirm-modal', {
                        agree: () => {
                            this.isLoading = true;

                            this.$axios.post('{{ route('shop.api.checkout.cart.destroy') }}', {
                                '_method': 'DELETE',
                                'cart_item_id': itemId,
                            })
                            .then(response => {
                                this.cart = response.data.data;

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                this.isLoading = false;
                            })
                            .catch(error => {
                                this.$emitter.emit('add-flash', { type: 'error', message: response.data.message });

                                this.isLoading = false;
                            });
                        }
                    });
                },
            },
        });
    </script>
@endpushOnce
