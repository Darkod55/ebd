@php($data = $spread['data'])
<section class="issue-layout issue-layout--split issue-layout--paper @if (!empty($data['long_title'])) is-long-title @endif">
  <div class="issue-layout__copy">
    <p class="issue-kicker">{{ $data['kicker'] ?? '' }}</p>
    <hr class="issue-rule">
    <h1 id="issue-spread-title">{{ $data['heading'] ?? $spread['title'] }}</h1>
    @if (! empty($data['dek']))
      <p class="issue-dek">{{ $data['dek'] }}</p>
    @endif
    @if (! empty($data['items']))
      <ul class="issue-name-list">
        @foreach ($data['items'] as $item)
          <li>{{ $item }}</li>
        @endforeach
      </ul>
    @endif
    @if (! empty($data['byline']))
      <p class="issue-spread-byline">{{ $data['byline'] }}</p>
    @endif
    @if ($spread['article_url'])
      <p class="issue-article-row">
        <a class="issue-article" href="{{ $spread['article_url'] }}">{{ $spread['article_label'] }}</a>
      </p>
    @endif
  </div>
  <div class="issue-layout__media">
    <div class="issue-plate @if (($data['image_fit'] ?? '') === 'contain') is-contain @endif" @if (empty($data['image'])) role="img" aria-label="{{ $data['aside'] ?? 'Photograph to come' }}" @endif>
      @if (! empty($data['image']))
        <picture>
          <source type="image/avif" srcset="{{ \App\Issue::imageAvif($data['image']) }}">
          <img src="{{ \App\Issue::image($data['image']) }}" alt="{{ $data['image_alt'] ?? '' }}">
        </picture>
      @else
        <span>{{ $data['aside'] ?? 'Photograph to come' }}</span>
      @endif
    </div>
  </div>
</section>
