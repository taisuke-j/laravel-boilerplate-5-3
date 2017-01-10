@extends('layouts.admin')

@section('title', trans('category.page_title.create'))

@section('content')

<h1>{{ trans('category.page_title.create') }}</h1>

<form method="post" action="{{ url('/admin/'.$model.'/category/store') }}" class="vertical-form">
	{{ csrf_field() }}
	<input type="hidden" name="type" value="{{ $model }}">

	<div class="vertical-form-row">
		<div class="label-column">
			<label for="name">
				<strong>{{ trans('category.label.name') }}</strong>
			</label>
		</div>
		<div class="field-column">
			<input class="full-width border-bottom" type="text" name="name" id="name" value="{{ old('name') }}">
			<div class="error-text">{{ $errors->first('name') }}</div>
		</div>
	</div>
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="slug">
				<strong>{{ trans('category.label.slug') }}</strong>
			</label>
		</div>
		<div class="field-column">
			<input class="full-width border-bottom" type="text" name="slug" id="slug" value="{{ old('slug') }}">
			<div class="error-text">{{ $errors->first('slug') }}</div>
		</div>
	</div>
	<div class="vertical-form-row button-row">
		<div class="field-column">
			<input class="button" type="submit" value="{{ trans('category.button.submit.create') }}">
		</div>
	</div>
</form>

@stop

@section('sidebar')
	<h3>Sidebar</h3>
	<p>Bourbon Neat is used for grid system in this example.</p>
@stop

@section('javascript')
	@parent
@endsection
