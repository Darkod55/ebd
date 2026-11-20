{{-- Sticky contact widgets: Book a Call + Email Chris --}}
<nav class="mpx-contact-fab" aria-label="{{ esc_attr__('Contact', 'sage') }}">
  <a
    href="{{ home_url('/book-a-call') }}"
    class="mpx-contact-fab__btn"
  >
    <span class="mpx-contact-fab__icon" aria-hidden="true">
      {!! \App\helpers()->getSvg(['icon' => 'phone', 'width' => 22, 'title' => '']) !!}
    </span>
    <span class="mpx-contact-fab__label">{{ __('Book a Call', 'sage') }}</span>
  </a>

  <a
    href="mailto:chris@christopherpauljones.com"
    class="mpx-contact-fab__btn"
  >
    <span class="mpx-contact-fab__icon" aria-hidden="true">
      {!! \App\helpers()->getSvg(['icon' => 'envelope', 'width' => 22, 'title' => '']) !!}
    </span>
    <span class="mpx-contact-fab__label">{{ __('Email Chris', 'sage') }}</span>
  </a>
</nav>
