@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#ffffff';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'الشفافية الصيدلانية المطلقة' : 'ACTIVE INGREDIENTS TRANSPARENCY INDEX');
    $title = data_get($options, 'title') ?: ($isAr ? "دليل المواد الفعالة:\nالنسب والوظائف، بدون غموض." : "Actives Transparency Index:\nConcentrations, Functions, No Guesswork.");
    $subtitle = data_get($options, 'subtitle') ?: ($isAr
        ? 'نختار كل مادة بناءً على ما تؤديه فعلياً لبشرتك وليس على تكلفة استبعادها. خالية تماماً من البارابين، السلفات، والصبغات، ومسجلة في نظام Health Canada.'
        : 'Every active is dosed and chosen the way a pharmaceutical scientist would — zero sulfates, zero parabens, zero synthetic dyes across the entire line.');

    $actives = data_get($options, 'actives') ?: [];
@endphp

<section class="border-b border-[#2e2224]/15 py-16 px-6 md:px-12" id="actives-index" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg);">
    <div class="max-w-7xl mx-auto">
        <div class="nc-section-header text-center max-w-3xl mx-auto mb-14 reveal" style="color: var(--section-color);">
            <p class="font-mono text-xs font-bold tracking-widest uppercase mb-3 opacity-75" style="color: var(--section-color);">
                {{ $eyebrow }}
            </p>
            <h2 class="nc-section-title font-mono text-3xl md:text-5xl font-bold leading-tight mb-4" style="color: var(--section-color);">
                {!! nl2br(e($title)) !!}
            </h2>
            <p class="font-mono text-xs md:text-sm leading-relaxed opacity-80" style="color: var(--section-color);">
                {{ $subtitle }}
            </p>
        </div>

        @if (! empty($actives) && is_array($actives))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($actives as $item)
                    <div class="border border-[#2e2224]/15 p-6 bg-white/90 flex flex-col justify-between hover:border-[#bd1765] transition-colors text-[#2e2224]">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-mono text-base font-bold text-[#2e2224]">
                                    {{ $item['name'] ?? '' }}
                                </h3>
                                @if (! empty($item['percentage']))
                                    <span class="font-mono text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 border border-[#2e2224] bg-[#2e2224] text-white">
                                        {{ $item['percentage'] }}
                                    </span>
                                @endif
                            </div>

                            @if (! empty($item['ancient_counterpart']))
                                <p class="font-mono text-xs text-[#bd1765] font-semibold mb-3">
                                    {{ $isAr ? 'المصدر التقليدي:' : 'Ancient Root:' }} {{ $item['ancient_counterpart'] }}
                                </p>
                            @endif

                            <p class="font-mono text-xs opacity-85 leading-relaxed mb-4">
                                {{ $item['clinical_function'] ?? '' }}
                            </p>
                        </div>

                        @if (! empty($item['clean_promise']))
                            <div class="pt-3 border-t border-[var(--section-color,#2e2224)]/20 flex items-center gap-1.5 text-[#1e5631]">
                                <span class="text-xs">✓</span>
                                <span class="font-mono text-[10px] uppercase tracking-wider font-semibold">
                                    {{ $item['clean_promise'] }}
                                </span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
