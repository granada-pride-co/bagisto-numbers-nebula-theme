@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#f4789c';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';

    $image = \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::url(
        data_get($options, 'image'),
        asset('themes/shop/nebula-cosmetics/images/cleo-concern-application.jpg')
    );

    $eyebrow = data_get($options, 'eyebrow') ?: trans('nc::app.sections.rewards.default_eyebrow');
    $title = data_get($options, 'title') ?: trans('nc::app.sections.rewards.default_title');
    $description = data_get($options, 'description') ?: trans('nc::app.sections.rewards.default_description');
    $linkText = data_get($options, 'link_text') ?: trans('nc::app.sections.rewards.default_link_text');
    $linkUrl = data_get($options, 'link_url') ?: '#newsletter';
@endphp

<section class="border-b border-[#2e2224]" id="rewards" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="background-color: {{ $bgColor }}; color: {{ $textColor }};">
    <div class="grid grid-cols-1 lg:grid-cols-2">
        {{-- Promo Image (Left Column) --}}
        <div class="border-b lg:border-b-0 lg:border-e border-[#2e2224] overflow-hidden min-h-[450px]">
            <img
                src="{{ $image }}"
                alt="{{ $title }}"
                class="w-full h-full object-cover"
            />
        </div>

        {{-- Text Content Box (Right Column) --}}
        <div class="p-8 md:p-16 flex flex-col justify-center reveal {{ $isAr ? 'text-right' : 'text-left' }}" style="background-color: {{ $bgColor }}; color: {{ $textColor }};">
            <p class="font-mono text-xs font-bold tracking-widest uppercase mb-4 opacity-80" style="color: {{ $textColor }};">
                {{ $eyebrow }}
            </p>
            <h2 class="font-mono text-3xl md:text-5xl font-bold leading-tight mb-6" style="color: {{ $textColor }};">
                {!! nl2br(e($title)) !!}
            </h2>
            <p class="font-mono text-xs md:text-sm leading-relaxed max-w-md mb-8 opacity-85" style="color: {{ $textColor }};">
                {{ $description }}
            </p>
            <div>
                <a
                    href="{{ $linkUrl }}"
                    class="inline-flex items-center gap-2 font-mono text-xs font-bold tracking-wider hover:underline uppercase" style="color: {{ $textColor }};"
                >
                    {{ $linkText }}
                    <svg class="w-4 h-4 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
