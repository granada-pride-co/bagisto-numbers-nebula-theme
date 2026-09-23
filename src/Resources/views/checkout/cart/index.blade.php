<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.checkout.cart.index.cart')"/>
    <meta name="keywords" content="@lang('shop::app.checkout.cart.index.cart')"/>
@endPush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.checkout.cart.index.cart')
    </x-slot>

    {!! view_render_event('bagisto.shop.checkout.cart.header.before') !!}

    <!-- Luxury Cart Header -->
    <header class="border-b border-[#2e2224]/15 bg-[#fffefd] sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 md:px-12 py-4 flex items-center justify-between">
            <div class="flex items-center gap-6">
                {!! view_render_event('bagisto.shop.checkout.cart.logo.before') !!}

                <a
                    href="{{ route('shop.home.index') }}"
                    class="flex items-center gap-3 transition-opacity hover:opacity-80"
                    aria-label="@lang('shop::app.checkout.cart.index.bagisto')"
                >
                    <img
                        src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                        alt="{{ core()->getCurrentChannel()->logo_alt ?: config('app.name') }}"
                        class="h-7 md:h-9 w-auto object-contain"
                    >
                </a>

                {!! view_render_event('bagisto.shop.checkout.cart.logo.after') !!}
            </div>

            <div class="flex items-center gap-4 text-xs font-mono">
                @guest('customer')
                    @include('shop::checkout.login')
                @else
                    <div class="flex items-center gap-2 text-[#2e2224] font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>{{ auth()->guard('customer')->user()->first_name }}</span>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    {!! view_render_event('bagisto.shop.checkout.cart.header.after') !!}

    <!-- Main Cart Content -->
    <div class="min-h-screen bg-[#fbf8f1] py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-6 md:px-12">

            {!! view_render_event('bagisto.shop.checkout.cart.breadcrumbs.before') !!}

            @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
                <x-shop::breadcrumbs name="cart" />
            @endif

            {!! view_render_event('bagisto.shop.checkout.cart.breadcrumbs.after') !!}

            <!-- Page Heading -->
            <h1 class="font-serif text-3xl md:text-4xl font-bold text-[#2e2224] uppercase tracking-wide mb-8 md:mb-10">
                @lang('shop::app.checkout.cart.index.cart')
            </h1>

            @php
                $errors = \Webkul\Checkout\Facades\Cart::getErrors();
            @endphp

            @if (! empty($errors) && $errors['error_code'] === 'MINIMUM_ORDER_AMOUNT')
                <div class="mb-6 border border-amber-400/50 bg-amber-50 px-5 py-3 text-sm font-mono text-[#2e2224]">
                    {{ $errors['message'] }}: {{ $errors['amount'] }}
                </div>
            @endif

            <v-cart ref="vCart">
                <x-shop::shimmer.checkout.cart :count="3" />
            </v-cart>
        </div>
    </div>

    @if (core()->getConfigData('sales.checkout.shopping_cart.cross_sell'))
        {!! view_render_event('bagisto.shop.checkout.cart.cross_sell_carousel.before') !!}

        <x-shop::products.carousel
            :title="trans('shop::app.checkout.cart.index.cross-sell.title')"
            :src="route('shop.api.checkout.cart.cross-sell.index')"
        >
        </x-shop::products.carousel>

        {!! view_render_event('bagisto.shop.checkout.cart.cross_sell_carousel.after') !!}
    @endif

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-cart-template"
        >
            <div>
                <!-- Cart Shimmer Effect -->
                <template v-if="isLoading">
                    <x-shop::shimmer.checkout.cart :count="3" />
                </template>

                <!-- Cart Information -->
                <template v-else>
                    <div
                        class="flex flex-wrap gap-10 lg:gap-16 max-lg:flex-col"
                        v-if="cart?.items?.length"
                    >
                        <!-- Left Column: Cart Items -->
                        <div class="flex flex-1 flex-col gap-6">

                            {!! view_render_event('bagisto.shop.checkout.cart.cart_mass_actions.before') !!}

                            <!-- Cart Mass Action Container -->
                            <div class="flex items-center justify-between border-b border-[#2e2224]/15 pb-4">
                                <div class="flex select-none items-center">
                                    <input
                                        type="checkbox"
                                        id="select-all"
                                        class="peer hidden"
                                        v-model="allSelected"
                                        @change="selectAll"
                                    >

                                    <label
                                        class="icon-uncheck peer-checked:icon-check-box cursor-pointer text-2xl text-[#2e2224] peer-checked:text-[#bd1765]"
                                        for="select-all"
                                        tabindex="0"
                                        aria-label="@lang('shop::app.checkout.cart.index.select-all')"
                                        aria-labelledby="select-all-label"
                                    >
                                    </label>

                                    <span
                                        class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/70 ltr:ml-3 rtl:mr-3"
                                        role="heading"
                                        aria-level="2"
                                    >
                                        @{{ "@lang('shop::app.checkout.cart.index.items-selected')".replace(':count', selectedItemsCount) }}
                                    </span>
                                </div>

                                <div v-if="selectedItemsCount" class="flex items-center gap-3">
                                    <span
                                        class="cursor-pointer font-mono text-xs font-bold uppercase tracking-wider text-[#bd1765] hover:text-[#8f0e4b] transition-colors"
                                        role="button"
                                        tabindex="0"
                                        @click="removeSelectedItems"
                                    >
                                        @lang('shop::app.checkout.cart.index.remove')
                                    </span>

                                    @if (auth()->guard()->check())
                                        <span class="border-r border-[#2e2224]/20 h-4"></span>

                                        <span
                                            class="cursor-pointer font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/70 hover:text-[#bd1765] transition-colors"
                                            role="button"
                                            tabindex="0"
                                            @click="moveToWishlistSelectedItems"
                                        >
                                            @lang('shop::app.checkout.cart.index.move-to-wishlist')
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.cart.cart_mass_actions.after') !!}

                            {!! view_render_event('bagisto.shop.checkout.cart.item.listing.before') !!}

                            <!-- Cart Item Listing -->
                            <div
                                class="grid gap-y-6"
                                v-for="item in cart?.items"
                            >
                                <div class="flex justify-between gap-x-4 border-b border-[#2e2224]/10 pb-6">
                                    <div class="flex gap-x-4 md:gap-x-6">
                                        <!-- Item Checkbox -->
                                        <div class="mt-10 md:mt-12 select-none">
                                            <input
                                                type="checkbox"
                                                :id="'item_' + item.id"
                                                class="peer hidden"
                                                v-model="item.selected"
                                                @change="updateAllSelected"
                                            >

                                            <label
                                                class="icon-uncheck peer-checked:icon-check-box cursor-pointer text-2xl text-[#2e2224] peer-checked:text-[#bd1765]"
                                                :for="'item_' + item.id"
                                                tabindex="0"
                                                aria-label="@lang('shop::app.checkout.cart.index.select-cart-item')"
                                                aria-labelledby="select-item-label"
                                            ></label>
                                        </div>

                                        {!! view_render_event('bagisto.shop.checkout.cart.item_image.before') !!}

                                        <!-- Cart Item Image -->
                                        <a :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', item.product_url_key)">
                                            <img
                                                class="h-24 w-24 md:h-28 md:w-28 border border-[#2e2224]/20 object-cover bg-white shrink-0"
                                                :src="item.base_image?.small_image_url || '/themes/shop/nebula-cosmetics/images/cleo-hero-product.jpg'"
                                                :alt="item.base_image?.alt || item.name"
                                                width="110"
                                                height="110"
                                                loading="lazy"
                                            />
                                        </a>

                                        {!! view_render_event('bagisto.shop.checkout.cart.item_image.after') !!}

                                        <!-- Cart Item Details -->
                                        <div class="grid place-content-start gap-y-2">
                                            {!! view_render_event('bagisto.shop.checkout.cart.item_name.before') !!}

                                            <a :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', item.product_url_key)">
                                                <p class="font-serif text-base md:text-lg font-semibold text-[#2e2224] leading-snug">
                                                    @{{ item.name }}
                                                </p>
                                            </a>

                                            {!! view_render_event('bagisto.shop.checkout.cart.item_name.after') !!}

                                            {!! view_render_event('bagisto.shop.checkout.cart.item_details.before') !!}

                                            <!-- Cart Item Options -->
                                            <div
                                                class="grid select-none gap-x-2 gap-y-1"
                                                v-if="item.options.length"
                                            >
                                                <div>
                                                    <p
                                                        class="flex cursor-pointer items-center gap-x-2 font-mono text-xs uppercase tracking-wider text-[#2e2224]/60 hover:text-[#bd1765] transition-colors"
                                                        @click="item.option_show = ! item.option_show"
                                                    >
                                                        @lang('shop::app.checkout.cart.index.see-details')

                                                        <span
                                                            class="text-lg"
                                                            :class="{'icon-arrow-up': item.option_show, 'icon-arrow-down': ! item.option_show}"
                                                        ></span>
                                                    </p>
                                                </div>

                                                <div
                                                    class="grid gap-1.5"
                                                    v-show="item.option_show"
                                                >
                                                    <template v-for="attribute in item.options">
                                                        <div class="max-md:grid max-md:gap-0.5">
                                                            <p class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/50">
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
                                            </div>

                                            {!! view_render_event('bagisto.shop.checkout.cart.item_details.after') !!}

                                            {!! view_render_event('bagisto.shop.checkout.cart.formatted_total.before') !!}

                                            <!-- Mobile Price -->
                                            <div class="md:hidden">
                                                <p class="font-serif text-base font-bold text-[#bd1765]">
                                                    <template v-if="displayTax.prices == 'including_tax'">
                                                            @{{ item.formatted_total_incl_tax }}
                                                    </template>

                                                    <template v-else-if="displayTax.prices == 'both'">
                                                        @{{ item.formatted_total_incl_tax }}
                                                        <span class="text-xs font-mono font-normal text-[#2e2224]/50">
                                                            @lang('shop::app.checkout.cart.index.excl-tax')
                                                            <span class="font-bold">@{{ item.formatted_total }}</span>
                                                        </span>
                                                    </template>

                                                    <template v-else>
                                                            @{{ item.formatted_total }}
                                                    </template>
                                                </p>
                                            </div>

                                            {!! view_render_event('bagisto.shop.checkout.cart.formatted_total.after') !!}

                                            {!! view_render_event('bagisto.shop.checkout.cart.quantity_changer.before') !!}

                                            <div class="flex items-center gap-3 mt-1">
                                                <x-shop::quantity-changer
                                                    v-if="item.can_change_qty"
                                                    ::key="'qty-' + item.id + '-' + refreshKey"
                                                    class="flex max-w-max items-center gap-x-3 border border-[#2e2224] px-3 py-1.5"
                                                    name="quantity"
                                                    ::value="item?.quantity"
                                                    :removable="true"
                                                    @change="setItemQuantity(item.id, $event)"
                                                    @remove="removeItem(item.id)"
                                                />

                                                <span
                                                    class="hidden cursor-pointer font-mono text-xs font-bold uppercase tracking-wider text-[#bd1765] hover:text-[#8f0e4b] max-md:inline transition-colors"
                                                    role="button"
                                                    tabindex="0"
                                                    @click="removeItem(item.id)"
                                                >
                                                    @lang('shop::app.checkout.cart.index.remove')
                                                </span>
                                            </div>

                                            {!! view_render_event('bagisto.shop.checkout.cart.quantity_changer.after') !!}
                                        </div>
                                    </div>

                                    <!-- Desktop Price & Remove -->
                                    <div class="text-right max-md:hidden shrink-0">
                                        {!! view_render_event('bagisto.shop.checkout.cart.total.before') !!}

                                        <template v-if="displayTax.prices == 'including_tax'">
                                            <p class="font-serif text-lg font-bold text-[#bd1765]">
                                                @{{ item.formatted_total_incl_tax }}
                                            </p>
                                        </template>

                                        <template v-else-if="displayTax.prices == 'both'">
                                            <p class="flex flex-col font-serif text-lg font-bold text-[#bd1765]">
                                                @{{ item.formatted_total_incl_tax }}

                                                <span class="text-xs font-mono font-normal text-[#2e2224]/50">
                                                    @lang('shop::app.checkout.cart.index.excl-tax')
                                                    <span class="font-bold">@{{ item.formatted_total }}</span>
                                                </span>
                                            </p>
                                        </template>

                                        <template v-else>
                                            <p class="font-serif text-lg font-bold text-[#bd1765]">
                                                @{{ item.formatted_total }}
                                            </p>
                                        </template>

                                        {!! view_render_event('bagisto.shop.checkout.cart.total.after') !!}

                                        {!! view_render_event('bagisto.shop.checkout.cart.remove_button.before') !!}

                                        <span
                                            class="cursor-pointer font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/50 hover:text-[#bd1765] transition-colors mt-2 inline-block"
                                            role="button"
                                            tabindex="0"
                                            @click="removeItem(item.id)"
                                        >
                                            @lang('shop::app.checkout.cart.index.remove')
                                        </span>

                                        {!! view_render_event('bagisto.shop.checkout.cart.remove_button.after') !!}
                                    </div>
                                </div>
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.cart.item.listing.after') !!}

                            {!! view_render_event('bagisto.shop.checkout.cart.controls.before') !!}

                            <!-- Cart Item Actions -->
                            <div class="flex flex-wrap justify-end gap-4 mt-2">
                                {!! view_render_event('bagisto.shop.checkout.cart.continue_shopping.before') !!}

                                <a
                                    class="inline-flex items-center justify-center border border-[#2e2224] bg-white text-[#2e2224] font-mono text-xs font-bold uppercase tracking-widest px-8 py-3 hover:bg-[#2e2224] hover:text-white transition-colors"
                                    href="{{ route('shop.home.index') }}"
                                >
                                    @lang('shop::app.checkout.cart.index.continue-shopping')
                                </a>

                                {!! view_render_event('bagisto.shop.checkout.cart.continue_shopping.after') !!}

                                {!! view_render_event('bagisto.shop.checkout.cart.update_cart.before') !!}

                                <x-shop::button
                                    class="inline-flex items-center justify-center bg-[#2e2224] text-white font-mono text-xs font-bold uppercase tracking-widest px-8 py-3 hover:bg-[#bd1765] transition-colors border-0 cursor-pointer"
                                    :title="trans('shop::app.checkout.cart.index.update-cart')"
                                    ::loading="isStoring"
                                    ::disabled="isStoring"
                                    @click="update()"
                                />

                                {!! view_render_event('bagisto.shop.checkout.cart.update_cart.after') !!}
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.cart.controls.after') !!}
                        </div>

                        {!! view_render_event('bagisto.shop.checkout.cart.summary.before') !!}

                        @include('shop::checkout.cart.summary')

                        {!! view_render_event('bagisto.shop.checkout.cart.summary.after') !!}
                    </div>

                    <!-- Empty Cart Section -->
                    <div
                        class="m-auto grid w-full place-content-center items-center justify-items-center py-32 text-center"
                        v-else
                    >
                        <img
                            class="max-md:h-25 max-md:w-25"
                            src="{{ bagisto_asset('images/thank-you.png') }}"
                            alt="@lang('shop::app.checkout.cart.index.empty-product')"
                            loading="lazy"
                            decoding="async"
                        />

                        <p
                            class="font-serif text-xl text-[#2e2224] mt-4"
                            role="heading"
                        >
                            @lang('shop::app.checkout.cart.index.empty-product')
                        </p>

                        <a
                            href="{{ route('shop.home.index') }}"
                            class="mt-6 inline-flex items-center justify-center border border-[#2e2224] bg-white text-[#2e2224] font-mono text-xs font-bold uppercase tracking-widest px-8 py-3 hover:bg-[#2e2224] hover:text-white transition-colors"
                        >
                            @lang('shop::app.checkout.cart.index.continue-shopping')
                        </a>
                    </div>
                </template>
            </div>
        </script>

        <script type="module">
            app.component("v-cart", {
                template: '#v-cart-template',

                data() {
                    return  {
                        refreshKey: 0,

                        cart: [],

                        allSelected: false,

                        applied: {
                            quantity: {},
                        },

                        displayTax: {
                            prices: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_prices') }}",

                            subtotal: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_subtotal') }}",

                            shipping: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_shipping_amount') }}",
                        },

                        isLoading: true,

                        isStoring: false,
                    };
                },

                mounted() {
                    this.getCart();
                },

                computed: {
                    selectedItemsCount() {
                        return this.cart.items.filter(item => item.selected).length;
                    },
                },

                methods: {
                    getCart() {
                        this.$axios.get('{{ route('shop.api.checkout.cart.index') }}')
                            .then(response => {
                                this.cart = response.data.data;

                                this.isLoading = false;

                                if (response.data.message) {
                                    this.$emitter.emit('add-flash', { type: 'info', message: response.data.message });
                                }
                            })
                            .catch(error => {});
                    },

                    setCart(cart) {
                        this.cart = cart;
                    },

                    selectAll() {
                        for (let item of this.cart.items) {
                            item.selected = this.allSelected;
                        }
                    },

                    updateAllSelected() {
                        this.allSelected = this.cart.items.every(item => item.selected);
                    },

                    update() {
                        this.isStoring = true;

                        this.$axios.put('{{ route('shop.api.checkout.cart.update') }}', { qty: this.applied.quantity })
                            .then(response => {
                                if (response.data.data?.items !== undefined) {
                                    this.cart = response.data.data;

                                    this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                } else {
                                    this.$emitter.emit('add-flash', {
                                        type: 'warning',
                                        message: response.data.data?.message || response.data.message,
                                    });
                                }

                                this.isStoring = false;

                                this.applied.quantity = {};
                                this.refreshKey++;
                            })
                            .catch(error => {
                                this.isStoring = false;

                                this.applied.quantity = {};
                                this.refreshKey++;
                            });
                    },

                    setItemQuantity(itemId, quantity) {
                        this.applied.quantity[itemId] = quantity;
                    },

                    removeItem(itemId) {
                        this.$emitter.emit('open-confirm-modal', {
                            agree: () => {
                                this.$axios.post('{{ route('shop.api.checkout.cart.destroy') }}', {
                                        '_method': 'DELETE',
                                        'cart_item_id': itemId,
                                    })
                                    .then(response => {
                                        this.cart = response.data.data;

                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                    })
                                    .catch(error => {});
                            }
                        });
                    },

                    removeSelectedItems() {
                        this.$emitter.emit('open-confirm-modal', {
                            agree: () => {
                                const selectedItemsIds = this.cart.items.flatMap(item => item.selected ? item.id : []);

                                this.$axios.post('{{ route('shop.api.checkout.cart.destroy_selected') }}', {
                                        '_method': 'DELETE',
                                        'ids': selectedItemsIds,
                                    })
                                    .then(response => {
                                        this.cart = response.data.data;

                                        this.$emitter.emit('update-mini-cart', response.data.data );

                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                    })
                                    .catch(error => {});
                            }
                        });
                    },

                    moveToWishlistSelectedItems() {
                        this.$emitter.emit('open-confirm-modal', {
                            agree: () => {
                                const selectedItemsIds = this.cart.items.flatMap(item => item.selected ? item.id : []);

                                const selectedItemsQty = this.cart.items.filter(item => item.selected).map(item => this.applied.quantity[item.id] ?? item.quantity);

                                this.$axios.post('{{ route('shop.api.checkout.cart.move_to_wishlist') }}', {
                                        'ids': selectedItemsIds,
                                        'qty': selectedItemsQty
                                    })
                                    .then(response => {
                                        this.cart = response.data.data;

                                        this.$emitter.emit('update-mini-cart', response.data.data );

                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                    })
                                    .catch(error => {});
                            }
                        });
                    },
                }
            });
        </script>
    @endpushOnce
</x-shop::layouts>
