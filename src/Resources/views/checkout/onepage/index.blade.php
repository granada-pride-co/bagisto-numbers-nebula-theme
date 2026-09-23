<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.checkout.onepage.index.checkout')"/>
    <meta name="keywords" content="@lang('shop::app.checkout.onepage.index.checkout')"/>
@endPush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.checkout.onepage.index.checkout')
    </x-slot>

    {!! view_render_event('bagisto.shop.checkout.onepage.header.before') !!}

    <!-- Luxury Checkout Header -->
    <header class="border-b border-[#2e2224]/15 bg-[#fffefd] sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 md:px-12 py-4 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a
                    href="{{ route('shop.home.index') }}"
                    class="flex items-center gap-3 transition-opacity hover:opacity-80"
                    aria-label="{{ core()->getCurrentChannel()->name }}"
                >
                    <img
                        src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                        alt="{{ core()->getCurrentChannel()->name }}"
                        class="h-7 md:h-9 w-auto object-contain"
                    >
                </a>
            </div>

            <div class="flex items-center gap-4 text-xs font-mono">
                <a
                    href="{{ route('shop.checkout.cart.index') }}"
                    class="hidden sm:inline-flex items-center gap-2 text-[#2e2224]/70 hover:text-[#bd1765] transition-colors font-bold uppercase tracking-wider"
                >
                    <span class="rtl:rotate-180">←</span>
                    <span>{{ trans('nc::app.cart.your_bag') ?? 'Back to Cart' }}</span>
                </a>

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

    {!! view_render_event('bagisto.shop.checkout.onepage.header.after') !!}

    <!-- Main Checkout Content -->
    <div class="min-h-screen bg-[#fbf8f1] py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <!-- Checkout Vue Component -->
            <v-checkout>
                <!-- Shimmer Effect -->
                <x-shop::shimmer.checkout.onepage />
            </v-checkout>
        </div>
    </div>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-checkout-template"
        >
            <template v-if="! cart">
                <!-- Shimmer Effect -->
                <x-shop::shimmer.checkout.onepage />
            </template>

            <template v-else>
                <!-- Editorial Step Tracker -->
                <div class="mb-10 pb-6 border-b border-[#2e2224]/15">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-xs font-mono uppercase tracking-widest">
                        <div
                            class="flex items-center gap-2 p-2 border-b-2 transition-all"
                            :class="currentStep === 'address' ? 'border-[#bd1765] text-[#bd1765] font-bold' : (['shipping', 'payment', 'review'].includes(currentStep) ? 'border-[#2e2224] text-[#2e2224]' : 'border-transparent text-[#2e2224]/40')"
                        >
                            <span class="text-sm">01</span>
                            <span>@lang('shop::app.checkout.onepage.address.title')</span>
                            <span v-if="['shipping', 'payment', 'review'].includes(currentStep)" class="ms-auto text-[#bd1765]">✓</span>
                        </div>

                        <div
                            class="flex items-center gap-2 p-2 border-b-2 transition-all"
                            :class="currentStep === 'shipping' ? 'border-[#bd1765] text-[#bd1765] font-bold' : (['payment', 'review'].includes(currentStep) ? 'border-[#2e2224] text-[#2e2224]' : 'border-transparent text-[#2e2224]/40')"
                            v-if="cart.have_stockable_items"
                        >
                            <span class="text-sm">02</span>
                            <span>@lang('shop::app.checkout.onepage.shipping.shipping-method')</span>
                            <span v-if="['payment', 'review'].includes(currentStep)" class="ms-auto text-[#bd1765]">✓</span>
                        </div>

                        <div
                            class="flex items-center gap-2 p-2 border-b-2 transition-all"
                            :class="currentStep === 'payment' ? 'border-[#bd1765] text-[#bd1765] font-bold' : (currentStep === 'review' ? 'border-[#2e2224] text-[#2e2224]' : 'border-transparent text-[#2e2224]/40')"
                        >
                            <span class="text-sm">@{{ cart.have_stockable_items ? '03' : '02' }}</span>
                            <span>@lang('shop::app.checkout.onepage.payment.payment-method')</span>
                            <span v-if="currentStep === 'review'" class="ms-auto text-[#bd1765]">✓</span>
                        </div>

                        <div
                            class="flex items-center gap-2 p-2 border-b-2 transition-all"
                            :class="currentStep === 'review' ? 'border-[#bd1765] text-[#bd1765] font-bold' : 'border-transparent text-[#2e2224]/40'"
                        >
                            <span class="text-sm">@{{ cart.have_stockable_items ? '04' : '03' }}</span>
                            <span>@lang('shop::app.checkout.onepage.summary.place-order')</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                    <!-- Left Steps Column -->
                    <div
                        class="lg:col-span-7 xl:col-span-8 flex flex-col gap-6"
                        id="steps-container"
                    >
                        <!-- Included Addresses Blade File -->
                        <template v-if="['address', 'shipping', 'payment', 'review'].includes(currentStep)">
                            @include('shop::checkout.onepage.address')
                        </template>

                        <!-- Included Shipping Methods Blade File -->
                        <template v-if="cart.have_stockable_items && ['shipping', 'payment', 'review'].includes(currentStep)">
                            @include('shop::checkout.onepage.shipping')
                        </template>

                        <!-- Included Payment Methods Blade File -->
                        <template v-if="['payment', 'review'].includes(currentStep)">
                            @include('shop::checkout.onepage.payment')
                        </template>
                    </div>

                    <!-- Right Summary Column (Sticky) -->
                    <div class="lg:col-span-5 xl:col-span-4 sticky top-24">
                        @include('shop::checkout.onepage.summary')

                        <div
                            class="mt-6 flex flex-col gap-3"
                            v-if="canPlaceOrder"
                        >
                            <template v-if="(selectedPaymentMethod || cart.payment_method) == 'paypal_smart_button'">
                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.before') !!}

                                <!-- Paypal Smart Button Vue Component -->
                                <v-paypal-smart-button></v-paypal-smart-button>

                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.after') !!}
                            </template>

                            <template v-else>
                                <button
                                    type="button"
                                    class="w-full bg-[#bd1765] hover:bg-[#8f0e4b] text-white font-mono text-xs md:text-sm font-bold uppercase tracking-widest py-4 px-8 border border-[#bd1765] transition-all shadow-luxury flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
                                    :disabled="isPlacingOrder"
                                    @click="placeOrder"
                                >
                                    <svg
                                        v-if="isPlacingOrder"
                                        class="animate-spin h-4 w-4 text-white"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>@lang('shop::app.checkout.onepage.summary.place-order')</span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </script>

        <script type="module">
            app.component('v-checkout', {
                template: '#v-checkout-template',

                data() {
                    return {
                        cart: null,

                        displayTax: {
                            prices: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_prices') }}",
                            subtotal: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_subtotal') }}",
                            shipping: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_shipping_amount') }}",
                        },

                        isPlacingOrder: false,

                        currentStep: 'address',

                        shippingMethods: null,

                        paymentMethods: null,

                        selectedPaymentMethod: null,

                        canPlaceOrder: false,
                    }
                },

                mounted() {
                    this.getCart();
                },

                methods: {
                    getCart() {
                        this.$axios.get("{{ route('shop.checkout.onepage.summary') }}")
                            .then(response => {
                                this.cart = response.data.data;
                                this.scrollToCurrentStep();
                            })
                            .catch(error => {});
                    },

                    stepForward(step) {
                        this.currentStep = step;

                        if (step == 'review') {
                            this.canPlaceOrder = true;
                            return;
                        }

                        this.canPlaceOrder = false;

                        if (this.currentStep == 'shipping') {
                            this.shippingMethods = null;
                        } else if (this.currentStep == 'payment') {
                            this.paymentMethods = null;
                        }
                    },

                    stepProcessed(data) {
                        if (this.currentStep == 'shipping') {
                            this.shippingMethods = data;
                        } else if (this.currentStep == 'payment') {
                            this.paymentMethods = data;
                        }

                        this.getCart();
                    },

                    scrollToCurrentStep() {
                        let container = document.getElementById('steps-container');

                        if (! container) {
                            return;
                        }

                        container.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    },

                    setSelectedPaymentMethod(method) {
                        this.selectedPaymentMethod = method;
                    },

                    placeOrder() {
                        if ((this.selectedPaymentMethod || this.cart.payment_method) == 'paypal_smart_button') {
                            return;
                        }

                        this.isPlacingOrder = true;

                        this.$axios.post('{{ route('shop.checkout.onepage.orders.store') }}')
                            .then(response => {
                                if (response.data.data.redirect) {
                                    window.location.href = response.data.data.redirect_url;
                                } else {
                                    window.location.href = '{{ route('shop.checkout.onepage.success') }}';
                                }

                                this.isPlacingOrder = false;
                            })
                            .catch(error => {
                                this.isPlacingOrder = false;

                                this.$emitter.emit('add-flash', {
                                    type: 'error',
                                    message: error.response?.data?.message || 'An error occurred'
                                });
                            });
                    }
                },
            });
        </script>
    @endPushOnce
</x-shop::layouts>
