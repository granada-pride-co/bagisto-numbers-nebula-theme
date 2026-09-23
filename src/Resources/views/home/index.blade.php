@php
    $channel = core()->getCurrentChannel();
    $isAr = app()->getLocale() === 'ar';
    $defaultTitle = $isAr ? 'سديم كوزمتكس | عناية عصرية بالبشرة' : 'Nebula Cosmetics | Modern High-Performance Skincare';
    $defaultDesc = $isAr ? 'عناية عصرية بالبشرة. تركيبات عالية الأداء مدعومة بالعلوم ومصنوعة بأرقى المكونات.' : 'High-performance skincare formulas rooted in real science and natural botanicals.';
    $defaultKeywords = $isAr ? 'كوزمتكس, عناية بالبشرة, سيروم, ترطيب, مقشر' : 'cosmetics, skincare, serum, moisturizer, glow';
    $defaultSiteName = $channel->name ?: ($isAr ? 'سديم كوزمتكس' : 'Nebula Cosmetics');
@endphp

@push ('meta')
    <meta name="title" content="{{ $channel->home_seo['meta_title'] ?? $defaultTitle }}" />
    <meta name="description" content="{{ $channel->home_seo['meta_description'] ?? $defaultDesc }}" />
    <meta name="keywords" content="{{ $channel->home_seo['meta_keywords'] ?? $defaultKeywords }}" />
@endPush

<x-nc::layouts :title="$channel->home_seo['meta_title'] ?? $defaultSiteName">
    @if (! empty($sections) && $sections->count())
        @foreach ($sections as $section)
            @php
                $data = (array) $section->options;
                $marks = ($preview ?? false) && ! $section->getTypeInstance()?->rendersInLayout();
            @endphp

            @if ($marks)
                <div
                    data-section-id="{{ $section->id }}"
                    data-section-name="{{ $section->name }}"
                >
            @endif

            @switch ($section->type)
                @case ('nc_hero')
                    <x-nc::sections.hero :options="$data" />
                    @break

                @case ('nc_manifesto')
                    <x-nc::sections.manifesto :options="$data" />
                    @break

                @case ('nc_concerns')
                    <x-nc::sections.concerns :options="$data" />
                    @break

                @case ('nc_campaign')
                    <x-nc::sections.campaign :options="$data" />
                    @break

                @case ('nc_featured_products')
                    <x-nc::sections.featured-products :options="$data" />
                    @break

                @case ('nc_routine')
                    <x-nc::sections.routine :options="$data" />
                    @break

                @case ('nc_collections')
                    <x-nc::sections.collections :options="$data" />
                    @break

                @case ('nc_rewards')
                    <x-nc::sections.rewards :options="$data" />
                    @break

                @case ('nc_social_line')
                    <x-nc::sections.social-line :options="$data" />
                    @break

                @case ('nc_service_strip')
                    <x-nc::sections.service-strip :options="$data" />
                    @break

                @case ('nc_newsletter')
                    <x-nc::sections.newsletter :options="$data" />
                    @break

                @case ('nc_html')
                    <x-nc::sections.html :options="$data" />
                    @break

                @case (\Webkul\Theme\Enums\SectionTypeEnum::STATIC_CONTENT->value)
                    @if (! empty($data['css']))
                        @push ('styles')
                            <style>{!! $data['css'] !!}</style>
                        @endpush
                    @endif

                    @if (! empty($data['html']))
                        <div class="nc-custom-static-content max-w-7xl mx-auto px-6 py-8">
                            {!! $data['html'] !!}
                        </div>
                    @endif
                    @break

                @case (\Webkul\Theme\Enums\SectionTypeEnum::IMAGE_CAROUSEL->value)
                    <x-shop::carousel
                        :options="$section->getTypeInstance()?->sanitize((array) $data) ?? $data"
                        aria-label="{{ trans('shop::app.home.index.image-carousel') }}"
                    />
                    @break

                @case (\Webkul\Theme\Enums\SectionTypeEnum::CATEGORY_CAROUSEL->value)
                    <x-shop::categories.carousel
                        :title="$data['title'] ?? ''"
                        :src="route('shop.api.categories.index', $data['filters'] ?? [])"
                        :navigation-link="route('shop.home.index')"
                    />
                    @break

                @case (\Webkul\Theme\Enums\SectionTypeEnum::PRODUCT_CAROUSEL->value)
                    <x-shop::products.carousel
                        :title="$data['title'] ?? ''"
                        :src="route('shop.api.products.index', $data['filters'] ?? [])"
                        :navigation-link="route('shop.search.index', $data['filters'] ?? [])"
                    />
                    @break
            @endswitch

            @if ($marks)
                </div>
            @endif
        @endforeach
    @else
        <x-nc::sections.hero />
        <x-nc::sections.manifesto />
        <x-nc::sections.concerns />
        <x-nc::sections.campaign />
        <x-nc::sections.featured-products />
        <x-nc::sections.routine />
        <x-nc::sections.collections />
        <x-nc::sections.rewards />
        <x-nc::sections.social-line />
        <x-nc::sections.service-strip />
        <x-nc::sections.newsletter />
    @endif
</x-nc::layouts>
