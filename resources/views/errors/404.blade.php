@extends('layouts.main')

@section('title', trans('auth.page_title.404'))

@section('content')

<h1>{{ trans('auth.page_title.404') }}</h1>
<p>{{ trans('auth.error_message.404') }}</p>

@stop