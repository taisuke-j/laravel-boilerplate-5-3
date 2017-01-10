@extends('layouts.admin')

@section('title', trans('user.page_title.create'))

@section('content')

<h1>{{ trans('user.page_title.create') }}</h1>

<form method="post" action="{{ action('UserController@store') }}" class="vertical-form">
	{{ csrf_field() }}

	<div class="vertical-form-row">
		<div class="label-column">
			<label for="name">
				<strong>{{ trans('user.label.name') }}</strong>
			</label>
		</div>
		<div class="field-column">
			<input class="full-width border-bottom" type="text" name="name" id="name" value="{{ old('name') }}">
			<div class="error-text">{{ $errors->first('name') }}</div>
		</div>
	</div>
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="name">
				<strong>{{ trans('user.label.email') }}</strong>
			</label>
		</div>
		<div class="field-column">
			<input class="full-width border-bottom" type="email" name="email" id="email" value="{{ old('email') }}">
			<div class="error-text">{{ $errors->first('email') }}</div>
		</div>
	</div>
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="password">
				<strong>{{ trans('user.label.password') }}</strong>
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
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="role">
				<strong>{{ trans('user.label.role') }}</strong>
			</label>
		</div>
		<div class="field-column select-field">
			<select name="role" id="role" style="width: 250px;">
				@foreach ($role_list as $key => $role)
					<option value="{{ $key }}" @if (old('role') === $key) selected @endif>{{ $role }}</option>
				@endforeach
			</select>
			<div class="error-text">{{ $errors->first('role') }}</div>
		</div>
	</div>
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="status">
				<strong>{{ trans('user.label.status') }}</strong>
			</label>
		</div>
		<div class="field-column select-field">
			<select name="status" id="status" style="width: 250px;">
				@foreach ($status_list as $key => $status)
					<option value="{{ $key }}" @if (old('status') === $key) selected @endif>{{ $status }}</option>
				@endforeach
			</select>
			<div class="error-text">{{ $errors->first('status') }}</div>
		</div>
	</div>
	<div class="vertical-form-row button-row">
		<div class="field-column">
			<input class="button" type="submit" value="{{ trans('user.button.submit.create') }}">
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
