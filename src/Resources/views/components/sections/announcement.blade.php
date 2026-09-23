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
                    'btn_text' => $item['btn_text'] ?? trans('nc::app.header.sign_up'),
                ];
            }
        }
    }

    if (empty($messages)) {
        $singleText = data_get($options, 'text') ?: trans('nc::app.brand.tagline');
        $singleLink = data_get($options, 'link') ?: '#newsletter';
        $singleBtn = data_get($options, 'btn_text') ?: trans('nc::app.header.sign_up');

        $messages = [
            [
                'text'     => $singleText,
                'link'     => $singleLink,
                'btn_text' => $singleBtn,
            ],
            [
                'text'     => trans('nc::app.sections.announcement.default_msg_1'),
                'link'     => route('shop.search.index'),
                'btn_text' => trans('nc::app.sections.announcement.default_btn_1'),
            ],
            [
                'text'     => trans('nc::app.sections.announcement.default_msg_2'),
                'link'     => '#routine',
                'btn_text' => trans('nc::app.sections.announcement.default_btn_2'),
            ],
        ];
    }

    $bgColor = data_get($options, 'bg_color') ?: 'var(--primary, #bd1765)';
    $textColor = data_get($options, 'text_color') ?: '#ffffff';
@endphp

<div
    class="nc-announcement relative overflow-hidden flex items-center justify-center px-4 md:px-6"
    dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
    style="background-color: {{ $bgColor }}; color: {{ $textColor }};"
    data-nc-announcement-ticker
    data-speed="{{ $speed }}"
>
    <div class="max-w-7xl mx-auto w-full flex items-center justify-center">
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
</div>
