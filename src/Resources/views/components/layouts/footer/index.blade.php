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

    $brandDescription = data_get($footerSection?->options, 'brand_description') 
        ?: trans('nc::app.brand.tagline');
    $location = data_get($footerSection?->options, 'location') 
        ?: trans('nc::app.footer.location_default');
    $copyright = data_get($footerSection?->options, 'copyright') 
        ?: ('© ' . date('Y') . ' ' . ($channel->name ?: 'NEBULA COSMETICS') . '. ' . trans('nc::app.footer.rights'));
    $socialLinks = data_get($footerSection?->options, 'social_links') 
        ?: 'INSTAGRAM   TIKTOK   PINTEREST';
@endphp

<footer class="bg-[#fbf8f1] border-t border-[#2e2224] mt-24">
    <div class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12">
        <div class="lg:col-span-2 flex flex-col gap-4">
            <a href="{{ route('shop.home.index') }}" class="nc-brand-lockup text-[#2e2224] w-max">
                <span>{{ $channel->name ?: trans('nc::app.brand.name') }}</span>
                <span class="nc-brand-lockup__sub">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 92 82" fill="currentColor">
                        <path d="M46 72C28 52 27 28 46 3c19 25 18 49 0 69Z" opacity=".62"/>
                        <path d="M42 72C21 63 10 45 12 17c24 13 35 31 30 55Z" opacity=".82"/>
                        <path d="M50 72c21-9 32-27 30-55-24 13-35 31-30 55Z" opacity=".82"/>
                        <path d="M36 70C17 68 5 56 1 34c22 1 35 12 35 36Zm20 0c19-2 31-14 35-36-22 1-35 12-35 36Z"/>
                        <ellipse cx="46" cy="72" rx="14" ry="9"/>
                    </svg>
                    {{ trans('nc::app.brand.subtitle') }}
                </span>
            </a>
            <p class="text-sm text-[#2e2224]/80 max-w-sm leading-relaxed">
                {{ $brandDescription }}
            </p>
        </div>

        <div class="flex flex-col gap-3">
            <h4 class="font-mono text-xs font-bold tracking-widest text-[#2e2224] uppercase">
                {{ trans('nc::app.footer.help') }}
            </h4>
            <a href="#top" class="text-xs text-[#2e2224]/75 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.faq') }}</a>
            <a href="#top" class="text-xs text-[#2e2224]/75 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.contact') }}</a>
            <a href="#top" class="text-xs text-[#2e2224]/75 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.shipping') }}</a>
            <a href="#top" class="text-xs text-[#2e2224]/75 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.returns') }}</a>
        </div>

        <div class="flex flex-col gap-3">
            <h4 class="font-mono text-xs font-bold tracking-widest text-[#2e2224] uppercase">
                {{ trans('nc::app.footer.more') }}
            </h4>
            <a href="#routine" class="text-xs text-[#2e2224]/75 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.routine') }}</a>
            <a href="#rewards" class="text-xs text-[#2e2224]/75 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.rewards') }}</a>
            <a href="#top" class="text-xs text-[#2e2224]/75 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.standards') }}</a>
            <a href="#top" class="text-xs text-[#2e2224]/75 hover:text-[#bd1765] transition-colors">{{ trans('nc::app.footer.journal') }}</a>
        </div>

        <div class="flex flex-col gap-3">
            <h4 class="font-mono text-xs font-bold tracking-widest text-[#2e2224] uppercase">
                {{ trans('nc::app.footer.shop') }}
            </h4>
            @foreach ($categories as $cat)
                <a
                    href="{{ $cat->url ?: ($cat->slug ? route('shop.product_or_category.index', $cat->slug) : route('shop.search.index')) }}"
                    class="text-xs text-[#2e2224]/75 hover:text-[#bd1765] transition-colors"
                >
                    {{ $cat->name }}
                </a>
            @endforeach
            <a href="{{ route('shop.search.index') }}" class="text-xs font-bold text-[#bd1765] hover:underline">
                {{ trans('nc::app.footer.shop_all') }} →
            </a>
        </div>
    </div>

    <div class="border-t border-[#2e2224] py-6 px-6 max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 font-mono text-[11px] tracking-wider text-[#2e2224]/70">
        <div>{{ $location }}</div>
        <div>{{ $socialLinks }}</div>
        <div>{{ $copyright }}</div>
    </div>
</footer>
