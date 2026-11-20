<section class="issue-layout mag mag-contents">
  <header>
    <p class="mag-kicker">Contents</p>
    <hr class="mag-rule">
    <h1 id="issue-spread-title">In this issue</h1>
  </header>
  <ol class="mag-contents__list">
    @foreach ($spreads as $item)
      <li>
        <a href="{{ $item['url'] }}">
          <span>{{ str_pad((string) $item['number'], 2, '0', STR_PAD_LEFT) }}</span>
          <span>{{ $item['title'] }}</span>
        </a>
      </li>
    @endforeach
  </ol>
</section>
