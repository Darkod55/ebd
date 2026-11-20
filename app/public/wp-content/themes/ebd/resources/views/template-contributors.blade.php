{{--
  Template Name: Contributors
  Static demo. Placeholder copy only.
  Later: a contributor post type. Fields live on DemoCatalog::contributors().
--}}

@extends('layouts.issue')

@section('content')
  <header class="container px-clamp pt-clamp">
    <p class="issue-kicker">Placeholder · Contributors</p>
    <h1 class="m-0 mt-4">Placeholder contributors title</h1>
  </header>

  <div class="container grid gap-10 px-clamp py-clamp md:grid-cols-3">
    @foreach (\App\DemoCatalog::contributors() as $person)
      <article>
        <div class="issue-swatch max-w-48" role="img" aria-label="Placeholder portrait"></div>
        <h2 class="m-0 mt-4 text-3xl">{{ $person['name'] }}</h2>
        <p class="issue-kicker mt-2">{{ $person['role'] }}</p>
        <p class="m-0 mt-3 text-muted">{{ $person['bio'] }}</p>
      </article>
    @endforeach
  </div>
@endsection
