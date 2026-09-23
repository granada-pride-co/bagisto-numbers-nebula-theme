@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';
    $eyebrow = data_get($options, 'eyebrow') ?: ($isAr ? 'انضمي إلى مجتمعنا' : "LET'S MAKE THIS OFFICIAL");
    $title = data_get($options, 'title') ?: ($isAr ? 'احصلي على خصم 15%.' : 'Take 15% off.');
    $description = data_get($options, 'description') ?: ($isAr ? 'تركيبات جديدة، نصائح للبشرة، ووصول حصري قبل الجميع. محتوى قيّم وهادئ.' : 'New formulas, useful skin notes and first access. Nothing noisy.');
    $placeholder = data_get($options, 'placeholder') ?: ($isAr ? 'البريد الإلكتروني' : 'EMAIL ADDRESS');
    $btnText = data_get($options, 'btn_text') ?: ($isAr ? 'سجليني الآن' : 'SIGN ME UP');
    $bgColor = data_get($options, 'bg_color') ?: '#f089a8';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
@endphp

<section
    class="border-b border-[#2e2224] py-20 px-6 text-center transition-colors duration-300"
    style="background-color: {{ $bgColor }}; color: {{ $textColor }};"
    id="newsletter"
>
    <div class="max-w-xl mx-auto flex flex-col items-center gap-4 reveal">
        <p class="font-mono text-xs font-bold tracking-widest uppercase opacity-90">
            {{ $eyebrow }}
        </p>
        <h2 class="font-serif text-3xl md:text-5xl font-bold tracking-tight">
            {{ $title }}
        </h2>
        <p class="text-sm opacity-90 max-w-md mb-4 leading-relaxed">
            {{ $description }}
        </p>

        <form
            action="{{ route('shop.subscription.store') }}"
            method="POST"
            class="w-full flex flex-col sm:flex-row gap-3"
            onsubmit="if(window.showToast){ window.showToast('{{ $isAr ? 'تم تسجيل بريدكِ بنجاح!' : 'You are on the list! Check your inbox.' }}'); }"
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
