@extends('layouts.main')

@section('title', trans('auth.page_title.403'))

@section('content')

<h1>{{ trans('auth.page_title.403') }}</h1>
<p>{{ trans('auth.error_message.403') }}</p>

@stop