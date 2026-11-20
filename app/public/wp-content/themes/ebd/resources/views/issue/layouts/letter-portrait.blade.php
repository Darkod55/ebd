@php($data = $spread['data'])
<section class="issue-layout mag mag--letter">
  <div class="mag-letter__copy">
    <div class="mag-letter__sheet">
      <p class="mag-kicker">{{ $data['kicker'] ?? 'Letter' }}</p>
      <h1 id="issue-spread-title">
        <span>Letter from</span>
        <span>the Editor</span>
      </h1>
      @if (! empty($data['stand']))
        <p class="mag-letter__stand">{{ $data['stand'] }}</p>
      @endif
      <div class="mag-letter__body">
        @foreach ($data['paragraphs'] ?? [] as $paragraph)
          <p @class(['mag-drop' => $loop->first])>{{ $paragraph }}</p>
        @endforeach
      </div>
      <p class="mag-sign">{{ $data['sign'] ?? '' }}<span>{{ $data['sign_role'] ?? '' }}</span></p>
      @if (! empty($data['flag']))
        <p class="mag-letter__flag">{{ $data['flag'] }}</p>
      @endif
    </div>
  </div>
  <div class="mag-letter__media">
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
