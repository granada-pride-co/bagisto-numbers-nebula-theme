@props(['options' => []])

@php
    $html = data_get($options, 'html');
    $css = data_get($options, 'css');
@endphp

@if (! empty($css))
    @push ('styles')
        <style>{!! $css !!}</style>
    @endpush
@endif

@if (! empty($html))
    <div class="nc-custom-html-block max-w-7xl mx-auto px-6 py-12">
        {!! $html !!}
    </div>
@endif
