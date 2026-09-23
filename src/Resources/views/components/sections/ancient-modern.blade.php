@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#f7f4ea';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'أسرار الفراعنة × الصيدلة الحديثة' : 'ANCIENT INSTINCT × MODERN CHEMISTRY');
    $title = data_get($options, 'title') ?: ($isAr ? "الحكمة القديمة،\nبدقة صيدلانية معاصرة." : "Ancient instinct,\nmodern chemistry.");
    $description = data_get($options, 'description') ?: ($isAr
        ? 'كل تركيبة في Cleo\'s Lab تجمع بين مكوّن عرفته الحضارة المصرية القديمة لآلاف السنين، والمركب الفعال الصيدلاني الذي يؤدي نفس الدور اليوم بدقة مثبتة مخبرياً.'
        : 'Every formula pairs a traditional botanical trusted for thousands of years with the active that does the same job today — ancient instinct, modern chemistry, no gap between the two.');

    $cards = data_get($options, 'cards') ?: [];
    $btnText = data_get($options, 'btn_text');
    $btnLink = data_get($options, 'btn_link') ?: '#shop';
@endphp

<section class="border-b border-[#2e2224]/15 py-16 px-6 md:px-12" id="ancient-modern" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg);">
    <div class="max-w-7xl mx-auto">
        <div class="nc-section-header text-center max-w-3xl mx-auto mb-14 reveal" style="color: var(--section-color);">
            <p class="font-mono text-xs font-bold tracking-widest uppercase mb-3 opacity-75" style="color: var(--section-color);">
                {{ $eyebrow }}
            </p>
            <h2 class="nc-section-title font-mono text-3xl md:text-5xl font-bold leading-tight mb-4" style="color: var(--section-color);">
                {!! nl2br(e($title)) !!}
            </h2>
            <p class="font-mono text-xs md:text-sm leading-relaxed opacity-85" style="color: var(--section-color);">
                {{ $description }}
            </p>
        </div>

        @if (! empty($cards) && is_array($cards))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @foreach ($cards as $card)
                    <div class="border border-[#2e2224]/15 bg-white p-6 flex flex-col justify-between text-[#2e2224] transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div>
                            @if (! empty($card['badge']))
                                <span class="inline-block font-mono text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 border border-[#2e2224] bg-[#2e2224] text-white mb-4">
                                    {{ $card['badge'] }}
                                </span>
                            @endif

                            <div class="mb-4 pb-4 border-b border-[#2e2224]/15">
                                <span class="font-mono text-[10px] uppercase tracking-wider opacity-60 block mb-1">
                                    {{ $isAr ? 'الأصل التاريخي' : 'Ancient Source' }}
                                </span>
                                <h3 class="font-mono text-base font-bold text-[#2e2224]">
                                    {{ $card['ancient_name'] ?? '' }}
                                </h3>
                                @if (! empty($card['ancient_origin']))
                                    <p class="font-mono text-[11px] opacity-70 italic mt-0.5">
                                        {{ $card['ancient_origin'] }}
                                    </p>
                                @endif
                                <p class="font-mono text-xs opacity-80 mt-2 leading-relaxed">
                                    {{ $card['ancient_desc'] ?? '' }}
                                </p>
                            </div>

                            <div>
                                <span class="font-mono text-[10px] uppercase tracking-wider opacity-60 block mb-1">
                                    {{ $isAr ? 'البديل الصيدلاني اليوم' : 'Modern Pharmaceutical Equivalent' }}
                                </span>
                                <h4 class="font-mono text-sm font-bold text-[#2e2224]">
                                    {{ $card['modern_active'] ?? '' }}
                                </h4>
                                <p class="font-mono text-xs opacity-80 mt-1 leading-relaxed">
                                    {{ $card['modern_function'] ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if (! empty($btnText))
            <div class="text-center">
                <a href="{{ $btnLink }}" class="nc-btn nc-btn--dark inline-block">
                    {{ $btnText }}
                </a>
            </div>
        @endif
    </div>
</section>
