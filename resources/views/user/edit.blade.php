@extends('layouts.admin')

@section('title', trans('user.page_title.edit'))

@section('content')

<div class="go-back">
	<a href="{{ action('UserController@index') }}">
		<i class="fa fa-angle-left"></i>
		<span>{{ trans('user.link_text.back_to_list') }}</span>
	</a>
</div>

<h1>{{ trans('user.page_title.edit') }}</h1>

<form method="post" action="{{ action('UserController@update', $user->id) }}" class="vertical-form">
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
			<label for="role">
				<strong>{{ trans('user.label.role') }}</strong>
			</label>
		</div>
		<div class="field-column select-field">
			<select name="role" id="role" style="width: 250px;">
				@foreach ($role_list as $key => $role)
					<option value="{{ $key }}" @if (old('role') === $key) selected @elseif ($user->role === $key) selected @endif>{{ $role }}</option>
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
					<option value="{{ $key }}" @if (old('status') === $key) selected @elseif ($user->status === $key) selected @endif>{{ $status }}</option>
				@endforeach
			</select>
			<div class="error-text">{{ $errors->first('status') }}</div>
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
			<input type="submit" value="{{ trans('user.button.submit.edit') }}" class="button">
			<a href="#" title="{{ trans('user.link_title.delete') }}" data-delete-id="user_{{ $user->id }}" data-delete-confirm="{{ trans('user.message.delete_instance') }}">
				<i class="fa fa-trash"></i> <span>{{ trans('user.button.submit.delete') }}</span>
			</a>
		</div>
	</div>

</form>

<form action="{{ action('UserController@destroy', $user->id) }}" id="user_{{ $user->id }}" class="hide" method="post">
	{{ csrf_field() }}
	{{ method_field('delete') }}
</form>

@stop

@section('sidebar')
	<h3>Sidebar</h3>
	<p>Bourbon Neat is used for grid system in this example.</p>
@stop

@section('javascript')
	@parent
@endsection
