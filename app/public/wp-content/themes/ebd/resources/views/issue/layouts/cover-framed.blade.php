@php($data = $spread['data'])
<section class="issue-layout mag mag-framed">
  <header class="mag-framed__mast">
    <p class="mag-cover__ebd">EBD</p>
    <p>Ethical Brand Directory Magazine</p>
    <p>{{ $data['issue_line'] ?? 'Issue 01 | Winter 2026' }}</p>
  </header>
  <div class="mag-framed__stage">
    @if (! empty($data['image']))
      <picture>
        <source type="image/avif" srcset="{{ \App\Issue::imageAvif($data['image']) }}">
        <img src="{{ \App\Issue::image($data['image']) }}" alt="{{ $data['image_alt'] ?? '' }}">
      </picture>
    @endif
    <div>
      <h1 id="issue-spread-title">{{ $data['heading'] ?? '' }}</h1>
      <p>{{ $data['dek'] ?? '' }}</p>
    </div>
  </div>
</section>
