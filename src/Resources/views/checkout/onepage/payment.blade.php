{!! view_render_event('bagisto.shop.checkout.onepage.payment_methods.before') !!}

<v-payment-methods
    :methods="paymentMethods"
    @payment-method-selected="setSelectedPaymentMethod"
    @processing="stepForward"
    @processed="stepProcessed"
>
    <x-shop::shimmer.checkout.onepage.payment-method />
</v-payment-methods>

{!! view_render_event('bagisto.shop.checkout.onepage.payment_methods.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-payment-methods-template"
    >
        <div class="bg-white border border-[#2e2224] p-6 md:p-8 transition-all">
            <template v-if="! methods">
                <!-- Payment Method shimmer Effect -->
                <x-shop::shimmer.checkout.onepage.payment-method />
            </template>
    
            <template v-else>
                {!! view_render_event('bagisto.shop.checkout.onepage.payment_method.accordion.before') !!}

                <div class="flex items-center justify-between pb-5 mb-6 border-b border-[#2e2224]/15">
                    <div class="flex items-center gap-3">
                        <span class="inline-block font-mono text-[10px] uppercase tracking-widest text-[#2e2224] font-bold px-2.5 py-0.5 bg-[#f7b7ba] border border-[#2e2224]">
                            STEP 03
                        </span>
                        <h2 class="font-serif font-bold text-xl md:text-2xl text-[#2e2224] uppercase tracking-wide">
                            @lang('shop::app.checkout.onepage.payment.payment-method')
                        </h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div 
                        class="relative cursor-pointer select-none"
                        v-for="(payment, index) in methods"
                    >
                        {!! view_render_event('bagisto.shop.checkout.payment-method.before') !!}

                        <input 
                            type="radio" 
                            name="payment[method]" 
                            :value="payment.payment"
                            :id="payment.method"
                            class="peer sr-only"
                            @change="store(payment)"
                        >

                        <label
                            :for="payment.method"
                            class="flex flex-col justify-between h-full p-5 border transition-all cursor-pointer bg-white peer-checked:border-2 peer-checked:border-[#bd1765] peer-checked:bg-[#fdf0f4]/50 border-[#2e2224]/20 hover:border-[#2e2224]"
                        >
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div class="flex items-center gap-3">
                                    <img
                                        v-if="payment.image"
                                        class="h-8 w-auto max-w-16 object-contain"
                                        :src="payment.image"
                                        :alt="payment.method_title"
                                        :title="payment.method_title"
                                    />
                                    <div v-else class="w-8 h-8 rounded-full border border-[#2e2224] flex items-center justify-center bg-[#fbf8f1] text-[#2e2224] shrink-0">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                            <line x1="1" y1="10" x2="23" y2="10"></line>
                                        </svg>
                                    </div>

                                    <div>
                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.title.before') !!}

                                        <p class="font-serif font-bold text-base text-[#2e2224]">
                                            @{{ payment.method_title }}
                                        </p>
                                        
                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.title.after') !!}
                                    </div>
                                </div>

                                <div class="w-5 h-5 rounded-full border border-[#2e2224] flex items-center justify-center bg-white peer-checked:border-[#bd1765] shrink-0">
                                    <div class="w-2.5 h-2.5 rounded-full bg-[#bd1765] hidden" :class="{ '!block': selectedPaymentMethod == payment.method }"></div>
                                </div>
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.description.before') !!}

                            <p class="font-mono text-xs text-[#2e2224]/70 pt-2 border-t border-[#2e2224]/10" v-if="payment.description">
                                @{{ payment.description }}
                            </p> 

                            {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.description.after') !!}
                        </label>

                        {!! view_render_event('bagisto.shop.checkout.payment-method.after') !!}
                    </div>
                </div>

                {!! view_render_event('bagisto.shop.checkout.onepage.payment_method.accordion.after') !!}
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-payment-methods', {
            template: '#v-payment-methods-template',

            props: {
                methods: {
                    type: Object,
                    required: true,
                    default: () => null,
                },
            },

            emits: ['payment-method-selected', 'processing', 'processed'],

            data() {
                return {
                    selectedPaymentMethod: null,
                };
            },

            methods: {
                store(selectedMethod) {
                    this.selectedPaymentMethod = selectedMethod.method;

                    this.$emit('payment-method-selected', selectedMethod.method);

                    this.$emit('processing', 'review');

                    this.$axios.post('{{ route('shop.checkout.onepage.payment_methods.store') }}', {
                            payment: selectedMethod
                        })
                        .then(response => {
                            if (response.data.data.redirect_url) {
                                window.location.href = response.data.data.redirect_url;
                            } else {
                                this.$emit('processed', response.data.data.cart);
                            }
                        })
                        .catch(error => {
                            this.$emit('processing', 'payment');

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
