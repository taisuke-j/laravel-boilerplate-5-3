@extends('layouts.admin')

@section('title', trans('post.page_title.create'))

@section('content')

<h1>{{ trans('post.page_title.create') }}</h1>

<form method="post" action="{{ action('PostController@store') }}" class="vertical-form">
	{{ csrf_field() }}

	<div class="vertical-form-row">
		<div class="label-column">
			<label for="title">
				<strong>{{ trans('post.label.title') }}</strong>
			</label>
		</div>
		<div class="field-column">
			<input class="full-width border-bottom" type="text" name="title" id="title" value="{{ old('title') }}">
			<div class="error-text">{{ $errors->first('title') }}</div>
		</div>
	</div>
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="slug">
				<strong>{{ trans('post.label.slug') }}</strong>
			</label>
		</div>
		<div class="field-column">
			<input class="full-width border-bottom" type="text" name="slug" id="slug" value="{{ old('slug') }}">
			<div class="error-text">{{ $errors->first('slug') }}</div>
		</div>
	</div>
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="category">
				<strong>{{ trans('post.label.category') }}</strong>
			</label>
		</div>
		<div class="field-column select-field">
			<select name="category" id="category" style="width: 250px;">
				<option value="">{{ trans('post.placeholder.category') }}</option>
				@foreach ($categories as $category)
					<option value="{{ $category->id }}" @if (old('category') === $category->id) selected @endif>{{ $category->name }}</option>
				@endforeach
			</select>
			<div class="error-text">{{ $errors->first('category') }}</div>
		</div>
	</div>
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="content">
				<strong>{{ trans('post.label.content') }}</strong>
			</label>
		</div>
		<div class="field-column">
			<textarea name="content" id="content" class="hide">{{ old('content') }}</textarea>
			<div class="error-text">{{ $errors->first('content') }}</div>
		</div>
	</div>
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="status">
				<strong>{{ trans('post.label.status') }}</strong>
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
			<input class="button" type="submit" value="{{ trans('post.button.submit.create') }}">
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
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	<script>
	// TinyMCE
	tinymce.init({
		selector: '#content',
		height: 300,
		plugins: [
			'print image code'
		],
		toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
		relative_urls: false,
		file_browser_callback: function(field_name, url, type, win) {
			// trigger file upload form
			if (type == 'image') $('#formUpload input').click();
		}
	});

	// Select2
	$('[name="status"]').select2();
	</script>

@endsection

@include('mceImageUpload::upload_form', ['upload_url' => url('/admin/post/upload_image')])
