<p class="mag-foot">
  <span>{{ $data['kicker'] ?? 'Issue 01' }}@if (! empty($data['continued'])) · Continued @endif</span>
  @if (! empty($data['words']))
    <span>About {{ number_format((int) $data['words']) }} words</span>
  @endif
  @if (! empty($data['single_url']))
    <a href="{{ $data['single_url'] }}">Single-page version</a>
  @endif
</p>
