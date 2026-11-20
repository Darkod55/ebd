@php($data = $spread['data'])
<section class="issue-layout mag mag--three">
  <header class="mag-run">
    <p class="mag-kicker">{{ $data['kicker'] ?? '' }} @if (! empty($data['continued'])) · Continued @endif</p>
    <h1 id="issue-spread-title">{{ $data['heading'] ?? '' }}</h1>
  </header>
  @include('partials.issue.mag-columns', ['columns' => $data['columns'] ?? [[]]])
  @include('partials.issue.mag-foot', ['data' => $data])
</section>
