@php($data = $spread['data'])
@php($flow = array_values($data['flow'] ?? [90, 90]))
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
<section class="issue-layout mag mag-edit mag-close">
  <header class="mag-edit__run">
    <p class="mag-kicker">{{ $data['kicker'] ?? '' }} · Continued</p>
    <h1 id="issue-spread-title">{{ $data['article_title'] ?? ($data['heading'] ?? '') }}</h1>
  </header>
  <div class="mag-close__board">
    <div class="mag-close__main">
    <div class="mag-tri__text mag-close__col">
      @include('partials.issue.mag-blocks', ['blocks' => $bins[0]])
    </div>
    <div class="mag-tri__text mag-close__col">
      @include('partials.issue.mag-blocks', ['blocks' => $bins[1]])
      @if (! empty($data['qa']))
        <div class="mag-close__qa" data-placeholder="true">
          @foreach ($data['qa'] as $item)
            <p><strong>{{ $item['q'] }}</strong> {{ $item['a'] }}</p>
          @endforeach
        </div>
      @endif
    </div>
    @include('partials.issue.editorial-figure', ['figure' => $data['figure'] ?? null, 'slot' => 'portrait'])
    </div>
    @if (! empty($data['bio']))
      <aside class="mag-close__bio" data-placeholder="true">
        <p class="mag-close__mark" aria-hidden="true"></p>
        <div>
          <p class="mag-close__who">{{ $data['bio']['name'] ?? '' }}</p>
          <p>{{ $data['bio']['text'] ?? '' }}</p>
        </div>
      </aside>
    @endif
  </div>
  <p class="mag-edit__foot">
    <span>Continued</span>
    <span>{{ str_pad((string) ($spread['number'] ?? ''), 2, '0', STR_PAD_LEFT) }} / {{ str_pad((string) ($spread['total'] ?? ''), 2, '0', STR_PAD_LEFT) }}</span>
  </p>
</section>
