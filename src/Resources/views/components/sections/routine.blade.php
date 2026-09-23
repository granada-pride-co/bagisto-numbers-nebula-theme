@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $bgColor = data_get($options, 'bg_color') ?: '#91e4d9';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';

    $image = \NumbersNebula\NebulaCosmetics\Helpers\MediaHelper::url(
        data_get($options, 'image'),
        asset('themes/shop/nebula-cosmetics/images/cleo-concern-portrait.jpg')
    );

    $eyebrow = data_get($options, 'eyebrow') ?: trans('nc::app.sections.routine.default_eyebrow');
    $title = data_get($options, 'title') ?: trans('nc::app.sections.routine.default_title');
    $description = data_get($options, 'description') ?: trans('nc::app.sections.routine.default_description');

    $defaultSteps = [
        ['number' => '01', 'title' => trans('nc::app.sections.routine.step_1_title'), 'copy' => trans('nc::app.sections.routine.step_1_copy')],
        ['number' => '02', 'title' => trans('nc::app.sections.routine.step_2_title'), 'copy' => trans('nc::app.sections.routine.step_2_copy')],
        ['number' => '03', 'title' => trans('nc::app.sections.routine.step_3_title'), 'copy' => trans('nc::app.sections.routine.step_3_copy')],
    ];

    $rawSteps = data_get($options, 'steps');
    $steps = ! empty($rawSteps) && is_array($rawSteps) ? $rawSteps : $defaultSteps;

    $btnText = data_get($options, 'btn_text') ?: trans('nc::app.sections.routine.default_btn_text');
    $btnLink = data_get($options, 'btn_link') ?: '#shop';
@endphp

<section class="border-b border-[var(--section-color,#2e2224)]" id="routine" dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg); color: var(--section-color); border-color: var(--section-color);">
    <div class="grid grid-cols-1 lg:grid-cols-2">
        <div class="border-b lg:border-b-0 lg:border-e border-[var(--section-color,#2e2224)] overflow-hidden min-h-[450px]">
            <img
                src="{{ $image }}"
                alt="{{ $title }}"
                class="w-full h-full object-cover"
            />
        </div>

        <div class="p-8 md:p-16 flex flex-col justify-center reveal {{ $isAr ? 'text-right' : 'text-left' }}" style="background-color: var(--section-bg); color: var(--section-color);">
            <p class="font-mono text-xs font-bold tracking-widest uppercase mb-3 opacity-80">
                {{ $eyebrow }}
            </p>
            <h2 class="font-mono text-3xl md:text-5xl font-bold leading-tight mb-4">
                {!! nl2br(e($title)) !!}
            </h2>
            <p class="font-mono text-xs md:text-sm opacity-85 leading-relaxed mb-8 max-w-lg">
                {{ $description }}
            </p>

            <ol class="flex flex-col gap-5 mb-10">
                @foreach ($steps as $step)
                    <li class="flex items-start gap-4 pb-4 border-b border-[var(--section-color,#2e2224)]/20">
                        <span class="font-mono text-xs font-bold shrink-0 pt-0.5 text-[var(--section-color,#2e2224)]">
                            {{ $step['number'] ?? '' }}
                        </span>
                        <div>
                            <h3 class="font-mono text-xs font-bold tracking-wider uppercase mb-1 text-[var(--section-color,#2e2224)]">
                                {{ $step['title'] ?? '' }}
                            </h3>
                            <p class="font-mono text-[11px] opacity-80 leading-normal">
                                {{ $step['copy'] ?? '' }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ol>

            <div>
                <a href="{{ $btnLink }}" class="nc-btn nc-btn--dark inline-block">
                    {{ $btnText }}
                </a>
            </div>
        </div>
    </div>
</section>
