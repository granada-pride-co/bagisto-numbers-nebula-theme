@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#ffffff';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'حقائق علمية ومفاهيم خاطئة' : 'BEAUTY MYTHS VS. PHARMACEUTICAL TRUTH');
    $title = data_get($options, 'title') ?: ($isAr ? "دحض خرافات الجمال:\nالعلم وراء ما تضعينه على بشرتك." : "Beauty Myths vs. Truth:\nThe Science Behind Your Skin.");
    $subtitle = data_get($options, 'subtitle') ?: ($isAr
        ? 'بصفتنا صيادلة وباحثين، نؤمن بأن الشفافية هي أسمى درجات العناية. إليك الحقيقة وراء أشهر أساطير العناية بالبشرة.'
        : 'Formulated by pharmaceutical scientists who value evidence over marketing buzz. Here is what research actually says.');

    $myths = data_get($options, 'myths') ?: [];
    $footerNote = data_get($options, 'footer_note') ?: ($isAr
        ? '«الاستمرارية مع مركبات صيدلانية فعالة ومدروسة تتفوق دائماً على التعقيد والخطوات الزائدة.» — د. البدري'
        : '"A handful of well-chosen actives, used consistently, will outperform ten mediocre steps. Consistency beats complexity." — Dr. Albadry');
@endphp

<section class="border-b border-[var(--section-color,#2e2224)] py-16 px-6 md:px-12" id="beauty-myths" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg); color: var(--section-color); border-color: var(--section-color);">
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

        @if (! empty($myths) && is_array($myths))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @foreach ($myths as $item)
                    <div class="border border-[var(--section-color,#2e2224)] p-6 flex flex-col justify-between bg-white/70 hover:shadow-md transition-shadow">
                        <div>
                            @if (! empty($item['tag']))
                                <span class="font-mono text-[10px] uppercase tracking-wider px-2 py-0.5 border border-[var(--section-color,#2e2224)]/40 bg-white inline-block mb-4">
                                    {{ $item['tag'] }}
                                </span>
                            @endif

                            <div class="mb-4 pb-4 border-b border-[var(--section-color,#2e2224)]/20">
                                <span class="font-mono text-[10px] font-bold uppercase tracking-wider text-[#bd1765] flex items-center gap-1 mb-1">
                                    <span>✕</span> {{ $isAr ? 'الخرافة الشائعة' : 'Common Myth' }}
                                </span>
                                <h3 class="font-mono text-sm font-bold text-[var(--section-color,#2e2224)] leading-snug">
                                    {{ $item['myth_text'] ?? '' }}
                                </h3>
                            </div>

                            <div>
                                <span class="font-mono text-[10px] font-bold uppercase tracking-wider text-[#1e5631] flex items-center gap-1 mb-1">
                                    <span>✓</span> {{ $isAr ? 'الحقيقة العلمية' : 'Scientific Truth' }}
                                </span>
                                <p class="font-mono text-xs opacity-85 leading-relaxed">
                                    {{ $item['truth_text'] ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if (! empty($footerNote))
            <div class="border border-[var(--section-color,#2e2224)] p-6 text-center bg-white/60 max-w-3xl mx-auto">
                <p class="font-mono text-xs md:text-sm font-semibold italic text-[var(--section-color,#2e2224)]">
                    {{ $footerNote }}
                </p>
            </div>
        @endif
    </div>
</section>
