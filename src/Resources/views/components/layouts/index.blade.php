@props([
    'title'      => null,
    'hasHeader'  => true,
    'hasFeature' => true,
    'hasFooter'  => true,
])

@inject('sectionRepository', 'Webkul\Theme\Repositories\SectionRepository')

@php
    $channel = core()->getCurrentChannel();
    $headerNavSection = $sectionRepository->findOneOfType(
        'nc_header_nav',
        $channel->id,
        $channel->theme,
        app()->getLocale()
    );
@endphp

<!DOCTYPE html>
<html
    lang="{{ app()->getLocale() }}"
    dir="{{ core()->getCurrentLocale()->direction }}"
>
    <head>
        {!! view_render_event('bagisto.shop.layout.head.before') !!}

        <title>{{ $title ? $title . ' | ' . core()->getCurrentChannel()->name : core()->getCurrentChannel()->name }}</title>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="content-language" content="{{ app()->getLocale() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="base-url" content="{{ url()->to('/') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="currency" content="{{ core()->getCurrentCurrency()->toJson() }}">
        <meta name="generator" content="Bagisto - Numbers Nebula Theme">

        @stack('meta')

        <link
            rel="icon"
            sizes="16x16"
            href="{{ core()->getCurrentChannel()->favicon_url ?? asset('themes/shop/nebula-cosmetics/images/preview.png') }}"
        />

        @php
            $customAr = core()->getConfigData('general.design.nebula_theme.custom_font_arabic');
            $adminThemeFont = core()->getConfigData('nebula_theme.settings.appearance.font_family');
            $adminThemeFontMap = [
                'ibm_plex' => 'IBM Plex Sans Arabic',
                'tajawal'  => 'Tajawal',
                'cairo'    => 'Cairo',
                'system'   => 'Inter',
            ];
            $adminFallback = $adminThemeFontMap[$adminThemeFont] ?? null;

            $selectedArFont = ! empty($customAr)
                ? $customAr
                : (core()->getConfigData('general.design.nebula_theme.font_arabic')
                    ?: $adminFallback
                    ?: data_get($headerNavSection?->options, 'font_arabic')
                    ?: 'Tajawal');

            $customEn = core()->getConfigData('general.design.nebula_theme.custom_font_english');
            $selectedEnFont = ! empty($customEn)
                ? $customEn
                : (core()->getConfigData('general.design.nebula_theme.font_english')
                    ?: data_get($headerNavSection?->options, 'font_english')
                    ?: 'Cormorant Garamond');

            $primaryColor = core()->getConfigData('general.design.nebula_theme.primary_color')
                ?: data_get($headerNavSection?->options, 'primary_color')
                ?: '#bd1765';

            $secondaryColor = core()->getConfigData('general.design.nebula_theme.secondary_color')
                ?: data_get($headerNavSection?->options, 'secondary_color')
                ?: '#91e4d9';

            $googleFontsUrl = \NumbersNebula\NebulaCosmetics\Helpers\FontHelper::getGoogleFontsUrl([
                $selectedArFont,
                $selectedEnFont,
            ]);
        @endphp

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="{!! $googleFontsUrl !!}" rel="stylesheet">

        <script>
            window.ncTranslations = {
                added_to_bag: "{{ trans('nc::app.cart.added_to_bag') }}",
                error_add_to_bag: "{{ trans('nc::app.cart.error_add_to_bag') }}",
                select_options: "{{ trans('nc::app.products.select_options') }}"
            };
        </script>

        @bagistoVite(['src/Resources/assets/js/app.js'], 'shop')
        @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'])

        @stack('styles')

        <style>
            :root {
                --magenta: {{ $primaryColor }};
                --primary: {{ $primaryColor }};
                --secondary: {{ $secondaryColor }};
                --selected-font-ar: "{{ $selectedArFont }}", sans-serif;
                --selected-font-en: "{{ $selectedEnFont }}", sans-serif;
                --active-font: {{ app()->getLocale() === 'ar' ? 'var(--selected-font-ar)' : 'var(--selected-font-en)' }};
                --font-sans: var(--active-font);
                --font-serif: var(--active-font);
                --font-mono: var(--active-font);
            }

            body,
            input,
            button,
            select,
            textarea,
            .font-sans,
            .font-serif,
            .font-mono {
                font-family: var(--active-font) !important;
            }
        </style>

        @if ($customCss = core()->getConfigData('general.content.custom_scripts.custom_css'))
            <style>
                {!! $customCss !!}
            </style>
        @endif

        {!! view_render_event('bagisto.shop.layout.head.after') !!}
    </head>

    <body class="bg-[#fbf8f1] text-[#2e2224] antialiased selection:bg-[#bd1765] selection:text-white">
        {!! view_render_event('bagisto.shop.layout.body.before') !!}

        <div id="app">
            <x-shop::flash-group />

            <x-shop::modal.confirm />

            <div class="nc-site-shell min-h-screen flex flex-col justify-between">
                <div>
                    @if ($hasHeader)
                        <x-nc::layouts.header />
                    @endif

                    <main id="main">
                        {{ $slot }}
                    </main>
                </div>

                @if ($hasFooter)
                    <x-nc::layouts.footer />
                @endif
            </div>

            <x-nc::cart.drawer />

            <x-nc::search.modal />

            <div id="nc-toast-container"></div>
        </div>

        {!! view_render_event('bagisto.shop.layout.body.after') !!}

        <x-shop::layouts.webmcp />

        @stack('scripts')

        {!! view_render_event('bagisto.shop.layout.vue-app-mount.before') !!}
        <script>
            function mountApp() {
                if (window.app && typeof window.app.mount === "function") {
                    window.app.mount("#app");
                }
            }

            if (document.readyState === "loading") {
                document.addEventListener("DOMContentLoaded", mountApp);
            } else {
                mountApp();
            }
        </script>
        {!! view_render_event('bagisto.shop.layout.vue-app-mount.after') !!}

        <script type="text/javascript">
            {!! core()->getConfigData('general.content.custom_scripts.custom_javascript') !!}
        </script>
    </body>
</html>
