@props(['options' => []])
@inject('sectionRepository', 'Webkul\Theme\Repositories\SectionRepository')
@inject('categoryRepository', 'Webkul\Category\Repositories\CategoryRepository')

@php
    $channel = core()->getCurrentChannel();
    $cart = \Webkul\Checkout\Facades\Cart::getCart();
    $cartCount = (int) ($cart?->items_qty ?? 0);
    $customer = auth()->guard('customer')->user();
    $locale = app()->getLocale();

    $announcementSection = $sectionRepository->findOneOfType(
        'nc_announcement',
        $channel->id,
        $channel->theme,
        $locale
    );

    $headerNavSection = $sectionRepository->findOneOfType(
        'nc_header_nav',
        $channel->id,
        $channel->theme,
        $locale
    );

    $headerNavOptions = array_merge((array) ($headerNavSection?->options ?? []), (array) ($options ?? []));
    $headerBgColor = data_get($headerNavOptions, 'bg_color');
    $headerTextColor = data_get($headerNavOptions, 'text_color');

    $announcementText = data_get($announcementSection?->options, 'text') 
        ?: trans('nc::app.brand.tagline');
    $announcementLink = data_get($announcementSection?->options, 'link') ?: '#newsletter';
    $announcementBtn = data_get($announcementSection?->options, 'btn_text') ?: trans('nc::app.header.sign_up');

    $brandTitle = data_get($headerNavOptions, 'brand_title') 
        ?: ($channel->name ?: trans('nc::app.brand.name'));
    $brandSubtitle = data_get($headerNavOptions, 'brand_subtitle') 
        ?: trans('nc::app.brand.subtitle');

    $allLocales = $channel->locales()->orderBy('name')->get();
    $currentLocale = core()->getCurrentLocale();
    $allCurrencies = $channel->currencies;
    $currentCurrency = core()->getCurrentCurrency();
    $currentCurrencyCode = core()->getCurrentCurrencyCode();

    $buildQueryUrl = function (array $params) {
        $merged = array_merge(request()->query(), $params);
        return url()->current() . '?' . http_build_query($merged);
    };

    $visibleCategories = $categoryRepository->getVisibleCategoryTree($channel->root_category_id);

    $customLinks = data_get($headerNavSection?->options, 'links');
    $hasCustomLinks = ! empty($customLinks) && is_array($customLinks);

    $navCategories = [];
    if (! $hasCustomLinks && $visibleCategories->count()) {
        foreach ($visibleCategories as $cat) {
            $children = [];
            if ($cat->children && $cat->children->count()) {
                foreach ($cat->children as $child) {
                    $subChildren = [];
                    if ($child->children && $child->children->count()) {
                        foreach ($child->children as $sub) {
                            $subChildren[] = [
                                'label' => $sub->name,
                                'url'   => $sub->url ?: ($sub->slug ? route('shop.product_or_category.index', $sub->slug) : route('shop.search.index')),
                            ];
                        }
                    }

                    $children[] = [
                        'label'    => $child->name,
                        'url'      => $child->url ?: ($child->slug ? route('shop.product_or_category.index', $child->slug) : route('shop.search.index')),
                        'children' => $subChildren,
                    ];
                }
            }

            $navCategories[] = [
                'label'    => $cat->name,
                'url'      => $cat->url ?: ($cat->slug ? route('shop.product_or_category.index', $cat->slug) : route('shop.search.index')),
                'children' => $children,
            ];
        }
    }
@endphp

<x-nc::sections.announcement :options="$announcementSection?->options ?? []" />

<header class="nc-site-header" style="{{ $headerBgColor ? 'background-color: ' . $headerBgColor . ';' : '' }} {{ $headerTextColor ? 'color: ' . $headerTextColor . ';' : '' }}">
    <div class="nc-site-header__container max-w-7xl mx-auto w-full h-full flex items-center justify-between gap-4 lg:gap-8">
        <div class="flex items-center shrink-0">
            @if ($channel->logo_url)
                <a href="{{ route('shop.home.index') }}" class="inline-flex items-center hover:opacity-85 transition-opacity">
                    <img src="{{ $channel->logo_url }}" alt="{{ $channel->name }}" class="h-9 w-auto max-h-9 object-contain" />
                </a>
            @else
                <a href="{{ route('shop.home.index') }}" class="nc-brand-lockup text-[#2e2224] hover:text-[#bd1765]">
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
        </div>

        <nav class="hidden lg:flex flex-1 items-center justify-center gap-4 xl:gap-6 px-2" aria-label="{{ trans('nc::app.header.main_navigation') }}">
            <a href="{{ route('shop.home.index') }}" class="nc-nav-link {{ request()->routeIs('shop.home.index') ? 'text-[#bd1765]' : '' }}">
                {{ trans('nc::app.header.home') }}
            </a>

            @if ($hasCustomLinks)
                @foreach ($customLinks as $link)
                    <a href="{{ $link['url'] ?? '#' }}" class="nc-nav-link">
                        {{ $link['label'] ?? '' }}
                    </a>
                @endforeach
            @elseif (! empty($navCategories))
                @foreach ($navCategories as $catItem)
                    @if (! empty($catItem['children']))
                        <div class="relative group/menu py-2">
                            <a
                                href="{{ $catItem['url'] }}"
                                class="nc-nav-link inline-flex items-center gap-1.5 cursor-pointer"
                            >
                                <span>{{ $catItem['label'] }}</span>
                                <svg class="w-3 h-3 text-[#2e2224]/60 transition-transform duration-200 group-hover/menu:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </a>

                            <div class="invisible opacity-0 translate-y-1 group-hover/menu:visible group-hover/menu:opacity-100 group-hover/menu:translate-y-0 transition-all duration-200 absolute top-full start-0 pt-2 z-50 min-w-[240px]">
                                <div class="bg-white border border-[#2e2224] shadow-2xl p-3 space-y-1">
                                    <a
                                        href="{{ $catItem['url'] }}"
                                        class="flex items-center justify-between px-3.5 py-2 text-xs font-mono font-bold text-[#bd1765] hover:bg-[#bd1765] hover:text-white border-b border-[#2e2224]/10 mb-1 uppercase tracking-wider transition-colors"
                                    >
                                        <span>{{ trans('nc::app.footer.shop_all') }} ({{ $catItem['label'] }})</span>
                                        <svg class="w-3.5 h-3.5 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14M12 5l7 7-7 7"/>
                                        </svg>
                                    </a>

                                    @foreach ($catItem['children'] as $child)
                                        <div class="relative group/submenu">
                                            <a
                                                href="{{ $child['url'] }}"
                                                class="flex items-center justify-between px-3.5 py-2 text-xs font-serif text-[#2e2224] hover:text-white hover:bg-[#bd1765] transition-colors"
                                            >
                                                <span>{{ $child['label'] }}</span>
                                                @if (! empty($child['children']))
                                                    <svg class="w-3 h-3 rtl:rotate-180 text-current" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="m9 18 6-6-6-6"/>
                                                    </svg>
                                                @endif
                                            </a>

                                            @if (! empty($child['children']))
                                                <div class="invisible opacity-0 -translate-x-1 group-hover/submenu:visible group-hover/submenu:opacity-100 group-hover/submenu:translate-x-0 transition-all duration-200 absolute top-0 start-full ps-1.5 z-50 min-w-[220px]">
                                                    <div class="bg-white border border-[#2e2224] shadow-2xl p-2.5 space-y-1">
                                                        @foreach ($child['children'] as $sub)
                                                            <a
                                                                href="{{ $sub['url'] }}"
                                                                class="block px-3 py-1.5 text-xs font-serif text-[#2e2224] hover:text-white hover:bg-[#bd1765] transition-colors"
                                                            >
                                                                {{ $sub['label'] }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ $catItem['url'] }}" class="nc-nav-link">
                            {{ $catItem['label'] }}
                        </a>
                    @endif
                @endforeach
            @else
                <a href="{{ route('shop.search.index') }}" class="nc-nav-link">
                    {{ trans('nc::app.header.shop') }}
                </a>
                <a href="#concerns" class="nc-nav-link">
                    {{ trans('nc::app.header.concerns') }}
                </a>
                <a href="#routine" class="nc-nav-link">
                    {{ trans('nc::app.header.routine') }}
                </a>
                <a href="#rewards" class="nc-nav-link">
                    {{ trans('nc::app.header.rewards') }}
                </a>
            @endif
        </nav>

        <div class="shrink-0 flex items-center justify-end gap-2 sm:gap-2.5">
            <div class="relative group">
                <button
                    type="button"
                    class="h-10 px-3.5 flex items-center gap-2 border border-[#2e2224] bg-white text-[#2e2224] hover:bg-[#bd1765] hover:text-white hover:border-[#bd1765] transition-colors cursor-pointer select-none group"
                    aria-label="{{ trans('nc::app.header.language') }} / {{ trans('nc::app.header.currency') }}"
                >
                    <svg class="w-4 h-4 shrink-0 transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9.5"/>
                        <path d="M2.5 12h19M12 2.5a14.5 14.5 0 0 1 3.8 9.5 14.5 14.5 0 0 1-3.8 9.5 14.5 14.5 0 0 1-3.8-9.5 14.5 14.5 0 0 1 3.8-9.5z"/>
                    </svg>
                    <span class="hidden sm:inline-block font-mono text-[11px] font-bold uppercase tracking-wider whitespace-nowrap">
                        <bdi>{{ $currentLocale?->code }}</bdi> · <bdi>{{ $currentCurrencyCode }}</bdi>
                    </span>
                    <svg class="w-3 h-3 transition-transform duration-200 group-hover:rotate-180 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </button>

                <div class="invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200 absolute top-full end-0 mt-1 w-72 bg-white border border-[#2e2224] shadow-2xl p-4 z-50">
                    <div class="mb-3.5 pb-3 border-b border-[#2e2224]/15">
                        <div class="flex items-center gap-2 mb-2.5">
                            <span class="w-2 h-2 bg-[#bd1765]"></span>
                            <span class="text-[10px] font-mono uppercase tracking-widest text-[#bd1765] font-bold">
                                {{ trans('nc::app.header.language') }}
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-1.5">
                            @foreach ($allLocales as $loc)
                                <a
                                    href="{{ $buildQueryUrl(['locale' => $loc->code]) }}"
                                    class="flex items-center justify-between px-3 py-2 text-xs font-serif transition-colors border {{ $loc->code === app()->getLocale() ? 'bg-[#2e2224] text-white border-[#2e2224]' : 'bg-[#fbf8f1] text-[#2e2224] border-[#2e2224]/20 hover:border-[#bd1765] hover:bg-[#bd1765] hover:text-white' }}"
                                >
                                    <span>{{ $loc->name }}</span>
                                    <span class="text-[10px] uppercase font-mono {{ $loc->code === app()->getLocale() ? 'text-white/80' : 'text-[#2e2224]/60' }}">{{ $loc->code }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center gap-2 mb-2.5">
                            <span class="w-2 h-2 bg-[#bd1765]"></span>
                            <span class="text-[10px] font-mono uppercase tracking-widest text-[#bd1765] font-bold">
                                {{ trans('nc::app.header.currency') }}
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-1.5">
                            @foreach ($allCurrencies as $cur)
                                <a
                                    href="{{ $buildQueryUrl(['currency' => $cur->code]) }}"
                                    class="flex items-center justify-between px-3 py-2 text-xs font-mono transition-colors border {{ $cur->code === $currentCurrencyCode ? 'bg-[#2e2224] text-white border-[#2e2224]' : 'bg-[#fbf8f1] text-[#2e2224] border-[#2e2224]/20 hover:border-[#bd1765] hover:bg-[#bd1765] hover:text-white' }}"
                                >
                                    <span class="font-bold">{{ $cur->code }}</span>
                                    <span class="text-[11px] {{ $cur->code === $currentCurrencyCode ? 'text-white/80' : 'text-[#2e2224]/60' }}">{{ $cur->symbol }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <button
                type="button"
                data-nc-search-open
                class="p-2 flex items-center justify-center text-[#2e2224] hover:text-[#bd1765] transition-colors cursor-pointer group"
                aria-label="{{ trans('nc::app.header.search') }}"
            >
                <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="7"/>
                    <path d="m20.5 20.5-4.2-4.2"/>
                </svg>
            </button>

            <div class="relative group">
                <a
                    href="{{ $customer ? route('shop.customers.account.profile.index') : route('shop.customer.session.index') }}"
                    class="p-2 flex items-center justify-center text-[#2e2224] hover:text-[#bd1765] transition-colors cursor-pointer group"
                    aria-label="{{ trans('nc::app.header.account') }}"
                >
                    <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="4.25"/>
                        <path d="M4.5 20a7.5 7.5 0 0 1 15 0"/>
                    </svg>
                </a>

                @if ($customer)
                    <div class="invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200 absolute end-0 top-full mt-1 w-56 bg-white border border-[#2e2224] shadow-2xl p-2 z-50">
                        <div class="px-3 py-2 mb-1 bg-[#fbf8f1] border border-[#2e2224]/20">
                            <div class="text-[10px] font-mono text-[#2e2224]/60 uppercase tracking-wider">
                                {{ trans('nc::app.header.welcome') }}
                            </div>
                            <div class="text-xs font-serif font-bold text-[#bd1765] truncate">
                                {{ $customer->first_name }} {{ $customer->last_name }}
                            </div>
                        </div>
                        <a href="{{ route('shop.customers.account.orders.index') }}" class="flex items-center gap-2 px-3 py-2 text-xs font-serif text-[#2e2224] hover:bg-[#bd1765] hover:text-white transition-colors">
                            <svg class="w-3.5 h-3.5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect width="18" height="18" x="3" y="3"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                            <span>{{ trans('nc::app.header.orders') }}</span>
                        </a>
                        <a href="{{ route('shop.customers.account.profile.index') }}" class="flex items-center gap-2 px-3 py-2 text-xs font-serif text-[#2e2224] hover:bg-[#bd1765] hover:text-white transition-colors">
                            <svg class="w-3.5 h-3.5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <span>{{ trans('nc::app.header.profile') }}</span>
                        </a>
                        <div class="my-1 border-t border-[#2e2224]/15"></div>
                        <form action="{{ route('shop.customer.session.destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-xs font-serif text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                <svg class="w-3.5 h-3.5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>
                                </svg>
                                <span>{{ trans('nc::app.header.logout') }}</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <button
                type="button"
                data-nc-cart-open
                class="relative p-2 flex items-center justify-center text-[#2e2224] hover:text-[#bd1765] transition-colors cursor-pointer group"
                aria-label="{{ trans('nc::app.header.cart') }}"
            >
                <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 8h12l1.2 12.5a1 1 0 0 1-1 .5H5.8a1 1 0 0 1-1-.5L6 8Z"/>
                    <path d="M9 8V6a3 3 0 0 1 6 0v2"/>
                </svg>
                <span
                    data-nc-cart-count
                    class="absolute -top-1 -end-1 min-w-[17px] h-[17px] px-1 bg-[#bd1765] text-white text-[10px] font-mono font-bold flex items-center justify-center leading-none transition-all duration-200 {{ $cartCount > 0 ? 'scale-100 opacity-100' : 'scale-0 opacity-0' }}"
                >
                    {{ $cartCount }}
                </span>
            </button>

            <button
                type="button"
                data-nc-menu-toggle
                class="lg:hidden p-2 flex items-center justify-center text-[#2e2224] hover:text-[#bd1765] transition-colors cursor-pointer"
                aria-label="{{ trans('nc::app.header.menu') }}"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round">
                    <line x1="4" y1="7" x2="20" y2="7"/>
                    <line x1="4" y1="12" x2="20" y2="12"/>
                    <line x1="4" y1="17" x2="20" y2="17"/>
                </svg>
            </button>
        </div>
    </div>
</header>

<div data-nc-mobile-nav class="hidden lg:hidden fixed inset-x-0 top-[122px] z-30 bg-[#fbf8f1] border-b border-[#2e2224] p-6 shadow-2xl max-h-[calc(100vh-140px)] overflow-y-auto">
    <div class="flex flex-col gap-4 max-w-lg mx-auto">
        <a href="{{ route('shop.home.index') }}" class="nc-nav-link text-base">
            {{ trans('nc::app.header.home') }}
        </a>

        @if ($hasCustomLinks)
            @foreach ($customLinks as $link)
                <a href="{{ $link['url'] ?? '#' }}" class="nc-nav-link text-base">
                    {{ $link['label'] ?? '' }}
                </a>
            @endforeach
        @elseif (! empty($navCategories))
            @foreach ($navCategories as $catItem)
                <div class="space-y-1.5 p-3 bg-white border border-[#2e2224]">
                    <a href="{{ $catItem['url'] }}" class="nc-nav-link text-base font-bold text-[#bd1765] block">
                        {{ $catItem['label'] }}
                    </a>
                    @if (! empty($catItem['children']))
                        <div class="ps-3 flex flex-col gap-2 pt-1 border-s border-[#2e2224]/30">
                            @foreach ($catItem['children'] as $child)
                                <a href="{{ $child['url'] }}" class="text-sm font-serif text-[#2e2224] hover:text-[#bd1765] transition-colors">
                                    {{ $child['label'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @endif

        <div class="pt-4 border-t border-[#2e2224]/20 space-y-3">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-[#bd1765]"></span>
                <span class="block text-xs font-mono font-bold text-[#bd1765] uppercase">
                    {{ trans('nc::app.header.language') }} / {{ trans('nc::app.header.currency') }}
                </span>
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach ($allLocales as $loc)
                    <a
                        href="{{ $buildQueryUrl(['locale' => $loc->code]) }}"
                        class="px-3.5 py-1.5 text-xs font-serif transition-colors border {{ $loc->code === app()->getLocale() ? 'bg-[#2e2224] text-white border-[#2e2224]' : 'bg-white text-[#2e2224] border-[#2e2224]/30 hover:border-[#bd1765] hover:bg-[#bd1765] hover:text-white' }}"
                    >
                        {{ $loc->name }}
                    </a>
                @endforeach
                @foreach ($allCurrencies as $cur)
                    <a
                        href="{{ $buildQueryUrl(['currency' => $cur->code]) }}"
                        class="px-3.5 py-1.5 text-xs font-mono transition-colors border {{ $cur->code === $currentCurrencyCode ? 'bg-[#2e2224] text-white border-[#2e2224]' : 'bg-white text-[#2e2224] border-[#2e2224]/30 hover:border-[#bd1765] hover:bg-[#bd1765] hover:text-white' }}"
                    >
                        {{ $cur->code }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
