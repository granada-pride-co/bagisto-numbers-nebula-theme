@php use Illuminate\Support\Facades\Route; @endphp
<x-nc::layouts :title="trans('nc::app.customer.register.title')">
    @push('meta')
        <meta name="description" content="{{ trans('nc::app.customer.register.title') }}"/>
        <meta name="keywords" content="{{ trans('nc::app.customer.register.title') }}"/>
    @endPush

    <div class="nc-auth-view py-14 md:py-20 bg-[#fffefd]">
        <div class="max-w-lg w-full mx-auto px-6">
            <div class="text-center mb-8">
                <span class="inline-block font-mono text-[11px] uppercase tracking-widest text-[#2e2224] font-bold mb-3 px-3.5 py-1 bg-[#f7b7ba] border border-[#2e2224]">
                    {{ trans('nc::app.customer.register.luxury_badge') }}
                </span>
                <h1 class="font-mono font-bold text-2xl md:text-4xl text-[#2e2224] mb-2 uppercase tracking-wide">
                    {{ trans('nc::app.customer.register.welcome') }}
                </h1>
                <p class="font-mono text-xs md:text-sm text-[#2e2224]/80 leading-relaxed max-w-md mx-auto">
                    {{ trans('nc::app.customer.register.subtitle') }}
                </p>
            </div>

            <div class="bg-white border border-[#2e2224] p-8 md:p-10">
                @if (isset($errors) && $errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-300 text-xs font-mono text-red-800 space-y-1.5 font-bold">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-red-600 rounded-full shrink-0"></span>
                                <span>{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                {!! view_render_event('bagisto.shop.customers.signup.before') !!}

                <form action="{{ route('shop.customers.register.store') }}" method="POST" class="space-y-4">
                    @csrf

                    {!! view_render_event('bagisto.shop.customers.signup_form_controls.before') !!}

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="first_name"
                                   class="block font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5">
                                {{ trans('nc::app.customer.register.first_name') }} *
                            </label>
                            <input
                                type="text"
                                name="first_name"
                                id="first_name"
                                value="{{ old('first_name') }}"
                                required
                                class="w-full bg-[#fbf8f1] border border-[#2e2224] px-4 py-3 text-sm font-mono font-bold text-[#2e2224] outline-none focus:border-[#bd1765] transition-colors"
                            />
                        </div>

                        <div>
                            <label for="last_name"
                                   class="block font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5">
                                {{ trans('nc::app.customer.register.last_name') }} *
                            </label>
                            <input
                                type="text"
                                name="last_name"
                                id="last_name"
                                value="{{ old('last_name') }}"
                                required
                                class="w-full bg-[#fbf8f1] border border-[#2e2224] px-4 py-3 text-sm font-mono font-bold text-[#2e2224] outline-none focus:border-[#bd1765] transition-colors"
                            />
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5">
                            {{ trans('nc::app.customer.register.email') }} *
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            placeholder="name@example.com"
                            class="w-full bg-[#fbf8f1] border border-[#2e2224] px-4 py-3 text-sm font-mono font-bold text-[#2e2224] outline-none focus:border-[#bd1765] transition-colors"
                        />
                    </div>

                    <div>
                        <label for="phone" class="block font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5">
                            {{ trans('nc::app.customer.register.phone') }}
                        </label>
                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            value="{{ old('phone') }}"
                            class="w-full bg-[#fbf8f1] border border-[#2e2224] px-4 py-3 text-sm font-mono font-bold text-[#2e2224] outline-none focus:border-[#bd1765] transition-colors"
                        />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password"
                                   class="block font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5">
                                {{ trans('nc::app.customer.register.password') }} *
                            </label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                required
                                class="w-full bg-[#fbf8f1] border border-[#2e2224] px-4 py-3 text-sm font-mono font-bold text-[#2e2224] outline-none focus:border-[#bd1765] transition-colors"
                            />
                        </div>

                        <div>
                            <label for="password_confirmation"
                                   class="block font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-1.5">
                                {{ trans('nc::app.customer.register.confirm_password') }} *
                            </label>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                required
                                class="w-full bg-[#fbf8f1] border border-[#2e2224] px-4 py-3 text-sm font-mono font-bold text-[#2e2224] outline-none focus:border-[#bd1765] transition-colors"
                            />
                        </div>
                    </div>

                    <div class="pt-4">
                        <button
                            type="submit"
                            class="w-full bg-[#2e2224] text-white border border-[#2e2224] font-mono text-xs font-bold py-4 uppercase tracking-widest hover:bg-[#bd1765] transition-colors cursor-pointer"
                        >
                            {{ trans('nc::app.customer.register.btn_submit') }}
                        </button>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.signup_form_controls.after') !!}
                </form>

                {!! view_render_event('bagisto.shop.customers.signup.after') !!}

                <div class="mt-8 pt-6 border-t border-[#2e2224]/15 text-center">
                    <p class="font-mono text-xs text-[#2e2224]/80 mb-2 font-bold">
                        {{ trans('nc::app.customer.register.have_account') }}
                    </p>
                    <a
                        href="{{ route('shop.customer.session.index') }}"
                        class="font-mono text-xs font-bold uppercase text-[#bd1765] hover:underline tracking-wider"
                    >
                        {{ trans('nc::app.customer.register.sign_in_link') }} &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-nc::layouts>
