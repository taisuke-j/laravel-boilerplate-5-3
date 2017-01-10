@extends('layouts.main')

@section('title', $page->title)

@section('content')

<h1>{{ $page->title }}</h1>

{!! $page->content !!}

@stop

@section('javascript')
	@parent
@endsection
