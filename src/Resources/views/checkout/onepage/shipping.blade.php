{!! view_render_event('bagisto.shop.checkout.onepage.shipping_methods.before') !!}

<v-shipping-methods
    :methods="shippingMethods"
    @processing="stepForward"
    @processed="stepProcessed"
>
    <!-- Shipping Method Shimmer Effect -->
    <x-shop::shimmer.checkout.onepage.shipping-method />
</v-shipping-methods>

{!! view_render_event('bagisto.shop.checkout.onepage.shipping_methods.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-shipping-methods-template"
    >
        <div class="bg-white border border-[#2e2224] p-6 md:p-8 transition-all">
            <template v-if="! methods">
                <!-- Shipping Method Shimmer Effect -->
                <x-shop::shimmer.checkout.onepage.shipping-method />
            </template>

            <template v-else>
                <div class="flex items-center justify-between pb-5 mb-6 border-b border-[#2e2224]/15">
                    <div class="flex items-center gap-3">
                        <span class="inline-block font-mono text-[10px] uppercase tracking-widest text-[#2e2224] font-bold px-2.5 py-0.5 bg-[#f7b7ba] border border-[#2e2224]">
                            STEP 02
                        </span>
                        <h2 class="font-serif font-bold text-xl md:text-2xl text-[#2e2224] uppercase tracking-wide">
                            @lang('shop::app.checkout.onepage.shipping.shipping-method')
                        </h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <template v-for="method in methods">
                        {!! view_render_event('bagisto.shop.checkout.onepage.shipping_method.before') !!}

                        <div
                            class="relative cursor-pointer select-none"
                            v-for="rate in method.rates"
                        >
                            <input 
                                type="radio"
                                name="shipping_method"
                                :id="rate.method"
                                :value="rate.method"
                                class="peer sr-only"
                                @change="store(rate.method)"
                            >

                            <label 
                                class="flex flex-col justify-between h-full p-5 border transition-all cursor-pointer bg-white peer-checked:border-2 peer-checked:border-[#bd1765] peer-checked:bg-[#fdf0f4]/50 border-[#2e2224]/20 hover:border-[#2e2224]"
                                :for="rate.method"
                            >
                                <div class="flex items-start justify-between gap-4 mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full border border-[#2e2224] flex items-center justify-center bg-[#fbf8f1] text-[#2e2224] shrink-0">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="1" y="3" width="15" height="13"></rect>
                                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                            </svg>
                                        </div>

                                        <div>
                                            <p class="font-serif font-bold text-base text-[#2e2224]">
                                                @{{ rate.method_title }}
                                            </p>
                                            <p class="font-mono text-xs text-[#2e2224]/60 mt-0.5" v-if="rate.method_description">
                                                @{{ rate.method_description }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="w-5 h-5 rounded-full border border-[#2e2224] flex items-center justify-center bg-white peer-checked:border-[#bd1765] shrink-0">
                                        <div class="w-2.5 h-2.5 rounded-full bg-[#bd1765] hidden" :class="{ '!block': selectedShippingRate == rate.method }"></div>
                                    </div>
                                </div>

                                <div class="pt-3 border-t border-[#2e2224]/10 flex items-center justify-between">
                                    <span class="font-mono text-[11px] uppercase tracking-wider text-[#2e2224]/70">Rate</span>
                                    <span class="font-mono text-base font-bold text-[#bd1765]">
                                        @{{ rate.base_formatted_price }}
                                    </span>
                                </div>
                            </label>
                        </div>

                        {!! view_render_event('bagisto.shop.checkout.onepage.shipping_method.after') !!}
                    </template>
                </div>
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-shipping-methods', {
            template: '#v-shipping-methods-template',

            props: {
                methods: {
                    type: Object,
                    required: true,
                    default: () => null,
                },
            },

            emits: ['processing', 'processed'],

            data() {
                return {
                    selectedShippingRate: null,
                };
            },

            methods: {
                store(selectedMethod) {
                    this.selectedShippingRate = selectedMethod;

                    this.$emit('processing', 'payment');

                    this.$axios.post('{{ route('shop.checkout.onepage.shipping_methods.store') }}', {
                            shipping_method: selectedMethod,
                        })
                        .then(response => {
                            if (response.data.data.redirect_url) {
                                window.location.href = response.data.data.redirect_url;
                            } else {
                                this.$emit('processed', response.data.data.payment_methods);
                            }
                        })
                        .catch(error => {
                            this.$emit('processing', 'shipping');

                            if (error.response?.data?.message) {
                                this.$emitter.emit('add-flash', {
                                    type: 'error',
                                    message: error.response.data.message
                                });
                            }
                        });
                },
            },
        });
    </script>
@endPushOnce
