@php use Illuminate\Support\Facades\Route; @endphp
<x-nc::layouts :title="trans('nc::app.customer.login.title')">
    @push('meta')
        <meta name="description" content="{{ trans('nc::app.customer.login.title') }}"/>
        <meta name="keywords" content="{{ trans('nc::app.customer.login.title') }}"/>
    @endPush

    <div class="nc-auth-view py-14 md:py-20 bg-[#fffefd]">
        <div class="max-w-md w-full mx-auto px-6">
            <div class="text-center mb-8">
                <span class="inline-block font-mono text-[11px] uppercase tracking-widest text-[#2e2224] font-bold mb-3 px-3.5 py-1 bg-[#f7b7ba] border border-[#2e2224]">
                    {{ trans('nc::app.customer.login.luxury_badge') }}
                </span>
                <h1 class="font-mono font-bold text-2xl md:text-4xl text-[#2e2224] mb-2 uppercase tracking-wide">
                    {{ trans('nc::app.customer.login.welcome') }}
                </h1>
                <p class="font-mono text-xs md:text-sm text-[#2e2224]/80 leading-relaxed max-w-sm mx-auto">
                    {{ trans('nc::app.customer.login.subtitle') }}
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

                {!! view_render_event('bagisto.shop.customers.login.before') !!}

                <form action="{{ route('shop.customer.session.create') }}" method="POST" class="space-y-5">
                    @csrf

                    {!! view_render_event('bagisto.shop.customers.login_form_controls.before') !!}

                    <div>
                        <label for="email" class="block font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224] mb-2">
                            {{ trans('nc::app.customer.login.email') }} *
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            placeholder="name@example.com"
                            class="w-full bg-[#fbf8f1] border border-[#2e2224] px-4 py-3 text-sm font-mono text-[#2e2224] font-bold outline-none focus:border-[#bd1765] transition-colors"
                        />
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block font-mono text-xs font-bold uppercase tracking-wider text-[#2e2224]">
                                {{ trans('nc::app.customer.login.password') }} *
                            </label>
                            <a
                                href="{{ route('shop.customers.forgot_password.create') }}"
                                class="font-mono text-xs text-[#bd1765] hover:underline font-bold"
                            >
                                {{ trans('nc::app.customer.login.forgot_password') }}
                            </a>
                        </div>
                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="w-full bg-[#fbf8f1] border border-[#2e2224] px-4 py-3 text-sm font-mono text-[#2e2224] font-bold outline-none focus:border-[#bd1765] transition-colors pe-10"
                            />
                            <button
                                type="button"
                                class="absolute top-1/2 -translate-y-1/2 end-3 text-[#2e2224]/70 hover:text-[#bd1765] cursor-pointer"
                                onclick="const p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password';"
                                aria-label="{{ trans('nc::app.customer.login.toggle_password') }}"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full bg-[#2e2224] text-white border border-[#2e2224] font-mono text-xs font-bold py-4 uppercase tracking-widest hover:bg-[#bd1765] transition-colors cursor-pointer"
                        >
                            {{ trans('nc::app.customer.login.btn_submit') }}
                        </button>
                    </div>

                    {!! view_render_event('bagisto.shop.customers.login_form_controls.after') !!}
                </form>

                {!! view_render_event('bagisto.shop.customers.login.after') !!}

                <div class="mt-8 pt-6 border-t border-[#2e2224]/15 text-center">
                    <p class="font-mono text-xs text-[#2e2224]/80 mb-2 font-bold">
                        {{ trans('nc::app.customer.login.no_account') }}
                    </p>
                    <a
                        href="{{ Route::has('shop.customers.register.index') ? route('shop.customers.register.index') : '#' }}"
                        class="font-mono text-xs font-bold uppercase text-[#bd1765] hover:underline tracking-wider"
                    >
                        {{ trans('nc::app.customer.login.sign_up_link') }} &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-nc::layouts>
