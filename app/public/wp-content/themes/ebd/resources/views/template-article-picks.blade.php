{{--
  Template Name: Article — Editor’s picks
  Static demo. Placeholder copy only.
  Later: a beauty article whose product grid is a repeater. Fields live on DemoCatalog::picks().
--}}

@extends('layouts.issue')

@section('content')
  @php($article = \App\DemoCatalog::picks())

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

    <div class="mx-auto mt-12 grid max-w-5xl gap-8 sm:grid-cols-2 lg:grid-cols-4">
      @foreach ($article['products'] as $product)
        <article>
          <div class="issue-swatch" role="img" aria-label="Placeholder product image"></div>
          <p class="issue-kicker mt-4">{{ $product['brand'] }}</p>
          <h2 class="m-0 mt-2 text-2xl">{{ $product['name'] }}</h2>
          <p class="m-0 mt-2 text-sm text-muted">{{ $product['note'] }}</p>
        </article>
      @endforeach
    </div>

    <div class="mx-auto mt-12 max-w-5xl">
      @include('partials.issue.ad-slot')
    </div>
  </article>
@endsection
