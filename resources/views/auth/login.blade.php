@extends('layouts.admin')

@section('title', trans('auth.page_title.login'))

@section('content')

<div class="login-form-wrapper">

    <h1>{{ trans('auth.page_title.login') }}</h1>

    <form method="POST" action="{{ url('/login') }}" class="login-form">

        {{ csrf_field() }}

        <div class="vertical-form-row">
            <div class="label-column">
                <label for="email">
                    <strong>{{ trans('auth.label.email') }}</strong>
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
                    <strong>{{ trans('auth.label.password') }}</strong>
                </label>
            </div>
            <div class="field-column">
                <input class="full-width border-bottom" type="password" name="password" id="password" value="{{ old('password') }}">
                <div class="error-text">{{ $errors->first('password') }}</div>
            </div>
        </div>
        <div class="vertical-form-row no-label-row">
            <div class="field-column">
                <label>
                    <input type="checkbox" name="remember"> {{ trans('auth.label.remember') }}
                </label>
            </div>
        </div>
        <div class="vertical-form-row button-row-larger">
            <div class="field-column">
                <input type="submit" value="{{ trans('auth.button.submit.login') }}" class="button">
                {{--
                <a href="{{ url('/password/reset') }}">Forgot Password?</a>
                --}}
            </div>
        </div>

    </form>

</div>

@stop
