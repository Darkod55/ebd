<header class="border-b border-line bg-white">
  <div class="container flex flex-wrap items-baseline justify-between gap-x-8 gap-y-3 px-clamp py-4">
    <a href="{{ \App\DemoCatalog::url('issue-01') }}" class="font-heading text-3xl leading-none text-secondary no-underline">
      Ethical Brand Directory
    </a>

    <nav aria-label="Placeholder navigation">
      <ul class="m-0 flex list-none flex-wrap gap-x-5 gap-y-2 p-0 text-sm">
        @foreach (\App\DemoCatalog::nav() as $item)
          <li>
            <a class="text-body no-underline hover:text-primary" href="{{ \App\DemoCatalog::url($item['key']) }}">
              {{ $item['label'] }}
            </a>
          </li>
        @endforeach
      </ul>
    </nav>
  </div>
</header>
