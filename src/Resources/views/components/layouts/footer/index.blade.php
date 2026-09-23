@props(['options' => []])
@inject('sectionRepository', 'Webkul\Theme\Repositories\SectionRepository')
@inject('categoryRepository', 'Webkul\Category\Repositories\CategoryRepository')

@php
    $channel = core()->getCurrentChannel();
    $categories = $categoryRepository->getVisibleCategoryTree($channel->root_category_id)->take(4);

    $footerSection = $sectionRepository->findOneOfType(
        'nc_footer',
        $channel->id,
        $channel->theme,
        app()->getLocale()
    );

    $footerRecord = $sectionRepository->findOneWhere([
        'type' => 'nc_footer',
        'channel_id' => $channel->id,
        'theme_code' => $channel->theme,
    ]);

    $options = array_merge((array) ($footerSection?->options ?? []), (array) ($options ?? []));
    $bgColor = data_get($options, 'bg_color') ?: '#fbf8f1';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';

    $brandTitle = data_get($options, 'brand_title')
        ?: ($channel->name ?: trans('nc::app.brand.name'));
    $brandSubtitle = data_get($options, 'brand_subtitle')
        ?: trans('nc::app.brand.subtitle');
    $brandDescription = data_get($options, 'brand_description')
        ?: trans('nc::app.brand.tagline');

    $col1Title = data_get($options, 'column_1_title')
        ?: trans('nc::app.footer.help');
    $col1Links = (array) data_get($options, 'column_1_links', []);

    $col2Title = data_get($options, 'column_2_title')
        ?: trans('nc::app.footer.more');
    $col2Links = (array) data_get($options, 'column_2_links', []);

    $col3Title = data_get($options, 'column_3_title')
        ?: trans('nc::app.footer.shop');
    $col3Links = (array) data_get($options, 'column_3_links', []);

    $location = data_get($options, 'location')
        ?: trans('nc::app.footer.location_default');
    $socialLinks = data_get($options, 'social_links')
        ?: trans('nc::app.footer.default_social');
    $copyright = data_get($options, 'copyright')
        ?: ('© ' . date('Y') . ' ' . $brandTitle . '. ' . trans('nc::app.footer.rights'));

    $showDeveloperCredit = (string) data_get($options, 'show_developer_credit', '1');
    $developerCreditText = array_key_exists('developer_credit_text', $options)
        ? trim((string) $options['developer_credit_text'])
        : trans('nc::app.sections.footer.default_developer_credit');
    $developerCreditUrl = data_get($options, 'developer_credit_url')
        ?: 'https://numbers-nebula.com';
@endphp

@if (
    ! $footerRecord
    || $footerSection
)
    <footer class="border-t border-[#2e2224]/15 mt-24 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg);">
        <div class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 text-[#2e2224]">
            <div class="lg:col-span-2 flex flex-col gap-4">
                @if ($channel->logo_url)
                    <a href="{{ route('shop.home.index') }}" class="inline-flex items-center w-max hover:opacity-85 transition-opacity">
                        <img src="{{ $channel->logo_url }}" alt="{{ $channel->name }}" class="h-9 w-auto max-h-9 object-contain" />
                    </a>
                @else
                    <a href="{{ route('shop.home.index') }}" class="nc-brand-lockup text-current w-max">
                        <span>{{ $brandTitle }}</span>
                        <span class="nc-brand-lockup__sub">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 92 82" fill="currentColor">
                                <path d="M46 72C28 52 27 28 46 3c19 25 18 49 0 69Z" opacity=".62"/>
                                <path d="M42 72C21 63 10 45 12 17c24 13 35 31 30 55Z" opacity=".82"/>
                                <path d="M50 72c21-9 32-27 30-55-24 13-35 31-30 55Z" opacity=".82"/>
                                <path d="M36 70C17 68 5 56 1 34c22 1 35 12 35 36Zm20 0c19-2 31-14 35-36-22 1-35 12-35 36Z"/>
                                <ellipse cx="46" cy="72" rx="14" ry="9"/>
                            </svg>
                            {{ $brandSubtitle }}
                        </span>
                    </a>
                @endif
                <p class="text-sm opacity-80 max-w-sm leading-relaxed">
                    {{ $brandDescription }}
                </p>
            </div>

            <div class="flex flex-col gap-3">
                <h4 class="font-mono text-xs font-bold tracking-widest uppercase" style="color: var(--section-color);">
                    {{ $col1Title }}
                </h4>
                @if (! empty($col1Links))
                    @foreach ($col1Links as $link)
                        @if (! empty($link['title']))
                            <a href="{{ $link['url'] ?? '#top' }}" class="text-xs opacity-75 hover:opacity-100 hover:text-[#bd1765] transition-colors">
                                {{ $link['title'] }}
                            </a>
                        @endif
                    @endforeach
                @else
                    <a href="#top" class="text-xs opacity-75 hover:opacity-100 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.faq') }}</a>
                    <a href="#top" class="text-xs opacity-75 hover:opacity-100 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.contact') }}</a>
                    <a href="#top" class="text-xs opacity-75 hover:opacity-100 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.shipping') }}</a>
                    <a href="#top" class="text-xs opacity-75 hover:opacity-100 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.returns') }}</a>
                @endif
            </div>

            <div class="flex flex-col gap-3">
                <h4 class="font-mono text-xs font-bold tracking-widest uppercase" style="color: var(--section-color);">
                    {{ $col2Title }}
                </h4>
                @if (! empty($col2Links))
                    @foreach ($col2Links as $link)
                        @if (! empty($link['title']))
                            <a href="{{ $link['url'] ?? '#top' }}" class="text-xs opacity-75 hover:opacity-100 hover:text-[#bd1765] transition-colors">
                                {{ $link['title'] }}
                            </a>
                        @endif
                    @endforeach
                @else
                    <a href="#routine" class="text-xs opacity-75 hover:opacity-100 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.routine') }}</a>
                    <a href="#rewards" class="text-xs opacity-75 hover:opacity-100 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.rewards') }}</a>
                    <a href="#top" class="text-xs opacity-75 hover:opacity-100 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.standards') }}</a>
                    <a href="#top" class="text-xs opacity-75 hover:opacity-100 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.journal') }}</a>
                @endif
            </div>

            <div class="flex flex-col gap-3">
                <h4 class="font-mono text-xs font-bold tracking-widest uppercase" style="color: var(--section-color);">
                    {{ $col3Title }}
                </h4>
                @if (! empty($col3Links))
                    @foreach ($col3Links as $link)
                        @if (! empty($link['title']))
                            <a href="{{ $link['url'] ?? '#top' }}" class="text-xs opacity-75 hover:opacity-100 hover:text-[#bd1765] transition-colors">
                                {{ $link['title'] }}
                            </a>
                        @endif
                    @endforeach
                @else
                    @foreach ($categories as $cat)
                        <a
                            href="{{ $cat->url ?: ($cat->slug ? route('shop.product_or_category.index', $cat->slug) : route('shop.search.index')) }}"
                            class="text-xs opacity-75 hover:opacity-100 hover:text-[#bd1765] transition-colors"
                        >
                            {{ $cat->name }}
                        </a>
                    @endforeach
                    <a href="{{ route('shop.search.index') }}" class="text-xs font-bold text-[#bd1765] hover:underline">
                        {{ trans('nc::app.footer.shop_all') }} →
                    </a>
                @endif
            </div>
        </div>

        <div class="border-t border-[#2e2224]/15 py-6 px-6 max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 font-mono text-[11px] tracking-wider opacity-70">
            <div>{{ $location }}</div>
            <div>{{ $socialLinks }}</div>
            <div>{{ $copyright }}</div>
            @if (
                $showDeveloperCredit !== '0'
                && filled($developerCreditText)
            )
                <div class="flex items-center gap-1.5 font-sans">
                    <a
                        href="{{ $developerCreditUrl ?: 'https://numbers-nebula.com' }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-1 opacity-80 hover:opacity-100 hover:text-[#bd1765] transition-colors font-medium group"
                    >
                        <span>{{ $developerCreditText }}</span>
                        <svg class="w-3 h-3 text-[#bd1765] group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <line x1="10" y1="14" x2="21" y2="3"></line>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </footer>
@endif
