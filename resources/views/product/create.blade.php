@extends('layouts.admin')

@section('title', trans('product.page_title.create'))

@section('content')

<h1>{{ trans('product.page_title.create') }}</h1>

<form method="post" action="{{ action('ProductController@store') }}" class="vertical-form">
	{{ csrf_field() }}

	<div class="vertical-form-row">
		<div class="label-column">
			<label for="category">
				<strong>{{ trans('product.label.category') }}</strong>
			</label>
		</div>
		<div class="field-column select-field">
			<select name="category" id="category" style="width: 250px;">
				<option value="">{{ trans('product.placeholder.category') }}</option>
				@foreach ($categories as $category)
					<option value="{{ $category->id }}" @if (old('category') === $category->id) selected @endif>{{ $category->name }}</option>
				@endforeach
			</select>
			<div class="error-text">{{ $errors->first('category') }}</div>
		</div>
	</div>
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="name">
				<strong>{{ trans('product.label.name') }}</strong>
			</label>
		</div>
		<div class="field-column">
			<input class="full-width border-bottom" type="text" name="name" id="name" value="{{ old('name') }}">
			<div class="error-text">{{ $errors->first('name') }}</div>
		</div>
	</div>
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="description">
				<strong>{{ trans('product.label.description') }}</strong>
			</label>
		</div>
		<div class="field-column">
			<textarea name="description" id="description" class="hide">{{ old('description') }}</textarea>
			<div class="error-text">{{ $errors->first('description') }}</div>
		</div>
	</div>
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="stock">
				<strong>{{ trans('product.label.stock') }}</strong>
			</label>
		</div>
		<div class="field-column">
			<input class="full-width border-bottom" type="number" name="stock" id="stock" value="{{ old('stock') }}">
			<div class="error-text">{{ $errors->first('stock') }}</div>
		</div>
	</div>
	<div class="vertical-form-row">
		<div class="label-column">
			<label for="status">
				<strong>{{ trans('product.label.status') }}</strong>
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
			<input class="button" type="submit" value="{{ trans('product.button.submit.create') }}">
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
		selector: '#description',
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

@include('mceImageUpload::upload_form', ['upload_url' => url('/admin/product/upload_image')])
