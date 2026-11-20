<p class="m-0 mt-4 flex flex-wrap gap-x-4 gap-y-1 text-sm text-muted">
  <span class="text-secondary">{{ $author }}</span>
  @if (! empty($role))
    <span>{{ $role }}</span>
  @endif
  @if (! empty($date))
    <span>{{ $date }}</span>
  @endif
</p>
