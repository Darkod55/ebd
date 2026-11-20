@php($data = $spread['data'])
@php($figures = [])
@foreach ($data['figures'] ?? [] as $figure)
  @php($figures[$figure['slot'] ?? 'top'] = $figure)
@endforeach
@php($flow = array_values($data['flow'] ?? [80, 40, 40, 80]))
@php($bins = [[], [], [], []])
@php($bin = 0)
@php($count = 0)
@foreach ($data['blocks'] ?? [] as $block)
  @php($words = str_word_count(strip_tags((string) ($block['text'] ?? ''))))
  @if ($bin < 3 && $count > 0 && $count >= ($flow[$bin] ?? 0))
    @php($bin++)
    @php($count = 0)
  @endif
  @php($bins[$bin][] = $block)
  @php($count += $words)
@endforeach
<section class="issue-layout mag mag-edit mag-tri">
  <header class="mag-edit__run">
    <p class="mag-kicker">{{ $data['kicker'] ?? '' }} · Continued</p>
    <h1 id="issue-spread-title">{{ $data['article_title'] ?? ($data['heading'] ?? '') }}</h1>
  </header>
  <div class="mag-tri__cols">
    <div class="mag-tri__col">
      @include('partials.issue.editorial-figure', ['figure' => $figures['top'] ?? null, 'slot' => 'top'])
      <div class="mag-tri__text">
        @include('partials.issue.mag-blocks', ['blocks' => $bins[0]])
      </div>
    </div>
    <div class="mag-tri__col">
      <div class="mag-tri__text">
        @include('partials.issue.mag-blocks', ['blocks' => $bins[1]])
      </div>
      @include('partials.issue.editorial-figure', ['figure' => $figures['mid'] ?? null, 'slot' => 'mid'])
      <div class="mag-tri__text">
        @include('partials.issue.mag-blocks', ['blocks' => $bins[2]])
      </div>
    </div>
    <div class="mag-tri__col">
      <div class="mag-tri__text">
        @include('partials.issue.mag-blocks', ['blocks' => $bins[3]])
      </div>
      @include('partials.issue.editorial-figure', ['figure' => $figures['end'] ?? null, 'slot' => 'end'])
    </div>
  </div>
  <p class="mag-edit__foot">
    <span>Continued</span>
    <span>{{ str_pad((string) ($spread['number'] ?? ''), 2, '0', STR_PAD_LEFT) }} / {{ str_pad((string) ($spread['total'] ?? ''), 2, '0', STR_PAD_LEFT) }}</span>
  </p>
</section>
