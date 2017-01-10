<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title')</title>
	<link rel="stylesheet" href="{{ URL::asset('css/admin.min.css') }}">
</head>

<body class="{{ $body_class }}">
	<header>
		<div class="top-nav">
			<img class="header_logo" src="{{ URL::asset('images/logo.png') }}" alt="" width="120">
			@if (Auth::check())
			<label class="menu-button" for="sideNav">
				<i class="fa fa-navicon"></i>
			</label>
			<div class="user-name">
				<i class="fa fa-user"></i> {{ Auth::user()->name }}
			</div>
			@endif
		</div>
	</header>

	<!-- Side Navigation -->
	<input type="checkbox" name="side-nav" id="sideNav" class="hide">

	@if (Auth::check())
	<nav class="side-nav">
		<ul>
			<li @if ($current_section['parent'] === 'dashboard') class="current" @endif>
				<a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
			</li>
			<li @if ($current_section['parent'] === 'product') class="current" @endif>
				<a href="{{ action('ProductController@index') }}"><i class="fa fa-database"></i> {{ trans('product.menu.parent') }}</a>
				@if ($current_section['parent'] === 'product')
				<ul>
					<li @unless ($current_section['child']) class="current" @endunless>
						<a href="{{ action('ProductController@index') }}">{{ trans('product.menu.index') }}</a>
					</li>
					<li @if ($current_section['child'] === 'create') class="current" @endif>
						<a href="{{ action('ProductController@create') }}">{{ trans('product.menu.create') }}</a>
					</li>
					<li @if ($current_section['child'] === 'category') class="current" @endif>
						<a href="{{ url('/admin/product/category/index') }}">{{ trans('category.menu.parent') }}</a>
					</li>
				</ul>
				@endif
			</li>
			<li @if ($current_section['parent'] === 'post') class="current" @endif>
				<a href="{{ action('PostController@index') }}"><i class="fa fa-pencil"></i> {{ trans('post.menu.parent') }}</a>
				@if ($current_section['parent'] === 'post')
				<ul>
					<li @unless ($current_section['child']) class="current" @endunless>
						<a href="{{ action('PostController@index') }}">{{ trans('post.menu.index') }}</a>
					</li>
					<li @if ($current_section['child'] === 'create') class="current" @endif>
						<a href="{{ action('PostController@create') }}">{{ trans('post.menu.create') }}</a>
					</li>
					<li @if ($current_section['child'] === 'category') class="current" @endif>
						<a href="{{ url('/admin/post/category/index') }}">{{ trans('category.menu.parent') }}</a>
					</li>
				</ul>
				@endif
			</li>
			<li @if ($current_section['parent'] === 'page') class="current" @endif>
				<a href="{{ action('PageController@index') }}"><i class="fa fa-file-text-o"></i> {{ trans('page.menu.parent') }}</a>
				@if ($current_section['parent'] === 'page')
				<ul>
					<li @unless ($current_section['child']) class="current" @endunless>
						<a href="{{ action('PageController@index') }}">{{ trans('page.menu.index') }}</a>
					</li>
					<li @if ($current_section['child'] === 'create') class="current" @endif>
						<a href="{{ action('PageController@create') }}">{{ trans('page.menu.create') }}</a>
					</li>
					<li @if ($current_section['child'] === 'category') class="current" @endif>
						<a href="{{ url('/admin/page/category/index') }}">{{ trans('category.menu.parent') }}</a>
					</li>
				</ul>
				@endif
			</li>
			@can('is-admin')
			<li @if ($current_section['parent'] === 'user') class="current" @endif>
				<a href="{{ action('UserController@index') }}"><i class="fa fa-users"></i> {{ trans('user.menu.parent') }}</a>
				@if ($current_section['parent'] === 'user')
				<ul>
					<li @unless ($current_section['child']) class="current" @endunless>
						<a href="{{ action('UserController@index') }}">{{ trans('user.menu.index') }}</a>
					</li>
					<li @if ($current_section['child'] === 'create') class="current" @endif>
						<a href="{{ action('UserController@create') }}">{{ trans('user.menu.create') }}</a>
					</li>
				</ul>
				@endif
			</li>
			@endcan
			<li @if ($current_section['parent'] === 'asset') class="current" @endif>
				<a href="{{ action('AssetController@index') }}"><i class="fa fa-briefcase"></i> {{ trans('asset.menu.parent') }}</a>
			</li>
			<li @if ($current_section['parent'] === 'settings') class="current" @endif>
				<a href="{{ url('/admin/settings/account') }}"><i class="fa fa-gear"></i> Settings</a>
			</li>
			<li>
				<a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> Sign Out</a>
			</li>
		</ul>
	</nav>
	@endif

	<div class="flash-message {{ session('status') }}">
		<div class="fluid container">
			@if (session('message'))
			<div class="flash-message-content">
				{{ trans(session('message')) }}
			</div>
			 @elseif ($errors->count())
				<div class="flash-message-content">
					{{ trans('validation.flash_message.error') }}
				</div>
			@endif
		</div>
	</div>

	<main>
		<div class="fluid container">
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
