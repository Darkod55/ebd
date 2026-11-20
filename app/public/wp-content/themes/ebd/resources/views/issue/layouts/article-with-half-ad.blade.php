@php($data = $spread['data'])
<section @class(['issue-layout mag mag--half', 'mag--editorial' => ! empty($data['editorial'])])>
  <div class="mag-half__copy">
    <p class="mag-kicker">{{ $data['kicker'] ?? '' }} @if (! empty($data['continued'])) · Continued @endif</p>
    <hr class="mag-rule">
    <h1 id="issue-spread-title">{{ $data['heading'] ?? '' }}</h1>
    @if (! empty($data['editorial']))
      <div class="mag-tri__text mag-fill">
        @include('partials.issue.mag-blocks', ['blocks' => $data['columns'][0] ?? []])
        @foreach ($data['notes'] ?? [] as $note)
          <p data-placeholder="true">{{ $note }}</p>
        @endforeach
        @foreach ($data['tall'] ?? [] as $note)
          <p class="mag-tall" data-placeholder="true">{{ $note }}</p>
        @endforeach
      </div>
    @else
      @include('partials.issue.mag-columns', ['columns' => $data['columns'] ?? [[]]])
    @endif
    @include('partials.issue.mag-foot', ['data' => $data])
  </div>
  <div class="mag-half__ad">
    @include('partials.issue.ad-creative', ['ad' => $data['ad'] ?? []])
  </div>
</section>
