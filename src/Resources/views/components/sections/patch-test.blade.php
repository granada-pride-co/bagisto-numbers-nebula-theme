@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#ffffff';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'بروتوكول السلامة الصيدلانية' : 'SAFETY PROTOCOL & CONSCIOUS USE');
    $title = data_get($options, 'title') ?: ($isAr ? "دليل اختبار الحساسية\nوإرشادات الاستخدام الآمن." : "Patch Test Protocol &\nSafety Guidelines.");
    $subtitle = data_get($options, 'subtitle') ?: ($isAr
        ? 'لأن كل بشرة فريدة ولها استجابتها الخاصة، نوصي دائماً بإجراء اختبار الحساسية قبل البدء بأي مستحضر جديد يحتوي على مركبات نشطة.'
        : 'Active skincare demands respect. We always recommend patch testing new active formulas 24–48 hours prior to full facial use.');

    $steps = data_get($options, 'steps') ?: [];
    $pregnancyTitle = data_get($options, 'pregnancy_advice_title') ?: ($isAr ? 'إرشادات الحمل والرضاعة' : 'Pregnancy & Nursing Guidance');
    $pregnancyText = data_get($options, 'pregnancy_advice_text') ?: ($isAr
        ? 'نوصي دائماً باستشارة طبيبكِ المختص قبل إدخال أي مادة فعالة جديدة (بما في ذلك الباكوتشيول وأحماض AHA) أثناء الحمل أو الرضاعة الطبيعية، لأن التوجيه الطبي الفردي أهم من أي ملصق عام.'
        : 'We always recommend checking with your healthcare provider before introducing active ingredients — including bakuchiol and AHA — during pregnancy or breastfeeding.');
    $contactText = data_get($options, 'doctor_contact_text') ?: ($isAr ? 'هل لديكِ استفسار خاص؟ تواصلي مع فريقنا العلمي' : 'Have a question? Reach out to our team');
    $contactLink = data_get($options, 'doctor_contact_link') ?: '#contact';
@endphp

<section class="border-b border-[#2e2224]/15 py-16 px-6 md:px-12" id="patch-test" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg);">
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

        @if (! empty($steps) && is_array($steps))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                @foreach ($steps as $item)
                    <div class="border border-[#2e2224]/15 p-6 bg-white relative text-[#2e2224]">
                        <span class="font-mono text-3xl font-bold opacity-20 block mb-2 text-[#2e2224]">
                            {{ $item['step_number'] ?? '' }}
                        </span>
                        <h3 class="font-mono text-sm font-bold uppercase tracking-wider text-[#2e2224] mb-2">
                            {{ $item['step_title'] ?? '' }}
                        </h3>
                        <p class="font-mono text-xs opacity-85 leading-relaxed">
                            {{ $item['step_desc'] ?? '' }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="border border-[#2e2224]/15 bg-white/70 p-8 max-w-4xl mx-auto flex flex-col md:flex-row gap-6 items-start justify-between">
            <div class="max-w-xl">
                <span class="font-mono text-[10px] uppercase tracking-wider px-2 py-0.5 border border-[#2e2224] bg-white inline-block mb-2">
                    {{ $isAr ? 'رعاية الأم والطفل' : 'Maternal Care' }}
                </span>
                <h4 class="font-mono text-base font-bold text-[#2e2224] mb-2">
                    {{ $pregnancyTitle }}
                </h4>
                <p class="font-mono text-xs opacity-85 leading-relaxed">
                    {{ $pregnancyText }}
                </p>
            </div>
            <div class="shrink-0 self-center md:self-end">
                <a href="{{ $contactLink }}" class="nc-btn nc-btn--dark inline-block text-center">
                    {{ $contactText }}
                </a>
            </div>
        </div>
    </div>
</section>
