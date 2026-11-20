@php($data = $spread['data'])
<section class="issue-layout mag mag-f1">
  @if (! empty($data['image']))
    <picture>
      <source type="image/avif" srcset="{{ \App\Issue::imageAvif($data['image']) }}">
      <img src="{{ \App\Issue::image($data['image']) }}" alt="{{ $data['image_alt'] ?? '' }}">
    </picture>
  @endif
  <div class="mag-f1__shade" aria-hidden="true"></div>
  <div class="mag-f1__copy">
    <p class="mag-f1__kicker">{{ $data['kicker'] ?? '' }}</p>
    <h1 id="issue-spread-title">{{ $data['heading'] ?? $spread['title'] }}</h1>
    @if (! empty($data['dek']))
      <p class="mag-f1__stand">{{ $data['dek'] }}</p>
    @endif
    @if (! empty($data['byline']))
      <p class="mag-f1__by">{{ $data['byline'] }}@if (! empty($data['role'])) <span>{{ $data['role'] }}</span>@endif</p>
    @endif
    @if (! empty($data['note']))
      <p class="mag-f1__note">{{ $data['note'] }}</p>
    @endif
  </div>
</section>
