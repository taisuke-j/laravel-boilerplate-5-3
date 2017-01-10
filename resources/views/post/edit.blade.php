@extends('layouts.admin')

@section('title', trans('post.page_title.edit'))

@section('content')

<div class="go-back">
	<a href="{{ action('PostController@index') }}">
		<i class="fa fa-angle-left"></i>
		<span>{{ trans('post.link_text.back_to_list') }}</span>
	</a>
</div>

<h1>{{ trans('post.page_title.edit') }}</h1>

<form method="post" action="{{ action('PostController@update', $post->slug) }}" class="vertical-form">
	{{ csrf_field() }}
	{{ method_field('patch') }}

	<div class="vertical-form-row">
		<div class="label-column">
			<label for="title">
				<strong>{{ trans('post.label.title') }}</strong>
			</label>
		</div>
		<div class="field-column">
			<input class="full-width border-bottom" type="text" name="title" id="title" value="{{ old('title', $post->title) }}">
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
			<input class="full-width border-bottom" type="text" name="slug" id="slug" value="{{ old('slug', $post->slug) }}">
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
					<option value="{{ $category->id }}" @if (old('category') === $category->id) selected @elseif (isset($current_category) && $current_category->id === $category->id) selected @endif>{{ $category->name }}</option>
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
			<textarea id="content" name="content" class="hide">{{ old('content', $post->content) }}</textarea>
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
					<option value="{{ $key }}" @if (old('status') === $key) selected @elseif ($post->status === $key) selected @endif>{{ $status }}</option>
				@endforeach
			</select>
			<div class="error-text">{{ $errors->first('status') }}</div>
		</div>
	</div>
	<div class="vertical-form-row button-row">
		<div class="field-column">
			<input type="submit" value="{{ trans('post.button.submit.edit') }}" class="button">
			<a href="#" title="{{ trans('post.link_title.delete') }}" data-delete-id="post_{{ $post->id }}" data-delete-confirm="{{ trans('post.message.delete_instance') }}">
				<i class="fa fa-trash"></i> <span>{{ trans('page.button.submit.delete') }}</span>
			</a>
		</div>
	</div>

</form>

<form action="{{ action('PostController@destroy', $post->slug) }}" id="post_{{ $post->id }}" class="hide" method="post">
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
