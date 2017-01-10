@extends('layouts.admin')

@section('title', trans('admin.page_title.account'))

@section('content')

<h1>{{ trans('admin.page_title.account') }}</h1>

<form method="post" action="{{ url('/admin/settings/account') }}" class="vertical-form">
	{{ csrf_field() }}
	{{ method_field('patch') }}

	<div class="vertical-form-row">
		<div class="label-column">
			<label for="name">
				<strong>{{ trans('user.label.name') }}</strong>
			</label>
		</div>
		<div class="field-column">
			<input class="full-width border-bottom" type="text" name="name" id="name" value="{{ old('name', $user->name) }}">
			<div class="error-text">{{ $errors->first('name') }}</div>
		</div>
	</div>
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="password">
				<strong>{{ trans('user.label.new_password') }}</strong>
			</label>
		</div>
		<div class="field-column">
			<input class="full-width border-bottom" type="password" name="password" id="password" value="{{ old('password') }}">
			<div class="error-text">{{ $errors->first('password') }}</div>
		</div>
	</div>
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="password_confirmation">
				<strong>{{ trans('user.label.password_confirmation') }}</strong>
			</label>
		</div>
		<div class="field-column">
			<input class="full-width border-bottom" type="password" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}">
			<div class="error-text">{{ $errors->first('password_confirmation') }}</div>
		</div>
	</div>
	<div class="vertical-form-row button-row">
		<div class="field-column">
			<input type="submit" value="{{ trans('product.button.submit.edit') }}" class="button">
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
