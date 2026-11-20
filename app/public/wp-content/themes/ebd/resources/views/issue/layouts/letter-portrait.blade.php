@php($data = $spread['data'])
<section class="issue-layout mag mag--opener">
  <div class="mag-opener__copy">
    <p class="mag-kicker">{{ $data['kicker'] ?? 'Letter' }}</p>
    <hr class="mag-rule">
    <h1 id="issue-spread-title">{{ $data['heading'] ?? '' }}</h1>
    <div class="mag-letter">
      @foreach ($data['paragraphs'] ?? [] as $paragraph)
        <p>{{ $paragraph }}</p>
      @endforeach
      <p class="mag-sign">{{ $data['sign'] ?? '' }}<span>{{ $data['sign_role'] ?? '' }}</span></p>
    </div>
    @include('partials.issue.mag-foot', ['data' => $data])
  </div>
  <div class="mag-opener__media">
    @if (! empty($data['image']))
      <picture>
        <source type="image/avif" srcset="{{ \App\Issue::imageAvif($data['image']) }}">
        <img src="{{ \App\Issue::image($data['image']) }}" alt="{{ $data['image_alt'] ?? 'Placeholder portrait' }}">
      </picture>
    @endif
    @if (! empty($data['image_note']))
      <p>{{ $data['image_note'] }}</p>
    @endif
  </div>
</section>
