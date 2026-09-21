@inject('sectionRepository', 'Webkul\Theme\Repositories\SectionRepository')
@inject('categoryRepository', 'Webkul\Category\Repositories\CategoryRepository')

@php
    $channel = core()->getCurrentChannel();
    $cart = \Webkul\Checkout\Facades\Cart::getCart();
    $cartCount = $cart?->items_qty ?? 0;
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

    $announcementText = data_get($announcementSection?->options, 'text') 
        ?: trans('nc::app.brand.tagline');
    $announcementLink = data_get($announcementSection?->options, 'link') ?: '#newsletter';
    $announcementBtn = data_get($announcementSection?->options, 'btn_text') ?: 'SIGN UP';

    $brandTitle = data_get($headerNavSection?->options, 'brand_title') 
        ?: ($channel->name ?: trans('nc::app.brand.name'));
    $brandSubtitle = data_get($headerNavSection?->options, 'brand_subtitle') 
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

<header class="nc-site-header">
    <div class="flex items-center">
        <a href="{{ route('shop.home.index') }}" class="nc-brand-lockup text-[#2e2224] hover:text-[#bd1765]">
            @if ($channel->logo_url)
                <img src="{{ $channel->logo_url }}" alt="{{ $channel->name }}" class="h-9 w-auto max-h-9 object-contain" />
            @else
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
            @endif
        </a>
    </div>

    <nav class="hidden lg:flex items-center justify-center gap-7" aria-label="Main Navigation">
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
                            class="nc-nav-link inline-flex items-center gap-1 cursor-pointer"
                        >
                            <span>{{ $catItem['label'] }}</span>
                            <svg class="w-3 h-3 opacity-60 transition-transform duration-200 group-hover/menu:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </a>

                        <div class="invisible opacity-0 group-hover/menu:visible group-hover/menu:opacity-100 transition-all duration-200 absolute top-full start-0 pt-2 z-50 min-w-[220px]">
                            <div class="bg-white border border-[#2e2224] shadow-xl p-3 space-y-1">
                                <a
                                    href="{{ $catItem['url'] }}"
                                    class="block px-3 py-1.5 text-xs font-mono font-bold text-[#bd1765] hover:bg-[#fbf8f1] border-b border-[#2e2224]/10 mb-1 uppercase"
                                >
                                    {{ trans('nc::app.footer.shop_all') }} ({{ $catItem['label'] }})
                                </a>

                                @foreach ($catItem['children'] as $child)
                                    <div class="relative group/submenu">
                                        <a
                                            href="{{ $child['url'] }}"
                                            class="flex items-center justify-between px-3 py-1.5 text-xs font-serif hover:text-[#bd1765] hover:bg-[#fbf8f1] transition-colors"
                                        >
                                            <span>{{ $child['label'] }}</span>
                                            @if (! empty($child['children']))
                                                <svg class="w-3 h-3 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M9 18l6-6-6-6"/>
                                                </svg>
                                            @endif
                                        </a>

                                        @if (! empty($child['children']))
                                            <div class="invisible opacity-0 group-hover/submenu:visible group-hover/submenu:opacity-100 transition-all duration-200 absolute top-0 start-full ps-1 z-50 min-w-[200px]">
                                                <div class="bg-white border border-[#2e2224] shadow-xl p-2 space-y-1">
                                                    @foreach ($child['children'] as $sub)
                                                        <a
                                                            href="{{ $sub['url'] }}"
                                                            class="block px-3 py-1.5 text-xs font-serif hover:text-[#bd1765] hover:bg-[#fbf8f1]"
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

    <div class="flex items-center justify-end gap-3">
        <div class="relative group">
            <button
                type="button"
                class="p-2 flex items-center gap-1.5 text-[#2e2224] hover:text-[#bd1765] transition-colors text-xs font-mono font-bold select-none cursor-pointer"
                aria-label="{{ trans('nc::app.header.language') }} / {{ trans('nc::app.header.currency') }}"
            >
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                </svg>
                <span class="hidden xl:inline uppercase tracking-wider text-[11px]">
                    {{ $currentLocale?->code }} · {{ $currentCurrencyCode }}
                </span>
                <svg class="w-3 h-3 text-[#2e2224]/60 transition-transform duration-200 group-hover:rotate-180 hidden sm:inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>

            <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 absolute top-full end-0 mt-1 w-64 bg-white border border-[#2e2224] shadow-2xl p-4 z-50">
                <div class="mb-3.5 pb-3 border-b border-[#2e2224]/15">
                    <span class="block text-[10px] font-mono uppercase tracking-wider text-[#bd1765] font-bold mb-2">
                        {{ trans('nc::app.header.language') }}
                    </span>
                    <div class="grid grid-cols-2 gap-1.5">
                        @foreach ($allLocales as $loc)
                            <a
                                href="{{ $buildQueryUrl(['locale' => $loc->code]) }}"
                                class="flex items-center justify-between px-2.5 py-1.5 text-xs font-serif transition-colors border {{ $loc->code === app()->getLocale() ? 'bg-[#2e2224] text-white border-[#2e2224]' : 'text-[#2e2224] border-[#2e2224]/20 hover:border-[#bd1765] hover:text-[#bd1765] hover:bg-[#fbf8f1]' }}"
                            >
                                <span>{{ $loc->name }}</span>
                                <span class="text-[10px] uppercase font-mono {{ $loc->code === app()->getLocale() ? 'text-white/80' : 'text-[#2e2224]/60' }}">{{ $loc->code }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div>
                    <span class="block text-[10px] font-mono uppercase tracking-wider text-[#bd1765] font-bold mb-2">
                        {{ trans('nc::app.header.currency') }}
                    </span>
                    <div class="grid grid-cols-2 gap-1.5">
                        @foreach ($allCurrencies as $cur)
                            <a
                                href="{{ $buildQueryUrl(['currency' => $cur->code]) }}"
                                class="flex items-center justify-between px-2.5 py-1.5 text-xs font-mono transition-colors border {{ $cur->code === $currentCurrencyCode ? 'bg-[#2e2224] text-white border-[#2e2224]' : 'text-[#2e2224] border-[#2e2224]/20 hover:border-[#bd1765] hover:text-[#bd1765] hover:bg-[#fbf8f1]' }}"
                            >
                                <span class="font-bold">{{ $cur->code }}</span>
                                <span class="text-[11px]">{{ $cur->symbol }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <button
            type="button"
            data-nc-search-open
            class="p-2 text-[#2e2224] hover:text-[#bd1765] transition-colors"
            aria-label="{{ trans('nc::app.header.search') }}"
        >
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="11" cy="11" r="7"/>
                <path d="m20 20-3.5-3.5"/>
            </svg>
        </button>

        <div class="relative group">
            <a
                href="{{ $customer ? route('shop.customers.account.profile.index') : route('shop.customer.session.index') }}"
                class="p-2 flex items-center text-[#2e2224] hover:text-[#bd1765] transition-colors"
                aria-label="{{ trans('nc::app.header.account') }}"
            >
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 20c0-4 4-6 8-6s8 2 8 6"/>
                </svg>
            </a>

            @if ($customer)
                <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 absolute end-0 top-full mt-1 w-48 bg-white border border-[#2e2224] shadow-xl p-2 z-50">
                    <div class="px-3 py-2 border-b border-[#2e2224]/10 text-xs font-mono font-bold text-[#bd1765]">
                        {{ $customer->first_name }}
                    </div>
                    <a href="{{ route('shop.customers.account.orders.index') }}" class="block px-3 py-2 text-xs font-serif hover:bg-[#fbf8f1]">
                        {{ trans('nc::app.header.orders') }}
                    </a>
                    <a href="{{ route('shop.customers.account.profile.index') }}" class="block px-3 py-2 text-xs font-serif hover:bg-[#fbf8f1]">
                        {{ trans('nc::app.header.profile') }}
                    </a>
                    <form action="{{ route('shop.customer.session.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-start px-3 py-2 text-xs font-serif text-red-600 hover:bg-red-50">
                            {{ trans('nc::app.header.logout') }}
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <button
            type="button"
            data-nc-cart-open
            class="relative p-2 text-[#2e2224] hover:text-[#bd1765] transition-colors"
            aria-label="{{ trans('nc::app.header.cart') }}"
        >
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M6 9h12l1 11H5L6 9Z"/>
                <path d="M9 9V6a3 3 0 0 1 6 0v3"/>
            </svg>
            <span
                data-nc-cart-count
                class="absolute -top-1 -end-1 w-4 h-4 rounded-full bg-[#bd1765] text-white text-[9px] font-mono font-bold flex items-center justify-center"
            >
                {{ $cartCount }}
            </span>
        </button>

        <button
            type="button"
            data-nc-menu-toggle
            class="lg:hidden p-2 text-[#2e2224] hover:text-[#bd1765]"
            aria-label="{{ trans('nc::app.header.menu') }}"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
</header>

<div data-nc-mobile-nav class="hidden lg:hidden fixed inset-x-0 top-[122px] z-30 bg-[#fbf8f1] border-b border-[#2e2224] p-6 shadow-2xl max-h-[calc(100vh-140px)] overflow-y-auto">
    <div class="flex flex-col gap-4">
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
                <div class="space-y-1">
                    <a href="{{ $catItem['url'] }}" class="nc-nav-link text-base font-bold text-[#bd1765]">
                        {{ $catItem['label'] }}
                    </a>
                    @if (! empty($catItem['children']))
                        <div class="ps-4 flex flex-col gap-2 pt-1 border-s border-[#2e2224]/15">
                            @foreach ($catItem['children'] as $child)
                                <a href="{{ $child['url'] }}" class="text-sm font-serif text-[#2e2224] hover:text-[#bd1765]">
                                    {{ $child['label'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @endif

        <div class="pt-4 border-t border-[#2e2224]/15 space-y-3">
            <span class="block text-xs font-mono font-bold text-[#bd1765] uppercase">
                {{ trans('nc::app.header.language') }} / {{ trans('nc::app.header.currency') }}
            </span>
            <div class="flex flex-wrap gap-2">
                @foreach ($allLocales as $loc)
                    <a
                        href="{{ $buildQueryUrl(['locale' => $loc->code]) }}"
                        class="px-3 py-1 text-xs border {{ $loc->code === app()->getLocale() ? 'bg-[#2e2224] text-white border-[#2e2224]' : 'border-[#2e2224]/20' }}"
                    >
                        {{ $loc->name }}
                    </a>
                @endforeach
                @foreach ($allCurrencies as $cur)
                    <a
                        href="{{ $buildQueryUrl(['currency' => $cur->code]) }}"
                        class="px-3 py-1 text-xs font-mono border {{ $cur->code === $currentCurrencyCode ? 'bg-[#2e2224] text-white border-[#2e2224]' : 'border-[#2e2224]/20' }}"
                    >
                        {{ $cur->code }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
