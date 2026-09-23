{!! view_render_event('bagisto.shop.checkout.onepage.address.customer.before') !!}

<!-- Customer Address Vue Component -->
<v-checkout-address-customer
    :cart="cart"
    :current-step="currentStep"
    @processing="stepForward"
    @processed="stepProcessed"
>
    <!-- Billing Address Shimmer -->
    <x-shop::shimmer.checkout.onepage.address />
</v-checkout-address-customer>

{!! view_render_event('bagisto.shop.checkout.onepage.address.customer.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-checkout-address-customer-template"
    >
        <template v-if="isLoading">
            <!-- Billing Address Shimmer -->
            <x-shop::shimmer.checkout.onepage.address />
        </template>

        <template v-else>
            <!-- Saved Addresses -->
            <template v-if="! activeAddressForm && customerSavedAddresses.billing.length">
                <x-shop::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                >
                    <form
                        @submit="handleSubmit($event, addAddressToCart)"
                        @input="handleAddressChange"
                    >
                        <!-- Billing Address Header -->
                        <div class="mb-4 flex items-center justify-between pb-3 border-b border-[#2e2224]/10">
                            <h3 class="font-serif font-bold text-lg md:text-xl text-[#2e2224]">
                                @lang('shop::app.checkout.onepage.address.billing-address')
                            </h3>
                        </div>

                        <!-- Saved Customer Addresses Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div
                                class="relative cursor-pointer select-none border transition-all p-5 bg-white"
                                :class="selectedAddresses.billing_address_id == address.id ? 'border-2 border-[#bd1765] bg-[#fdf0f4]/50' : 'border-[#2e2224]/20 hover:border-[#2e2224]'"
                                v-for="address in customerSavedAddresses.billing"
                            >
                                <!-- Actions -->
                                <div class="absolute top-4 flex items-center gap-3 ltr:right-4 rtl:left-4">
                                    <input
                                        type="radio"
                                        name="billing.id"
                                        :id="`billing_address_id_${address.id}`"
                                        :value="address.id"
                                        v-model="selectedAddresses.billing_address_id"
                                        class="w-4 h-4 accent-[#bd1765] text-[#bd1765] cursor-pointer"
                                    />

                                    <!-- Edit Button -->
                                    <button
                                        type="button"
                                        class="text-xs font-mono text-[#2e2224]/60 hover:text-[#bd1765] uppercase font-bold"
                                        @click="
                                            selectedAddressForEdit = address;
                                            activeAddressForm = 'billing';
                                            saveAddress = address.address_type == 'customer'
                                        "
                                    >
                                        Edit
                                    </button>
                                </div>

                                <!-- Details -->
                                <label
                                    class="block cursor-pointer"
                                    :for="`billing_address_id_${address.id}`"
                                >
                                    <p class="font-serif font-bold text-base text-[#2e2224]">
                                        @{{ address.first_name + ' ' + address.last_name }}

                                        <template v-if="address.company_name">
                                            (@{{ address.company_name }})
                                        </template>
                                    </p>

                                    <p class="mt-3 font-mono text-xs text-[#2e2224]/70 leading-relaxed">
                                        <template v-if="address.address">
                                            @{{ address.address.join(', ') }},
                                        </template>

                                        @{{ address.city }}, @{{ address.state }}, @{{ address.country }}, @{{ address.postcode }}
                                    </p>
                                    
                                    <p class="mt-2 font-mono text-xs text-[#2e2224]/60" v-if="address.phone">
                                        Tel: @{{ address.phone }}
                                    </p>
                                </label>
                            </div>

                            <!-- New Address Card -->
                            <div
                                class="flex cursor-pointer items-center justify-center p-6 border-2 border-dashed border-[#2e2224]/30 hover:border-[#bd1765] bg-[#fbf8f1] transition-colors"
                                @click="activeAddressForm = 'billing'"
                                v-if="! cart.billing_address"
                            >
                                <div class="flex items-center gap-2 font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]">
                                    <span class="text-base text-[#bd1765]">+</span>
                                    <span>@lang('shop::app.checkout.onepage.address.add-new-address')</span>
                                </div>
                            </div>
                        </div>

                        <!-- Error Message Block -->
                        <x-shop::form.control-group.error name="billing.id" class="text-xs font-mono text-red-600 mb-4" />

                        <!-- Shipping Address Block if have stockable items -->
                        <template v-if="cart.have_stockable_items">
                            <!-- Use for Shipping Checkbox -->
                            <div class="mt-4 flex items-center gap-3 p-3 bg-[#fbf8f1] border border-[#2e2224]/10 mb-6">
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

                            <!-- Customer Shipping Address -->
                            <div
                                class="mt-6 mb-6"
                                v-if="! useBillingAddressForShipping"
                            >
                                <!-- Shipping Address Header -->
                                <div class="mb-4 flex items-center justify-between pb-3 border-b border-[#2e2224]/10">
                                    <h3 class="font-serif font-bold text-lg md:text-xl text-[#2e2224]">
                                        @lang('shop::app.checkout.onepage.address.shipping-address')
                                    </h3>
                                </div>

                                <!-- Saved Customer Addresses Cards -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div
                                        class="relative cursor-pointer select-none border transition-all p-5 bg-white"
                                        :class="selectedAddresses.shipping_address_id == address.id ? 'border-2 border-[#bd1765] bg-[#fdf0f4]/50' : 'border-[#2e2224]/20 hover:border-[#2e2224]'"
                                        v-for="address in customerSavedAddresses.shipping"
                                    >
                                        <!-- Actions -->
                                        <div class="absolute top-4 flex items-center gap-3 ltr:right-4 rtl:left-4">
                                            <input
                                                type="radio"
                                                name="shipping.id"
                                                :id="`shipping_address_id_${address.id}`"
                                                :value="address.id"
                                                v-model="selectedAddresses.shipping_address_id"
                                                class="w-4 h-4 accent-[#bd1765] text-[#bd1765] cursor-pointer"
                                            />

                                            <button
                                                type="button"
                                                class="text-xs font-mono text-[#2e2224]/60 hover:text-[#bd1765] uppercase font-bold"
                                                @click="
                                                    selectedAddressForEdit = address;
                                                    activeAddressForm = 'shipping';
                                                    saveAddress = address.address_type == 'customer'
                                                "
                                            >
                                                Edit
                                            </button>
                                        </div>

                                        <!-- Details -->
                                        <label
                                            class="block cursor-pointer"
                                            :for="`shipping_address_id_${address.id}`"
                                        >
                                            <p class="font-serif font-bold text-base text-[#2e2224]">
                                                @{{ address.first_name + ' ' + address.last_name }}

                                                <template v-if="address.company_name">
                                                    (@{{ address.company_name }})
                                                </template>
                                            </p>

                                            <p class="mt-3 font-mono text-xs text-[#2e2224]/70 leading-relaxed">
                                                <template v-if="address.address">
                                                    @{{ address.address.join(', ') }},
                                                </template>

                                                @{{ address.city }}, @{{ address.state }}, @{{ address.country }}, @{{ address.postcode }}
                                            </p>

                                            <p class="mt-2 font-mono text-xs text-[#2e2224]/60" v-if="address.phone">
                                                Tel: @{{ address.phone }}
                                            </p>
                                        </label>
                                    </div>

                                    <!-- New Address Card -->
                                    <div
                                        class="flex cursor-pointer items-center justify-center p-6 border-2 border-dashed border-[#2e2224]/30 hover:border-[#bd1765] bg-[#fbf8f1] transition-colors"
                                        @click="selectedAddressForEdit = null; activeAddressForm = 'shipping'"
                                        v-if="! cart.shipping_address"
                                    >
                                        <div class="flex items-center gap-2 font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]">
                                            <span class="text-base text-[#bd1765]">+</span>
                                            <span>@lang('shop::app.checkout.onepage.address.add-new-address')</span>
                                        </div>
                                    </div>
                                </div>

                                <x-shop::form.control-group.error name="shipping.id" class="text-xs font-mono text-red-600 mb-4" />
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
            </template>

            <!-- Create/Edit Address Form -->
            <template v-else>
                <x-shop::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                >
                    <form
                        @submit="handleSubmit($event, updateOrCreateAddress)"
                        @input="handleAddressChange"
                    >
                        <!-- Address Form Header -->
                        <div class="mb-4 flex items-center justify-between pb-3 border-b border-[#2e2224]/10">
                            <h3 class="font-serif font-bold text-lg md:text-xl text-[#2e2224]">
                                <template v-if="activeAddressForm == 'billing'">
                                    @lang('shop::app.checkout.onepage.address.billing-address')
                                </template>

                                <template v-else>
                                    @lang('shop::app.checkout.onepage.address.shipping-address')
                                </template>
                            </h3>

                            <button
                                type="button"
                                class="text-xs font-mono uppercase font-bold text-[#2e2224] hover:text-[#bd1765] flex items-center gap-1.5"
                                v-show="customerSavedAddresses.billing.length && ['billing', 'shipping'].includes(activeAddressForm)"
                                @click="selectedAddressForEdit = null; activeAddressForm = null"
                            >
                                <span class="rtl:rotate-180">←</span>
                                <span>@lang('shop::app.checkout.onepage.address.back')</span>
                            </button>
                        </div>
                        
                        <!-- Address Form Vue Component -->
                        <v-checkout-address-form
                            :control-name="activeAddressForm"
                            :address="selectedAddressForEdit || undefined"
                        ></v-checkout-address-form>

                        <!-- Save Address to Address Book Checkbox -->
                        <div class="mt-4 flex items-center gap-3 p-3 bg-[#fbf8f1] border border-[#2e2224]/10">
                            <input
                                type="checkbox"
                                :name="activeAddressForm + '.save_address'"
                                id="save_address"
                                value="1"
                                v-model="saveAddress"
                                @change="saveAddress = ! saveAddress"
                                class="w-4 h-4 accent-[#bd1765] text-[#bd1765] border border-[#2e2224] rounded-none cursor-pointer"
                            />

                            <label
                                class="cursor-pointer select-none font-mono text-xs text-[#2e2224] font-medium"
                                for="save_address"
                            >
                                @lang('shop::app.checkout.onepage.address.save-address')
                            </label>
                        </div>

                        <!-- Save Button -->
                        <div class="mt-6 flex justify-end">
                            <button
                                type="submit"
                                class="w-full sm:w-auto bg-[#2e2224] hover:bg-[#bd1765] text-white font-mono text-xs md:text-sm font-bold uppercase tracking-widest py-3.5 px-10 border border-[#2e2224] hover:border-[#bd1765] transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50"
                                :disabled="isStoring"
                            >
                                <span v-if="isStoring" class="animate-spin inline-block w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full"></span>
                                <span>@lang('shop::app.checkout.onepage.address.save')</span>
                            </button>
                        </div>
                    </form>
                </x-shop::form>
            </template>
        </template>
    </script>

    <script type="module">
        app.component('v-checkout-address-customer', {
            template: '#v-checkout-address-customer-template',

            props: ['cart', 'currentStep'],

            emits: ['processing', 'processed'],

            data() {
                return {
                    customerSavedAddresses: {
                        'billing': [],
                        
                        'shipping': [],
                    },

                    useBillingAddressForShipping: true,

                    activeAddressForm: null,

                    selectedAddressForEdit: null,

                    saveAddress: false,

                    selectedAddresses: {
                        billing_address_id: null,

                        shipping_address_id: null,
                    },

                    isLoading: true,

                    isStoring: false,

                    isAddressUpdated: false,
                }
            },

            created() {
                if (this.cart.billing_address) {
                    this.useBillingAddressForShipping = this.cart.billing_address.use_for_shipping;
                }
            },

            mounted() {
                this.getCustomerSavedAddresses();
            },

            methods: {
                getCustomerSavedAddresses() {
                    this.$axios.get('{{ route('shop.api.customers.account.addresses.index') }}')
                        .then(response => {
                            this.initializeAddresses('billing', structuredClone(response.data.data));

                            this.initializeAddresses('shipping', structuredClone(response.data.data));

                            if (! this.customerSavedAddresses.billing.length) {
                                this.activeAddressForm = 'billing';
                            }

                            this.isLoading = false;
                        })
                        .catch((error) => {
                            this.isLoading = false;
                            console.error(error);
                        });
                },

                initializeAddresses(type, addresses) {
                    this.customerSavedAddresses[type] = addresses;

                    let cartAddress = this.cart[type + '_address'];

                    if (! cartAddress) {
                        addresses.forEach(address => {
                            if (address.default_address) {
                                this.selectedAddresses[type + '_address_id'] = address.id;
                            }
                        });

                        return addresses;
                    }

                    if (cartAddress.parent_address_id) {
                        addresses.forEach(address => {
                            if (address.id == cartAddress.parent_address_id) {
                                this.selectedAddresses[type + '_address_id'] = address.id;
                            }
                        });
                    } else {
                        this.selectedAddresses[type + '_address_id'] = cartAddress.id;
                        
                        addresses.unshift(cartAddress);
                    }

                    return addresses;
                },

                updateOrCreateAddress(params, { setErrors }) {
                    this.handleAddressChange();

                    params = params[this.activeAddressForm];

                    let address = this.customerSavedAddresses[this.activeAddressForm].find(address => {
                        return address.id == params.id;
                    });

                    if (! address) {
                        if (params.save_address) {
                            this.createCustomerAddress(params, { setErrors })
                                .then((response) => {
                                    this.addAddressToList(response.data.data);
                                })
                                .catch((error) => {});
                        } else {
                            this.addAddressToList(params);
                        }

                        return;
                    }

                    if (params.save_address) {
                        if (address.address_type == 'customer') {
                            this.updateCustomerAddress(params.id, params, { setErrors })
                                .then((response) => {
                                    this.updateAddressInList(response.data.data);
                                })
                                .catch((error) => {});
                        } else {
                            this.removeAddressFromList(params);

                            this.createCustomerAddress(params, { setErrors })
                                .then((response) => {
                                    this.addAddressToList(response.data.data);
                                })
                                .catch((error) => {});
                        }
                    } else {
                        this.updateAddressInList(params);
                    }
                },

                addAddressToList(address) {
                    this.cart[this.activeAddressForm + '_address'] = address;

                    this.customerSavedAddresses[this.activeAddressForm].unshift(address);

                    this.selectedAddresses[this.activeAddressForm + '_address_id'] = address.id;

                    this.activeAddressForm = null;
                },

                updateAddressInList(params) {
                    this.customerSavedAddresses[this.activeAddressForm].forEach((address, index) => {
                        if (address.id == params.id) {
                            params = {
                                ...address,
                                ...params,
                            };

                            this.cart[this.activeAddressForm + '_address'] = params;

                            this.customerSavedAddresses[this.activeAddressForm][index] = params;

                            this.selectedAddresses[this.activeAddressForm + '_address_id'] = params.id;

                            this.activeAddressForm = null;
                        }
                    });
                },

                removeAddressFromList(params) {
                    this.customerSavedAddresses[this.activeAddressForm] = this.customerSavedAddresses[this.activeAddressForm].filter(address => address.id != params.id);
                },

                createCustomerAddress(params, { setErrors }) {
                    this.isStoring = true;

                    return this.$axios.post('{{ route('shop.api.customers.account.addresses.store') }}', params)
                        .then((response) => {
                            this.isStoring = false;

                            return response;
                        })
                        .catch(error => {
                            this.isStoring = false;

                            if (error.response?.status == 422) {
                                let errors = {};

                                Object.keys(error.response.data.errors).forEach(key => {
                                    errors[this.activeAddressForm + '.' + key] = error.response.data.errors[key];
                                });

                                setErrors(errors);
                            }

                            return Promise.reject(error);
                        });
                },

                updateCustomerAddress(id, params, { setErrors }) {
                    this.isStoring = true;

                    return this.$axios.put('{{ route('shop.api.customers.account.addresses.update') }}/' + id, params)
                        .then((response) => {
                            this.isStoring = false;

                            return response;
                        })
                        .catch(error => {
                            this.isStoring = false;

                            if (error.response?.status == 422) {
                                let errors = {};

                                Object.keys(error.response.data.errors).forEach(key => {
                                    errors[this.activeAddressForm + '.' + key] = error.response.data.errors[key];
                                });

                                setErrors(errors);
                            }

                            return Promise.reject(error);
                        });
                },

                addAddressToCart(params, { setErrors }) {
                    let payload = {
                        billing: {
                            ...this.getSelectedAddress('billing', params.billing.id),
                            use_for_shipping: this.useBillingAddressForShipping
                        },
                    };

                    if (params.shipping !== undefined) {
                        payload.shipping = this.getSelectedAddress('shipping', params.shipping.id);
                    }

                    this.isStoring = true;

                    this.moveToNextStep();

                    this.$axios.post('{{ route('shop.checkout.onepage.addresses.store') }}', payload)
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
                                const billingRegex = /^billing\./;

                                if (Object.keys(error.response.data.errors).some(key => billingRegex.test(key))) {
                                    setErrors({
                                        'billing.id': error.response.data.message
                                    });
                                } else {
                                    setErrors({
                                        'shipping.id': error.response.data.message
                                    });
                                }
                            }
                        });
                },

                getSelectedAddress(type, id) {
                    let address = Object.assign({}, this.customerSavedAddresses[type].find(address => address.id == id));

                    if (id == 0) {
                        address.id = null;
                    }

                    return {
                        ...address,
                        default_address: 0,
                    };
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
                },
            }
        });
    </script>
@endPushOnce
