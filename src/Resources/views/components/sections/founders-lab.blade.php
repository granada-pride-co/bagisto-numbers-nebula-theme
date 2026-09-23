@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#fbf8f1';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'خلف الكواليس الصيدلانية' : 'THE PEOPLE BEHIND THE BEAKER');
    $title = data_get($options, 'title') ?: ($isAr ? "مختبر عائلي في فانكوفر،\nبأيدي باحثين وصيادلة." : "Our Cleo's Lab:\nFormulated by Real Scientists, Not Marketers.");
    $quote = data_get($options, 'quote') ?: ($isAr
        ? '«لسنا مصنعاً تجارياً، بل مختبر تديره عائلتنا في فانكوفر، حيث يتم تركيب واختبار كل تركيبة بعناية صيدلانية قبل أن تطبع عليها أي علامة. لسنا هنا لنكون أضخم علامة في كندا، بل العلامة التي تأتمنها لتهديها لابنتك، لأمك، ولنفسك في السادسة صباحاً.»'
        : 'Cleo\'s Lab isn\'t a factory. It is a family-run lab in Vancouver where every formula gets mixed and tested by pharmaceutical researchers. We are trying to be the one you trust enough to hand to your daughter, your mother, your own tired-eyed self at 6 am.');

    $badgeText = data_get($options, 'badge_text') ?: ($isAr ? 'صُنعت يدوياً بدفعات صغيرة في فانكوفر، كندا 🍁' : 'Hand-Filled Small-Batches in Vancouver, BC 🍁');
    $founders = data_get($options, 'founders') ?: [];
    $btnText = data_get($options, 'btn_text');
    $btnLink = data_get($options, 'btn_link') ?: '#story';
@endphp

<section class="border-b border-[#2e2224]/15 py-16 px-6 md:px-12" id="founders-lab" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg);">
    <div class="max-w-7xl mx-auto">
        <div class="nc-section-header max-w-3xl mb-12 reveal" style="color: var(--section-color);">
            <p class="font-mono text-xs font-bold tracking-widest uppercase mb-3 opacity-75" style="color: var(--section-color);">
                {{ $eyebrow }}
            </p>
            <h2 class="nc-section-title font-mono text-3xl md:text-5xl font-bold leading-tight mb-6" style="color: var(--section-color);">
                {!! nl2br(e($title)) !!}
            </h2>
            <div class="border-s-4 border-[#bd1765] ps-6 py-2 mb-6 bg-white/70">
                <p class="font-mono text-xs md:text-sm italic leading-relaxed text-[#2e2224]">
                    {{ $quote }}
                </p>
            </div>
            @if (! empty($badgeText))
                <span class="inline-block font-mono text-xs font-bold uppercase tracking-wider px-3 py-1 border border-[#2e2224] bg-[#2e2224] text-white">
                    {{ $badgeText }}
                </span>
            @endif
        </div>

        @if (! empty($founders) && is_array($founders))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                @foreach ($founders as $founder)
                    <div class="border border-[#2e2224]/15 bg-white p-8 relative flex flex-col justify-between text-[#2e2224]">
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-full border border-[#2e2224]/20 bg-[#fbf8f1] flex items-center justify-center font-mono font-bold text-sm text-[#2e2224]">
                                    {{ mb_substr($founder['name'] ?? 'Dr', 0, 2) }}
                                </div>
                                <div>
                                    <h3 class="font-mono text-lg font-bold text-[#2e2224]">
                                        {{ $founder['name'] ?? '' }}
                                    </h3>
                                    <p class="font-mono text-xs text-[#bd1765] font-semibold">
                                        {{ $founder['role'] ?? '' }}
                                    </p>
                                </div>
                            </div>
                            <p class="font-mono text-xs md:text-sm opacity-85 leading-relaxed">
                                {{ $founder['bio'] ?? '' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if (! empty($btnText))
            <div class="text-center pt-4">
                <a href="{{ $btnLink }}" class="nc-btn nc-btn--dark inline-block">
                    {{ $btnText }}
                </a>
            </div>
        @endif
    </div>
</section>
