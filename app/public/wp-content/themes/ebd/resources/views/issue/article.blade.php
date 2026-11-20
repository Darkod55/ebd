{{--
  Scrolling long-form page. Author copy is not rewritten.
  Bylines sit at the bottom, per the editorial handbook.
--}}
@extends('layouts.issue')

@section('content')
  <article class="issue-story container px-clamp py-clamp">
    <p class="issue-kicker">{{ $piece['kicker'] ?? '' }}</p>
    <h1>{{ $piece['title'] }}</h1>

    @if (! empty($piece['standfirst']))
      <p class="issue-standfirst">{{ $piece['standfirst'] }}</p>
    @endif

    @if (($piece['template'] ?? '') === 'names')
      <ul class="issue-name-list">
        @foreach ($piece['names'] as $name)
          <li>{{ $name }}</li>
        @endforeach
      </ul>
    @endif

    @if (($piece['template'] ?? '') === 'people')
      <div class="issue-people">
        @foreach ($piece['people'] as $person)
          <section class="issue-person">
            @if (! empty($person['image']))
              <picture>
                <source type="image/avif" srcset="{{ \App\Issue::imageAvif($person['image']) }}">
                <img src="{{ \App\Issue::image($person['image']) }}" alt="Portrait of {{ $person['name'] }}">
              </picture>
            @else
              <div class="issue-person__missing" role="img" aria-label="Photograph to come">Photograph to come</div>
            @endif
            <div>
              <h2>{{ $person['name'] }}</h2>
              @if (! empty($person['role']))
                <p class="issue-spread-byline">{{ $person['role'] }}</p>
              @endif
              @foreach ($person['bio'] as $paragraph)
                <p>{{ $paragraph }}</p>
              @endforeach
              @if (! empty($person['missing']))
                <p class="issue-aside-note">{{ $person['missing'] }}</p>
              @endif
            </div>
          </section>
        @endforeach
      </div>
    @endif

    @if (! empty($piece['images']))
      <div class="issue-products">
        @foreach ($piece['images'] as $image)
          <figure>
            <picture>
              <source type="image/avif" srcset="{{ \App\Issue::imageAvif($image['file']) }}">
              <img src="{{ \App\Issue::image($image['file']) }}" alt="{{ $image['alt'] }}">
            </picture>
          </figure>
        @endforeach
      </div>
    @endif

    @if (! empty($piece['blocks']))
      @foreach ($piece['blocks'] as $block)
        @if ($block['type'] === 'h2')
          <h2>{{ $block['text'] }}</h2>
        @elseif ($block['type'] === 'h3')
          <h3>{{ $block['text'] }}</h3>
        @elseif ($block['type'] === 'quote')
          <blockquote><p>{{ $block['text'] }}</p></blockquote>
        @else
          <p>{{ $block['text'] }}</p>
        @endif
      @endforeach
    @endif

    @if (! empty($piece['byline']))
      <p class="issue-story-byline">
        {{ $piece['byline'] }}
        @if (! empty($piece['role']))
          <span>{{ $piece['role'] }}</span>
        @endif
      </p>
    @endif

    <p class="issue-article-row">
      <a class="issue-article" href="{{ $spread_url }}">Back to the spread</a>
    </p>
  </article>
@endsection
