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

    $visibleCategories = $categoryRepository->getVisibleCategoryTree($channel->root_category_id);

    $customLinks = data_get($headerNavSection?->options, 'links');
    if (! empty($customLinks) && is_array($customLinks)) {
        $navLinks = $customLinks;
    } else {
        $navLinks = [
            ['label' => trans('nc::app.header.shop'), 'url' => route('shop.search.index')],
            ['label' => trans('nc::app.header.concerns'), 'url' => '#concerns'],
            ['label' => trans('nc::app.header.routine'), 'url' => '#routine'],
            ['label' => trans('nc::app.header.rewards'), 'url' => '#rewards'],
        ];

        if ($visibleCategories->count()) {
            $catLinks = [];
            foreach ($visibleCategories->take(4) as $cat) {
                $catLinks[] = [
                    'label' => mb_strtoupper($cat->name),
                    'url'   => $cat->url ?: ($cat->slug ? route('shop.product_or_category.index', $cat->slug) : route('shop.search.index')),
                ];
            }
            if (! empty($catLinks)) {
                $navLinks = array_merge([['label' => trans('nc::app.header.home'), 'url' => route('shop.home.index')]], $catLinks);
            }
        }
    }
@endphp

<a href="{{ $announcementLink }}" class="nc-announcement flex items-center justify-center gap-2 px-4 text-center">
    <span>{{ $announcementText }}</span>
    <span class="inline-flex items-center gap-1 underline underline-offset-2">
        {{ $announcementBtn }}
        <svg class="w-3.5 h-3.5 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
    </span>
</a>

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

    <nav class="hidden lg:flex items-center justify-center gap-8" aria-label="Main Navigation">
        @foreach ($navLinks as $link)
            <a href="{{ $link['url'] ?? '#' }}" class="nc-nav-link">
                {{ $link['label'] ?? '' }}
            </a>
        @endforeach
    </nav>

    <div class="flex items-center justify-end gap-4">
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
                <div class="absolute end-0 top-full mt-2 w-48 bg-white border border-[#2e2224] shadow-xl p-2 hidden group-hover:block z-50">
                    <div class="px-3 py-2 border-b border-[#2e2224]/10 text-xs font-mono font-bold text-[#bd1765]">
                        {{ $customer->first_name }}
                    </div>
                    <a href="{{ route('shop.customers.account.orders.index') }}" class="block px-3 py-2 text-xs hover:bg-[#fbf8f1]">
                        {{ trans('nc::app.header.orders') }}
                    </a>
                    <a href="{{ route('shop.customers.account.profile.index') }}" class="block px-3 py-2 text-xs hover:bg-[#fbf8f1]">
                        {{ trans('nc::app.header.profile') }}
                    </a>
                    <form action="{{ route('shop.customer.session.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-start px-3 py-2 text-xs text-red-600 hover:bg-red-50">
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

<div data-nc-mobile-nav class="hidden lg:hidden fixed inset-x-0 top-[122px] z-30 bg-[#fbf8f1] border-b border-[#2e2224] p-6 shadow-2xl">
    <div class="flex flex-col gap-4">
        @foreach ($navLinks as $link)
            <a href="{{ $link['url'] ?? '#' }}" class="nc-nav-link text-base">
                {{ $link['label'] ?? '' }}
            </a>
        @endforeach
    </div>
</div>
