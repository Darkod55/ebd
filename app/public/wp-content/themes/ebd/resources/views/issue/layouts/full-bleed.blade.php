@php($data = $spread['data'])
<section class="issue-layout issue-layout--full issue-layout--{{ ($data['tone'] ?? 'paper') === 'dark' ? 'dark' : 'paper' }} @if (!empty($data['long_title'])) is-long-title @endif">
  @if (! empty($data['image']))
    <picture>
      <source type="image/avif" srcset="{{ \App\Issue::imageAvif($data['image']) }}">
      <img class="issue-layout__bg" src="{{ \App\Issue::image($data['image']) }}" alt="{{ $data['image_alt'] ?? '' }}">
    </picture>
    <div class="issue-layout__scrim" aria-hidden="true"></div>
  @endif
  <div class="issue-layout__copy">
    <p class="issue-kicker">{{ $data['kicker'] ?? '' }}</p>
    <hr class="issue-rule">
    <h1 id="issue-spread-title">{{ $data['heading'] ?? $spread['title'] }}</h1>
    @if (! empty($data['dek']))
      <p class="issue-dek">{{ $data['dek'] }}</p>
    @endif
    @if (! empty($data['byline']))
      <p class="issue-spread-byline">{{ $data['byline'] }}</p>
    @endif
    @if (! empty($data['aside']) && empty($data['image']))
      <p class="issue-aside-note">{{ $data['aside'] }}</p>
    @endif
    @if ($spread['article_url'])
      <p class="issue-article-row">
        <a class="issue-article" href="{{ $spread['article_url'] }}">{{ $spread['article_label'] }}</a>
      </p>
    @endif
  </div>
</section>
