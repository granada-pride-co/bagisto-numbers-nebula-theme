@props(['options' => []])

@inject('productRepository', 'Webkul\Product\Repositories\ProductRepository')
@inject('categoryRepository', 'Webkul\Category\Repositories\CategoryRepository')

@php
    $isAr = app()->getLocale() === 'ar';

    $productId = data_get($options, 'product_id');
    $product = $productId ? $productRepository->find($productId) : null;

    $categoryId = data_get($options, 'category_id');
    $category = $categoryId ? $categoryRepository->find($categoryId) : null;

    $entityName = $product?->name ?: $category?->name;
    $entityDesc = $product?->short_description ? strip_tags($product->short_description) : ($category?->description ? strip_tags($category->description) : null);
    $entityUrl = $product?->url_key ? route('shop.product_or_category.index', $product->url_key) : ($category?->slug ? route('shop.product_or_category.index', $category->slug) : null);
    $entityImg = $product?->base_image_url ?: \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::categoryImage($category);

    $bgImageRaw = data_get($options, 'bg_image');
    if ($bgImageRaw) {
        $bgImage = \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::url(
            $bgImageRaw,
            asset('themes/shop/nebula-cosmetics/images/cleo-ritual-wide.jpg')
        );
    } elseif ($entityImg) {
        $bgImage = $entityImg;
    } else {
        $bgImage = asset('themes/shop/nebula-cosmetics/images/cleo-ritual-wide.jpg');
    }

    $eyebrow = data_get($options, 'eyebrow') ?: trans('nc::app.sections.campaign.default_eyebrow');
    $title = data_get($options, 'title') ?: ($entityName ?: trans('nc::app.sections.campaign.default_title'));
    $description = data_get($options, 'description') ?: ($entityDesc ?: trans('nc::app.sections.campaign.default_desc'));
    $btnText = data_get($options, 'btn_text') ?: trans('nc::app.sections.campaign.default_btn_text');
    $btnLink = data_get($options, 'btn_link') ?: ($entityUrl ?: '#routine');
    $bgColor = data_get($options, 'bg_color');
    $textColor = data_get($options, 'text_color') ?: '#ffffff';
@endphp

<section class="relative min-h-[480px] md:min-h-[580px] flex items-end justify-center border-b border-[#2e2224] overflow-hidden" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="{{ $bgColor ? 'background-color: ' . $bgColor . ';' : '' }} color: {{ $textColor }};">
    <img
        src="{{ $bgImage }}"
        alt="{{ $title }}"
        class="absolute inset-0 w-full h-full object-cover object-center"
    />
    <div class="absolute inset-0 bg-gradient-to-t from-[#2e2224]/85 via-[#2e2224]/40 to-transparent"></div>

    <div class="relative z-10 max-w-2xl mx-auto px-6 text-center text-white pb-12 pt-16 reveal">
        <p class="font-mono text-xs font-bold tracking-widest uppercase mb-3 opacity-90" style="color: {{ $textColor }};">
            {{ $eyebrow }}
        </p>
        <h2 class="font-serif text-3xl md:text-5xl font-bold mb-4 leading-tight">
            {{ $title }}
        </h2>
        <p class="text-sm md:text-base text-white/85 mb-8 leading-relaxed">
            {{ $description }}
        </p>
        <a href="{{ $btnLink }}" class="nc-btn nc-btn--light">
            {{ $btnText }}
        </a>
    </div>
</section>
