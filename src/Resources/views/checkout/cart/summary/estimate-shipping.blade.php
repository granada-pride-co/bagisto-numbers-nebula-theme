<!-- Estimate Tax and Shipping -->
{!! view_render_event('bagisto.shop.checkout.cart.summary.estimate_shipping.before') !!}

<x-shop::accordion
    class="overflow-hidden border border-[#2e2224]/15 bg-white"
    :is-active="false"
>
    <x-slot:header class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/70 py-3 px-4">
        @lang('shop::app.checkout.cart.summary.estimate-shipping.title')
    </x-slot>

    <x-slot:content class="p-4 pt-0 border-t border-[#2e2224]/10">
        <v-estimate-tax-shipping
            :cart="cart"
            @processed="setCart"
        ></v-estimate-tax-shipping>
    </x-slot>
</x-shop::accordion>

{!! view_render_event('bagisto.shop.checkout.cart.summary.estimate_shipping.after') !!}

@pushOnce('scripts')
    <script type="text/x-template" id="v-estimate-tax-shipping-template">
        <x-shop::form
            v-slot="{ meta, errors, handleSubmit }"
            as="div"
        >
            <form @change="handleSubmit($event, estimateShipping)">
                <p class="mb-4 font-mono text-xs text-[#2e2224]/60">
                    @lang('shop::app.checkout.cart.summary.estimate-shipping.info')
                </p>

                <!-- Country -->
                <x-shop::form.control-group class="mb-3!">
                    <x-shop::form.control-group.label class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/70 {{ core()->isCountryRequired() ? 'required' : '' }}">
                        @lang('shop::app.checkout.cart.summary.estimate-shipping.country')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="select"
                        name="country"
                        v-model="selectedCountry"
                        class="w-full bg-[#fbf8f1] border border-[#2e2224]/20 px-3 py-2.5 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765]"
                        rules="{{ core()->isCountryRequired() ? 'required' : '' }}"
                        :label="trans('shop::app.checkout.cart.summary.estimate-shipping.country')"
                        :placeholder="trans('shop::app.checkout.cart.summary.estimate-shipping.country')"
                        @change="selectedState = ''"
                    >
                        <option value="">
                            @lang('shop::app.checkout.cart.summary.estimate-shipping.select-country')
                        </option>

                        <option
                            v-for="country in countries"
                            :value="country.code"
                            v-text="country.name"
                        >
                        </option>
                    </x-shop::form.control-group.control>

                    <x-shop::form.control-group.error name="country" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.country.after') !!}

                <!-- State -->
                <x-shop::form.control-group class="mb-3!">
                    <x-shop::form.control-group.label class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/70 {{ core()->isStateRequired() ? 'required' : '' }}">
                        @lang('shop::app.checkout.cart.summary.estimate-shipping.state')
                    </x-shop::form.control-group.label>

                    <template v-if="states">
                        <template v-if="haveStates">
                            <x-shop::form.control-group.control
                                type="select"
                                name="state"
                                v-model="selectedState"
                                class="w-full bg-[#fbf8f1] border border-[#2e2224]/20 px-3 py-2.5 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765]"
                                rules="{{ core()->isStateRequired() ? 'required' : '' }}"
                                :label="trans('shop::app.checkout.cart.summary.estimate-shipping.state')"
                                :placeholder="trans('shop::app.checkout.cart.summary.estimate-shipping.state')"
                            >
                                <option value="">
                                    @lang('shop::app.checkout.cart.summary.estimate-shipping.select-state')
                                </option>

                                <option
                                    v-for='(state, index) in states[selectedCountry]'
                                    :value="state.code"
                                >
                                    @{{ state.default_name }}
                                </option>
                            </x-shop::form.control-group.control>
                        </template>

                        <template v-else>
                            <x-shop::form.control-group.control
                                type="text"
                                name="state"
                                v-model="selectedState"
                                class="w-full bg-[#fbf8f1] border border-[#2e2224]/20 px-3 py-2.5 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765]"
                                rules="{{ core()->isStateRequired() ? 'required' : '' }}"
                                :label="trans('shop::app.checkout.cart.summary.estimate-shipping.state')"
                                :placeholder="trans('shop::app.checkout.cart.summary.estimate-shipping.state')"
                            />
                        </template>
                    </template>

                    <x-shop::form.control-group.error name="state" />
                </x-shop::form.control-group>

                <!-- Postcode -->
                <x-shop::form.control-group class="mb-0!">
                    <x-shop::form.control-group.label class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]/70 {{ core()->isPostCodeRequired() ? 'required' : '' }}">
                        @lang('shop::app.checkout.cart.summary.estimate-shipping.postcode')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        name="postcode"
                        class="w-full bg-[#fbf8f1] border border-[#2e2224]/20 px-3 py-2.5 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765]"
                        rules="{{ core()->isPostCodeRequired() ? 'required' : '' }}|postcode"
                        :label="trans('shop::app.checkout.cart.summary.estimate-shipping.postcode')"
                        :placeholder="trans('shop::app.checkout.cart.summary.estimate-shipping.postcode')"
                    />

                    <x-shop::form.control-group.error control-name="postcode" />
                </x-shop::form.control-group>

                <!-- Estimated Shipping Methods -->
                <div
                    class="mt-4 grid border border-[#2e2224]/15"
                    v-if="methods.length"
                >
                    <template v-for="method in methods">
                        {!! view_render_event('bagisto.shop.checkout.cart.summary.estimate_shipping.shipping_method.before') !!}

                        <div
                            class="relative select-none border-b border-[#2e2224]/10 last:border-b-0"
                            v-for="rate in method.rates"
                        >
                            <div class="absolute top-5 ltr:left-4 rtl:right-4">
                                <x-shop::form.control-group.control
                                    type="radio"
                                    name="shipping_method"
                                    ::for="rate.method"
                                    ::id="rate.method"
                                    ::value="rate.method"
                                    ::label="rate.method"
                                />
                            </div>

                            <label
                                class="block cursor-pointer p-4 ps-12"
                                :for="rate.method"
                            >
                                <p class="font-serif text-lg font-bold text-[#2e2224]">
                                    @{{ rate.base_formatted_price }}
                                </p>

                                <p class="mt-1 font-mono text-xs text-[#2e2224]/60">
                                    <span class="font-bold text-[#2e2224]">@{{ rate.method_title }}</span> — @{{ rate.method_description }}
                                </p>
                            </label>
                        </div>

                        {!! view_render_event('bagisto.shop.checkout.cart.summary.estimate_shipping.shipping_method.after') !!}
                    </template>
                </div>
            </form>
        </x-shop::form>
    </script>

    <script type="module">
        app.component('v-estimate-tax-shipping', {
            template: '#v-estimate-tax-shipping-template',

            props: ['cart'],

            data() {
                return {
                    selectedCountry: '',

                    selectedState: '',

                    countries: [],

                    states: null,

                    methods: [],

                    isStoring: false,
                }
            },

            computed: {
                haveStates() {
                    return !! this.states[this.selectedCountry]?.length;
                },
            },

            mounted() {
                this.getCountries();

                this.getStates();
            },

            methods: {
                getCountries() {
                    this.$axios.get("{{ route('shop.api.core.countries') }}")
                        .then(response => {
                            this.countries = response.data.data;
                        })
                        .catch(() => {});
                },

                getStates() {
                    this.$axios.get("{{ route('shop.api.core.states') }}")
                        .then(response => {
                            this.states = response.data.data;
                        })
                        .catch(() => {});
                },

                estimateShipping(params, { setErrors }) {
                    this.isStoring = true;

                    Object.keys(params).forEach(key => params[key] == null && delete params[key]);

                    this.$axios.post('{{ route('shop.api.checkout.cart.estimate_shipping') }}', params)
                        .then((response) => {
                            this.isStoring = false;

                            this.methods = response.data.data.shipping_methods;

                            this.$emit('processed', response.data.data.cart);
                        })
                        .catch(error => {
                            this.isStoring = false;

                            if (error.response.status == 422) {
                                setErrors(error.response.data.errors);
                            }
                        });
                },
            },
        });
    </script>
@endPushOnce
