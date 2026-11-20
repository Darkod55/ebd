{{--
  Template Name: About
  Static demo. Placeholder copy only.
  Later: an About page. Fields live on DemoCatalog::about().
--}}

@extends('layouts.issue')

@section('content')
  @php($about = \App\DemoCatalog::about())

  <article class="container px-clamp py-clamp">
    <div class="max-w-3xl">
      <p class="issue-kicker">{{ $about['kicker'] }}</p>
      <h1 class="m-0 mt-4">{{ $about['title'] }}</h1>
      @foreach ($about['paragraphs'] as $paragraph)
        <p class="text-lg">{{ $paragraph }}</p>
      @endforeach
    </div>
  </article>
@endsection
