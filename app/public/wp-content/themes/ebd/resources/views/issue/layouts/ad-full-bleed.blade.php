@php($ad = $spread['data']['ad'] ?? [])
<section class="issue-layout mag mag-adpage">
  <h1 id="issue-spread-title" class="sr-only">{{ $ad['brand'] ?? 'Advertisement' }}</h1>
  @include('partials.issue.ad-creative', ['ad' => array_merge($ad, ['variant' => $ad['variant'] ?? 'overlay'])])
</section>
