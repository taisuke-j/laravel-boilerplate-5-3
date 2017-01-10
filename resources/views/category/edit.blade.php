@extends('layouts.admin')

@section('title', trans('category.page_title.edit'))

@section('content')

<h1>{{ trans('category.page_title.edit') }}</h1>

<form method="post" action="{{ url('/admin/category/'.$category->id.'/update') }}" class="vertical-form">
	{{ csrf_field() }}
	{{ method_field('patch') }}

	<input type="hidden" name="type" value="{{ $model }}">
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="name">
				<strong>{{ trans('category.label.name') }}</strong>
			</label>
		</div>
		<div class="field-column">
			<input class="full-width border-bottom" type="text" name="name" id="name" value="{{ old('name', $category->name) }}">
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
			<input class="full-width border-bottom" type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}">
			<div class="error-text">{{ $errors->first('slug') }}</div>
		</div>
	</div>
	<div class="vertical-form-row button-row">
		<div class="field-column">
			<input type="submit" value="{{ trans('category.button.submit.edit') }}" class="button">
			<a href="#" title="{{ trans('category.link_title.delete') }}" data-delete-id="category_{{ $category->id }}" data-delete-confirm="{{ trans('category.message.delete_instance') }}">
				<i class="fa fa-trash"></i> <span>{{ trans('category.button.submit.delete') }}</span>
			</a>
		</div>
	</div>

</form>

<form action="{{ url('/admin/category/'.$category->id) }}" id="category_{{ $category->id }}" class="hide" method="post">
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
