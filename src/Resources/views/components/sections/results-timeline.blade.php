@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#f7f4ea';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'الجدول الزمني للنتائج الواقعية' : '28-DAY CELLULAR TURNOVER TIMELINE');
    $title = data_get($options, 'title') ?: ($isAr ? "ماذا تتوقعين من بشرتك؟\nنتائج حقيقية، خطوة بخطوة." : "What to Expect:\nReal Skin Results, Day by Day.");
    $subtitle = data_get($options, 'subtitle') ?: ($isAr
        ? 'البشرة الحقيقية تحتاج وقتاً لتجديد خلاياها. نحن لا نعد بتغيير سحري في ليلة واحدة، بل نبني صحة مستدامة ترافقك كل صباح.'
        : 'Skin cells take roughly 28 days to turn over. We don\'t promise overnight miracles — we engineer steady, noticeable transformation.');

    $milestones = data_get($options, 'milestones') ?: [];
    $doctorNote = data_get($options, 'doctor_note') ?: ($isAr
        ? '«النتائج المستقرة تأتي من احترام الدورة الحيوية للبشرة، وليس بإجهادها بتركيزات غير محسوبة.» — د. رانيا'
        : '"Consistent actives paired with barrier support will always outperform aggressive quick fixes." — Dr. Rania');
@endphp

<section class="border-b border-[var(--section-color,#2e2224)] py-16 px-6 md:px-12" id="results-timeline" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg); color: var(--section-color); border-color: var(--section-color);">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-14 reveal">
            <p class="font-mono text-xs font-bold tracking-widest uppercase mb-3 opacity-75">
                {{ $eyebrow }}
            </p>
            <h2 class="font-mono text-3xl md:text-5xl font-bold leading-tight mb-4">
                {!! nl2br(e($title)) !!}
            </h2>
            <p class="font-mono text-xs md:text-sm leading-relaxed opacity-80">
                {{ $subtitle }}
            </p>
        </div>

        @if (! empty($milestones) && is_array($milestones))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 relative">
                @foreach ($milestones as $item)
                    <div class="border border-[var(--section-color,#2e2224)] bg-white/80 p-6 flex flex-col justify-between relative shadow-sm">
                        <div>
                            <div class="flex items-center justify-between mb-4 border-b border-[var(--section-color,#2e2224)]/20 pb-3">
                                <span class="font-mono text-xl font-bold text-[#bd1765]">
                                    {{ $item['day'] ?? '' }}
                                </span>
                                <span class="font-mono text-[10px] uppercase tracking-wider px-2 py-0.5 border border-[var(--section-color,#2e2224)]/30 bg-white/60">
                                    {{ $item['phase'] ?? '' }}
                                </span>
                            </div>

                            <p class="font-mono text-xs opacity-85 leading-relaxed mb-4">
                                {{ $item['what_happens'] ?? '' }}
                            </p>
                        </div>

                        @if (! empty($item['recommended_ritual']))
                            <div class="pt-3 border-t border-[var(--section-color,#2e2224)]/20 bg-[var(--section-color,#2e2224)]/5 -mx-6 -mb-6 p-4">
                                <span class="font-mono text-[10px] uppercase tracking-wider opacity-60 block mb-0.5">
                                    {{ $isAr ? 'الطقس الموصى به:' : 'Ritual Focus:' }}
                                </span>
                                <span class="font-mono text-xs font-bold text-[var(--section-color,#2e2224)]">
                                    {{ $item['recommended_ritual'] }}
                                </span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if (! empty($doctorNote))
            <div class="border border-[var(--section-color,#2e2224)] p-5 text-center bg-white/70 max-w-2xl mx-auto">
                <p class="font-mono text-xs italic text-[var(--section-color,#2e2224)]">
                    {{ $doctorNote }}
                </p>
            </div>
        @endif
    </div>
</section>
