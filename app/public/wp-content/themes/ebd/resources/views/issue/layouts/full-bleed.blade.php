@php($data = $spread['data'])
<section class="issue-layout issue-layout--full issue-layout--{{ ($data['tone'] ?? 'paper') === 'dark' ? 'dark' : 'paper' }}">
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
</section>
