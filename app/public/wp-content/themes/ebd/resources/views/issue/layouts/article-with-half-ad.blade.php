@php($data = $spread['data'])
<section @class(['issue-layout mag mag--half', 'mag--editorial' => ! empty($data['editorial'])])>
  <div class="mag-half__copy">
    <p class="mag-kicker">{{ $data['kicker'] ?? '' }} @if (! empty($data['continued'])) · Continued @endif</p>
    <hr class="mag-rule">
    <h1 id="issue-spread-title">{{ $data['heading'] ?? '' }}</h1>
    @include('partials.issue.mag-columns', ['columns' => $data['columns'] ?? [[]]])
    @if (! empty($data['note']))
      <div class="mag-col" data-placeholder="true">
        <p>{{ $data['note'] }}</p>
      </div>
    @endif
    @include('partials.issue.mag-foot', ['data' => $data])
  </div>
  <div class="mag-half__ad">
    @include('partials.issue.ad-creative', ['ad' => $data['ad'] ?? []])
  </div>
</section>
