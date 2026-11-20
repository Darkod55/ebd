{{--
  Template Name: Issue 01 — Cover
  Static demo. Placeholder copy only.
  Later: the front page. Fields live on DemoCatalog::issue().
--}}

@extends('layouts.issue')

@section('content')
  @php($issue = \App\DemoCatalog::issue())

  <section class="issue-cover flex min-h-[80svh] flex-col justify-end bg-black text-on-dark">
    <div class="container px-clamp py-16">
      <p class="issue-kicker">{{ $issue['kicker'] }}</p>
      <hr class="issue-rule mt-6">
      <h1 class="m-0 mt-6 max-w-4xl text-on-dark">{{ $issue['title'] }}</h1>
      <p class="m-0 mt-6 max-w-xl text-lg font-light text-on-dark">{{ $issue['deck'] }}</p>
      <p class="m-0 mt-8 text-sm tracking-[0.2em] text-primary uppercase">{{ $issue['edition'] }}</p>
    </div>
  </section>

  <section class="container px-clamp py-clamp">
    <p class="issue-kicker">Placeholder · In this issue</p>
    <div class="mt-8 grid gap-10 md:grid-cols-3">
      @foreach ($issue['features'] as $feature)
        <article>
          <div class="issue-swatch" role="img" aria-label="Placeholder image"></div>
          <p class="issue-kicker mt-5">{{ $feature['kicker'] }}</p>
          <h2 class="m-0 mt-3 text-3xl">
            <a class="text-secondary no-underline hover:text-primary" href="{{ $feature['href'] }}">{{ $feature['title'] }}</a>
          </h2>
          <p class="m-0 mt-3 text-sm text-muted">{{ $feature['author'] }}</p>
        </article>
      @endforeach
    </div>
  </section>

  <div class="container px-clamp pb-clamp">
    @include('partials.issue.ad-slot')
  </div>
@endsection
