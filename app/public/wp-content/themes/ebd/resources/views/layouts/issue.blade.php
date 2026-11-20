{{--
  Static magazine shell for the Issue 01 demo.
  Keeps wp_head / wp_footer. Does not use the starter site header.
--}}
<!doctype html>
<html @php(language_attributes())>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php(do_action('get_header'))
    @php(wp_head())

    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body @php(body_class('issue-shell bg-gray text-body'))>
    @php(wp_body_open())

    <div id="app">
      <a class="sr-only focus:not-sr-only" href="#main">
        {{ __('Skip to content', 'sage') }}
      </a>

      @include('partials.issue.masthead')

      <main id="main" class="main">
        @yield('content')
      </main>

      @include('partials.issue.newsletter')
      @include('partials.issue.footer')
    </div>

    @php(do_action('get_footer'))
    @php(wp_footer())
  </body>
</html>
