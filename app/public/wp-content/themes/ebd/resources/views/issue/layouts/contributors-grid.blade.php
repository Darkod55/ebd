@php($data = $spread['data'])
<section class="issue-layout mag mag-people">
  <header>
    <p class="mag-kicker">Contributors</p>
    <hr class="mag-rule">
    <h1 id="issue-spread-title">The people in this issue</h1>
  </header>
  <ul>
    @foreach ($data['people'] ?? [] as $person)
      <li>
        @if (! empty($person['image']))
          <picture>
            <source type="image/avif" srcset="{{ \App\Issue::imageAvif($person['image']) }}">
            <img src="{{ \App\Issue::image($person['image']) }}" alt="Portrait of {{ $person['name'] }}">
          </picture>
        @else
          <div class="mag-people__empty">Placeholder portrait</div>
        @endif
        <p>{{ $person['name'] }}</p>
        <span>{{ $person['role'] ?? '' }}</span>
      </li>
    @endforeach
  </ul>
</section>
