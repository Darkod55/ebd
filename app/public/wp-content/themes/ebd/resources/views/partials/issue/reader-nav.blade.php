<nav class="issue-nav" aria-label="Placeholder issue">
  <div id="issue-pager" class="issue-nav__pager">
    @if ($spread['prev'])
      <a id="issue-prev" class="issue-nav__arrow" href="{{ $spread['prev']['url'] }}" data-spread-url rel="prev" aria-label="Previous spread">
        <span aria-hidden="true">←</span>
      </a>
    @else
      <span id="issue-prev" class="issue-nav__arrow is-disabled" aria-disabled="true" aria-label="Previous spread">
        <span aria-hidden="true">←</span>
      </span>
    @endif

    <details id="issue-overview" class="issue-overview">
      <summary id="issue-progress-btn" aria-label="Spread {{ $spread['number'] }} of {{ $spread['total'] }}. Show all spreads.">
        <span id="issue-progress">{{ $spread['number'] }} / {{ $spread['total'] }}</span>
      </summary>
      <div class="issue-overview__panel">
        <ol id="issue-overview-list" class="issue-overview__list">
          @foreach ($spreads as $item)
            <li>
              <a
                href="{{ $item['url'] }}"
                data-spread-url
                @if ($item['current']) aria-current="page" @endif
              >
                <span class="issue-overview__thumb">
                  @if (! empty($item['thumbnail']))
                    <img src="{{ $item['thumbnail'] }}" alt="">
                  @else
                    {{ $item['number'] }}
                  @endif
                </span>
                <span class="issue-overview__caption">{{ $item['title'] }}</span>
              </a>
            </li>
          @endforeach
        </ol>
      </div>
    </details>

    @if ($spread['next'])
      <a id="issue-next" class="issue-nav__arrow" href="{{ $spread['next']['url'] }}" data-spread-url rel="next" aria-label="Next spread">
        <span aria-hidden="true">→</span>
      </a>
    @else
      <span id="issue-next" class="issue-nav__arrow is-disabled" aria-disabled="true" aria-label="Next spread">
        <span aria-hidden="true">→</span>
      </span>
    @endif
  </div>

  <details id="issue-menu" class="issue-menu">
    <summary>Menu</summary>
    <ul class="issue-menu__list">
      @foreach ($menu as $item)
        <li><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
      @endforeach
    </ul>
  </details>
</nav>
