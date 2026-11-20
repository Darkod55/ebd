@php($data = $spread['data'])
@php($pattern = $data['pattern'] ?? 'corners')
@php($figures = [])
@foreach ($data['figures'] ?? [] as $figure)
  @php($figures[$figure['slot'] ?? 'a'] = $figure)
@endforeach
<section @class(['issue-layout mag mag-edit', 'mag-edit--'.$pattern])>
  <header class="mag-edit__run">
    <p class="mag-kicker">{{ $data['kicker'] ?? '' }} · Continued</p>
    <h1 id="issue-spread-title">{{ $data['article_title'] ?? ($data['heading'] ?? '') }}</h1>
  </header>
  <div class="mag-edit__board">
    @php($columns = array_values($data['columns'] ?? []))
    @include('partials.issue.editorial-figure', ['figure' => $figures['a'] ?? null, 'slot' => 'a'])
    <div class="mag-edit__col mag-edit__col--0">
      @include('partials.issue.mag-blocks', ['blocks' => $columns[0] ?? []])
      @if (count($columns) < 2 && ! empty($data['callout']))
        <aside class="mag-edit__stat">
          <p>{{ $data['callout']['kicker'] ?? '' }}</p>
          <p>{{ $data['callout']['line'] ?? '' }}</p>
        </aside>
      @endif
    </div>
    @include('partials.issue.editorial-figure', ['figure' => $figures['b'] ?? null, 'slot' => 'b'])
    @if (isset($columns[1]))
      <div class="mag-edit__col mag-edit__col--1">
        @include('partials.issue.mag-blocks', ['blocks' => $columns[1]])
        @if (! empty($data['callout']))
          <aside class="mag-edit__stat">
            <p>{{ $data['callout']['kicker'] ?? '' }}</p>
            <p>{{ $data['callout']['line'] ?? '' }}</p>
          </aside>
        @endif
      </div>
    @endif
    @include('partials.issue.editorial-figure', ['figure' => $figures['c'] ?? null, 'slot' => 'c'])
  </div>
  <p class="mag-edit__foot">
    <span>Continued</span>
    <span>{{ str_pad((string) ($spread['number'] ?? ''), 2, '0', STR_PAD_LEFT) }} / {{ str_pad((string) ($spread['total'] ?? ''), 2, '0', STR_PAD_LEFT) }}</span>
  </p>
</section>
