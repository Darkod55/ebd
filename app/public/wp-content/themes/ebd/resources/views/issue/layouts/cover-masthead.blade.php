@php($data = $spread['data'])
<section class="issue-layout mag mag-cover">
  @if (! empty($data['image']))
    <picture>
      <source type="image/avif" srcset="{{ \App\Issue::imageAvif($data['image']) }}">
      <img src="{{ \App\Issue::image($data['image']) }}" alt="{{ $data['image_alt'] ?? '' }}">
    </picture>
  @endif
  <div class="mag-cover__shade"></div>
  <header class="mag-cover__mast">
    <p class="mag-cover__ebd">EBD</p>
    <p>Ethical Brand Directory Magazine</p>
    <p>{{ $data['issue_line'] ?? 'Issue 01 | Winter 2026' }}</p>
  </header>
  <div class="mag-cover__lines">
    <h1 id="issue-spread-title">{{ $data['heading'] ?? 'Show the Love' }}</h1>
    @if (! empty($data['dek']))
      <p>{{ $data['dek'] }}</p>
    @endif
    <ul>
      @foreach ($data['lines'] ?? [] as $line)
        <li><span>{{ $line['section'] }}</span> {{ $line['text'] }}</li>
      @endforeach
    </ul>
    @if (! empty($data['note']))
      <p class="mag-cover__note">{{ $data['note'] }}</p>
    @endif
  </div>
</section>
