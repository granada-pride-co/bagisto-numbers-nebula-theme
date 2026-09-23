@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#2e2224';
    $textColor = data_get($options, 'text_color') ?: '#fbf8f1';
    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'الجدول الليلي الصيدلاني' : 'PHARMACEUTICAL NIGHT CYCLING');
    $title = data_get($options, 'title') ?: ($isAr ? "دورة التجديد الليلي:\nدعي بشرتك تستفيد حقاً." : "Night Skin Cycling:\nLet Skin Actually Use What You Put on It.");
    $subtitle = data_get($options, 'subtitle') ?: ($isAr
        ? 'السر في الفاعلية ليس كثرة الطبقات بل التوقيت الذكي. التناوب بين الباكوتشيول وأحماض التقشير يمنحك تجديداً مبهراً بدون إرهاق حاجز البشرة.'
        : 'True efficacy comes from strategic timing, not overloading. Alternating actives allows skin barrier recovery while maximizing cellular renewal.');

    $warningNote = data_get($options, 'warning_note') ?: ($isAr
        ? 'تنبيه صيدلاني: تجنبي استخدام Moonlight Serum ومقشر 5% AHA معاً في نفس الليلة. التناوب يحمي حاجز البشرة ويضمن الفاعلية القصوى.'
        : 'Clinical Rule: Do not run Moonlight Serum and the 5% AHA Exfoliant on the same night. Alternate to let your skin barrier breathe.');

    $scheduleItems = data_get($options, 'schedule_items') ?: [];
    $btnText = data_get($options, 'btn_text');
    $btnLink = data_get($options, 'btn_link') ?: '#shop';
@endphp

<section class="border-b border-white/20 py-16 px-6 md:px-12" id="night-cycling" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg);">
    <div class="max-w-7xl mx-auto">
        <div class="nc-section-header text-center max-w-3xl mx-auto mb-12 reveal" style="color: var(--section-color);">
            <p class="font-mono text-xs font-bold tracking-widest uppercase mb-3 opacity-60" style="color: var(--section-color);">
                {{ $eyebrow }}
            </p>
            <h2 class="nc-section-title font-mono text-3xl md:text-5xl font-bold leading-tight mb-4" style="color: var(--section-color);">
                {!! nl2br(e($title)) !!}
            </h2>
            <p class="font-mono text-xs md:text-sm leading-relaxed mb-6 opacity-80" style="color: var(--section-color);">
                {{ $subtitle }}
            </p>

            @if (! empty($warningNote))
                <div class="inline-block bg-[#bd1765]/20 border border-[#bd1765]/50 px-4 py-3 text-start max-w-xl">
                    <p class="font-mono text-xs opacity-90 flex items-start gap-2">
                        <span class="text-base shrink-0">⚠️</span>
                        <span>{{ $warningNote }}</span>
                    </p>
                </div>
            @endif
        </div>

        @if (! empty($scheduleItems) && is_array($scheduleItems))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                @foreach ($scheduleItems as $item)
                    <div class="border border-[var(--section-color,rgba(255,255,255,0.2))]/20 bg-[var(--section-color,rgba(255,255,255,0.1))]/5 p-6 backdrop-blur-sm flex flex-col justify-between hover:border-[var(--section-color,rgba(255,255,255,0.5))] transition-colors">
                        <div>
                            <div class="flex items-center justify-between mb-4 border-b border-[var(--section-color,rgba(255,255,255,0.2))]/10 pb-3">
                                <span class="font-mono text-xs font-bold tracking-wider uppercase opacity-60">
                                    {{ $item['days'] ?? '' }}
                                </span>
                                @if (! empty($item['action_type']))
                                    <span class="font-mono text-[10px] uppercase tracking-wider px-2 py-0.5 border border-[var(--section-color,#ffffff)]/20 bg-[var(--section-color,#ffffff)]/10 text-current">
                                        {{ $item['action_type'] }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="font-mono text-lg font-bold mb-1">
                                {{ $item['treatment_name'] ?? '' }}
                            </h3>
                            <h4 class="font-mono text-xs opacity-70 font-semibold mb-3">
                                {{ $item['product_name'] ?? '' }}
                            </h4>

                            <p class="font-mono text-xs opacity-80 leading-relaxed">
                                {{ $item['instructions'] ?? '' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if (! empty($btnText))
            <div class="text-center">
                <a href="{{ $btnLink }}" class="nc-btn inline-block font-mono text-xs font-bold tracking-wider uppercase py-3 px-8 border" style="background-color: var(--section-color); color: var(--section-bg); border-color: var(--section-color);">
                    {{ $btnText }}
                </a>
            </div>
        @endif
    </div>
</section>
