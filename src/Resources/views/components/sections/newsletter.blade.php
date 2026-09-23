@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $eyebrow = data_get($options, 'eyebrow') ?: trans('nc::app.sections.newsletter.default_eyebrow');
    $title = data_get($options, 'title') ?: trans('nc::app.sections.newsletter.default_title');
    $description = data_get($options, 'description') ?: trans('nc::app.sections.newsletter.default_description');
    $placeholder = data_get($options, 'placeholder') ?: trans('nc::app.sections.newsletter.default_placeholder');
    $btnText = data_get($options, 'btn_text') ?: trans('nc::app.sections.newsletter.default_btn_text');
    $bgColor = data_get($options, 'bg_color') ?: '#f089a8';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
@endphp

<section
    class="border-b border-[#2e2224]/15 py-20 px-6 text-center transition-colors duration-300"
    dir="{{ $isAr ? 'rtl' : 'ltr' }}"
    style="--section-bg: {{ $bgColor }}; --section-color: {{ $textColor }}; background-color: var(--section-bg);"
    id="newsletter"
>
    <div class="max-w-xl mx-auto flex flex-col items-center gap-4 reveal">
        <p class="font-mono text-xs font-bold tracking-widest uppercase opacity-90" style="color: var(--section-color);">
            {{ $eyebrow }}
        </p>
        <h2 class="font-serif text-3xl md:text-5xl font-bold tracking-tight" style="color: var(--section-color);">
            {{ $title }}
        </h2>
        <p class="text-sm opacity-90 max-w-md mb-4 leading-relaxed text-[#2e2224]">
            {{ $description }}
        </p>

        <form
            action="{{ route('shop.subscription.store') }}"
            method="POST"
            class="w-full flex flex-col sm:flex-row gap-3"
            onsubmit="if(window.showToast){ window.showToast('{{ trans('nc::app.sections.newsletter.toast_success') }}'); }"
        >
            @csrf
            <label for="newsletter-email" class="sr-only">{{ $placeholder }}</label>
            <input
                id="newsletter-email"
                type="email"
                name="email"
                required
                placeholder="{{ $placeholder }}"
                class="flex-1 bg-white border border-[#2e2224] px-4 py-3 font-mono text-xs outline-none focus:border-[#bd1765] transition-colors"
            />
            <button
                type="submit"
                class="nc-btn nc-btn--dark"
            >
                {{ $btnText }}
            </button>
        </form>
    </div>
</section>
