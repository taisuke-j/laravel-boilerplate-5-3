@extends('layouts.admin')

@section('title', trans('admin.page_title.dashboard'))

@section('content')

<section>
	<h1>{{ trans('admin.page_title.dashboard') }}</h1>
</section>

<p>You're now logged in.</p>

@endsection

@section('sidebar')
	<h3>Sidebar</h3>
	<p>Bourbon Neat is used for grid system in this example.</p>
@stop

@section('javascript')
	@parent
@endsection
