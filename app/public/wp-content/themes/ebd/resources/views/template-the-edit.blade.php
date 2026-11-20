{{--
  Template Name: The Edit
  Static demo. Placeholder copy only.
  Later: the brand directory. One card per brand post. Fields live on DemoCatalog::brands().
--}}

@extends('layouts.issue')

@section('content')
  <header class="container px-clamp pt-clamp">
    <p class="issue-kicker">Placeholder · The Edit</p>
    <h1 class="m-0 mt-4 max-w-3xl">Placeholder directory title</h1>
    <p class="m-0 mt-4 max-w-xl text-muted">Placeholder intro. Brand cards, not a database yet.</p>
  </header>

  <div class="container grid gap-6 px-clamp py-clamp md:grid-cols-2">
    @foreach (\App\DemoCatalog::brands() as $brand)
      <article class="border border-line bg-white p-8">
        <p class="issue-kicker">{{ $brand['category'] }}</p>
        <h2 class="m-0 mt-3 text-3xl">{{ $brand['name'] }}</h2>
        <p class="m-0 mt-2 text-sm text-muted">{{ $brand['city'] }}</p>
        <p class="m-0 mt-4">{{ $brand['summary'] }}</p>
      </article>
    @endforeach
  </div>
@endsection
