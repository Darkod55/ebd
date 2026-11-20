@php($data = $spread['data'])
<section class="issue-layout mag mag-framed">
  <header @class(['mag-framed__mast', 'is-'.($data['logo'] ?? 'dark')])>
    <x-ebd-logo :variant="$data['logo'] ?? 'dark'" />
    <p class="mag-cover__issue">{{ $data['issue_line'] ?? 'Issue 01 | Winter 2026' }}</p>
  </header>
  <div
    @class([
      'mag-framed__stage',
      'mag-cover--scrim-'.($data['scrim'] ?? 'dark'),
      'mag-cover--panel' => ! empty($data['panel']),
    ])
    style="--scrim-strength: {{ $data['scrim_strength'] ?? 0.84 }}"
  >
    @if (! empty($data['image']))
      <picture>
        <source type="image/avif" srcset="{{ \App\Issue::imageAvif($data['image']) }}">
        <img src="{{ \App\Issue::image($data['image']) }}" alt="{{ $data['image_alt'] ?? '' }}">
      </picture>
    @endif
    <div class="mag-cover__shade" aria-hidden="true"></div>
    <div class="mag-framed__copy">
      <h1 id="issue-spread-title">{{ $data['heading'] ?? '' }}</h1>
      <p>{{ $data['dek'] ?? '' }}</p>
    </div>
  </div>
</section>
