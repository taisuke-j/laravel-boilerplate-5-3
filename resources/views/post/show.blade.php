@extends('layouts.main')

@section('title', $post->title)

@section('content')

<h1>{{ $post->title }}</h1>

{!! $post->content !!}

@stop

@section('javascript')
	@parent
@endsection
