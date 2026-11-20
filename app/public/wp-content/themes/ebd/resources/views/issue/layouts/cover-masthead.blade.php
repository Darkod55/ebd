@php($data = $spread['data'])
<section
  @class([
    'issue-layout mag mag-cover',
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
  <div @class(['mag-cover__brand', 'is-'.($data['logo'] ?? 'dark')])>
    <x-ebd-logo :variant="$data['logo'] ?? 'dark'" />
    <p class="mag-cover__issue">{{ $data['issue_line'] ?? 'Issue 01 | Winter 2026' }}</p>
  </div>
  <div class="mag-cover__lines">
    <h1 id="issue-spread-title">{{ $data['heading'] ?? 'Show the Love' }}</h1>
    @if (! empty($data['dek']))
      <p>{{ $data['dek'] }}</p>
    @endif
    <ul>
      @foreach ($data['lines'] ?? [] as $line)
        <li>
          <span class="mag-cover__kicker">{{ $line['section'] }}</span>
          <span class="mag-cover__entry">{{ $line['text'] }}</span>
        </li>
      @endforeach
    </ul>
    @if (! empty($data['note']))
      <p class="mag-cover__note">{{ $data['note'] }}</p>
    @endif
  </div>
</section>
