@php($data = $spread['data'])
<section class="issue-layout mag mag-brands">
  <header>
    <p class="mag-kicker">The Edit</p>
    <hr class="mag-rule">
    <h1 id="issue-spread-title">{{ $data['heading'] ?? 'The Edit' }}</h1>
    <p class="mag-stand">{{ $data['dek'] ?? '' }}</p>
  </header>
  <ul class="mag-brands__grid">
    @foreach ($data['brands'] ?? [] as $brand)
      <li>
        @if (! empty($brand['image']))
          <picture>
            <source type="image/avif" srcset="{{ \App\Issue::imageAvif($brand['image']) }}">
            <img src="{{ \App\Issue::image($brand['image']) }}" alt="">
          </picture>
        @endif
        <p>{{ $brand['name'] }}</p>
        @if (! empty($brand['placeholder']))
          <span>Placeholder image</span>
        @endif
      </li>
    @endforeach
  </ul>
</section>
