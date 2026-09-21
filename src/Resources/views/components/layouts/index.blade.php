@props([
    'title'      => null,
    'hasHeader'  => true,
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

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@300;400;500;600;700;800&family=Amiri:ital,wght@0,400;0,700;1,400&family=Cairo:wght@400;600;700;800&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Courier+Prime:wght@400;700&family=DM+Sans:wght@400;500;700&family=El+Messiri:wght@400;600;700&family=IBM+Plex+Sans+Arabic:wght@400;600;700&family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Readex+Pro:wght@400;500;600;700&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

        @php
            $selectedArFont = data_get($headerNavSection?->options, 'font_arabic') ?: 'Alexandria';
            $selectedEnFont = data_get($headerNavSection?->options, 'font_english') ?: 'Cormorant Garamond';
            $primaryColor = data_get($headerNavSection?->options, 'primary_color') ?: '#bd1765';
        @endphp

        <style>
            :root {
                --magenta: {{ $primaryColor }};
                --selected-font-ar: "{{ $selectedArFont }}", "Alexandria", "Tajawal", "IBM Plex Sans Arabic", sans-serif;
                --selected-font-en: "{{ $selectedEnFont }}", "DM Sans", -apple-system, sans-serif;
                --font-sans: {{ app()->getLocale() === 'ar' ? 'var(--selected-font-ar)' : 'var(--selected-font-en)' }};
                --font-serif: {{ app()->getLocale() === 'ar' ? 'var(--selected-font-ar)' : 'var(--selected-font-en)' }};
            }
        </style>

        @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'])

        @stack('styles')

        {!! view_render_event('bagisto.shop.layout.head.after') !!}
    </head>

    <body class="bg-[#fbf8f1] text-[#2e2224] antialiased selection:bg-[#bd1765] selection:text-white">
        {!! view_render_event('bagisto.shop.layout.body.before') !!}

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

        {!! view_render_event('bagisto.shop.layout.body.after') !!}

        @stack('scripts')
    </body>
</html>
