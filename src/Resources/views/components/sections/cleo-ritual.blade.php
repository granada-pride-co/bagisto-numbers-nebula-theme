@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#fbf8f1';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'روتين العناية اليومي' : 'DAILY TREATMENT RITUAL');
    $title = data_get($options, 'title') ?: ($isAr ? "خطوات بسيطة لبشرة هادئة،\nنقية ومتألقة." : "Simple Steps to Calm, Clear,\nand Beautiful Skin.");
    $subtitle = data_get($options, 'subtitle') ?: ($isAr
        ? 'طقس علاجي مدروس لبناء طبقات العناية على بشرة نظيفة بالترتيب الصيدلاني الصحيح، لنتائج تدوم طوال اليوم.'
        : 'A clinical treatment ritual framed around what to layer on clean skin — ancient instinct, modern chemistry, zero guesswork.');

    $steps = data_get($options, 'steps') ?: [];
    $bundleBadge = data_get($options, 'bundle_badge');
    $bundleBtnText = data_get($options, 'bundle_btn_text') ?: ($isAr ? 'تسوق الروتين كاملاً' : 'SHOP THE COMPLETE RITUAL');
    $bundleBtnLink = data_get($options, 'bundle_btn_link') ?: '#shop';
@endphp

<section class="border-b border-[#2e2224]/15 py-16 px-6 md:px-12" id="cleo-ritual" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg);">
    <div class="max-w-7xl mx-auto">
        <div class="nc-section-header flex flex-col md:flex-row md:items-end justify-between mb-14 border-b border-[#2e2224]/15 pb-8 reveal" style="color: var(--section-color);">
            <div class="max-w-2xl">
                <p class="font-mono text-xs font-bold tracking-widest uppercase mb-3 opacity-75" style="color: var(--section-color);">
                    {{ $eyebrow }}
                </p>
                <h2 class="nc-section-title font-mono text-3xl md:text-5xl font-bold leading-tight" style="color: var(--section-color);">
                    {!! nl2br(e($title)) !!}
                </h2>
                <p class="font-mono text-xs md:text-sm mt-4 leading-relaxed opacity-80" style="color: var(--section-color);">
                    {{ $subtitle }}
                </p>
            </div>
            @if (! empty($bundleBadge))
                <div class="mt-6 md:mt-0">
                    <span class="inline-block font-mono text-xs font-bold uppercase tracking-wider px-4 py-2 border border-[#2e2224] bg-[#2e2224] text-white">
                        {{ $bundleBadge }}
                    </span>
                </div>
            @endif
        </div>

        @if (! empty($steps) && is_array($steps))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @foreach ($steps as $index => $step)
                    <div class="border border-[#2e2224]/15 bg-white p-6 flex flex-col justify-between relative group hover:border-[#bd1765] transition-colors text-[#2e2224]">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="font-mono text-2xl font-bold text-[#2e2224]">
                                    {{ $step['step_number'] ?? sprintf('%02d', $index + 1) }}
                                </span>
                                @if (! empty($step['timing']))
                                    <span class="font-mono text-[10px] uppercase tracking-wider px-2 py-0.5 border border-[#2e2224]/30 opacity-80">
                                        {{ $step['timing'] }}
                                    </span>
                                @endif
                            </div>

                            <span class="font-mono text-xs font-bold tracking-wider uppercase opacity-60 block mb-1">
                                {{ $step['step_title'] ?? '' }}
                            </span>
                            <h3 class="font-mono text-lg font-bold text-[#2e2224] mb-2">
                                {{ $step['product_name'] ?? '' }}
                            </h3>

                            @if (! empty($step['key_actives']))
                                <div class="bg-[#2e2224]/5 p-2 mb-3 border-s-2 border-[#bd1765]">
                                    <span class="font-mono text-[10px] text-[#bd1765] font-semibold block">
                                        {{ $step['key_actives'] }}
                                    </span>
                                </div>
                            @endif

                            <p class="font-mono text-xs opacity-80 leading-relaxed">
                                {{ $step['instructions'] ?? '' }}
                            </p>
                        </div>

                        @if (! empty($step['product_link']))
                            <div class="mt-6 pt-4 border-t border-[#2e2224]/15">
                                <a href="{{ $step['product_link'] }}" class="font-mono text-xs font-bold tracking-wider text-[#2e2224] hover:text-[#bd1765] inline-flex items-center gap-1 group-hover:underline">
                                    {{ $isAr ? 'استكشفي المستحضر' : 'View Formula' }} →
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <div class="text-center pt-4">
            <a href="{{ $bundleBtnLink }}" class="nc-btn nc-btn--dark inline-block">
                {{ $bundleBtnText }}
            </a>
        </div>
    </div>
</section>
