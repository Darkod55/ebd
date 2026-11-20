{{--
  Placeholder advertisement. variant: overlay | panel | poster
--}}
@php($ad = $ad ?? [])
<aside class="ad ad--{{ $ad['variant'] ?? 'overlay' }}" aria-label="Placeholder advertisement">
  @if (! empty($ad['image']))
    <picture>
      <source type="image/avif" srcset="{{ \App\Issue::imageAvif($ad['image']) }}">
      <img src="{{ \App\Issue::image($ad['image']) }}" alt="{{ $ad['image_alt'] ?? '' }}">
    </picture>
  @endif
  <div class="ad__panel">
    <p class="ad__flag">Placeholder ad</p>
    <p class="ad__mark" aria-hidden="true">{{ $ad['mark'] ?? '' }}</p>
    <p class="ad__brand">{{ $ad['brand'] ?? '' }}</p>
    @if (! empty($ad['tagline']))
      <p class="ad__tag">{{ $ad['tagline'] }}</p>
    @endif
    @if (! empty($ad['services']))
      <ul>
        @foreach ($ad['services'] as $service)
          <li>{{ $service }}</li>
        @endforeach
      </ul>
    @endif
    @if (! empty($ad['url']))
      <p class="ad__url">Discover more → {{ $ad['url'] }}</p>
    @endif
  </div>
</aside>
