@if (! empty($figure['file']))
  <figure @class(['mag-edit__fig', 'mag-edit__fig--'.$slot])>
    <picture>
      <source type="image/avif" srcset="{{ \App\Issue::imageAvif($figure['file']) }}">
      <img
        src="{{ \App\Issue::image($figure['file']) }}"
        alt="{{ $figure['alt'] ?? '' }}"
        @if (! empty($figure['position'])) style="object-position: {{ $figure['position'] }}" @endif
      >
    </picture>
    @if (! empty($figure['caption']))
      <figcaption>{{ $figure['caption'] }}</figcaption>
    @endif
  </figure>
@endif
