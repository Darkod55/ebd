@php($data = $spread['data'])
<section class="issue-layout mag mag--quote">
  <blockquote class="mag-pull">
    <p id="issue-spread-title">{{ $data['quote'] ?? '' }}</p>
  </blockquote>
  <div class="mag-half__copy">
    <p class="mag-kicker">{{ $data['kicker'] ?? '' }} · Continued</p>
    <hr class="mag-rule">
    @include('partials.issue.mag-columns', ['columns' => $data['columns'] ?? [[]]])
    @include('partials.issue.mag-foot', ['data' => $data])
  </div>
</section>
