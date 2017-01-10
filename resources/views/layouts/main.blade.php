<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title')</title>
	<link rel="stylesheet" href="{{ URL::asset('css/main.min.css') }}">
</head>

<body class="{{ $body_class }}">

	<header>
		<div class="container">
			<div class="content">
				<h1>Site Name</h1>
			</div>
		</div>
	</header>

	<main>
		<div class="container">
			<div class="content">
				@yield('content')
			</div>
			<div class="sidebar">
				@yield('sidebar')
			</div>
		</div>
	</main>

	@section('javascript')
		<script src="{{ URL::asset('js/vendor.min.js') }}"></script>
		<script src="{{ URL::asset('js/main.min.js') }}"></script>
	@show

</body>
