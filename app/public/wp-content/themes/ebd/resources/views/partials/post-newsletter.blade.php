@php
  $formId = 2;
  $canRender = shortcode_exists('fluentform');
@endphp

@if ($canRender)
  <aside class="mpx-post-newsletter" aria-label="{{ __('Newsletter signup', 'sage') }}">
    <h2 class="mpx-post-newsletter__title">{{ __('Sign up to our newsletter', 'sage') }}</h2>
    {!! do_shortcode('[fluentform id="' . (int) $formId . '"]') !!}
  </aside>
@endif
