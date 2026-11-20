{{--
  Template Name: Article
  Static demo. Placeholder copy only.
  Later: a single article. Fields live on DemoCatalog::article().
--}}

@extends('layouts.issue')

@section('content')
  @php($article = \App\DemoCatalog::article())

  <article class="container px-clamp py-clamp">
    <header class="mx-auto max-w-3xl">
      <p class="issue-kicker">{{ $article['kicker'] }}</p>
      <h1 class="m-0 mt-4">{{ $article['title'] }}</h1>
      <p class="m-0 mt-4 text-lg text-muted">{{ $article['deck'] }}</p>
      @include('partials.issue.byline', [
        'author' => $article['author'],
        'role' => $article['role'],
        'date' => $article['date'],
      ])
    </header>

    <div class="mx-auto mt-10 grid max-w-5xl gap-10 lg:grid-cols-[16rem_minmax(0,1fr)]">
      @include('partials.issue.toc', ['toc' => $article['toc']])

      <div class="max-w-xl">
        @foreach ($article['sections'] as $section)
          <section id="{{ $section['id'] }}" class="mb-10">
            <h2>{{ $section['heading'] }}</h2>
            <p>{{ $section['body'] }}</p>
          </section>
        @endforeach

        @include('partials.issue.ad-slot')
      </div>
    </div>
  </article>
@endsection
