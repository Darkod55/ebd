@php($data = $spread['data'])
@php($flow = array_values($data['flow'] ?? [100, 100]))
@php($bins = [[], []])
@php($bin = 0)
@php($count = 0)
@foreach ($data['blocks'] ?? [] as $block)
  @php($words = str_word_count(strip_tags((string) ($block['text'] ?? ''))))
  @if ($bin < 1 && $count > 0 && $count >= ($flow[$bin] ?? 0))
    @php($bin++)
    @php($count = 0)
  @endif
  @php($bins[$bin][] = $block)
  @php($count += $words)
@endforeach
<section class="issue-layout mag mag-edit mag-feat">
  <header class="mag-edit__run">
    <p class="mag-kicker">{{ $data['kicker'] ?? '' }} · Continued</p>
    <h1 id="issue-spread-title">{{ $data['article_title'] ?? ($data['heading'] ?? '') }}</h1>
  </header>
  <div class="mag-feat__board">
    <div class="mag-feat__main">
    @include('partials.issue.editorial-figure', ['figure' => $data['figure'] ?? null, 'slot' => 'lead'])
    <div class="mag-tri__text mag-feat__col">
      @include('partials.issue.mag-blocks', ['blocks' => $bins[0]])
      @if (! empty($data['notes'][0]))
        <p data-placeholder="true">{{ $data['notes'][0] }}</p>
      @endif
    </div>
    <div class="mag-tri__text mag-feat__col">
      @include('partials.issue.mag-blocks', ['blocks' => $bins[1]])
      @if (! empty($data['notes'][1]))
        <p data-placeholder="true">{{ $data['notes'][1] }}</p>
      @endif
    </div>
    </div>
    @if (! empty($data['stats']))
      <div class="mag-feat__stats">
        @foreach ($data['stats'] as $stat)
          <p data-placeholder="true">
            <strong>{{ $stat['kicker'] ?? '' }}</strong>
            <span>{{ $stat['line'] ?? '' }}</span>
          </p>
        @endforeach
      </div>
    @endif
  </div>
  <p class="mag-edit__foot">
    <span>Continued</span>
    <span>{{ str_pad((string) ($spread['number'] ?? ''), 2, '0', STR_PAD_LEFT) }} / {{ str_pad((string) ($spread['total'] ?? ''), 2, '0', STR_PAD_LEFT) }}</span>
  </p>
</section>
