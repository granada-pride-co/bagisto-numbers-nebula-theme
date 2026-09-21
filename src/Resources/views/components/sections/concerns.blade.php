@props(['options' => []])

@inject('categoryRepository', 'Webkul\Category\Repositories\CategoryRepository')

@php
    $isAr = app()->getLocale() === 'ar';
    $kicker = data_get($options, 'kicker') ?: ($isAr ? 'تسوقي حسب احتياج البشرة' : 'SHOP BY SKIN CONCERN');

    $defaultItems = [
        [
            'name'     => $isAr ? 'المسام والملمس' : 'Texture + Pores',
            'copy'     => $isAr ? 'لتجديد خلايا البشرة وتنعيم ملمسها وتنقية المسام طوال الليل.' : 'For rough texture, visible pores and overnight renewal.',
            'image'    => asset('themes/shop/nebula-cosmetics/images/cleo-hero-skin.jpg'),
            'btn_text' => $isAr ? 'تسوقي الآن' : 'SHOP NOW',
            'btn_link' => '#shop',
        ],
        [
            'name'     => $isAr ? 'ترميم حاجز البشرة' : 'Barrier Repair',
            'copy'     => $isAr ? 'للبشرة الجافة والحساسة التي تحتاج إلى حماية فائقة وترطيب عميق.' : 'For dry, reactive skin that needs comfort and strength.',
            'image'    => asset('themes/shop/nebula-cosmetics/images/cleo-concern-portrait.jpg'),
            'btn_text' => $isAr ? 'تسوقي الآن' : 'SHOP NOW',
            'btn_link' => '#shop',
        ],
        [
            'name'     => $isAr ? 'نضارة وتوحيد اللون' : 'Bright + Even',
            'copy'     => $isAr ? 'للتخلص من البهتان والتصبغات وإضفاء إشراقة حيوية متجددة.' : 'For dullness, uneven tone and a more rested look.',
            'image'    => asset('themes/shop/nebula-cosmetics/images/cleo-concern-application.jpg'),
            'btn_text' => $isAr ? 'تسوقي الآن' : 'SHOP NOW',
            'btn_link' => '#shop',
        ],
        [
            'name'     => $isAr ? 'شد ومرونة البشرة' : 'Firm + Restore',
            'copy'     => $isAr ? 'لاستعادة حيوية وامتلاء البشرة ومحاربة علامات الإجهاد والتقدم في السن.' : 'For skin marked by change, dryness and loss of bounce.',
            'image'    => asset('themes/shop/nebula-cosmetics/images/cleo-concern-texture.jpg'),
            'btn_text' => $isAr ? 'تسوقي الآن' : 'SHOP NOW',
            'btn_link' => '#shop',
        ],
        [
            'name'     => $isAr ? 'تهدئة وراحة' : 'Calm + Comfort',
            'copy'     => $isAr ? 'تركيبات فائقة اللطف لتهدئة تهيج البشرة ومنحها شعوراً فورياً بالارتياح.' : 'For easily stressed skin that wants a gentler routine.',
            'image'    => asset('themes/shop/nebula-cosmetics/images/cleo-hero-product.jpg'),
            'btn_text' => $isAr ? 'تسوقي الآن' : 'SHOP NOW',
            'btn_link' => '#shop',
        ],
    ];

    $rawItems = data_get($options, 'items');
    $items = ! empty($rawItems) && is_array($rawItems) ? $rawItems : $defaultItems;
@endphp

<section class="border-b border-[#2e2224] bg-[#fbf8f1] py-16 px-6" id="concerns">
    <div class="max-w-7xl mx-auto">
        <div class="font-mono text-xs font-bold tracking-widest text-[#2e2224] uppercase border-b border-[#2e2224] pb-4 mb-8">
            {{ $kicker }}
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            @foreach ($items as $index => $item)
                @php
                    $categoryId = data_get($item, 'category_id');
                    $category = $categoryId ? $categoryRepository->find($categoryId) : null;

                    $catName = $category?->name;
                    $catDesc = $category?->description ? strip_tags($category->description) : null;
                    $catImage = $category?->logo_url ?: $category?->banner_url;
                    $catUrl = $category?->slug ? route('shop.product_or_category.index', $category->slug) : null;

                    $default = $defaultItems[$index % count($defaultItems)];

                    $title = data_get($item, 'name') ?: ($catName ?: $default['name']);
                    $copy = data_get($item, 'copy') ?: ($catDesc ?: $default['copy']);
                    $link = data_get($item, 'btn_link') ?: ($catUrl ?: $default['btn_link']);
                    $btnText = data_get($item, 'btn_text') ?: ($isAr ? 'تسوقي الآن' : 'SHOP NOW');

                    $customImage = data_get($item, 'image');
                    if ($customImage) {
                        $img = \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::url($customImage, $default['image']);
                    } elseif ($catImage) {
                        $img = $catImage;
                    } else {
                        $img = $default['image'];
                    }
                @endphp
                <article class="reveal flex flex-col justify-between border border-[#2e2224] bg-white transition-transform hover:-translate-y-1">
                    <div class="aspect-[4/5] overflow-hidden border-b border-[#2e2224] bg-[#fbf8f1]">
                        <img
                            src="{{ $img }}"
                            alt="{{ $title }}"
                            class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                        />
                    </div>
                    <div class="p-5 flex flex-col justify-between flex-1 gap-4">
                        <div>
                            <h3 class="font-serif font-bold text-lg text-[#2e2224] mb-2">
                                <a href="{{ $link }}" class="hover:text-[#bd1765] transition-colors">
                                    {{ $title }}
                                </a>
                            </h3>
                            <p class="text-xs text-[#2e2224]/75 leading-relaxed line-clamp-3">
                                {{ $copy }}
                            </p>
                        </div>
                        <a
                            href="{{ $link }}"
                            class="nc-btn nc-btn--light text-center py-2.5 text-[11px]"
                        >
                            {{ $btnText }}
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
