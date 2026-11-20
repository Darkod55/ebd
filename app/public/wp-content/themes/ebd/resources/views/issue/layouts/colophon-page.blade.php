@php($data = $spread['data'])
<section class="issue-layout mag mag-colo">
  <header>
    <p class="mag-cover__ebd">EBD</p>
    <h1 id="issue-spread-title">Masthead</h1>
    <p>{{ $data['issue_line'] ?? 'Issue 01 | Winter 2026' }}</p>
  </header>
  <div class="mag-colo__cols">
    @foreach ($data['groups'] ?? [] as $group)
      <section>
        <h2>{{ $group['label'] }}</h2>
        <ul>
          @foreach ($group['lines'] as $line)
            <li>{{ $line }}</li>
          @endforeach
        </ul>
      </section>
    @endforeach
  </div>
</section>
