@extends('layouts.app-wide')

@section('content')
  <div class="home">
    @include('sections.home.hero')
    @include('sections.home.stats')
    @include('sections.home.audiences')
    @include('sections.home.about')
    @include('sections.home.stages')
    @include('sections.home.services')
    @include('sections.home.technology')
    @include('sections.home.process')
    @include('sections.home.cta')
    @include('sections.home.testimonials')
    @include('sections.home.faq')
    @include('sections.home.contact')
  </div>
@endsection
