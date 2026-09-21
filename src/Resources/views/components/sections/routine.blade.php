@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $image = \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::url(
        data_get($options, 'image'),
        asset('themes/shop/nebula-cosmetics/images/cleo-concern-portrait.jpg')
    );

    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'فن دمج المستحضرات' : 'NEBULA MIXOLOGY');
    $title = data_get($options, 'title') ?: ($isAr ? 'روتين واحد متكامل. دون أي تعقيد.' : 'One routine. Zero confusion.');
    $description = data_get($options, 'description') ?: ($isAr ? 'اختاري قاعدة تنظيف نقية، أضيفي مادة فعالة موجهة لهدفك، ثم احبسي الترطيب. تركيباتنا متوافقة لتمنحكِ أقصى فائدة دون إرهاق بشرتكِ.' : 'Choose a clean base, add one targeted active, then seal in moisture. Our formulas are made to work together without overworking your skin.');

    $defaultSteps = [
        ['number' => '01', 'title' => $isAr ? 'التنظيف' : 'CLEANSE', 'copy' => $isAr ? 'إعادة التوازن والنقاء دون تجريد الزيوت الطبيعية.' : 'Reset without stripping.'],
        ['number' => '02', 'title' => $isAr ? 'العلاج' : 'TREAT', 'copy' => $isAr ? 'استهداف احتياج بشرتكِ بمواد فعالة مركزة.' : 'Target one concern at a time.'],
        ['number' => '03', 'title' => $isAr ? 'الحماية والترطيب' : 'SEAL', 'copy' => $isAr ? 'حبس المغذيات والترطيب طوال اليوم.' : 'Keep the good stuff in.'],
    ];

    $rawSteps = data_get($options, 'steps');
    $steps = ! empty($rawSteps) && is_array($rawSteps) ? $rawSteps : $defaultSteps;

    $btnText = data_get($options, 'btn_text') ?: ($isAr ? 'اعثري على تركيبتكِ' : 'FIND MY FORMULAS');
    $btnLink = data_get($options, 'btn_link') ?: '#shop';
@endphp

<section class="border-b border-[#2e2224] bg-[#fbf8f1]" id="routine">
    <div class="grid grid-cols-1 lg:grid-cols-2">
        <div class="border-b lg:border-b-0 lg:border-e border-[#2e2224] overflow-hidden min-h-[400px]">
            <img
                src="{{ $image }}"
                alt="{{ $title }}"
                class="w-full h-full object-cover"
            />
        </div>

        <div class="p-8 md:p-16 flex flex-col justify-center reveal">
            <p class="font-mono text-xs font-bold tracking-widest text-[#bd1765] uppercase mb-3">
                {{ $eyebrow }}
            </p>
            <h2 class="font-serif text-3xl md:text-5xl font-bold text-[#2e2224] leading-tight mb-4">
                {!! nl2br(e($title)) !!}
            </h2>
            <p class="text-sm md:text-base text-[#2e2224]/80 leading-relaxed mb-8">
                {{ $description }}
            </p>

            <ol class="flex flex-col gap-6 mb-10">
                @foreach ($steps as $step)
                    <li class="flex items-start gap-4 pb-4 border-b border-[#2e2224]/15">
                        <span class="font-mono text-lg font-bold text-[#bd1765]">
                            {{ $step['number'] ?? '' }}
                        </span>
                        <div>
                            <h3 class="font-mono text-xs font-bold tracking-wider text-[#2e2224] uppercase mb-1">
                                {{ $step['title'] ?? '' }}
                            </h3>
                            <p class="text-xs text-[#2e2224]/75">
                                {{ $step['copy'] ?? '' }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ol>

            <div>
                <a href="{{ $btnLink }}" class="nc-btn nc-btn--dark">
                    {{ $btnText }}
                </a>
            </div>
        </div>
    </div>
</section>
