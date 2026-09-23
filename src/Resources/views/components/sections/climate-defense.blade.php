@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#f4ede2';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'حماية فائقة من تقلبات الطقس' : 'EXTREME CLIMATE BARRIER DEFENSE');
    $title = data_get($options, 'title') ?: ($isAr ? "من شمس النيل الحارقة\nإلى شتاء كندا الجاف." : "From the Nile Sun\nto the Canadian Winter.");
    $story1 = data_get($options, 'story_paragraph_1') ?: ($isAr
        ? 'مناخ مصر القديمة كان قاسياً وجافاً للغاية، لذا لم تكن الزيوت الطبيعية والمستخلصات رفاهية تجميلية — بل أدوات بقاء يومية لحماية الجلد من الحروق والرياح العاتية. إن لم تكن فعالة، لما استمرت لآلاف السنين.'
        : "Egypt's climate is brutally drying. Castor, moringa, and almond oils weren't luxury spa items — they were survival tools against scorching sun and desert windburn. If an ingredient didn't work, it didn't last.");
    $story2 = data_get($options, 'story_paragraph_2') ?: ($isAr
        ? 'أخذنا هذه الأسرار وأعدنا صياغتها في فانكوفر لتواجه البرودة الشديدة والتدفئة المنزلية الجافة. تركيباتنا معززة ببروتين الشوفان وزبدة الشيا لحبس الماء داخل خلايا البشرة — الفرق الحقيقي بين بشرة ترتوي لساعة واحدة وبشرة تحتفظ بنضارتها حتى الثالثة عصراً.'
        : 'We brought that knowledge to Vancouver, BC to tackle freezing winds and dehydrating indoor heat. Shea butter and oat proteins hold moisture in rather than just coating the surface — the difference between hydration that fades in an hour and skin that thrives at 3 pm.');

    $image = \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::url(
        data_get($options, 'image'),
        asset('themes/shop/nebula-cosmetics/images/cleo-hero-skin.jpg')
    );

    $stats = data_get($options, 'stats') ?: [];
    $btnText = data_get($options, 'btn_text');
    $btnLink = data_get($options, 'btn_link') ?: '#shop';
@endphp

<section class="border-b border-[var(--section-color,#2e2224)] py-16 px-6 md:px-12" id="climate-defense" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg); color: var(--section-color); border-color: var(--section-color);">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-12">
            <div class="reveal">
                <p class="font-mono text-xs font-bold tracking-widest uppercase mb-3 opacity-75">
                    {{ $eyebrow }}
                </p>
                <h2 class="font-mono text-3xl md:text-5xl font-bold leading-tight mb-6">
                    {!! nl2br(e($title)) !!}
                </h2>
                <div class="space-y-4 font-mono text-xs md:text-sm opacity-85 leading-relaxed">
                    <p>{{ $story1 }}</p>
                    <p>{{ $story2 }}</p>
                </div>

                @if (! empty($btnText))
                    <div class="mt-8">
                        <a href="{{ $btnLink }}" class="nc-btn nc-btn--dark inline-block">
                            {{ $btnText }}
                        </a>
                    </div>
                @endif
            </div>

            <div class="border border-[var(--section-color,#2e2224)] p-3 bg-white/40 shadow-sm">
                <div class="aspect-[4/3] overflow-hidden border border-[var(--section-color,#2e2224)]">
                    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover" />
                </div>
            </div>
        </div>

        @if (! empty($stats) && is_array($stats))
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-8 border-t border-[var(--section-color,#2e2224)]">
                @foreach ($stats as $stat)
                    <div class="border border-[var(--section-color,#2e2224)] bg-white/70 p-5">
                        <span class="font-mono text-2xl md:text-3xl font-bold block mb-1">
                            {{ $stat['figure'] ?? '' }}
                        </span>
                        <h3 class="font-mono text-xs font-bold uppercase tracking-wider mb-2">
                            {{ $stat['label'] ?? '' }}
                        </h3>
                        <p class="font-mono text-[11px] opacity-80 leading-normal">
                            {{ $stat['desc'] ?? '' }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
