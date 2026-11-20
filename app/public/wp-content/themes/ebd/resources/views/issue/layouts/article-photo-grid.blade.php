@php($data = $spread['data'])
<section class="issue-layout mag mag-edit mag-photos">
  <header class="mag-edit__run">
    <p class="mag-kicker">{{ $data['kicker'] ?? '' }} · Continued</p>
    <h1 id="issue-spread-title">{{ $data['article_title'] ?? ($data['heading'] ?? '') }}</h1>
  </header>
  <div class="mag-photos__board">
    <div class="mag-photos__main">
    <div class="mag-tri__text mag-photos__copy">
      @if (! empty($data['aside']))
        <p class="mag-photos__label" data-placeholder="true">{{ $data['aside']['kicker'] ?? '' }}</p>
      @endif
      @include('partials.issue.mag-blocks', ['blocks' => $data['blocks'] ?? []])
      @if (! empty($data['aside']['text']))
        <p class="mag-photos__note" data-placeholder="true">{{ $data['aside']['text'] }}</p>
      @endif
    </div>
    <div class="mag-photos__grid">
      @foreach ($data['figures'] ?? [] as $figure)
        @include('partials.issue.editorial-figure', ['figure' => $figure, 'slot' => $figure['slot'] ?? 'a'])
      @endforeach
    </div>
    </div>
    @if (! empty($data['band']))
      <div class="mag-pair__band" data-placeholder="true">
        @foreach ($data['band'] as $stat)
          <p>
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
