<!-- Coupon Vue Component -->
<v-coupon 
    :cart="cart"
    @coupon-applied="getCart"
    @coupon-removed="getCart"
>
</v-coupon>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-coupon-template"
    >
        <div class="flex justify-between items-center text-xs font-mono">
            <span class="uppercase text-[#2e2224]/70">
                @{{ cart.coupon_code ? "@lang('shop::app.checkout.coupon.applied')" : "@lang('shop::app.checkout.coupon.discount')" }}
            </span>

            {!! view_render_event('bagisto.shop.checkout.cart.coupon.before') !!}

            <div>
                <!-- Apply Coupon Form -->
                <x-shop::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                >
                    <!-- Apply coupon form -->
                    <form @submit="handleSubmit($event, applyCoupon)">
                        {!! view_render_event('bagisto.shop.checkout.cart.coupon.coupon_form_controls.before') !!}

                        <!-- Apply coupon modal -->
                        <x-shop::modal ref="couponModel">
                            <!-- Modal Toggler -->
                            <x-slot:toggle>
                                <button 
                                    type="button"
                                    class="cursor-pointer text-xs font-mono font-bold uppercase tracking-wider text-[#bd1765] hover:text-[#8f0e4b] underline"
                                    v-if="! cart.coupon_code"
                                >
                                    @lang('shop::app.checkout.coupon.apply')
                                </button>
                            </x-slot>

                            <!-- Modal Header -->
                            <x-slot:header class="p-5 border-b border-[#2e2224]/10 bg-[#fbf8f1]">
                                <h2 class="font-serif font-bold text-xl text-[#2e2224] uppercase tracking-wide">
                                    @lang('shop::app.checkout.coupon.apply')
                                </h2>
                            </x-slot>

                            <!-- Modal Content -->
                            <x-slot:content class="p-6">
                                <x-shop::form.control-group class="mb-0">
                                    <x-shop::form.control-group.label class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-2 block">
                                        @lang('shop::app.checkout.coupon.enter-your-code')
                                    </x-shop::form.control-group.label>

                                    <x-shop::form.control-group.control
                                        type="text"
                                        class="w-full bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] uppercase"
                                        name="code"
                                        rules="required"
                                        :placeholder="trans('shop::app.checkout.coupon.enter-your-code')"
                                    />

                                    <x-shop::form.control-group.error
                                        class="text-xs font-mono text-red-600 mt-1"
                                        control-name="code"
                                    />
                                </x-shop::form.control-group>
                            </x-slot>

                            <!-- Modal Footer -->
                            <x-slot:footer class="p-5 border-t border-[#2e2224]/10 bg-white">
                                <div class="flex items-center justify-between w-full">
                                    <div class="font-mono text-xs text-[#2e2224]">
                                        <span class="text-[#2e2224]/60">@lang('shop::app.checkout.coupon.subtotal'):</span>
                                        <span class="font-bold text-[#bd1765] ms-1">@{{ cart.formatted_sub_total }}</span>
                                    </div>

                                    <button
                                        type="submit"
                                        class="bg-[#2e2224] hover:bg-[#bd1765] text-white font-mono text-xs font-bold uppercase tracking-widest py-3 px-8 transition-colors disabled:opacity-50 cursor-pointer"
                                        :disabled="isStoring"
                                    >
                                        <span v-if="isStoring" class="animate-spin inline-block w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full me-1"></span>
                                        <span>@lang('shop::app.checkout.coupon.button-title')</span>
                                    </button>
                                </div>
                            </x-slot>
                        </x-shop::modal>

                        {!! view_render_event('bagisto.shop.checkout.cart.coupon.coupon_form_controls.after') !!}
                    </form>
                </x-shop::form>

                <!-- Applied Coupon Information Container -->
                <span
                    class="inline-flex items-center gap-2"
                    v-if="cart.coupon_code"
                >
                    <span
                        class="inline-flex items-center border border-[#2e2224] bg-[#fbf8f1] px-2.5 py-0.5 text-xs font-mono font-bold text-[#2e2224]"
                        :title="@js(trans('shop::app.checkout.coupon.applied'))"
                    >
                        @{{ cart.coupon_code }}
                    </span>

                    <button
                        type="button"
                        class="cursor-pointer text-xs font-mono text-red-600 hover:text-red-800 font-bold uppercase"
                        title="@lang('shop::app.checkout.coupon.remove')"
                        aria-label="@lang('shop::app.checkout.coupon.remove')"
                        @click="destroyCoupon"
                    >
                        ✕
                    </button>
                </span>
            </div>

            {!! view_render_event('bagisto.shop.checkout.cart.coupon.after') !!}
        </div>
    </script>

    <script type="module">
        app.component('v-coupon', {
            template: '#v-coupon-template',
            
            props: ['cart'],

            data() {
                return {
                    isStoring: false,
                }
            },

            methods: {
                applyCoupon(params, { resetForm }) {
                    this.isStoring = true;

                    this.$axios.post("{{ route('shop.api.checkout.cart.coupon.apply') }}", params)
                        .then((response) => {
                            this.isStoring = false;

                            this.$emit('coupon-applied');
                  
                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                            this.$refs.couponModel.toggle();

                            resetForm();
                        })
                        .catch((error) => {
                            this.isStoring = false;

                            this.$refs.couponModel.toggle();

                            if ([400, 422].includes(error.response?.request?.status)) {
                                this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });

                                resetForm();

                                return;
                            }

                            this.$emitter.emit('add-flash', { type: 'error', message: error.response?.data?.message || 'Error' });
                        });
                },

                destroyCoupon() {
                    this.$axios.delete("{{ route('shop.api.checkout.cart.coupon.remove') }}", {
                            '_token': "{{ csrf_token() }}"
                        })
                        .then((response) => {
                            this.$emit('coupon-removed');

                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                        })
                        .catch(error => console.log(error));
                },
            }
        })
    </script>
@endPushOnce
