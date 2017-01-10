@extends('layouts.main')

@section('title', $product->name)

@section('content')

<h1>{{ $product->name }}</h1>

<div class="vertical-form-row">
	<div class="label-column">
		<label for="name">
			<strong>{{ trans('product.label.name') }}</strong>
		</label>
	</div>
	<div class="field-column">
		{{ $product->name }}
	</div>
</div>
<div class="vertical-form-row">
	<div class="label-column">
		<label for="description">
			<strong>{{ trans('product.label.description') }}</strong>
		</label>
	</div>
	<div class="field-column">
		{!! $product->description !!}
	</div>
</div>
<div class="vertical-form-row">
	<div class="label-column">
		<label for="inventory">
			<strong>{{ trans('product.label.stock') }}</strong>
		</label>
	</div>
	<div class="field-column">
		{{ number_format($product->stock) }}
	</div>
</div>
<div class="vertical-form-row">
	<div class="label-column">
		<label for="status">
			<strong>{{ trans('product.label.status') }}</strong>
		</label>
	</div>
	<div class="field-column status-field-{{$product->status}}">
		{{ trans('product.status.' . $product->status) }}
	</div>
</div>

@stop

@section('javascript')
	@parent
@endsection
