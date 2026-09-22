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

<section class="border-b border-t border-[#2e2224] bg-[#f7b7ba] overflow-hidden" id="concerns">
    {{-- Header Banner --}}
    <div class="py-4 px-6 border-b border-[#2e2224] text-center bg-[#f7b7ba]">
        <h2 class="font-mono text-xs font-bold tracking-widest text-[#2e2224] uppercase">
            {{ $kicker }}
        </h2>
    </div>

    {{-- 5 Columns Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 divide-y sm:divide-y-0 lg:divide-x rtl:lg:divide-x-reverse divide-[#2e2224] bg-[#f7b7ba]">
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
            <article class="flex flex-col justify-between bg-[#f7b7ba] group">
                {{-- Card Image --}}
                <div class="aspect-square overflow-hidden border-b border-[#2e2224] bg-[#ebd8c8]">
                    <img
                        src="{{ $img }}"
                        alt="{{ $title }}"
                        loading="lazy"
                        class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                    />
                </div>

                {{-- Card Details --}}
                <div class="p-6 flex flex-col items-center justify-between text-center flex-1 gap-4 bg-[#f7b7ba]">
                    <div class="space-y-2">
                        <h3 class="font-mono font-bold text-sm sm:text-base text-[#2e2224] tracking-wide">
                            <a href="{{ $link }}" class="hover:underline">
                                {{ $title }}
                            </a>
                        </h3>
                        <p class="font-mono text-[11px] text-[#2e2224]/85 leading-relaxed max-w-[220px] mx-auto">
                            {{ $copy }}
                        </p>
                    </div>

                    <a
                        href="{{ $link }}"
                        class="inline-block bg-white text-[#2e2224] border border-[#2e2224] font-mono text-[11px] font-bold tracking-widest uppercase px-5 py-2 transition-all hover:bg-[#2e2224] hover:text-white"
                    >
                        {{ $btnText }}
                    </a>
                </div>
            </article>
        @endforeach
    </div>
</section>
