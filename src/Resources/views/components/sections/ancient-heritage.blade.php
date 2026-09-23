@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#f4ede2';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'أسرار التاريخ الموثق' : 'ANCIENT EGYPT, ACTUALLY');
    $title = data_get($options, 'title') ?: ($isAr ? "مصر القديمة، في الواقع:\nتاريخ الجمال كما لم تسمعيه من قبل." : "Ancient Egypt, Actually:\nSkincare as Survival, Not Vanity.");
    $subtitle = data_get($options, 'subtitle') ?: ($isAr
        ? 'الفراعنة لم يخترعوا التباهي التجميلي، بل ابتكروا العناية بالبشرة كعلم صيدلاني للحماية اليومية.'
        : 'They didn\'t invent vanity — they invented skincare as daily protection. Here are the documented truths behind the legends.');

    $stories = data_get($options, 'stories') ?: [];
    $communityTitle = data_get($options, 'community_title') ?: ($isAr ? 'جذور مصرية في قلب كندا 🍁' : 'Egyptian Roots in Canada 🍁');
    $communityText = data_get($options, 'community_text') ?: ($isAr
        ? 'أكثر من 105,000 كندي من أصول مصرية يعيشون اليوم في كندا، وتعد فانكوفر ومونتريال وتورونتو من أكبر الحواضن المجتمعية. بدأت Cleo\'s Lab من مجتمع فانكوفر المحلي ومن أسواق الـ Pop-ups في Lower Mainland، لتصل إلى كل أنحاء كندا بجذور أصيلة.'
        : 'With over 105,000 people of Egyptian ancestry in Canada, Cleo\'s Lab was born right inside Vancouver\'s established Egyptian-Canadian community — hand-crafting small batches for local markets before expanding across Canada.');
@endphp

<section class="border-b border-[#2e2224]/15 py-16 px-6 md:px-12" id="ancient-heritage" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg);">
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

        @if (! empty($stories) && is_array($stories))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @foreach ($stories as $story)
                    <div class="border border-[#2e2224]/15 bg-white p-6 flex flex-col justify-between text-[#2e2224] transition-colors">
                        <div>
                            @if (! empty($story['tag']))
                                <span class="font-mono text-[10px] uppercase tracking-wider px-2 py-0.5 border border-[#2e2224] bg-[#2e2224] text-white inline-block mb-3">
                                    {{ $story['tag'] }}
                                </span>
                            @endif

                            <h3 class="font-mono text-base font-bold text-[#2e2224] mb-3">
                                {{ $story['title'] ?? '' }}
                            </h3>

                            <p class="font-mono text-xs opacity-85 leading-relaxed mb-4">
                                {{ $story['story'] ?? '' }}
                            </p>
                        </div>

                        @if (! empty($story['modern_takeaway']))
                            <div class="pt-3 border-t border-[#2e2224]/15 bg-[#2e2224]/5 -mx-6 -mb-6 p-4">
                                <span class="font-mono text-[10px] uppercase tracking-wider text-[#bd1765] font-bold block mb-0.5">
                                    {{ $isAr ? 'في مختبرنا اليوم:' : 'In Our Lab Today:' }}
                                </span>
                                <p class="font-mono text-[11px] opacity-80">
                                    {{ $story['modern_takeaway'] }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if (! empty($communityTitle))
            <div class="border border-[#2e2224]/15 bg-white/70 p-8 max-w-4xl mx-auto shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-2xl">🏛️</span>
                    <h4 class="font-mono text-lg font-bold text-[#2e2224]">
                        {{ $communityTitle }}
                    </h4>
                </div>
                <p class="font-mono text-xs md:text-sm opacity-85 leading-relaxed">
                    {{ $communityText }}
                </p>
            </div>
        @endif
    </div>
</section>
