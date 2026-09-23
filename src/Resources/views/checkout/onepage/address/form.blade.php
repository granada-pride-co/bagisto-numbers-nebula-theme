@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-checkout-address-form-template"
    >
        <div class="mt-4 space-y-4">
            <x-shop::form.control-group class="hidden">
                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.id'"
                    ::value="address.id"
                />
            </x-shop::form.control-group>

            <!-- Company Name -->
            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5 block" ::for="controlName + '_company_name'">
                    @lang('shop::app.checkout.onepage.address.company-name')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.company_name'"
                    ::value="address.company_name"
                    :placeholder="trans('shop::app.checkout.onepage.address.company-name')"
                    ::id="controlName + '_company_name'"
                    class="w-full bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] focus:bg-white transition-colors"
                />
            </x-shop::form.control-group>

            {!! view_render_event('bagisto.shop.checkout.onepage.address.form.company_name.after') !!}

            <!-- First Name & Last Name -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-shop::form.control-group class="mb-0">
                    <x-shop::form.control-group.label class="required font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5 block" ::for="controlName + '_first_name'">
                        @lang('shop::app.checkout.onepage.address.first-name')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.first_name'"
                        ::value="address.first_name"
                        rules="required"
                        :label="trans('shop::app.checkout.onepage.address.first-name')"
                        :placeholder="trans('shop::app.checkout.onepage.address.first-name')"
                        ::id="controlName + '_first_name'"
                        class="w-full bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] focus:bg-white transition-colors"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.first_name'" class="text-xs font-mono text-red-600 mt-1" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.first_name.after') !!}

                <!-- Last Name -->
                <x-shop::form.control-group class="mb-0">
                    <x-shop::form.control-group.label class="required font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5 block" ::for="controlName + '_last_name'">
                        @lang('shop::app.checkout.onepage.address.last-name')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.last_name'"
                        ::value="address.last_name"
                        rules="required"
                        :label="trans('shop::app.checkout.onepage.address.last-name')"
                        :placeholder="trans('shop::app.checkout.onepage.address.last-name')"
                        ::id="controlName + '_last_name'"
                        class="w-full bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] focus:bg-white transition-colors"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.last_name'" class="text-xs font-mono text-red-600 mt-1" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.last_name.after') !!}
            </div>

            <!-- Email & Telephone -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-shop::form.control-group class="mb-0">
                    <x-shop::form.control-group.label class="required font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5 block" ::for="controlName + '_email'">
                        @lang('shop::app.checkout.onepage.address.email')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="email"
                        ::name="controlName + '.email'"
                        ::value="address.email"
                        rules="required|email"
                        :label="trans('shop::app.checkout.onepage.address.email')"
                        placeholder="email@example.com"
                        ::id="controlName + '_email'"
                        class="w-full bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] focus:bg-white transition-colors"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.email'" class="text-xs font-mono text-red-600 mt-1" />
                </x-shop::form.control-group>

                <!-- Phone Number -->
                <x-shop::form.control-group class="mb-0">
                    <x-shop::form.control-group.label class="required font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5 block" ::for="controlName + '_phone'">
                        @lang('shop::app.checkout.onepage.address.telephone')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.phone'"
                        ::value="address.phone"
                        rules="required|phone"
                        :label="trans('shop::app.checkout.onepage.address.telephone')"
                        :placeholder="trans('shop::app.checkout.onepage.address.telephone')"
                        ::id="controlName + '_phone'"
                        class="w-full bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] focus:bg-white transition-colors"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.phone'" class="text-xs font-mono text-red-600 mt-1" />
                </x-shop::form.control-group>
            </div>

            <!-- Vat ID -->
            <template v-if="controlName=='billing'">
                <x-shop::form.control-group class="mb-4">
                    <x-shop::form.control-group.label class="font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5 block" ::for="controlName + '_vat_id'">
                        @lang('shop::app.checkout.onepage.address.vat-id')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.vat_id'"
                        ::value="address.vat_id"
                        :label="trans('shop::app.checkout.onepage.address.vat-id')"
                        :placeholder="trans('shop::app.checkout.onepage.address.vat-id')"
                        ::id="controlName + '_vat_id'"
                        class="w-full bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] focus:bg-white transition-colors"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.vat_id'" class="text-xs font-mono text-red-600 mt-1" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.vat_id.after') !!}
            </template>

            <!-- Street Address -->
            <x-shop::form.control-group class="mb-4">
                <x-shop::form.control-group.label class="required font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5 block" ::for="controlName + '_address_0'">
                    @lang('shop::app.checkout.onepage.address.street-address')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.address.[0]'"
                    ::value="address.address[0]"
                    rules="required|address"
                    :label="trans('shop::app.checkout.onepage.address.street-address')"
                    :placeholder="trans('shop::app.checkout.onepage.address.street-address')"
                    ::id="controlName + '_address_0'"
                    class="w-full bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] focus:bg-white transition-colors"
                />

                <x-shop::form.control-group.error
                    class="text-xs font-mono text-red-600 mt-1"
                    ::name="controlName + '.address.[0]'"
                />

                @if (core()->getConfigData('customer.address.information.street_lines') > 1)
                    @for ($i = 1; $i < core()->getConfigData('customer.address.information.street_lines'); $i++)
                        <x-shop::form.control-group.control
                            type="text"
                            ::name="controlName + '.address.[{{ $i }}]'"
                            rules="address"
                            :label="trans('shop::app.checkout.onepage.address.street-address')"
                            :placeholder="trans('shop::app.checkout.onepage.address.street-address')"
                            ::id="controlName + '_address_{{ $i }}'"
                            class="w-full mt-2 bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] focus:bg-white transition-colors"
                        />

                        <x-shop::form.control-group.error
                            class="text-xs font-mono text-red-600 mt-1"
                            ::name="controlName + '.address.[{{ $i }}]'"
                        />
                    @endfor
                @endif
            </x-shop::form.control-group>

            {!! view_render_event('bagisto.shop.checkout.onepage.address.form.address.after') !!}

            <!-- Country & State -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Country -->
                <x-shop::form.control-group class="mb-0" ::for="controlName + '_country'">
                    <x-shop::form.control-group.label class="{{ core()->isCountryRequired() ? 'required' : '' }} font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5 block">
                        @lang('shop::app.checkout.onepage.address.country')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="select"
                        ::name="controlName + '.country'"
                        ::value="address.country"
                        v-model="selectedCountry"
                        rules="{{ core()->isCountryRequired() ? 'required' : '' }}"
                        :label="trans('shop::app.checkout.onepage.address.country')"
                        :placeholder="trans('shop::app.checkout.onepage.address.country')"
                        ::id="controlName + '_country'"
                        @change="selectedState = ''"
                        class="w-full bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] focus:bg-white transition-colors cursor-pointer"
                    >
                        <option value="">
                            @lang('shop::app.checkout.onepage.address.select-country')
                        </option>

                        <option
                            v-for="country in countries"
                            :value="country.code"
                        >
                            @{{ country.name }}
                        </option>
                    </x-shop::form.control-group.control>

                    <x-shop::form.control-group.error ::name="controlName + '.country'" class="text-xs font-mono text-red-600 mt-1" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.country.after') !!}

                <!-- State -->
                <x-shop::form.control-group class="mb-0">
                    <x-shop::form.control-group.label class="{{ core()->isStateRequired() ? 'required' : '' }} font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5 block" ::for="controlName + '_state'">
                        @lang('shop::app.checkout.onepage.address.state')
                    </x-shop::form.control-group.label>

                    <template v-if="states">
                        <template v-if="haveStates">
                            <x-shop::form.control-group.control
                                type="select"
                                ::name="controlName + '.state'"
                                rules="{{ core()->isStateRequired() ? 'required' : '' }}"
                                ::value="address.state"
                                v-model="selectedState"
                                :label="trans('shop::app.checkout.onepage.address.state')"
                                :placeholder="trans('shop::app.checkout.onepage.address.state')"
                                ::id="controlName + '_state'"
                                class="w-full bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] focus:bg-white transition-colors cursor-pointer"
                            >
                                <option value="">
                                    @lang('shop::app.checkout.onepage.address.select-state')
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
                                ::name="controlName + '.state'"
                                ::value="address.state"
                                v-model="selectedState"
                                rules="{{ core()->isStateRequired() ? 'required' : '' }}"
                                :label="trans('shop::app.checkout.onepage.address.state')"
                                :placeholder="trans('shop::app.checkout.onepage.address.state')"
                                ::id="controlName + '_state'"
                                class="w-full bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] focus:bg-white transition-colors"
                            />
                        </template>
                    </template>

                    <x-shop::form.control-group.error ::name="controlName + '.state'" class="text-xs font-mono text-red-600 mt-1" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.state.after') !!}
            </div>

            <!-- City & Postcode -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- City -->
                <x-shop::form.control-group class="mb-0">
                    <x-shop::form.control-group.label class="required font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5 block" ::for="controlName + '_city'">
                        @lang('shop::app.checkout.onepage.address.city')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.city'"
                        ::value="address.city"
                        rules="required"
                        :label="trans('shop::app.checkout.onepage.address.city')"
                        :placeholder="trans('shop::app.checkout.onepage.address.city')"
                        ::id="controlName + '_city'"
                        class="w-full bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] focus:bg-white transition-colors"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.city'" class="text-xs font-mono text-red-600 mt-1" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.city.after') !!}

                <!-- Postcode -->
                <x-shop::form.control-group class="mb-0">
                    <x-shop::form.control-group.label class="{{ core()->isPostCodeRequired() ? 'required' : '' }} font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5 block" ::for="controlName + '_postcode'">
                        @lang('shop::app.checkout.onepage.address.postcode')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.postcode'"
                        ::value="address.postcode"
                        rules="{{ core()->isPostCodeRequired() ? 'required' : '' }}|postcode"
                        :label="trans('shop::app.checkout.onepage.address.postcode')"
                        :placeholder="trans('shop::app.checkout.onepage.address.postcode')"
                        ::id="controlName + '_postcode'"
                        class="w-full bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] focus:bg-white transition-colors"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.postcode'" class="text-xs font-mono text-red-600 mt-1" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.postcode.after') !!}
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-checkout-address-form', {
            template: '#v-checkout-address-form-template',

            props: {
                controlName: {
                    type: String,
                    required: true,
                },

                address: {
                    type: Object,

                    default: () => ({
                        id: 0,
                        company_name: '',
                        first_name: '',
                        last_name: '',
                        email: '',
                        address: [],
                        country: '',
                        state: '',
                        city: '',
                        postcode: '',
                        phone: '',
                    }),
                },
            },

            data() {
                return {
                    selectedCountry: this.address.country,

                    selectedState: this.address.state,

                    countries: [],

                    states: null,
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
            }
        });
    </script>
@endPushOnce
