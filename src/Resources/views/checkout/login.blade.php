<!-- Checkout Login Vue JS Component -->
<v-checkout-login>
    <div class="flex items-center">
        <span class="cursor-pointer font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] hover:text-[#bd1765] transition-colors">
            @lang('shop::app.checkout.login.title')
        </span>
    </div>
</v-checkout-login>

@pushOnce('scripts')
    {!! \Webkul\Customer\Facades\Captcha::renderJS() !!}

    <script
        type="text/x-template"
        id="v-checkout-login-template"
    >
        <div>
            <div class="flex items-center">
                <span
                    class="cursor-pointer font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] hover:text-[#bd1765] transition-colors"
                    role="button"
                    @click="$refs.loginModel.open()"
                >
                    @lang('shop::app.checkout.login.title')
                </span>
            </div>

            <!-- Login Form (Teleported to Body for Viewport Centering) -->
            <teleport to="body">
                <x-shop::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                >
                    {!! view_render_event('bagisto.shop.checkout.login.before') !!}

                    <!-- Login form -->
                    <form @submit="handleSubmit($event, login)">
                        {!! view_render_event('bagisto.shop.checkout.login.form_controls.before') !!}

                        <!-- Login modal -->
                        <x-shop::modal ref="loginModel">
                        <!-- Modal Header -->
                        <x-slot:header class="p-6 border-b border-[#2e2224]/10 bg-[#fbf8f1]">
                            <h2 class="font-serif font-bold text-xl md:text-2xl text-[#2e2224] uppercase tracking-wide">
                                @lang('shop::app.checkout.login.title')
                            </h2>
                        </x-slot>

                        <!-- Modal Content -->
                        <x-slot:content class="p-6 md:p-8 space-y-4">
                            <!-- Email -->
                            <x-shop::form.control-group class="mb-0">
                                <x-shop::form.control-group.label class="required font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5 block">
                                    @lang('shop::app.checkout.login.email')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="email"
                                    class="w-full bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] focus:bg-white transition-colors"
                                    name="email"
                                    rules="required|email"
                                    :label="trans('shop::app.checkout.login.email')"
                                    placeholder="email@example.com"
                                    :aria-label="trans('shop::app.checkout.login.email')"
                                    aria-required="true"
                                />

                                <x-shop::form.control-group.error control-name="email" class="text-xs font-mono text-red-600 mt-1" />
                            </x-shop::form.control-group>

                            <!-- Password -->
                            <x-shop::form.control-group class="mb-0">
                                <x-shop::form.control-group.label class="required font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5 block">
                                    @lang('shop::app.checkout.login.password')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="password"
                                    class="w-full bg-[#fbf8f1] border border-[#2e2224]/30 px-4 py-3 text-sm font-mono text-[#2e2224] outline-none focus:border-[#bd1765] focus:bg-white transition-colors"
                                    id="password"
                                    name="password"
                                    rules="required|min:6"
                                    :label="trans('shop::app.checkout.login.password')"
                                    :placeholder="trans('shop::app.checkout.login.password')"
                                    :aria-label="trans('shop::app.checkout.login.password')"
                                    aria-required="true"
                                />

                                <x-shop::form.control-group.error control-name="password" class="text-xs font-mono text-red-600 mt-1" />
                            </x-shop::form.control-group>

                            <!-- Captcha -->
                            @if (core()->getConfigData('customer.captcha.credentials.status'))
                                <x-shop::form.control-group class="mt-4">
                                    {!! \Webkul\Customer\Facades\Captcha::render() !!}

                                    <x-shop::form.control-group.error control-name="recaptcha_token" class="text-xs font-mono text-red-600 mt-1" />
                                </x-shop::form.control-group>
                            @endif
                        </x-slot>

                        <!-- Modal Footer -->
                        <x-slot:footer class="p-6 border-t border-[#2e2224]/10 bg-white">
                            <button
                                type="submit"
                                class="w-full bg-[#bd1765] hover:bg-[#8f0e4b] text-white font-mono text-xs md:text-sm font-bold uppercase tracking-widest py-3.5 px-8 transition-colors disabled:opacity-50 cursor-pointer flex items-center justify-center gap-2"
                                :disabled="isStoring"
                            >
                                <span v-if="isStoring" class="animate-spin inline-block w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full"></span>
                                <span>@lang('shop::app.checkout.login.title')</span>
                            </button>
                        </x-slot>
                    </x-shop::modal>

                    {!! view_render_event('bagisto.shop.checkout.login.form_controls.after') !!}
                    </form>
                </x-shop::form>
            </teleport>

            {!! view_render_event('bagisto.shop.checkout.login.after') !!}
        </div>
    </script>

    <script type="module">
        app.component('v-checkout-login', {
            template: '#v-checkout-login-template',

            data() {
                return {
                    isStoring: false,
                }
            },

            methods: {
                login(params, {
                    resetForm,
                    setErrors
                }) {
                    this.isStoring = true;

                    const captchaResponse = document.querySelector('[name="recaptcha_token"]')?.value

                    params['recaptcha_token'] = captchaResponse;

                    this.$axios.post("{{ route('shop.api.customers.session.create') }}", params)
                        .then((response) => {
                            this.isStoring = false;

                            window.location.reload();
                        })
                        .catch((error) => {
                            this.isStoring = false;

                            if (error.response?.status == 422) {
                                setErrors(error.response.data.errors);

                                return;
                            }

                            this.$emitter.emit('add-flash', {
                                type: 'error',
                                message: error.response?.data?.message || 'Error logging in'
                            });
                        });
                },
            }
        })
    </script>
@endPushOnce
