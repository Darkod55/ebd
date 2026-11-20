@php($data = $spread['data'])
<section class="issue-layout mag mag--banner">
  <div class="mag-banner__media">
    @if (! empty($data['image']))
      <picture>
        <source type="image/avif" srcset="{{ \App\Issue::imageAvif($data['image']) }}">
        <img src="{{ \App\Issue::image($data['image']) }}" alt="{{ $data['image_alt'] ?? '' }}">
      </picture>
    @endif
  </div>
  <div class="mag-banner__copy">
    <p class="mag-kicker">{{ $data['kicker'] ?? '' }}</p>
    <hr class="mag-rule">
    @if (! empty($data['show_title']))
      <h1 id="issue-spread-title">{{ $data['heading'] ?? '' }}</h1>
      @if (! empty($data['dek']))
        <p class="mag-stand">{{ $data['dek'] }}</p>
      @endif
    @else
      <h1 id="issue-spread-title">{{ $data['heading'] ?? '' }}</h1>
    @endif
    @include('partials.issue.mag-columns', ['columns' => $data['columns'] ?? [[]]])
    @include('partials.issue.mag-foot', ['data' => $data])
  </div>
</section>
