@php($data = $spread['data'])
<section class="issue-layout issue-layout--split issue-layout--paper">
  <div class="issue-layout__copy">
    <p class="issue-kicker">{{ $data['kicker'] ?? '' }}</p>
    <hr class="issue-rule">
    <h1 id="issue-spread-title">{{ $data['heading'] ?? $spread['title'] }}</h1>
    @if (! empty($data['dek']))
      <p class="issue-dek">{{ $data['dek'] }}</p>
    @endif
    @if ($spread['article_url'])
      <p class="issue-article-row">
        <a class="issue-article" href="{{ $spread['article_url'] }}">{{ $spread['article_label'] }}</a>
      </p>
    @endif
  </div>
  <div class="issue-layout__media">
    <div class="issue-plate" role="img" aria-label="{{ $data['aside'] ?? 'Placeholder plate' }}">
      <span>{{ $data['aside'] ?? 'Placeholder · Plate' }}</span>
    </div>
  </div>
</section>
