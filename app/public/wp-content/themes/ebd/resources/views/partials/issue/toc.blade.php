<nav class="border-t border-line pt-6" aria-label="Placeholder contents">
  <p class="issue-kicker">Placeholder · Contents</p>
  <ol class="m-0 mt-4 list-decimal space-y-2 pl-5 text-sm">
    @foreach ($toc as $item)
      <li>
        <a class="text-secondary no-underline hover:text-primary" href="#{{ $item['id'] }}">{{ $item['label'] }}</a>
      </li>
    @endforeach
  </ol>
</nav>
