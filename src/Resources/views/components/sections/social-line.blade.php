@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $text = data_get($options, 'text') ?: trans('nc::app.sections.social_line.default_text');
    $handle = data_get($options, 'handle') ?: '@NEBULA.COSMETICS';
    $link = data_get($options, 'link') ?: 'https://instagram.com';
    $configuredItems = (array) data_get($options, 'items', []);

    $defaultPhotos = [
        ['image' => asset('themes/shop/nebula-cosmetics/images/cleo-concern-portrait.jpg'), 'link' => $link],
        ['image' => asset('themes/shop/nebula-cosmetics/images/cleo-concern-application.jpg'), 'link' => $link],
        ['image' => asset('themes/shop/nebula-cosmetics/images/cleo-hero-product.jpg'), 'link' => $link],
        ['image' => asset('themes/shop/nebula-cosmetics/images/cleo-concern-texture.jpg'), 'link' => $link],
        ['image' => asset('themes/shop/nebula-cosmetics/images/cleo-hero-skin.jpg'), 'link' => $link],
        ['image' => asset('themes/shop/nebula-cosmetics/images/cleo-ritual-wide.jpg'), 'link' => $link],
    ];

    $items = ! empty($configuredItems) ? $configuredItems : $defaultPhotos;
    $bgColor = data_get($options, 'bg_color') ?: '#fbf8f1';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
@endphp

<section class="border-b border-[var(--section-color,#2e2224)] overflow-hidden" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg); color: var(--section-color); border-color: var(--section-color);">
    {{-- Header Banner --}}
    <div class="py-5 px-6 border-b border-[var(--section-color,#2e2224)]/20" style="background-color: var(--section-bg); color: var(--section-color);">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-6 font-mono text-xs font-bold tracking-widest uppercase text-center" style="color: var(--section-color);">
            <span class="opacity-80">{{ $text }}</span>
            <a
                href="{{ $link }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-2 text-[#bd1765] hover:text-[#2e2224] transition-colors"
            >
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                </svg>
                <span>{{ $handle }}</span>
                <svg class="w-3.5 h-3.5 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>

    {{-- Side-by-side Instagram Images Strip --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 divide-x rtl:divide-x-reverse divide-[#2e2224]/15">
        @foreach ($items as $item)
            @php
                $itemImage = data_get($item, 'image');
                $itemLink = data_get($item, 'link') ?: $link;

                $imgSrc = \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::url(
                    $itemImage,
                    asset('themes/shop/nebula-cosmetics/images/cleo-concern-portrait.jpg')
                );
            @endphp

            <a
                href="{{ $itemLink }}"
                target="_blank"
                rel="noopener noreferrer"
                class="group relative block aspect-square bg-[#ebd8c8] overflow-hidden focus:outline-none"
                aria-label="{{ trans('nc::app.sections.social_line.aria_post') }}"
            >
                <img
                    src="{{ $imgSrc }}"
                    alt="{{ trans('nc::app.sections.social_line.alt_photo') }}"
                    loading="lazy"
                    class="w-full h-full object-cover object-center transition-transform duration-500 ease-out group-hover:scale-110"
                >

                {{-- Luxury Instagram Overlay on Hover --}}
                <div class="absolute inset-0 bg-[#2e2224]/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center p-3 text-white">
                    <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mb-1 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                        </svg>
                    </div>
                    <span class="font-mono text-[10px] tracking-widest uppercase opacity-90">
                        {{ $handle }}
                    </span>
                </div>
            </a>
        @endforeach
    </div>
</section>
