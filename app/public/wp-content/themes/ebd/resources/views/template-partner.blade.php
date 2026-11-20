{{--
  Template Name: Partner with us
  Static demo. Placeholder copy only.
  Later: a page. Fields live on DemoCatalog::partner().
--}}

@extends('layouts.issue')

@section('content')
  @php($partner = \App\DemoCatalog::partner())

  <article class="container grid items-start gap-12 px-clamp py-clamp lg:grid-cols-2">
    <div>
      <p class="issue-kicker">{{ $partner['kicker'] }}</p>
      <h1 class="m-0 mt-4">{{ $partner['title'] }}</h1>
      @foreach ($partner['paragraphs'] as $paragraph)
        <p>{{ $paragraph }}</p>
      @endforeach
      <p>
        <a class="btn btn-secondary" href="{{ \App\DemoCatalog::url('contact') }}">Placeholder · Talk to us</a>
      </p>
    </div>
    @include('partials.issue.ad-slot')
  </article>
@endsection
