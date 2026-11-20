{{--
  One magazine spread. Full document, real URL.
  wp_head / wp_footer stay so SEO, analytics, and security can print.
--}}
<!doctype html>
<html @php(language_attributes())>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    @php(do_action('get_header'))
    @php(wp_head())
    <link rel="canonical" href="{{ $spread['url'] }}">
    @if ($spread['prev'])
      <link rel="prev" href="{{ $spread['prev']['url'] }}">
      <link rel="prefetch" href="{{ $spread['prev']['url'] }}" data-issue-prefetch="prev">
    @endif
    @if ($spread['next'])
      <link rel="next" href="{{ $spread['next']['url'] }}">
      <link rel="prefetch" href="{{ $spread['next']['url'] }}" data-issue-prefetch="next">
    @endif
    <style>
      @media (prefers-reduced-motion: no-preference) {
        @view-transition { navigation: auto; }
      }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body
    @php(body_class('issue-reader'))
    x-data="issueReader"
    @keydown.window="onKey($event)"
    @touchstart.passive="onTouchStart($event)"
    @touchend.passive="onTouchEnd($event)"
  >
    @php(wp_body_open())

    <div id="app">
      <a class="sr-only focus:not-sr-only" href="#issue-stage">
        {{ __('Skip to spread', 'sage') }}
      </a>
      <p id="issue-live" class="sr-only" aria-live="polite"></p>

      <main id="issue-stage" tabindex="-1" aria-labelledby="issue-spread-title">
        @yield('content')
      </main>

      @include('partials.issue.reader-nav')
    </div>

    @php(do_action('get_footer'))
    @php(wp_footer())
  </body>
</html>
