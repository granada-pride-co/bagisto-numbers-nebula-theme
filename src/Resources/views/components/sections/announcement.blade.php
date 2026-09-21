@props(['options' => []])

@php
    $text = data_get($options, 'text') ?: trans('nc::app.brand.tagline');
    $link = data_get($options, 'link') ?: '#newsletter';
    $btnText = data_get($options, 'btn_text') ?: 'SIGN UP';
@endphp

<a href="{{ $link }}" class="nc-announcement flex items-center justify-center gap-2 px-4 text-center">
    <span>{{ $text }}</span>
    <span class="inline-flex items-center gap-1 underline underline-offset-2">
        {{ $btnText }}
        <svg class="w-3.5 h-3.5 rtl:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
    </span>
</a>
