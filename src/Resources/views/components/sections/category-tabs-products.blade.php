@props(['options' => []])

@inject('productRepository', 'Webkul\Product\Repositories\ProductRepository')
@inject('categoryRepository', 'Webkul\Category\Repositories\CategoryRepository')

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#ffffff';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'تركيبات موجهة حسب الاحتياج' : 'TARGETED BY CATEGORY');
    $title = data_get($options, 'title') ?: ($isAr ? "تسوقي التركيبات الصيدلانية\nحسب نوع العناية." : "Shop Pharmaceutical Formulas\nby Treatment Category.");
    $description = data_get($options, 'description') ?: ($isAr
        ? 'كل فئة علاجية صُممت بتركيزات مدروسة ومكونات نشطة معتمدة من Health Canada لدعم حاجز بشرتك واستعادة توازنها.'
        : 'Every collection is formulated with measured clinical actives and small-batch craftsmanship in Vancouver, BC.');

    $badgeText = data_get($options, 'badge_text') ?: ($isAr ? 'تركيبة معملية' : 'LAB FORMULA');
    $showAllTab = (string) data_get($options, 'show_all_tab', '1') !== '0';

    $limit = (int) (data_get($options, 'filters.limit') ?: 8);
    $sort = data_get($options, 'filters.sort') ?: 'created_at-desc';
    $isFeatured = (string) data_get($options, 'filters.featured', '0') === '1';
    $isNew = (string) data_get($options, 'filters.new', '0') === '1';

    $categoryIdsRaw = data_get($options, 'filters.category_ids');
    $configuredCategoryIds = [];
    if (! empty($categoryIdsRaw)) {
        if (is_array($categoryIdsRaw)) {
            $configuredCategoryIds = array_filter(array_map('intval', $categoryIdsRaw));
        } elseif (is_string($categoryIdsRaw)) {
            $configuredCategoryIds = array_filter(array_map('intval', explode(',', $categoryIdsRaw)));
        }
    }

    $channel = core()->getCurrentChannel();

    if (! empty($configuredCategoryIds)) {
        $categories = $categoryRepository->scopeQuery(function ($query) use ($configuredCategoryIds) {
            return $query->whereIn('categories.id', $configuredCategoryIds)->where('status', 1);
        })->all();
    } else {
        $rootCategory = $channel->root_category;
        $candidateCategories = $rootCategory ? $rootCategory->children()->where('status', 1)->get() : collect();

        $leafCategories = collect();
        foreach ($candidateCategories as $candidate) {
            $children = $candidate->children()->where('status', 1)->get();
            if ($children->isNotEmpty()) {
                $leafCategories = $leafCategories->concat($children);
            } else {
                $leafCategories->push($candidate);
            }
        }

        $categories = $leafCategories->isNotEmpty() ? $leafCategories : $candidateCategories;
    }

    $tabsData = [];

    $baseParams = [
        'limit' => $limit,
        'sort' => $sort,
    ];

    if ($isFeatured) {
        $baseParams['featured'] = 1;
    }

    if ($isNew) {
        $baseParams['new'] = 1;
    }

    if ($showAllTab) {
        $allProducts = $productRepository->getAll($baseParams);
        $tabsData['all'] = [
            'id' => 'all',
            'name' => $isAr ? 'جميع التركيبات' : 'All Formulas',
            'products' => $allProducts,
            'count' => $allProducts->count(),
            'url' => route('shop.search.index'),
        ];
    }

    foreach ($categories as $category) {
        $descendantIds = $category->descendants()->where('status', 1)->pluck('id')->prepend($category->id)->toArray();
        $catParams = array_merge($baseParams, [
            'category_id' => implode(',', $descendantIds),
        ]);

        $catProducts = $productRepository->getAll($catParams);

        if ($catProducts->isNotEmpty() || ! empty($configuredCategoryIds)) {
            $tabsData['cat_' . $category->id] = [
                'id' => 'cat_' . $category->id,
                'name' => $category->name,
                'products' => $catProducts,
                'count' => $catProducts->count(),
                'url' => $category->url_key ? route('shop.product_or_category.index', $category->url_key) : '#',
            ];
        }
    }

    $activeTabId = ! empty($tabsData) ? array_key_first($tabsData) : null;
    $btnText = data_get($options, 'btn_text') ?: ($isAr ? 'استكشفي جميع المستحضرات' : 'VIEW ALL FORMULAS');
    $btnLink = data_get($options, 'btn_link') ?: route('shop.search.index');
    $uniqueSectionId = 'cat-tabs-' . uniqid();
@endphp

<section class="border-b border-[var(--section-color,#2e2224)] py-16 px-4 md:px-8" id="{{ $uniqueSectionId }}" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg); color: var(--section-color); border-color: var(--section-color);">
    <div class="max-w-7xl mx-auto">
        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-10 reveal">
            <p class="font-mono text-xs font-bold tracking-widest text-[#bd1765] uppercase mb-2">
                {{ $eyebrow }}
            </p>
            <h2 class="font-mono text-2xl sm:text-3xl md:text-4xl font-bold leading-tight mb-3">
                {!! nl2br(e($title)) !!}
            </h2>
            <p class="font-mono text-xs md:text-sm opacity-80 leading-relaxed">
                {{ $description }}
            </p>
        </div>

        @if (! empty($tabsData))
            <v-category-tabs
                default-tab="{{ $activeTabId }}"
            >
                @foreach ($tabsData as $tabKey => $tab)
                    <v-category-tab-item
                        tab-id="{{ $tabKey }}"
                        title="{{ $tab['name'] }}"
                        :count="{{ (int) $tab['count'] }}"
                        :is-selected="{{ $tabKey === $activeTabId ? 'true' : 'false' }}"
                    >
                        <template v-slot>
                            @if ($tab['products']->isNotEmpty())
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 mb-10">
                                    @foreach ($tab['products'] as $product)
                                        <div class="h-full flex flex-col">
                                            <x-nc::products.card :product="$product" :badge="$badgeText" />
                                        </div>
                                    @endforeach
                                </div>

                                @if (! empty($tab['url']) && $tab['id'] !== 'all')
                                    <div class="text-center pt-2">
                                        <a href="{{ $tab['url'] }}" class="font-mono text-xs font-bold tracking-wider uppercase text-[#bd1765] hover:underline inline-flex items-center gap-1.5">
                                            {{ $isAr ? 'عرض تشكيلة ' . $tab['name'] . ' بالكامل' : 'Explore all ' . $tab['name'] }}
                                            <span class="rtl:rotate-180">→</span>
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="border border-dashed border-[#2e2224]/30 bg-[#fbf8f1] p-12 text-center my-6">
                                    <p class="font-mono text-sm text-[#2e2224]/70 mb-2">
                                        {{ $isAr ? 'لا توجد منتجات متوفرة حالياً في هذا التصنيف.' : 'No formulas currently available in this collection.' }}
                                    </p>
                                    <a href="{{ route('shop.search.index') }}" class="font-mono text-xs font-bold text-[#bd1765] hover:underline uppercase tracking-wider">
                                        {{ $isAr ? 'تصفحي جميع المنتجات' : 'Browse All Formulas' }} →
                                    </a>
                                </div>
                            @endif
                        </template>
                    </v-category-tab-item>
                @endforeach
            </v-category-tabs>
        @endif

        @if (! empty($btnText))
            <div class="text-center pt-8 border-t border-[#2e2224]/10 mt-10">
                <a href="{{ $btnLink }}" class="nc-btn nc-btn--dark inline-block">
                    {{ $btnText }}
                </a>
            </div>
        @endif
    </div>
</section>

@pushOnce('scripts')
    <script type="text/x-template" id="v-category-tabs-template">
        <div>
            <div class="flex items-center justify-start md:justify-center overflow-x-auto scrollbar-none pb-4 mb-10 gap-2 border-b border-[#2e2224]/15" role="tablist">
                <button
                    type="button"
                    role="tab"
                    v-for="tab in tabs"
                    :key="tab.tabId"
                    :aria-selected="tab.isActive ? 'true' : 'false'"
                    class="nc-cat-tab-btn font-mono text-xs font-bold tracking-wider uppercase px-4 py-2.5 transition-all shrink-0 border border-[#2e2224] flex items-center gap-2 cursor-pointer"
                    :class="tab.isActive ? 'bg-[#2e2224] text-white shadow-sm' : 'bg-white/80 text-[#2e2224] hover:bg-[#2e2224]/5'"
                    @click="changeTab(tab)"
                >
                    <span>@{{ tab.title }}</span>
                    <span
                        v-if="tab.count > 0"
                        class="inline-flex items-center justify-center text-[10px] px-1.5 py-0.5 rounded-full"
                        :class="tab.isActive ? 'bg-white/20 text-white' : 'bg-[#2e2224]/10 text-[#2e2224]'"
                    >
                        @{{ tab.count }}
                    </span>
                </button>
            </div>

            <div class="nc-cat-tab-panels">
                <slot></slot>
            </div>
        </div>
    </script>

    <script type="text/x-template" id="v-category-tab-item-template">
        <div
            v-show="isActive"
            class="nc-cat-tab-panel transition-opacity duration-300"
            role="tabpanel"
            tabindex="0"
        >
            <slot></slot>
        </div>
    </script>

    <script type="module">
        app.component('v-category-tabs', {
            template: '#v-category-tabs-template',

            props: {
                defaultTab: {
                    type: String,
                    default: 'all',
                },
            },

            data() {
                return {
                    tabs: [],
                };
            },

            methods: {
                changeTab(selectedTab) {
                    this.tabs.forEach(tab => {
                        tab.isActive = (tab.tabId === selectedTab.tabId);
                    });
                },
            },
        });

        app.component('v-category-tab-item', {
            template: '#v-category-tab-item-template',

            props: {
                tabId: {
                    type: String,
                    required: true,
                },
                title: {
                    type: String,
                    required: true,
                },
                count: {
                    type: Number,
                    default: 0,
                },
                isSelected: {
                    type: Boolean,
                    default: false,
                },
            },

            data() {
                return {
                    isActive: false,
                };
            },

            mounted() {
                this.isActive = this.isSelected || (this.$parent && this.$parent.defaultTab === this.tabId);

                if (this.$parent && this.$parent.tabs) {
                    this.$parent.tabs.push(this);
                }
            },
        });
    </script>
@endPushOnce
