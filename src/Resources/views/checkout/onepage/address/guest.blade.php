{!! view_render_event('bagisto.shop.checkout.onepage.address.guest.before') !!}

<!-- Guest Address Vue Component -->
<v-checkout-address-guest
    :cart="cart"
    :current-step="currentStep"
    @processing="stepForward"
    @processed="stepProcessed"
></v-checkout-address-guest>

{!! view_render_event('bagisto.shop.checkout.onepage.address.guest.after') !!}

@include('shop::checkout.onepage.address.form')

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-checkout-address-guest-template"
    >
        <!-- Address Form -->
        <x-shop::form
            v-slot="{ meta, errors, handleSubmit }"
            as="div"
        >
            <form
                @submit="handleSubmit($event, addAddress)"
                @input="handleAddressChange"
            >
                <!-- Guest Billing Address -->
                <div class="mb-6">
                    {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.billing.before') !!}

                    <!-- Billing Address Header -->
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-[#2e2224]/10">
                        <h3 class="font-serif font-bold text-lg md:text-xl text-[#2e2224]">
                            @lang('shop::app.checkout.onepage.address.billing-address')
                        </h3>
                    </div>
                
                    <!-- Billing Address Form -->
                    <v-checkout-address-form
                        control-name="billing"
                        :address="cart.billing_address || undefined"
                    ></v-checkout-address-form>

                    <!-- Use for Shipping Checkbox -->
                    <div
                        class="mt-4 flex items-center gap-3 p-3 bg-[#fbf8f1] border border-[#2e2224]/10"
                        v-if="cart.have_stockable_items"
                    >
                        <input
                            type="checkbox"
                            name="billing.use_for_shipping"
                            id="use_for_shipping"
                            value="1"
                            @change="useBillingAddressForShipping = ! useBillingAddressForShipping"
                            :checked="!! useBillingAddressForShipping"
                            class="w-4 h-4 accent-[#bd1765] text-[#bd1765] border border-[#2e2224] rounded-none cursor-pointer"
                        />

                        <label
                            class="cursor-pointer select-none font-mono text-xs text-[#2e2224] font-medium"
                            for="use_for_shipping"
                        >
                            @lang('shop::app.checkout.onepage.address.same-as-billing')
                        </label>
                    </div>

                    {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.billing.after') !!}
                </div>

                <!-- Guest Shipping Address -->
                <template v-if="cart.have_stockable_items">
                    <div
                        class="mt-8 mb-6"
                        v-if="! useBillingAddressForShipping"
                    >
                        {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.shipping.before') !!}

                        <!-- Shipping Address Header -->
                        <div class="flex items-center justify-between pb-3 mb-4 border-b border-[#2e2224]/10">
                            <h3 class="font-serif font-bold text-lg md:text-xl text-[#2e2224]">
                                @lang('shop::app.checkout.onepage.address.shipping-address')
                            </h3>
                        </div>
                    
                        <!-- Shipping Address Form -->
                        <v-checkout-address-form
                            control-name="shipping"
                            :address="cart.shipping_address || undefined"
                        ></v-checkout-address-form>

                        {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.shipping.after') !!}
                    </div>
                </template>

                <!-- Address Updated Notice -->
                <transition
                    enter-from-class="scale-95 opacity-0"
                    enter-active-class="transform transition duration-200 ease-in-out"
                    leave-active-class="transform transition duration-200 ease-in-out"
                    leave-to-class="scale-95 opacity-0"
                >
                    <div
                        class="mt-4 flex items-start gap-3 border border-[#bd1765]/30 bg-[#fdf0f4] p-4 text-xs font-mono text-[#2e2224]"
                        role="status"
                        v-if="isAddressUpdated"
                    >
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#bd1765] text-white text-xs">i</span>

                        <div>
                            <p class="font-bold text-[#bd1765]">
                                @lang('shop::app.checkout.onepage.address.address-updated-title')
                            </p>

                            <p class="mt-1 text-[#2e2224]/80">
                                <template v-if="cart.have_stockable_items">
                                    @lang('shop::app.checkout.onepage.address.address-updated-shipping-info')
                                </template>

                                <template v-else>
                                    @lang('shop::app.checkout.onepage.address.address-updated-payment-info')
                                </template>
                            </p>
                        </div>
                    </div>
                </transition>

                <!-- Proceed Button -->
                <div
                    class="mt-6 flex justify-end"
                    v-if="currentStep == 'address' || isStoring"
                >
                    <button
                        type="submit"
                        class="w-full sm:w-auto bg-[#2e2224] hover:bg-[#bd1765] text-white font-mono text-xs md:text-sm font-bold uppercase tracking-widest py-3.5 px-10 border border-[#2e2224] hover:border-[#bd1765] transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50"
                        :disabled="isStoring"
                    >
                        <span v-if="isStoring" class="animate-spin inline-block w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full"></span>
                        <span>@lang('shop::app.checkout.onepage.address.proceed')</span>
                        <span class="rtl:rotate-180">→</span>
                    </button>
                </div>
            </form>
        </x-shop::form>
    </script>

    <script type="module">
        app.component('v-checkout-address-guest', {
            template: '#v-checkout-address-guest-template',

            props: ['cart', 'currentStep'],

            emits: ['processing', 'processed'],

            data() {
                return {
                    useBillingAddressForShipping: true,

                    isStoring: false,

                    isAddressUpdated: false,
                }
            },

            created() {
                if (this.cart.billing_address) {
                    this.useBillingAddressForShipping = this.cart.billing_address.use_for_shipping;
                }
            },

            methods: {
                addAddress(params, { setErrors }) {
                    this.isStoring = true;

                    params['billing']['use_for_shipping'] = this.useBillingAddressForShipping;

                    this.moveToNextStep();

                    this.$axios.post('{{ route('shop.checkout.onepage.addresses.store') }}', params)
                        .then((response) => {
                            this.isStoring = false;

                            this.isAddressUpdated = false;

                            if (response.data.data.redirect_url) {
                                window.location.href = response.data.data.redirect_url;
                            } else {
                                if (this.cart.have_stockable_items) {
                                    this.$emit('processed', response.data.data.shippingMethods);
                                } else {
                                    this.$emit('processed', response.data.data.payment_methods);
                                }
                            }
                        })
                        .catch(error => {
                            this.isStoring = false;

                            this.$emit('processing', 'address');

                            if (error.response?.status == 422) {
                                setErrors(error.response.data.errors);
                            }
                        });
                },

                handleAddressChange() {
                    if (this.currentStep != 'address') {
                        this.isAddressUpdated = true;
                    }

                    this.$emit('processing', 'address');
                },

                moveToNextStep() {
                    if (this.cart.have_stockable_items) {
                        this.$emit('processing', 'shipping');
                    } else {
                        this.$emit('processing', 'payment');
                    }
                }
            }
        });
    </script>
@endPushOnce
