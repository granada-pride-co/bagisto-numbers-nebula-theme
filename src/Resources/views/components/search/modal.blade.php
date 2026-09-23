@inject('categoryRepository', 'Webkul\Category\Repositories\CategoryRepository')

@php
    $channel = core()->getCurrentChannel();
    $categories = $categoryRepository->getVisibleCategoryTree($channel->root_category_id)->take(6);
@endphp

<div id="nc-search-layer" role="dialog" aria-modal="true" aria-label="{{ trans('nc::app.header.search') }}">
    <div class="max-w-3xl w-full mx-auto flex flex-col gap-8">
        <div class="flex items-center justify-between">
            <span class="font-mono text-xs font-bold tracking-widest text-[#bd1765] uppercase">
                {{ trans('nc::app.header.search_prompt') }}
            </span>
            <button
                type="button"
                data-nc-search-close
                class="h-9 px-4 flex items-center gap-2 border border-[#2e2224] bg-white text-[#2e2224] hover:bg-[#bd1765] hover:text-white hover:border-[#bd1765] font-mono text-xs font-bold uppercase transition-colors cursor-pointer"
                aria-label="{{ trans('nc::app.header.close') }}"
            >
                <span>{{ trans('nc::app.header.close') }}</span>
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div>
            <label for="nc-search-input" class="font-serif text-2xl md:text-3xl font-bold block mb-4">
                {{ trans('nc::app.header.search_label') }}
            </label>

            <form action="{{ route('shop.search.index') }}" method="GET" class="relative">
                <input
                    id="nc-search-input"
                    name="query"
                    type="search"
                    required
                    placeholder="{{ trans('nc::app.header.search_holder') }}"
                    class="w-full bg-transparent border-b-2 border-[#2e2224] py-4 pe-12 text-lg md:text-xl font-serif outline-none focus:border-[#bd1765] transition-colors"
                />
                <button
                    type="submit"
                    class="absolute end-0 top-1/2 -translate-y-1/2 p-2 text-[#2e2224] hover:text-[#bd1765]"
                    aria-label="{{ trans('nc::app.header.search') }}"
                >
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"/>
                        <path d="m20 20-3.5-3.5"/>
                    </svg>
                </button>
            </form>
        </div>

        @if ($categories->isNotEmpty())
            <div class="flex flex-col gap-3">
                <span class="font-mono text-xs text-[#2e2224]/60 uppercase">
                    {{ trans('nc::app.footer.shop') }}
                </span>
                <div class="flex flex-wrap gap-2">
                    @foreach ($categories as $cat)
                        <a
                            href="{{ $cat->url ?: ($cat->slug ? route('shop.product_or_category.index', $cat->slug) : route('shop.search.index', ['query' => $cat->name])) }}"
                            class="px-3 py-1.5 border border-[#2e2224]/30 text-xs font-mono hover:border-[#bd1765] hover:text-[#bd1765] transition-colors"
                        >
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
