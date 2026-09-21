@props(['options' => []])

@php
    $speed = (int) (data_get($options, 'speed') ?: 4000);
    $configuredMessages = data_get($options, 'messages');
    
    $messages = [];
    if (! empty($configuredMessages) && is_array($configuredMessages)) {
        foreach ($configuredMessages as $item) {
            $msgText = trim($item['text'] ?? '');
            if (! empty($msgText)) {
                $messages[] = [
                    'text'     => $msgText,
                    'link'     => $item['link'] ?? '#newsletter',
                    'btn_text' => $item['btn_text'] ?? 'SIGN UP',
                ];
            }
        }
    }

    if (empty($messages)) {
        $singleText = data_get($options, 'text') ?: trans('nc::app.brand.tagline');
        $singleLink = data_get($options, 'link') ?: '#newsletter';
        $singleBtn = data_get($options, 'btn_text') ?: 'SIGN UP';

        $messages = [
            [
                'text'     => $singleText,
                'link'     => $singleLink,
                'btn_text' => $singleBtn,
            ],
            [
                'text'     => app()->getLocale() === 'ar' ? 'توصيل مجاني لجميع الطلبات التي تتجاوز 250 ر.س' : 'Free delivery on all orders over $75',
                'link'     => route('shop.search.index'),
                'btn_text' => app()->getLocale() === 'ar' ? 'تسوقي الآن' : 'SHOP NOW',
            ],
            [
                'text'     => app()->getLocale() === 'ar' ? 'تركيبات نباتية 100% ونقية ومثبتة سريرياً' : '100% Clean, Vegan & Clinically Proven Formulas',
                'link'     => '#routine',
                'btn_text' => app()->getLocale() === 'ar' ? 'اكتشفي الروتين' : 'EXPLORE',
            ],
        ];
    }
@endphp

<div
    class="nc-announcement relative overflow-hidden flex items-center justify-center px-4"
    data-nc-announcement-ticker
    data-speed="{{ $speed }}"
>
    @foreach ($messages as $index => $msg)
        <a
            href="{{ $msg['link'] }}"
            data-nc-announcement-slide="{{ $index }}"
            class="nc-announcement-slide flex items-center justify-center gap-2 text-center transition-all duration-700 w-full {{ $index === 0 ? 'opacity-100 translate-y-0 relative' : 'opacity-0 -translate-y-4 absolute inset-0 pointer-events-none' }}"
        >
            <span>{{ $msg['text'] }}</span>
            <span class="inline-flex items-center gap-1 underline underline-offset-2 shrink-0">
                {{ $msg['btn_text'] }}
                <svg class="w-3.5 h-3.5 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </span>
        </a>
    @endforeach
</div>
