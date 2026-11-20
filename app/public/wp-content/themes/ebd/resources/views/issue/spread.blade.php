@extends('layouts.issue-spread')

@section('content')
  @include('issue.layouts.' . $spread['layout'], ['spread' => $spread])
@endsection
